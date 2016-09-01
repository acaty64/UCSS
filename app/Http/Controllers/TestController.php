<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Dhora;

class TestController extends Controller
{
    public function view($id){
    	$datauser = \App\DataUser::find($id);
    	dd($datauser);
    }
}
