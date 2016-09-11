<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Denvio extends Model
{
    protected $table = 'Denvios';		
    protected $fillable = [		
    	'user_id', 'menvio_id', 'email_to', 'email_cc', 'fenvio', 'flimite', 'sw_envio','sw_rpta'
    ];	

    public function user()
    {
         return $this->belongsTo('App\User');
    }
	
	public function menvio()
    {
         return $this->belongsTo('App\Menvio');
    }
}
