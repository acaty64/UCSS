<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Grupo extends Model
{
    protected $table = 'grupos';		
    protected $fillable = [		
    	//'semestre','cgrupo','wgrupo'
        'cgrupo','wgrupo'	
    ];		

    public function cursos()
    {
         return $this->hasMany('App\GrupoCurso');
    }
    public function usergrupo()
    {
        return $this->hasOne('App\UserGrupo');
    }

    /** SCOPE grupo SEMESTRE actual 
    public function scopeSsemestre($query){
        return $query->where('semestre', '=', \Auth::user()->semestre);
    }
*/
}
