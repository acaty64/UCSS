<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Menvio extends Model
{
    protected $table = 'menvios';		
    protected $fillable = [		
    	'fenvio', 'flimite', 'envio1', 'envio2', 'rpta1', 'rpta2' , 'tipo', 'tablename', 'tx_need', 'sw_envio'
    ];	

    public function denvios()
    {
         return $this->hasMany('App\Denvio');
    }

   	
}
