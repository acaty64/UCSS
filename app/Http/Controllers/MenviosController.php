<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Collection as Collection;
use Carbon\Carbon;
use DB;

use App\Http\Requests;

use App\Menvio;
use App\Denvio;
use App\User;
use Laracasts\Flash\Flash;
 
class MenviosController extends Controller
{
    /**
     * INDICE DEL MAESTRO DE ENVIOS.
     *
     * @return view('admin.envios.index')
            ->with('Menvios', $Menvios);
     */
    public function index()
    {
        //dd('Aqui viene la vista admin.envios.index');
        
        // NO ES NECESARIO //$this->tfcia_rptas();
        $this->recontar_envios();
        $this->recontar_rptas();
        /*  PARA SELECT HORA DE ENVIO QUEUE
        date_default_timezone_set('America/Lima');
        $contador = 1;
        $hora_ini = substr(Carbon::now()->format('H:i:s'),0,2)+1;
        $hora_fin = 24;
        */
        $Menvios = Menvio::orderBy('id', 'DESC')->paginate(6);
        return view('admin.envios.index')
            ->with('Menvios', $Menvios);
        //    ->with('hora_ini',$hora_ini)
        //    ->with('hora_fin',$hora_fin);
    }

    /**
     * MUESTRA LA VISTA PARA LA CREACIÓN DE
     * NUEVOS REGISTROS DEL MAESTRO DE ENVIOS
     * Show the form for creating a new resource.
     *
     * @return view('admin.envios.create');
     */
    public function create()
    {
        //dd('MenviosController@create');
        return view('admin.envios.create');
    }

    /**
     * GRABA EL NUEVO REGISTRO DEL MAESTRO DE ENVIOS
     * Store a newly created resource in storage.
     *
     * @param  admin.envios.create -> $request
     * @return redirect()->route('admin.menvios.index');
     */
    public function store(Request $request)
    {
        //dd($request->all());
        $menvio = new menvio($request->all());
        $menvio->fenvio = date('Y-m-d');
        /*if ($menvio->tipo == 'disp') {
            $menvio->tablename = 'dhoras';
        } elseif ($menvio->tipo == 'hora') {
            $menvio->tablename = 'horarios';   
        }*/
        $menvio->save(); 
        Flash::success('Se ha registrado '.$menvio->tipo.' de forma exitosa');
        return redirect()->route('admin.menvios.index');
    }

    /**
     * MUESTRA LOS DETALLES DE ENVIOS ENVIADOS
     * Display the specified resource.
     *
     * @param  admin.Menvios.index ->  Menvio->$id
     * @return \Illuminate\Http\Response
     *      view('admin.envios.list')
                ->with('Denvios', $Denvios);
     */
    public function show($id)
    {
        //dd('MenviosController@show: '.$id);
        $Denvios = Denvio::where('menvio_id','=',$id)
                            ->Paginate(10);
        //dd($Denvios);
        return view('admin.envios.list')
            ->with('Denvios', $Denvios);
    }

    /**
     * MUESTRA EL REGISTRO DEL MAESTRO DE ENVIOS A MODIFICAR
     * Show the form for editing the specified resource.
     *
     * @param  admin.Menvios.index ->  Menvio->$id
     * @return view('admin.envios.edit')
                ->with('Menvios', $menvios);
     */
    public function edit($id)
    {
        //dd('MenviosController.edit '.$id);
        $menvio = Menvio::find($id);
        //dd($menvio);
        return view('admin.envios.edit')
            ->with('menvio',$menvio);
    }

    /**
     * ACTUALIZA EL MAESTRO DE DETALLES DE ENVIOS MODIFICADO
     * Update the specified resource in storage.
     *
     * @param  admin.Menvios.edit.blade.php -> $request
     * @param  int  $id
     * @return back()
     */
    public function update(Request $request, $id)
    {
        //dd($request->all());
        $menvio = Menvio::find($id);
        $menvio->fill($request->all());
        $menvio->save();
        Flash::success('Grupo de Envios modificado exitosamente.');
        return redirect()->route('admin.menvios.index');
    }

    /**
     * ELIMINA EL REGISTRO EN EL MAESTRO DE ENVIOS Y LOS DETALLES ASOCIADOS
     * Remove the specified resource from storage.
     *
     * @param  admin.Menvios.index ->  Menvio->$id
     * @return ********* BACK()
     */
    public function destroy($id)
    {
        //        dd('En construcción: MenviosController@destroy');
        $denvios = Menvio::find($id)->denvios;
        foreach ($denvios as $denvio) {
            $xdenvio = Denvio::find($denvio->id);
            $xdenvio->delete();
        }
        $menvio =  Menvio::find($id);
        $menvio->delete();          
        Flash::error('Se ha eliminado el grupo de envios: '.$menvio->id.' de forma exitosa');
        return redirect()->route('admin.menvios.index');
    }

    /**
     * MUESTRA LOS DETALLES DE ENVIOS A DEFINIR
     * Display the specified resource.
     *
     * @param  admin.Menvios.index.blade.php : Menvio->$id
     * @return view('admin.envios.send') 
                ->with('denvios', $denvios);
     */
    public function dshow($id)
    {
        //dd('En construcción: MenviosController@dshow($id)');
        // Recuperar los Denvios del Menvio
        $denvios = Menvio::find($id)->denvios()->get();
        $menvio = Menvio::find($id);
        $tipo = $menvio->tipo;
        $updated_at = $menvio->created_at;
        if($denvios->isEmpty())
        {
            $users = User::orderBy('wdoc2','ASC')->get();
            foreach ($users as $user) {
                $denvio = new Denvio;
                $denvio->user_id = $user->id;
                $denvio->menvio_id = $id;
                $denvio->email_to = $user->datauser->email1;
                $denvio->email_cc = $user->datauser->email2;
                $denvio->updated_at = $updated_at;
                // Grabar registro a registro
                if ($tipo = 'disp') {
                    $denvio->tipo = 'horas';
                    $denvio->save();
                    // Graba registro 'cursos'
                    $denvio_c = new Denvio;
                    $denvio_c->fill($denvio->toArray());
                    $denvio_c->tipo = 'cursos';
                    $denvio_c->updated_at = $updated_at;
                    $denvio_c->save();
                }else{
                    $denvio->tipo = 'carga';
                    $denvio->save();
                }
            }
        }
        if ($tipo = 'disp') {
            $denvios = Denvio::Stipo(['menvio_id'=>$id, 'type'=>'horas'])->orderBy('id','ASC')->paginate(10);
        }else{
            $denvios = Menvio::find($id)->denvios->Stipo('carga')->orderBy('id','ASC')->paginate(10);
        }
        //    dd($denvios);
        // Enviar a la vista send los denvios
        return view('admin.envios.send')
            ->with('denvios', $denvios);
    }

    /**
     * ACTUALIZA LAS MARCAS DE LOS DETALLES DE ENVIOS (PAGINA ACTUAL) 
     * Update the specified resource in storage.
     *
     * @param  admin.envios.send.blade.php : $request
     * @return back() 
     */
    public function dupdate(Request $request)
    {
        $denvios = $request['xenvios'];
        $contador01 = 0;
        $contador10 = 0;
        foreach ($denvios as $id => $value) {
            $denvio = Denvio::find($id);
            if ($denvio->getOriginal('sw_envio') != $value) {
                $denvio->sw_envio = $value;
                if ($denvio->sw_envio == 1) {
                    $contador01++;
                }else{
                    $contador10++;
                }
                $denvio->save();
                // Actualiza la marca de detalles de envios CURSOS
                $envio_curso = Denvio::where('user_id','=',$denvio->user_id)
                    ->where('menvio_id','=',$denvio->menvio_id)->get();
                foreach ($envio_curso as $envio) {
                    $envio->sw_envio = $value;
                    $envio->save();
                }
            }
        }
        Flash::success($contador01.' marcas agregadas, '.$contador10. ' marcas eliminadas.');
        return back();                
    }

    /**
     * MARCA TODOS LOS DETALLES DE ENVIOS
     *
     * @param  admin.envios.send.blade.php : Menvio->$id
     * @return back()
     */
    public function dmarkall($id)
    {
        $menvio = Menvio::find($id);
        $id = $menvio->id;
        $type = $menvio->tipo;
        $updated_at = $menvio->created_at;
        
        $newvalue = 1;
        $contador01 = 0;
        $contador10 = 0;
        $denvios = Menvio::find($id)->denvios()->get(); 
        foreach ($denvios as $denvio) {
            $denvio->sw_envio = $newvalue;
            $denvio->updated_at = $updated_at;
            // Cuenta solo los registros diferentes a CURSOS marcados adicionalmente
            if ($denvio->getOriginal('sw_envio') != $newvalue) {
                if ($denvio->sw_envio == 1 and $denvio->tipo != 'cursos')
                {
                    $contador01++;
                }
            }
            $denvio->save();
        }
        Flash::success($contador01.' marcas agregadas, '.$contador10. ' marcas eliminadas.');
        return back();  
    }

    /**
     * DESMARCA TODOS LOS DETALLES DE ENVIOS
     *
     * @param  admin.envios.send.blade.php : Menvio->$id
     * @return back()
     */
    public function dunmarkall($id)
    {
        $menvio = Menvio::find($id);
        $id = $menvio->id;
        $type = $menvio->tipo;
        $updated_at = $menvio->created_at;
           
        $newvalue = 0;
        $contador01 = 0;
        $contador10 = 0;
        $denvios = Menvio::find($id)->denvios()->get(); 
        foreach ($denvios as $denvio) {
            $denvio->sw_envio = $newvalue;
            $denvio->updated_at = $updated_at;
            // Cuenta solo los registros diferentes a CURSOS DESmarcados adicionalmente
            if ($denvio->getOriginal('sw_envio') != $newvalue) {
                if ($denvio->sw_envio == 0 and $denvio->tipo != 'cursos')
                {
                    $contador10++;
                }
                $denvio->save();
            }
        }
        Flash::success($contador01.' marcas agregadas, '.$contador10. ' marcas eliminadas.');
        return back();  
    }

    
    /**
     * RECUENTA LOS DETALLES DE ENVIOS MARCADOS
     *
     * @param  MenviosController.index()
     */
    public function recontar_envios()
    {
        $Menvios = Menvio::all();
        if ($Menvios->isEmpty() == false) 
        {
            foreach ($Menvios as $Menvio) 
            {
                $Denvios = $Menvio->denvios;
                $envio1 = 0;
                $envio2 = 0;
                if ($Denvios->isEmpty() == false)
                { 
                    foreach ($Denvios as $Denvio) 
                    {
                        if ($Denvio->tipo == 'cursos') {
                            $envio2 = $envio2 + $Denvio->sw_envio;
                        }else{
                            $envio1 = $envio1 + $Denvio->sw_envio;    
                        }
                    }
                }
                $xEnvio = Menvio::find($Menvio->id);
                $xEnvio->envio1 = $envio1;
                $xEnvio->envio2 = $envio2;
                $xEnvio->save();
            }  
        }           
    }


    /**
     * RECUENTA LAS RESPUESTAS DE LOS DETALLES DE ENVIOS
     *
     * @param  MenviosController.index()
     */
    public function recontar_rptas()
    {
        $Menvios = Menvio::all();
        if($Menvios->isEmpty() == false)
        {
            foreach ($Menvios as $Menvio) 
            {
                $Denvios = $Menvio->denvios()->get();
                $rpta1 = 0;
                $rpta2 = 0;
                if ($Denvios->isEmpty() == false) 
                {
                    foreach ($Denvios as $Denvio) 
                    {
                        if ($Denvio->tipo == 'cursos') {
                            $rpta2 = $rpta2 + $Denvio->sw_rpta;
                        }else{
                            $rpta1 = $rpta1 + $Denvio->sw_rpta;
                        }
                    }
                }
                $xEnvio = Menvio::find($Menvio->id);
                $xEnvio->rpta1 = $rpta1;
                $xEnvio->rpta2 = $rpta2;
                $xEnvio->save();
            }    
        }
    }

}
