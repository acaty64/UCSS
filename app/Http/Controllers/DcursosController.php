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
        return view('errors.000');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('errors.000');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return view('errors.000');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view('errors.000');
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
                        'cdocente'=>$user->cdocente,
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
        // Modifica switch respuesta en Denvios
        $denvio = Denvio::where('user_id','=', $docente_id)
                ->where('tipo','=','cursos')->get()->last();
        if(!empty($denvio)){
            $denvio->sw_rpta = '1';
            $denvio->save();
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
        return view('errors.000');
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

    /* Lista las actualizaciones de disponibilidad de cursos */
    public function lista()
    {
        $lista = $this->status_cursos();
        return view('admin.dcursos.list')
            ->with('lista', $lista);
    } 

    public function status_cursos()
    {
        // Lista los usuarios con lo siguiente:
        //      Solicitado: fecha de envio
        //      Limite: fecha limite
        //      Respuesta: fecha de respuesta
        // $merged = $collection->merge(['price' => 100, 'discount' => false]);

        $nxlista = 0;
        // $xlista: lista de detalle de envios del docente
        $xlista = [];
        // $registro: Registros a listar        
        $registro = collect([]);
        // Selecciona todos los usuarios        
        $users = User::all();
        foreach ($users as $user) {
            $registro = $registro->merge([
                'user_id' => $user->id,
                'username' => $user->username,
                'wdocente' => $user->wdocente($user->id) ]);
            $denvios = Denvio::where('user_id','=',$user->id)
                        ->where('tipo', '=', 'cursos')
                        ->where('sw_envio', '=', '1')->get();
            if ($denvios->count() == 0) {
                $registro = $registro->merge([
                    'sw_actualizacion' => 'NO COMUNICADO',
                    'status' => '0' // NO COMUNICADO
                    ]);
                $xlista[$nxlista++] = $registro;
            }else{
                $registro = $registro->merge([
                    'status' => '1' // INFORMADO
                    ]);     
                foreach ($denvios as $denvio) {
                    $registro = $registro->merge([                                
                                'sw_rpta' => $denvio->sw_rpta,
                                'updated_at' => $denvio->updated_at->toDateString(),
                                'fenvio' => $denvio->menvio->fenvio,
                                'flimite' => $denvio->menvio->flimite,
                                'tipo' => $denvio->menvio->tipo,
                                'user_denvio' => $denvio->id
                            ]);
                    if($denvio->sw_rpta == '1'){
                        $registro = $registro->merge([                                
                                'sw_actualizacion' => 'actualizado'
                            ]);
                    }else{
                        if($denvio->flimite < Carbon::today()->addDays(1)){
                            $registro = $registro->merge([
                                    'sw_actualizacion' => 'VENCIDO'
                                ]);
                        }else{
                            $registro = $registro->merge([
                                    'sw_actualizacion' => 'pendiente'
                                ]);
                        }
                    }
                    $xlista[$nxlista++] = $registro;
                }
            }
        }
        $xlista = collect($xlista);
//dd($xlista);
        // Selecciona el ultimo envio modificado
        // $lista: Lista de registros a visualizar
        $lista = [];
        $nlista = 0; 
        $users = $xlista->groupBy('user_id');
        foreach ($users as $user) {
            $xuser = $user->first();
            $denvios = $xlista->where('user_id', $xuser['user_id']);
            $denvios = $denvios->sortBy('fenvio');
            $lista[$nlista++] = $denvios->last();
        }
        $lista = collect($lista);
        $lista = $lista->sortBy('wdocente');
        return $lista;
    }

    public function List2Excel()
    {   
        $lista = $this->status_horas();
        $namefile = 'DispCursos_'.Carbon::now();
        $now = Carbon::now();
        $namefile = 'DH_'.$now->format('Y').'_'.$now->format('m').'_'.$now->format('d').'_'.$now->format('H').'_'.$now->format('i').'_'.$now->format('s');
        Excel::create($namefile, function($excel) use($lista){
            $excel->sheet('Disponibilidad de Cursos', function($sheet) use($lista){
                $sheet->fromArray($lista);
            });
        })->download('xls');
    }


}
