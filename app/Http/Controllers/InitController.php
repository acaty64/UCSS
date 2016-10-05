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
    		$users = User::where('username','=','000152')->get();
    		foreach ($users as $user) {
    			$password = $user->password;
    			if (strlen(trim($password)) < 15) {
    				$user->password = bcrypt($password);
    				$user->save();
    				dd('Master inicializado');
    			}
    		}    		
    	}
    }
}
