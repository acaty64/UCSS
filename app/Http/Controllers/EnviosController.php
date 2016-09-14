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

     /**************  EN CONSTRUCCION *************************************************
     * ENVIO DE CORREOS ELECTRONICOS
     *
     * @param  admin.Menvios.index ->  Menvio->$id
     * @return ******* BACK() *****************
     *          ****** DERIVAR view SEGUN TIPO DE ENVIO
     *          ****** ACTUALIZAR MENVIOS -> sw_envio *************
     */
    public function send($id)
    {
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
            dd($correo->user->username);
                $data=array('flimite'=>$correo->menvio->flimite,
                    'dlimite'=>$dias[date("w")],
                    'wdocente'=>$correo->user->wDocente($correo->user->id),
                    'username'=>$correo->user->username );
                $Acorreo = $correo->toArray();
                // Enviar correo
                try{
                        Mail::send('admin.envios.email', $data, function($message) use ($Acorreo)
                        {
                            dd($Acorreo['email_to']);
                        $message ->to($Acorreo['email_to'], $Acorreo['user']['wdoc1'])
                                ->subject($Acorreo['tx_need']);
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
