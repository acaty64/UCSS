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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($grupo_id)
    {
//        dd('GrupoCursosController.index');
        $grupo = Grupo::find($grupo_id);
//dd($grupo);
        $cursos = Grupo::find($grupo_id)->grupocursos->all();
//dd($cursos[0]->curso->wcurso);
        return view('admin.grupocursos.index')
                ->with('grupo',$grupo)
                ->with('cursos',$cursos);        
    }

    public function index2($user_id)
    {
        $user = User::find($user_id);
        $grupo_id = $user->usergrupo->grupo_id;
//dd($grupo_id);
//        dd('GrupoCursosController.index');
        $grupo = Grupo::find($grupo_id);
//dd($grupo);
        $cursos = Grupo::find($grupo_id)->grupocursos->all();
//dd($cursos[0]->curso->wcurso);
        return view('admin.grupocursos.index')
                ->with('grupo',$grupo)
                ->with('cursos',$cursos);        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        dd('GrupoCursosController.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        dd('GrupoCursosController.store ($request) ');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        dd('GrupoCursosController.show ($id)');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        dd('GrupoCursosController.edit ($id)');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        dd('GrupoCursosController.update($request, $id)');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        dd('GrupoCursosController.destroy($id)');
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
        
//$xcursos = GrupoCurso::get();

//        dd($dcursos);
//        dd('GrupoCursosController.orden($grupo_id, $curso_id)');
        return view('admin.grupocursos.orden')
            ->with('dcursos', $dcursos);

    }

    /**
     * Graba el orden de prioridad de los docentes en cada curso.
     *
     * @param  $orden
     * @return index
     */
    public function uporden($id)
    {
        $dcurso = Dcurso::find($id);
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
            //dd($key);
            $dcurso = Dcurso::find($id);
            $dcurso->prioridad = $key+1;
            $dcurso->save();
        }
        return redirect()->back();
        //dd('GrupoCursosController.uporden($orden)');
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
