<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Laracasts\Flash\Flash;

use App\GrupoCurso;
use App\Grupo;
use App\Curso;

class GruposController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $grupos = Grupo::paginate(6);
        return view('admin.grupos.index')
            ->with('grupos',$grupos);
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
//dd('admin.grupos.edit($id)');
        $grupo = Grupo::find($id);
//dd($grupo);
        $cursos = Grupo::find($id)->GrupoCursos()->get();
        /***********************************************************************************/
        /* Datos para el CHOSEN inferior */
        /* Crea el array para el CHOSEN select multiple  */
        $ch_cursos = $cursos->lists('curso_id')->toArray();
//dd($ch_cursos);
        /* Crea la lista de cursos */
        $xcursos = Curso::all();
//dd($xcursos);
        $xcursos->each(function($xcursos){
            $xcursos->curso;
            $xcursos->wwcurso = $xcursos->wcurso." (".$xcursos->ccurso.")";
        });
//    dd($xcursos);
        $lcursos = $xcursos->lists('wwcurso','id');
//dd($lcursos);
        /***********************************************************************************/
        return view('admin.grupos.edit')
            ->with('grupo', $grupo)
            ->with('cursos',$cursos)
            ->with('ch_cursos', $ch_cursos)
            ->with('lcursos', $lcursos);
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
        return view('errors.000');
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
}
