<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Menvio extends Model
{
    protected $table = 'menvios';		
    protected $fillable = [		
    	'fenvio', 'flimite', 'envios', 'rptas', 'tipo', 'tablename', 'tx_need', 'sw_envio'
    ];	

    public function Denvios()
    {
         return $this->hasMany('App\Denvio');
    }
}
