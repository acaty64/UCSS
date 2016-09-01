<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sede extends Model
{
    
	protected $table = 'sedes';

    protected $fillable = ['csede','wsede' ];

    public function franjas()
    {
         return $this->hasMany('App\Franja');
    }
}
