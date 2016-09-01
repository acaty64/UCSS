<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GrupoCurso extends Model
{
    protected $table = 'grupocursos';		
    protected $fillable = [		
    	//'semestre','cgrupo','ccurso'
        'cgrupo','ccurso'	
    ];

/*    public function semestre()
    {
        return $this->belongsTo('App\Semestre');
    }
*/
    public function grupo()
    {
        return $this->belongsTo('App\Grupo');
    }
    		
    public function curso()
    {
        return $this->belongsTo('App\Curso');
    }

    /** SCOPE grupo SEMESTRE actual 
    public function scopeSsemestre($query){
        return $query->where('semestre', '=', \Auth::user()->semestre);
    }
*/
    /** SCOPE grupo CGRUPO */
    public function scopeSgrupo($query,$cgrupo){
        //dd($query->where('cgrupo', '=', $cgrupo));
        return $query->where('cgrupo', '=', $cgrupo);
    }

}
