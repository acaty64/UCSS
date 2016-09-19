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
     * Create a new authentication controller instance.
     *
     * @return void
     */
    /*public function __construct()
    {
        $this->middleware($this->guestMiddleware(), ['except' => 'logout']);
    }*/

    protected $username = "username";

    public function authenticate()
    {
        if (Auth::attempt(['username' => $username, 'password' => $password])) {
            // Authentication passed...
            return redirect()->intended('dashboard');
        }

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
            'username' => 'required|min:6|max:6|unique:users',  
            'password' => 'required|min:6|confirmed',
        ]);
    }

    

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    //protected $redirectTo = '/'; 
    //protected $redirectPath = '/admin';
    //protected $loginPath = '/auth/login';
    protected $redirectTo = '/home';
    protected $redirectAfterLogout = '/login';

/*    protected function getLogin(){
        //dd('\app\Http\Controllers\Auth\AuthController\getLogin()');
        return view('auth.login');
    }
    protected function postLogin(){
        //dd('\app\Http\Controllers\Auth\AuthController\postLogin()');
        return view('index');
    }*/

    /*protected function getLogout(){
        dd(Auth::guest());
        return view('auth.login');
    }*/

}
