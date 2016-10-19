<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;


use DB;

class AccionesController extends Controller
{
	public function ExportSQL()
    {
    	DB::unprepared(\File::get(storage_path('imports').'/dataremota.sql'));
    }

    public function DownData()
    {
    	return view('errors.000');
    }
}
