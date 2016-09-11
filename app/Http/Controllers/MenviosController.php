<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Collection as Collection;
use DB;

use App\Http\Requests;

use App\Menvio;
use App\Denvio;
use App\User;
use Laracasts\Flash\Flash;

class MenviosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
//dd('Aqui viene la vista admin.envios.index');
        
        $this->tfcia_rptas();
        $this->recontar_envios();
        $this->recontar_rptas();

        $Menvios = Menvio::orderBy('fenvio', 'DESC')->paginate(6);
        return view('admin.envios.index')
            ->with('Menvios', $Menvios);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //dd('MenviosController@create');
        return view('admin.envios.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
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
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
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

    /* MOSTRAR LOS DETALLES */
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

    /* ACTUALIZAR LOS DETALLES*/
    public function dupdate(Request $request)
    {
//dd($request['xenvios']);
//        dd($denvios);
        $denvios = $request['xenvios'];
//dd($request->all());
        $contador01 = 0;
        $contador10 = 0;
        foreach ($denvios as $id => $value) {
//dd($value);
            $denvio = Denvio::find($id);
//dd($denvio);
            if ($denvio->getOriginal('sw_envio') != $value) {
                $denvio->sw_envio = $value;
                if ($denvio->sw_envio == 1) {
                    $contador01++;
                }else{
                    $contador10++;
                }
    //        dd($denvio);    
                $denvio->save();
            }
        }
        Flash::success($contador01.' marcas agregadas, '.$contador10. ' marcas eliminadas.');
        return back();                
    }

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

    public function dunmarkall($id)
    {
        $newvalue = 0;
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
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
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
        Flash::error('Se ha eliminado el envio: '.$menvio->id.' de forma exitosa');
        return redirect()->route('admin.menvios.index');
    }

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

    /*************************
    /* Transfiere las respuestas de las tablas definidas en Menvios a los registros de Denvios
    /************************/
    public function tfcia_rptas()
    {
        $Menvios = Menvio::all();
        if ($Menvios->isEmpty() == false) 
        {
            foreach ($Menvios as $Menvio) 
            {
                $xfenvio = $Menvio->fenvio;
                $xrptas = DB::table($Menvio->tablename)
                        ->where( 'updated_at' , '>' , $xfenvio)->get();
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



}
