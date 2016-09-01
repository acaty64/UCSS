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

    /** SCOPE grupo SEMESTRE actual 
    public function scopeSsemestre($query){
        return $query->where('semestre', '=', \Auth::user()->semestre);
    }
*/
}
