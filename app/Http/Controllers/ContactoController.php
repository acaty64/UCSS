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
        $data = $request->all();
        if (Auth::guest()){
            $solicitante = $data['name2']." ".$data['name3'].", ".$data['name1'];
        }else{
            $solicitante = Auth::user()->wdocente(Auth::user()->id);
        }

        try{
            Mail::send('emails.solicitud', $data, function ($message) use($solicitante) {
                $message->from(config('mail.username'), $solicitante)
                    ->to(config('mail.username'), 'master_project')
                    ->subject('Solicitud de Contacto');
            });
            Flash::success('Mensaje enviado, espere nuestro correo de invitación.');
            return redirect()->route('solicitud.index'); 
        } catch(Swift_SwiftException $e) {
            Flash::danger('Lo siento, no se ha podido enviar la información.');
            return redirect()->route('welcome');
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
