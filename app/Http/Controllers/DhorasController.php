<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\User;
use App\Dhora;
use App\Franja;
use Laracasts\Flash\Flash;

class DhorasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        //
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
    public function edit($user_id)
    {
        
        $franjas = Franja::get();
        $gfranjas = Franja::orderby('turno','ASC')->orderby('hora','ASC')->groupby('turno','hora')->get();
        $xhoras = User::find($user_id)->dhoras()->get();
        $dhoras = $xhoras[0];
        $wdocente = User::find($user_id)->wdocente($user_id);

        return view('admin.dhoras.edit')
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
    public function update(Request $request, $user_id)
    {
//        dd($user_id);
        $dhoras = Dhora::find($user_id);
//        dd($dhoras);
//        $dhoras->fill($request->all());
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
//        dd($dhoras);
        $dhoras->save(); 
        Flash::success('Se ha registrado la modificación de forma exitosa');
        if (\Auth::user()->type == 'admin') {
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
        //
    }
}
