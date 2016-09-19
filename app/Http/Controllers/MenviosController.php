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
        
        $this->tfcia_rptas();
        $this->recontar_envios();
        $this->recontar_rptas();
        /*  PARA SELECT HORA DE ENVIO QUEUE
        date_default_timezone_set('America/Lima');
        $contador = 1;
        $hora_ini = substr(Carbon::now()->format('H:i:s'),0,2)+1;
        $hora_fin = 24;
        */
        $Menvios = Menvio::orderBy('fenvio', 'DESC')->paginate(6);
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
        if ($menvio->tipo == 'disp') {
            $menvio->tablename = 'dhoras';
        } elseif ($menvio->tipo == 'hora') {
            $menvio->tablename = 'horarios';   
        }
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

        if($denvios->isEmpty())
        {
            $users = User::orderBy('wdoc2','ASC')
                    ->orderBy('wdoc3','ASC')
                    ->orderBy('wdoc1','ASC')->get();
            foreach ($users as $user) {
                $denvio = new Denvio;
                $denvio->user_id = $user->id;
                $denvio->menvio_id = $id;
                $denvio->email_to = $user->datauser->email1;
                $denvio->email_cc = $user->datauser->email2;
                // Grabar registro a registro
                $denvio->save();
            }
        }
        $denvios = Menvio::find($id)->denvios()->paginate(10);
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
        $newvalue = 1;
        $denvios = Menvio::find($id)->denvios()->get();
        //dd($denvios);
        $contador01 = 0;
        $contador10 = 0;
        foreach ($denvios as $denvio) {
        //dd($denvio);
            $denvio->sw_envio = $newvalue;
            if ($denvio->getOriginal('sw_envio') != $newvalue) {
                if ($denvio->sw_envio == 1) {
                    $contador01++;
                }else{
                    $contador10++;
                }   
                $denvio->save();
            }
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
        $newvalue = 0;
        $denvios = Menvio::find($id)->denvios()->get();
        $contador01 = 0;
        $contador10 = 0;
        foreach ($denvios as $denvio) {
            $denvio->sw_envio = $newvalue;
            if ($denvio->getOriginal('sw_envio') != $newvalue) {
                if ($denvio->sw_envio == 1) {
                    $contador01++;
                }else{
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
                $Denvios = $Menvio->denvios()->get();
                $envios = 0;
                if ($Denvios->isEmpty() == false)
                { 
                    foreach ($Denvios as $Denvio) 
                    {
                        $envios = $envios + $Denvio->sw_envio;
                    }
                }
                $xEnvio = Menvio::find($Menvio->id);
                $xEnvio->envios = $envios;
                $xEnvio->save();
            }  
        }           
    }

    /**
     * TRANSFIERE LAS RESPUESTAS DE LAS TABLAS DEFINIDAS EN MENVIOS A LOS REGISTROS DE DENVIOS
     *
     * @param  MenviosController.index()
     */
    public function tfcia_rptas()
    {
        // Selecciona todos los Menvios
        $Menvios = Menvio::all();
        if ($Menvios->isEmpty() == false) 
        {
            // Por cada Menvio
            foreach ($Menvios as $Menvio) 
            {
                $xfenvio = $Menvio->fenvio;
                $xflimite = $Menvio->flimite;
                $xrptas = DB::table($Menvio->tablename)
                        ->where( 'updated_at' , '>' , $xfenvio )
                        ->where( 'updated_at' , '<' , $xflimite )
                        ->get();
                foreach ($xrptas as $xrpta) 
                {
                    $xDenvio = Denvio::where( 'user_id' , '=' , $xrpta->user_id )
                        ->where('menvio_id' , '=' , $Menvio->id)->get();
                    if ($xDenvio->isEmpty() == false ) 
                    {
                        $xxDenvio = Denvio::find($xDenvio[0]->id);
                        $xxDenvio->sw_rpta = 1;
                        $xxDenvio->save();
                    }
                }

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
                $rptas = 0;
                if ($Denvios->isEmpty() == false) 
                {
                    foreach ($Denvios as $Denvio) 
                    {
                        $rptas = $rptas + $Denvio->sw_rpta;
                    }
                }
                $xEnvio = Menvio::find($Menvio->id);
                $xEnvio->rptas = $rptas;
                $xEnvio->save();
            }    
        }
    }




}
