<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;

class PruebasController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function backup()
    {
        // Pruebas de filesystem 
        
        // Limpiar el directorio
        $directory = 'http---localhost';
        $files = Storage::allFiles($directory);
        foreach ($files as $file) {
            Storage::delete($file);
        }
        // Genera backup
        Artisan::call('backup:run', ['--only-db'=>'true']);
        $files = Storage::allFiles($directory);
        if (count($files) == 0) {
            return view('pruebas')->with('errors',['ERROR en Backup']);
        }else{
            return view('pruebas')->with('errors',['Backup Ejecutado']);
        }
    }

    public function restore()
    {
        dd('En construccion');

    }


}
