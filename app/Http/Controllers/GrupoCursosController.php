<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;

use App\User;
use App\GrupoCurso;
use App\Grupo;
use App\Curso;
use App\Dcurso;
use Laracasts\Flash\Flash;

class GrupoCursosController extends Controller
{
    /**
     * Muestra los cursos para priorizar los docentes segun el grupo_id
     *
     * @return \Illuminate\Http\Response
     */
    public function index($grupo_id)
    {
        $grupo = Grupo::find($grupo_id);
        $cursos = Grupo::find($grupo_id)->grupocursos->all();
        return view('admin.grupocursos.index')
                ->with('grupo',$grupo)
                ->with('cursos',$cursos);        
    }

    /* Muestra los cursos para priorizar los docentes segun el user_id del responsable */
    public function index2($user_id)
    {
        $user = User::find($user_id);
        $usergrupo = $user->usergrupo;
        if (empty($usergrupo)) {
            Flash::success('No se le ha asignado grupo de responsabilidad');
            return redirect()->back();
        }else{
            $grupo_id = $usergrupo->grupo_id;
            return redirect()->route('admin.grupocursos.index',$grupo_id);
        }
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

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('errors.000');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $grupo_id)
    {
        $grupo = Grupo::find($grupo_id);
        // Elimina los cursos sobrantes
        $grupocursos = Grupo::find($grupo_id)->grupocursos;
        $array = $request->cursos;
        foreach ($grupocursos as $grupocurso) {
            $curso_id = $grupocurso->curso_id;
            $seek = array_search($curso_id, $array);
            if(!$seek){
                $grupocurso->delete();
            }
        }
        // Agrega los cursos faltantes 
        $grupocursos = Grupo::find($grupo_id)->grupocursos;
        $array = $request->cursos;
        foreach ($array as $key => $value) {
//            dd($value);
            $curso = Curso::find($value);
            $grupocurso = new GrupoCurso;
            $grupocurso->cgrupo = $grupo->cgrupo;
            $grupocurso->ccurso = $curso->ccurso;
            $grupocurso->grupo_id = $grupo->id;
            $grupocurso->curso_id = $curso->id;
            $grupocurso->save();
        }
        Flash::success('Actualización realizada con éxito');
        return redirect()->back();
    }

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

    /**
     * Presenta el orden de prioridad de los docentes en cada curso.
     *
     * @param  $curso
     * @return index
     */
    public function orden($curso_id)
    {
        $dcursos = Curso::find($curso_id)->dcursos->sortBy('prioridad');
        // Renumera las prioridades
        $contador = 0;
        foreach ($dcursos as $dcurso) {
            $contador++;
            $dcurso->prioridad = $contador;
            $dcurso->save();
        }
        return view('admin.grupocursos.orden')
            ->with('dcursos', $dcursos);

    }

    /**
     * Graba el orden de prioridad de los docentes en cada curso.
     *
     * @param  $orden
     * @return index
     */
    public function uporden($dcurso_id)
    {
        // Recuperacion de datos
        $dcurso = Dcurso::find($dcurso_id);
        $curso = Curso::find($dcurso->curso_id);
        $grupocurso_id = $curso->grupocurso->id;
        // Procesamiento de datos
        $nact = $dcurso->prioridad;
        $usuarios = Dcurso::where('curso_id','=',$dcurso->curso_id)->orderBy('prioridad','ASC')->get();
        $ids = $usuarios->pluck('id');
        // Reordenamiento de prioridades
        $ini = $ids->slice(0, $nact-2);
        $ant = $ids->slice($nact-2, 1);
        $act = $ids->slice($nact-1, 1);
        $fin = $ids->slice($nact);

        $new = $ini;
        $new = $new->merge($act);
        $new = $new->merge($ant);
        $new = $new->merge($fin);
        // Grabacion de nuevo orden
        foreach ($new as $key => $id) {
            $dcurso = Dcurso::find($id);
            $dcurso->prioridad = $key+1;
            $dcurso->save();
        }
        // Grabación de sw_cambio en grupos
        $grupocurso = GrupoCurso::find($grupocurso_id);
        $grupocurso->sw_cambio = '1';
        $grupocurso->save();
        return redirect()->back();
    }

    public function downorden($id)
    {
        $dcurso = Dcurso::find($id);
        $nact = $dcurso->prioridad;
        $usuarios = Dcurso::where('curso_id','=',$dcurso->curso_id)->orderBy('prioridad','ASC')->get();
        $ids = $usuarios->pluck('id');
        // Reordenamiento de prioridades
        $ini = $ids->slice(0, $nact-1);
        $act = $ids->slice($nact-1, 1);
        $pos = $ids->slice($nact, 1);
        $fin = $ids->slice($nact+1);

        $new = $ini;
        $new = $new->merge($pos);
        $new = $new->merge($act);
        $new = $new->merge($fin);
        // Grabacion de nuevo orden
        foreach ($new as $key => $id) {
            //dd($key);
            $dcurso = Dcurso::find($id);
            $dcurso->prioridad = $key+1;
            $dcurso->save();
        }
        return redirect()->back();
        //dd('GrupoCursosController.uporden($orden)');
    }

}
