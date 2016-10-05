<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Maatwebsite\Excel\Facades\Excel;

use App\DCurso;

class ImportController extends Controller
{
	public function index()
	{	
		$tipos =[
			'usuarios'	=> 'Usuarios',
			'dhoras'	=> 'Disponibilidad de Horarios',
			'dcursos'	=> 'Disponibilidad de Cursos'
		];
		return view('admin.import.index')->with('tipos', $tipos);
	}

	// IMPORTAR DATOS
    public function updata($tipo)
    {
dd($tipo);
    	if ($tipo == 'dcursos') {
	    	Excel::load('/CSV/dcursos.csv', function($reader) {
	     		foreach ($reader->get() as $book) {
	     			Book::create([
	     				'ccurso' => $book->ccurso,
	     				'prioridad' => $book->prioridad,
	     				'sw_cambio' => $book->sw_cambio,
	     				'curso_id' => $book->curso_id,
	     				'user_id' => $book->user_id
	     			]);
	      		}
			});
			return Book::all();
		}
    }


}
