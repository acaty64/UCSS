<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Envio extends Model
{
    protected $table = 'envios';		
    protected $fillable = [		
    	'user_id', 'email_to', 'email_cc', 'fenvio', 'flimite'
	
    ];	

    public function user()
    {
         return $this->belongsTo('App\User');
    }

}
