<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Maatwebsite\Excel\Facades\Excel;

use Laracasts\Flash\Flash;
use App\Upload;
use App\DHora;
use App\DCurso;
use App\Franja;
use App\User;
use App\Curso;

//use File;
class ImportController extends Controller
{
	public function index()
	{	
//return view('errors.000');
		$subtipo =[
			'01'	=> 'Disponibilidad de Horarios',
			'02'	=> 'Disponibilidad de Cursos',
            '03'    => 'Carga Horaria'
		];
		$filename = '';
		return view('admin.import.index')
			->with('subtipo', $subtipo);
	}

	// IMPORTAR DATOS
    public function updata(Request $request)
    {
//dd($request->all());
    	$import = new Upload;
    	$import->fileuser = $request->file('fileuser')->getClientOriginalName();
    	$import->tipo = '99';
    	$import->subtipo = $request->subtipo;
    	$import->user_id = $request->user_id;
    	$extension = strtolower($request->file('fileuser')->getClientOriginalExtension());
    	$new_file = uniqid().'.'.$extension;
    	$import->filename = $new_file;
		// Verifica tipo de archivo
		// mimeType: "application/vnd.ms-excel" ------------> CSV
		if ($extension != 'csv' ) {
			flash('El archivo debe tener extensión .csv', 'danger');
			return redirect()->back();
		}else{
			// obtenemos el campo fileuser definido en el formulario
			$file = $request->file('fileuser');
			// Indicamos que queremos guardar un nuevo archivo en el disco local/imports
			\Storage::disk('imports')->put($new_file, \File::get($file)); 
			$import->save();
			$new_arch = storage_path('imports')."/".$new_file;
			if ($import->subtipo == '01') {
				$sw_import = $this->import_9901($new_arch);
			}elseif($import->subtipo == '02'){
				$sw_import = $this->import_9902($new_arch);
			}elseif($import->subtipo == '03'){
                $sw_import = $this->import_9903($new_arch);
            }
			if ($sw_import == true) {
				flash('Se ha importado '.$import->fileuser.' de forma exitosa','success');
			}else{
				flash('Error al importar archivo '.$import->fileuser,'danger');
			}
			return redirect()->back();
		}
    }
    
    /* Importa los datos del archivo dhoras.csv a tabla dhoras */
    public function import_9901($file)
    {
    	// Elimina los datos anteriores
    	$Dhoras = Dhora::all();
    	foreach ($Dhoras as $Dhora) {
    		$Dhora->delete();
    	}
    	 
    	// Importa los datos
    	$franjas = Franja::all();
    	Excel::load($file, function($reader) use ($franjas) {
     		foreach ($reader->get() as $registro) {
     			$Dhora = new Dhora;
     			$Dhora->csede = $registro->csede;
     			$Dhora->cdocente = $registro->cdocente;
     			foreach ($franjas as $franja) {
     				$xfranja = "d".$franja->dia.'_h'.$franja->turno.$franja->hora;
     				$Dhora->$xfranja = $registro->$xfranja;
     			}
     			$Dhora->sede_id = $registro->sede_id;
     			$Dhora->user_id = $registro->user_id; 
     			$Dhora->save();
      		}
		});
    	// Modifica los user_id
    	$Dhoras = Dhora::all();
    	foreach ($Dhoras as $dhora) {
    		$user_id = User::where('username','=',$dhora->cdocente)->first()->id;
    		if (empty($user_id)) {
    			return false;
    		}
			$dhora->user_id = $user_id;
			$dhora->save();    		
    	}
		return true;
    }

    /* Importa los datos del archivo dcursos.csv a tabla dcursos */
    public function import_9902($file)
    {
    	// Elimina los datos anteriores
    	$Dcursos = Dcurso::all();
    	foreach ($Dcursos as $Dcurso) {
    		$Dcurso->delete();
    	}
    	 
    	// Importa los datos
    	Excel::load($file, function($reader) {
     		foreach ($reader->get() as $registro) {
     			Dcurso::create([
     				'prioridad' => $registro->prioridad,
     				'cdocente' => $registro->cdocente,
     				'ccurso' => $registro->ccurso,
     				'curso_id' => $registro->curso_id,
     				'user_id' => $registro->user_id
     			]);
      		}
		});
    	// Modifica los user_id
    	$Dcursos = Dcurso::all();
    	foreach ($Dcursos as $dcurso) {
    		$user_id = User::where('username','=',$dcurso->cdocente)->first()->id;
    		if (empty($user_id)) {
    			return false;
    		}
			$dcurso->user_id = $user_id;
			$dcurso->save();    		
    	}
    	// Modifica los curso_id
    	$Dcursos = Dcurso::all();
    	foreach ($Dcursos as $dcurso) {
    		$curso_id = Curso::where('ccurso','=',$dcurso->ccurso)->first()->id;
    		if (empty($curso_id)) {
    			return false;
    		}
			$dcurso->curso_id = $curso_id;
			$dcurso->save();    		
    	}
		return true;
    }

    /* Importa los datos del archivo carga.csv a tabla carga */
    public function import_9903($file)
    {
        return view('errors.000');
    }
}
