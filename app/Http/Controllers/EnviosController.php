<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Mail;
use App\Http\Requests;
use App\User;
use App\Menvio;
use App\Denvio;
use Laracasts\Flash\Flash;
use Swift_SwiftException;

class EnviosController extends Controller
{
    /* Envio de correos electronicos */
    public function send($id)
    {
//        dd($id);
        $dias = array("domingo","lunes","martes","mi&eacute;rcoles","jueves","viernes","s&aacute;bado");
        $contador_xx = 0;
        $contador = 0;
        $correos = Menvio::find($id)->denvios->all();
        foreach ($correos as $correo) {
            if ($correo->sw_envio == 0) {
                $contador_xx++;
                $correo->delete();     
            }else{
                $contador++;
                $data=array('flimite'=>$correo->menvio->flimite,
                    'dlimite'=>$dias[date("w")],
                    'wdocente'=>$correo->user->wDocente($correo->user->id),
                    'texto'=>$correo->menvio->tx_need);
//dd($data);
                $Acorreo = $correo->toArray();
                // Enviar correo
                try{
                        Mail::send('admin.envios.email', $data, function($message)
                        {
                        $message ->to('ana.arashiro@gmail.com', 'Ana')
                                ->subject('Correo de prueba');
                        });
                } catch(Swift_SwiftException $e) {
                    // *********** ERROR DE ENVIO DE CORREO ELECTRONICO ***********
                        dd($e);
                }
            }
        }
//dd('enviados: '.$contador. ' / eliminados: '.$contador_xx);
    Flash::success('Se han enviado '.$contador.' correos de forma exitosa');
        return redirect()->route('admin.menvios.index');
    }

}
