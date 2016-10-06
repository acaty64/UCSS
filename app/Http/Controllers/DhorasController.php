<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Carbon\Carbon;
use Laracasts\Flash\Flash;
use Maatwebsite\Excel\Facades\Excel;

use App\User;
use App\Dhora;
use App\Franja;
use App\Denvio;
use App\Menvio;


class DhorasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('errors.000');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('errors.000');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return view('errors.000');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view('errors.000');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($user_id)
    {
        
        $franjas = Franja::get();
        $gfranjas = Franja::orderby('turno','ASC')->orderby('hora','ASC')->groupby('turno','hora')->get();
        $wdocente = User::find($user_id);
        $dhoras = $wdocente->dhora;
        if(empty($dhoras)){
            $dhoras = new Dhora;
            $dhoras->user_id = $wdocente->id;
            $dhoras->cdocente = $wdocente->username;
            $dhoras->save();
        }
        
        $sw_cambio = $this->sw_cambio($user_id, 'disp');

        return view('admin.dhoras.edit')
            ->with('sw_cambio',$sw_cambio)
            ->with('franjas', $franjas)
            ->with('gfranjas',$gfranjas)
            ->with('dhoras', $dhoras)
            ->with('wdocente',$wdocente);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        // Actualiza la disponibilidad horaria
        $dhoras = Dhora::find($request->dhoras_id);
//dd($dhoras);
        // Rehacer data
        $franjas = Franja::get();
        foreach ($franjas as $franja) {
            $campo = 'D'.$franja->dia.'_H'.$franja->turno.$franja->hora;
            if ($request->$campo == 'on') {
                $dhoras->$campo = 1;
            }else{
                $dhoras->$campo = 0;
            }
        }
        // Graba en archivo Dhoras
        $dhoras->save();
        // Actualiza el sw_envio en archivo Denvios
        date_default_timezone_set('America/Lima');
        $hoy = Carbon::now();
        $ayer = Carbon::now()->subDays(1);
        $denvios = User::find($request->user_id)->denvios;
        if (empty($denvios)) {
            Flash::success('No se ha enviado correo electronico');
            return redirect()->back();
        }else{
            $salida = collect([]);      
            foreach ($denvios as $denvio) {
                $menvio = $denvio->menvio;
                $salida = $salida->merge(['hoy'=>$hoy,'ayer'=>$ayer,'fenvio'=>$denvio->menvio->fenvio, 'flimite'=>$denvio->menvio->flimite]);
                if ($denvio->menvio->fenvio < $hoy
                            and $denvio->menvio->flimite > $ayer) 
                {
                    $denvio->sw_rpta = '1';
                    $denvio->save();
                }
            }
        }
        // Redirecciona segun tipo de usuario ********** FALTA PROBAR CON ->back()
        Flash::success('Se ha registrado la modificación de forma exitosa');
        if (\Auth::user()->type == '09') {
            return redirect()->route('admin.users.index');
        }else{
            return redirect()->route('admin.dhoras.edit', $dhoras->user_id);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return view('errors.000');
    }

    /* Identifica si tiene envio de disponibilidad pendiente */
        // Si el usuario es master puede modificar
        // Selecciona los denvios del usuario
        // Selecciona los menvios relacionados
        // Verifica si existe un menvio pendiente 
    public function sw_cambio($user_id, $tipo)
    {
        if (\Auth::user()->type == '09') {
            $sw_cambio = '1';
        }else{
            date_default_timezone_set('America/Lima');
            $hoy = Carbon::now();
            $ayer = Carbon::now()->subDays(1);
            $denvios = User::find($user_id)->denvios;
            if (!empty($denvios)) {
                $menvios = [];
                $contador = 0;
                foreach ($denvios as $denvio) {
                    if ($denvio->menvio->tipo=$tipo 
                            and $denvio->menvio->fenvio < $hoy
                            and $denvio->menvio->flimite > $ayer)
                    {
                        $menvios[$contador++] = $denvio->menvio->toArray();
                    }
                }
                if(!empty($menvios)){
                    $sw_cambio = '1';
                }else{
                    $sw_cambio = '0';
                }
            }else{
                $sw_cambio = '0';
            }            
        }
        return $sw_cambio;
    }

    /* Lista las actualizaciones de disponibilidad de horas */
    public function lista()
    {
        $lista = $this->status_horas();
        return view('admin.dhoras.list')
            ->with('lista', $lista);
    } 

    public function status_horas()
    {
return view('errors.000');
        // Lista los usuarios con lo siguiente:
        //      Solicitado: fecha de envio
        //      Limite: fecha limite
        //      Respuesta: fecha de respuesta
        // $merged = $collection->merge(['price' => 100, 'discount' => false]);
        $contador = 0;
        $xlista = [];        
        $registro = collect([]);        
        $users = User::all();
        foreach ($users as $user) {
            $registro = $registro->merge([
                'user_id' => $user->id,
                'username' => $user->username,
                'wdocente' => $user->wdocente($user->id) ]);
            $denvios = $user->denvios;
            foreach ($denvios as $denvio) {
                if ($denvio->menvio->tipo == 'disp' 
                        and $denvio->tipo == 'horas'
                        and $denvio->sw_envio == '1') {
                    if($denvio->updated_at > $denvio->menvio->fenvio){
                        $registro = $registro->merge([                                
                                'sw_rpta' => $denvio->sw_rpta,
                                'updated_at' => $denvio->updated_at->toDateString(),
                                'fenvio' => $denvio->menvio->fenvio,
                                'flimite' => $denvio->menvio->flimite,
                                'sw_actualizacion' => 'actualizado',
                                'tipo' => $denvio->menvio->tipo,
                                'user_denvio' => $denvio->id
                            ]);
                    }else{
                        $registro = $registro->merge([
                                'sw_rpta' => $denvio->sw_rpta,
                                'updated_at' => $denvio->updated_at->toDateString(),
                                'fenvio' => $denvio->menvio->fenvio,
                                'flimite' => $denvio->menvio->flimite,
                                'sw_actualizacion' => 'PENDIENTE',
                                'tipo' => $denvio->menvio->tipo,
                                'user_denvio' => $denvio->id
                            ]);
                    }
                    $xlista[$contador++] = $registro;
                }
            }
        }
        $xlista = collect($xlista);
        // Selecciona el ultimo envio modificado
        $contador = 0;
        $lista = []; 
        $users = $xlista->groupBy('user_id');
        foreach ($users as $user) {
            $xuser = $user->first();
            $denvios = $xlista->where('user_id', $xuser['user_id']);
            $denvios = $denvios->sortBy('fenvio');
            $lista[$contador++] = $denvios->last();
        }
        $lista = collect($lista);
        $lista = $lista->sortBy('wdocente');
        return $lista;
    }

    public function List2Excel()
    {        
        $lista = $this->status_horas();
        $namefile = 'DispHoras_'.Carbon::now();
        $now = Carbon::now();
        $namefile = 'DH_'.$now->format('Y').'_'.$now->format('m').'_'.$now->format('d').'_'.$now->format('H').'_'.$now->format('i').'_'.$now->format('s');
        Excel::create($namefile, function($excel) use($lista){
            $excel->sheet('Disponibilidad Horaria', function($sheet) use($lista){
                $sheet->fromArray($lista);
            });
        })->download('xls');
    }
    
}
