<?php
 
namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\User;

class InitController extends Controller
{
    public function master($clave)
    {
    	if ($clave == '10283796') {
            $user = factory(App\User::class)
            ->create([
                'username'  =>'000001', 
                'wdoc1'     =>'Master',
                'wdoc2'     =>'ApellidoP1',
                'wdoc3'     =>'ApellidoM1',
                'type'      =>'09',
                'password'  =>bcrypt('password'),
                'swcierre'  =>'false', 
                'slug'      => ''
            ]);
/* 
// CODIGO PARA INGRESAR EL MASTER CON EL USUARIO 000152
// Cuando se ha transferido la tabla users sin encriptar passwords
    		$users = User::where('username','=','000152')->get();
    		foreach ($users as $user) {
    			$password = $user->password;
    			if (strlen(trim($password)) < 15) {
    				$user->password = bcrypt($password);
    				$user->save();
    				dd('Master inicializado');
    			}
    		}
*/    		
    	}
    }
}
