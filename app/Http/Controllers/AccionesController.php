<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Laracasts\Flash\Flash;

use DB;

class AccionesController extends Controller
{
	public function index()
	{
		$file_local = 'up_'.date("Ymd").'.sql';
		$file_server = 'fcec_'.date("Ymd").'.gz';
		$mensaje = 'Presione el botón';
		if (env('APP_ENV')=='local')
		{
			$name_host = 'LOCALHOST';
			$fileDown = $file_local;
			$fileUp = $file_server;
		}else{
			$name_host = 'SERVER';
			$fileDown = $file_server;
			$fileUp = $file_local;
		}
		return view('admin.acciones.index')
				->with('name_host',$name_host)
				->with('fileDown',$fileDown)
				->with('fileUp',$fileUp)
				->with('mensaje',$mensaje);
	}

	// Backup del localhost 
	public function exportLocal($file_name)
	{
		$cmd = 'C:\wamp\www\fcec\mysql_upload.bat';
		exec($cmd,$output,$return_value);
		if ($return_value == 0){
			//$file_name = 'up_'.date("Ymd").'sql';
			$mensaje = 'Back Up en: C:\\wamp\\www\\fcec\\public\\' . $file_name ;
			Flash::success('Archivo creado: '.$mensaje);
            return redirect()->back();	
		}else{
			$file_name = '';
			$mensaje = 'Error en grabar archivo de Back Up.';
			Flash::error($mensaje);
			return redirect()->back();
		}
	}

	// Backup del server
	public function exportServer()
	{
    	// https://voragine.net/weblogs/como-hacer-copias-de-seguridad-de-bases-de-datos-con-php-y-mysqldump
		// variables
		$dbhost = env('DB_HOST');
		$dbname = env('DB_DATABASE');
		$dbuser = env('DB_USERNAME');
		$dbpass = env('DB_PASSWORD');
		 
		$backup_file = $dbname .'_'. date("Ymd") . '.gz';
 
		// comandos a ejecutar
		$command = "mysqldump --opt -h $dbhost -u $dbuser -p$dbpass $dbname | gzip > $backup_file";
		system($command,$output);
		// Verifica creacion del backup
		if ($output == 0){
			$file_name = public_path() . '/' . $backup_file ;
			// Descarga del backup creado
			if(!$this->downloadFile($file_name)){
				$mensaje = "No se pudo descargar el archivo " . $file_name;
			}
		}else{
			$file_name = '';
			$mensaje = 'Error en Back Up.';
		}
		//return $mensaje;
	}

	// Restore en el localhost
	public function importLocal()
	{

	}

	// Restore en el Server
	public function importServer()
	{

	}

	public function ExportSQL()
    {
    	if (env('APP_ENV')=='local')
    	{
    		$name_host = 'LOCALHOST';
    		$cmd = 'C:\wamp\www\fcec\mysql_upload.bat';
    		exec($cmd,$output,$return_value);
    		if ($return_value == 0){
    			$file_name = 'up_'.date("Ymd").'sql';
    			$mensaje = 'Back Up en: C:\\wamp\\www\\fcec\\public\\' . $file_name ;
    			
//    			echo 'Back Up en: C:\\wamp\\www\\fcec\\public\\' ;	
    		}else{
    			$file_name = '';
    			$mensaje = 'Error en Back Up.';
//    			echo 'Error en Back Up.';
    		}
    	}else{
    		$name_host = 'SERVIDOR REMOTO';
	    	// https://voragine.net/weblogs/como-hacer-copias-de-seguridad-de-bases-de-datos-con-php-y-mysqldump
			// variables
			$dbhost = env('DB_HOST');
			$dbname = env('DB_DATABASE');
			$dbuser = env('DB_USERNAME');
			$dbpass = env('DB_PASSWORD');
			 
			$backup_file = $dbname .'_'. date("Ymd") . '.gz';
	 
			// comandos a ejecutar
			$command = "mysqldump --opt -h $dbhost -u $dbuser -p$dbpass $dbname | gzip > $backup_file";
			system($command,$output);
			// Verifica creacion del backup
			if ($output == 0){
				$file_name = public_path() . '/' . $backup_file ;
				// Descarga del backup creado
				if(!$this->downloadFile($file_name)){
					$mensaje = "No se pudo descargar el archivo " . $file_name;
				}else{
					$mensaje = "Archivo descargado: " . $file_name;
				}
			}else{
				$file_name = '';
    			$mensaje = 'Error en Back Up.';
			}			
    	} 
    	return view('admin.acciones.index')
					->with('name_host',$name_host)
					->with('file_name', $file_name)
		            ->with('mensaje', $mensaje);   	
    }

    protected function downloadFile($src)
    {
    	if(is_file($src)){
    		$finfo = finfo_open(FILEINFO_MIME_TYPE);
    		$content_type = finfo_file($finfo, $src);
    		finfo_close($finfo);
    		$file_name = basename($src).PHP_EOL;
    		$file_size = filesize($src);
    		header('Content-Type: $content_type');
    		header('Content-Disposition: attachment; filename='.$file_name);
    		header('Content-Transfer-Encoding: binary');
    		header('Content-Lenght: $size');
    		readfile($src);
    		return true;
    	} else {
    		return false;
    	}
    }

    public function DownData()
    {
    	return view('errors.000');
    }
}
