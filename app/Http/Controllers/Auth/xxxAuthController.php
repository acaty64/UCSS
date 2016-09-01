<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;

class AuthController extends Controller
{
    /*
    * En el controllador app/Http/Controllers/Auth/AuthController.php 
    * añadimos la propiedad, que es la encargada de decirle a Laravel 
    * que utilice el campo username en vez de email.
    */

    protected $username = "username";

    protected function getLogin(){
        //dd('\app\Http\Controllers\Auth\AuthController');
        return view('admin.auth.login');
    }
    
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware($this->guestMiddleware(), ['except' => 'logout']);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {

        //dd('function validator');

        return Validator::make($data, [
            'username' => 'required|max:6|unique:users',  
            'password' => 'required|min:6|confirmed',
        ]);
    }
    //'email' => 'required|email|max:255|unique:users',

    /**
     * Create a new user instance after a valid registration.   NO SE USARA PORQUE SE CREA EN EL ADMINISTRADOR
     *
     * @param  array  $data
     * @return User
     */ 
    /*protected function create(array $data)
    {
        return User::create([
            'user' => $data['user'],
            //'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
    }*/


    

    /* Se redirige a donde queremos despues del login */
    protected $redirectPath = '/admin';

    
}
