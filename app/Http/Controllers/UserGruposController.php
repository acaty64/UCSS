<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use App\Http\Requests;
use App\User;
use App\Grupo;
use App\UserGrupo;
use Laracasts\Flash\Flash;

class UserGruposController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
//        dd('Muestra los responsables y los grupos asociados');
        $users = User::sType('03')->paginate(6);
        
        return view('admin.userGrupos.index')
            ->with('users', $users);
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
    public function edit($id)
    {
        // Identifica el usuario
        $user = user::find($id);
//dd($user);
        // Selecciona los grupos no utilizados -> $gruposdiff
        $xgrupos = Grupo::all()->lists('wgrupo', 'id');
//dd($xgrupos);
        $usergrupos = UserGrupo::all()->lists('grupo_id');
//dd($usergrupos);
        $gruposdiff = $xgrupos->diff($usergrupos);
//dd($gruposdiff);
//dd($user->usergrupo->id);
        // Identifica el UserGrupo anterior 
        $usergrupo = UserGrupo::suser($id)->first();
        //$usergrupo = UserGrupo::find($user->usergrupo->id)->first();
//dd($usergrupo);
        //if ($usergrupo->count()==0){
        if ($usergrupo == null) {
            // Crea un nuevo UserGrupo vacio
            $usergrupo = new UserGrupo;
            // Agrega el valor del campo user_id
            $usergrupo->user_id = $id;
            // Define los grupos no utilizados
            $grupos = $gruposdiff ;
//dd($usergrupo);
        }else{
            // Agrega el grupo del usuario actual a los grupos no utilizados
            $oldgrupos = Grupo::where('id','=',$user->usergrupo->grupo_id)->lists('wgrupo', 'id');
//dd($xxgrupos);
            $grupos = $oldgrupos->merge($gruposdiff);
//dd($newgrupos);
        }
//dd($usergrupo);
        return view('admin.userGrupos.edit')
            ->with('grupos',$grupos)
            ->with('usergrupo', $usergrupo);
//            ->with('user',$user)
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
//dd($request);
//dd($user_id);
//dd($request->all());
/****************************************************************************//////
        $user = User::find($user_id);
//dd($user->usergrupo->grupo->wgrupo);
        if (empty($user->usergrupo->grupo->wgrupo))
        {
            $usergrupo = new UserGrupo;
            $usergrupo->user_id = $user_id;
        }else
        {
            $id_usergrupo = User::find($user_id)->usergrupo->id;
//dd($id_usergrupo);
            $usergrupo = UserGrupo::find($id_usergrupo);
        }
        // Agrega el grupo_id
        $usergrupo->grupo_id = $request->grupo;
//dd($usergrupo);
        // Graba el usergrupo
        $usergrupo->save();
        Flash::success('Se ha registrado la asociación de forma exitosa');
        return redirect()->route('admin.usergrupos.index');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $xid = User::find($id)->usergrupo->id;
        $usergrupo = UserGrupo::find($xid);
        $usergrupo->delete();  
        Flash::error('Se ha disociado el grupo de forma exitosa');
        return redirect()->route('admin.usergrupos.index');
    }

}
