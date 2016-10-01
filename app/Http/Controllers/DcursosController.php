<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Carbon\Carbon;
use Laracasts\Flash\Flash;
use Illuminate\Support\Collection;

use App\User;
use App\DCurso;
use App\Grupo;
use App\GrupoCurso;
use App\Curso;
use App\Semestre;
use App\Denvio;
use App\Menvio;

class DcursosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

/*************************************************************************/  
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($docente_id)
    {
        /***********************************************************************************/
        /* Datos para el CHOSEN superior */
        $user = User::find($docente_id);           
        //$dcursos = dCurso::sUser_id($user_id)->get();
        $dcursos = $user->dcursos()->get();
        /* Crea el array para el CHOSEN select multiple  */
        $ch_cursos = $dcursos->lists('curso_id')->toArray();
        //dCurso::sUser_id($user_id)->lists('curso_id')->toArray();
        /* Crea la lista de cursos */
        $xcursos = GrupoCurso::get();
        $xcursos->each(function($xcursos){
            $xcursos->curso;
        });
        $lcursos = $xcursos->lists('curso.wcurso','curso_id');
        /***********************************************************************************/

        /***********************************************************************************/
        /* Datos para el CHOSEN inferior
        /* xlgrupos : Collection de grupos con cursos por grupo */
        $xlgrupos = [];
        $grupos = Grupo::get();
        foreach ($grupos as $grupo)
        {
            array_push($xlgrupos, $grupo->grupocursos);
        }

        /* lxgrupos : Array como lista para el CHOSEN select separado por grupos  */
        $lxgrupos = [];
        $xcont_1 = 0;
        foreach($xlgrupos as $grupos)
        {  
            //$xcont_2 = xl
            foreach($grupos as $cursos)
            {
                $lxgrupos[$grupos[0]->grupo->wgrupo][$cursos->curso->id] = $cursos->curso->wcurso ;
                //$xcont_2++;                
            }
            $xcont_1++;
        }
/*************************/

        $sw_cambio = $this->sw_cambio($docente_id,'disp');


/*********************************************/
        /* $dcursos: disponibilidad de cursos del usuario  */
        /* $lcursos: lista de cursos para el select  */
        /* $ch_cursos: Array de cursos del usuario para el chosen  */
        return view('admin.dcursos.edit')
                ->with('sw_cambio',$sw_cambio)
                ->with('docente',$user)
                ->with('dcursos', $dcursos)
                ->with('lcursos', $lcursos)
                ->with('ch_cursos', $ch_cursos)
                ->with('lxgrupos',$lxgrupos);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
/*************************************************************************/    
    public function update(Request $request, $docente_id)
    {
        // Docente seleccionado
        $user = User::find($docente_id);
        // Nuevos cursos seleccionados
        $newCursos = $request->cursos;
        // Usuario
        $oldCursos = [];
        $contador = 0;
        $dCursos = User::find($docente_id)->dcursos;
        foreach ($dCursos as $dCurso) {
            $oldCursos[$contador] = $dCurso->curso_id ;
            $contador++;
        }
        /* MODIFICA LOS REGISTROS */
        if (empty($newCursos)) {
            $agregados = [];
            $eliminados = $oldCursos;
        }else{
            //$iguales = array_intersect($newCursos, $oldCursos);
            $agregados = array_diff($newCursos, $oldCursos);
            $eliminados = array_diff($oldCursos, $newCursos);
        }
        /*  Agrega registros  */
        $dCurso = new dCurso;
        foreach ($agregados as $curso_id) {
            $curso = Curso::find($curso_id);
            $nuevo = ['user_id'=>$user->id,
                        'curso_id'=>$curso->id, 
                        'ccurso' =>$curso->ccurso,
                        'prioridad' => '99',
                        'sw_cambio' => '1' ];
            $dCurso = new DCurso ;
            $dCurso->fill($nuevo);
            $dCurso->save();
        }
        /* Elimina registros */
        foreach ($eliminados as $curso_id) {
            $dCurso = User::find($docente_id)->dcursos->toarray();
            $clave = array_search( $curso_id, array_column($dCurso, 'curso_id'));
            //dd($clave);
            $clave_id = $dCurso[$clave]['id'];
            //dd($clave_id);
            $dCursos = dCurso::find($clave_id);
            //dd($dCursos);
            $dCursos->delete();  
        }
        Flash::success('Se ha registrado la modificación de disponibilidad de cursos de forma exitosa');
        if (\Auth::user()->type == '09') {
            return redirect()->route('admin.users.index');
        }else{
            return redirect()->route('admin.dcursos.edit', $user->id);
        }
    }

/*************************************************************************/    

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /* Identifica si tiene envio de disponibilidad pendiente */
        // Si el usuario es master pude modificar
        // Selecciona los denvios del usuario
        // Selecciona los menvios relacionados
        // Verifica si existe un menvio pendiente 
    public function sw_cambio($user_id, $tipo)
    {
        if (\Auth::user()->type == '09') {
            $sw_cambio = '1';
        }else{
            date_default_timezone_set('America/Lima');
            $hoy = Carbon::now();
            $ayer = Carbon::now()->subDays(1);
            $denvios = User::find($user_id)->denvios;
            if (!empty($denvios)) {
                $menvios = [];
                $contador = 0;
                foreach ($denvios as $denvio) {
                    if ($denvio->menvio->tipo=$tipo 
                            and $denvio->menvio->fenvio < $hoy
                            and $denvio->menvio->flimite > $ayer)
                    {
                        $menvios[$contador++] = $denvio->menvio->toArray();
                    }
                }
                if(!empty($menvios)){
                    $sw_cambio = '1';
                }else{
                    $sw_cambio = '0';
                }
            }else{
                $sw_cambio = '0';
            }            
        }
        return $sw_cambio;
    }
}
