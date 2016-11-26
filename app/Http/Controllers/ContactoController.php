<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Swift_SwiftException;

use Laracasts\Flash\Flash;
use Auth;

class ContactoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('contacto');
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
        // Identifica el solicitante
        $data = $request->all();
        if (Auth::guest()){
            $solicitante = $data['name2']." ".$data['name3'].", ".$data['name1'];
        }else{ // Un docente puede presentar a un nuevo docente ???? como ?????
            $solicitante = Auth::user()->wdocente(Auth::user()->id);
        }
        // Verificacion de las carateristicas del documento adjunto        
        $file = $request->file('cv');
        $extension = $file->getMimeType();
        $tamano = $file->getSize(); 
        // Verificacion de la extension y tamaño < 5 Mb
        if ( $extension == 'application/pdf' && $tamano < 5242880){
            // Definir el nombre del documento ** No lo he cifrado porque se elimina despues
            $filename = $file->getClientOriginalName();
            // Guardar el archivo en la carpeta Storage\upload_pdf
//            \Storage::disk('upload_pdf')->put($filename,  \File::get($file));

            // Ruta y nombre del archivo temporal
            $arch_pdf = $file->getPathname();
            // Envia el correo
            try{
                
                // Envio del correo de contacto
                Mail::send('emails.solicitud', $data, function ($message) use($solicitante, $arch_pdf, $filename, $extension) {
                    $message->from(config('mail.username'), $solicitante)
                        ->to(config('mail.username'), 'master_project')
                        ->subject('Solicitud de Contacto')
                        ->attach($arch_pdf, ['as'=>$filename,'mime'=>$extension]);
                });
                Flash::success('Mensaje enviado, espere nuestro correo de invitación.');
                return redirect()->back(); 
            } catch(Swift_SwiftException $e) {
                Flash::error('Lo siento, no se ha podido enviar la información.');
                return redirect()->back();
            }
        }else{
            Flash::error('El archivo debe tener la extensión PDF y máximo de 5 Mb.');
            return redirect()->back();
        }
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

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

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
}
