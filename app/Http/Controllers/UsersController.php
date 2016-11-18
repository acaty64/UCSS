<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Requests\UserRequest;

use Laracasts\Flash\Flash;
use Carbon\Carbon;

use App\User;
use App\DataUser;
use App\DHora;
use App\Franja;
use App\Sede;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //date_default_timezone_set('America/Lima');
        $hoy = Carbon::now();
        //$users = User::sDocente($request->wdocente)->orderBy('id', 'DESC')->paginate(6);
        $users = User::search($request->get('wdocente'), $request->get('type'))->orderBy('id', 'ASC')->paginate(6);
        return view('admin.users.index')
            ->with('users',$users)
            ->with('hoy',$hoy);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //$user = new User;
        return view('admin.users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {
        // Recibe los datos del formulario de resources\admin\users\create.blade.php
        $user = new User($request->all());
        $user->password = bcrypt($request->password);
        $user->swcierre = '0';
        $user->slug = '';
        $user->save(); 
        
        // Crea un registro en DataUser
        $datauser = new DataUser();
        $datauser->cdocente = $user->username;
        $datauser->user()->associate($user);
        $datauser->save();

        // Crea un registro en DHora
        $dhora = new DHora();
        //$dhora->csede = 'LIM';
        $dhora->cdocente = $user->username;
        //$dhora->sede_id = Sede::where('csede','=', $dhora->csede)->first()->id;
        $dhora->user()->associate($user);
//        $dhora->sede()->associate($sede);
        $dhora->save();

        Flash::success('Se ha registrado '.$user->username.' de forma exitosa');
        return redirect()->route('admin.users.index');

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

        $user = User::find($id);
        return view('admin.users.edit')->with('user', $user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserRequest $request, $id)
    {
        $user = User::find($id);
        $user->fill($request->all());
        //$user->password = bcrypt($request->password);
        $user->save();
//dd($user);
        Flash::warning('Se ha modificado el registro: '.$user->id.' código:'.$user->username.' de forma exitosa');
        return redirect()->route('admin.users.index');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id);
        $user->delete();          
        Flash::error('Se ha eliminado el registro: '.$user->id.' '.$user->username.' de forma exitosa');
        return redirect()->route('admin.users.index');
    }

    /**********************************************/
    /* Edita el password
    /**********************************************/
    public function editpass($id)
    {
        $user = User::find($id);
        return view('admin.users.chpass')->with('user', $user);
    }

    /**********************************************/
    /* Graba el password 
    /**********************************************/
    public function savepass(Request $request, $id)
    {
//        dd($id);
        if ($request->password == $request->checkpassword) 
        {
            $user = User::find($id);
            $user->password = bcrypt($request->password);
            $user->save(); 
            Flash::success('Se ha modificado el password de '.$user->wdocente($id).' de forma exitosa');
            return redirect()->route('admin.users.index');
        }else{
            Flash::success('Ingrese la misma clave en las dos casillas.');
            return redirect()->back();
        }
    }

    /**********************************************/
    /* Encripta los passwords
    /**********************************************/
    public function cryptpass($id)
    {
        // dd('cryptpass');
        $contador = 0;
        $users = User::all(); 
        foreach ($users as $user) 
        {
//            dd($user);
            $password = $user->password;
//            dd('lenght'.strlen($password));
            if (strlen(trim($password)) < 15) {
                $xuser = User::find($user->id);
                $user->password = bcrypt($password);
                $user->save();
                $contador++;
            }    
        }
        Flash::success($contador.' Passwords encriptados.');
            return redirect()->back();

    }

}
