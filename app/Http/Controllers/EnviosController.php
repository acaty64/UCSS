<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Mail;
use App\Http\Requests;
use Carbon\Carbon;

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
    //dd('No envia con el correo de .env');
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
                // Define información según tipo de envío.                   
                if ($correo->Menvio->tipo='disp') {
                    $data=array('flimite'=>$correo->menvio->flimite,
                        'dlimite'=>$dias[date("w")],
                        'wdocente'=>$correo->user->wDocente($correo->user->id),
                        'username'=>$correo->user->username );
                    $blade = 'admin.envios.email_01';
                }elseif($correo->Menvio->tipo='hora'){
                    $data = 'FALTA DEFINIR DATA PARA ENVIAR AL BLADE';
                    
                    $blade = 'admin.envios.email_02';
                }
                // Enviar correo
                try{
                    Mail::send($blade, $data, function($message) use ($correo)
                    {
                    // MODIFICAR AL CORREGIR TABLA USERS: $correo->user->wdocente($correo->user->id)
                    $message ->to($correo->email_to, $correo->user->wdoc1)
                            ->subject($correo->menvio->tx_need);
                    });
                } catch(Swift_SwiftException $e) {
                    // *********** ERROR DE ENVIO DE CORREO ELECTRONICO ***********
                        dd($e);
                }
            }
        }
        // Asignación del switch envío en el Maestro de Envíos.
        $Menvio = Menvio::find($id);
        $Menvio->sw_envio = 1;
        $Menvio->save();
//dd('enviados: '.$contador. ' / eliminados: '.$contador_xx);
        Flash::success('Se han enviado '.$contador.' correos de forma exitosa');
        return redirect()->route('admin.menvios.index');
    }
}
