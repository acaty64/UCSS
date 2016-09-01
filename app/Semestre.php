<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Semestre extends Model
{
    protected $table = 'semestres';

    protected $fillable = ['semestre','swactivo','inicio','fin','cierredisp','cierredata'];


    public function franjas()
    {
         return $this->hasMany('App\Franja');
    }

    public function scopeActivo($query)
    {
        return $query->where('swactivo', '=', '1');
    }
}
