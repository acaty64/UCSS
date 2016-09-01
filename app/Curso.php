<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Curso extends Model
{
    protected $table = 'cursos';

    protected $fillable = [
    	'ccurso','wcurso'
    ];

    public function dcursos()
    {
         return $this->hasMany('App\Dcurso');
    }

    public function grupocursos()
    {
         return $this->hasMany('App\GrupoCurso');
    }

}
