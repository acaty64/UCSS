<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use  Cviebrock\EloquentSluggable\Sluggable;

class DCurso extends Model
{
    protected $table = 'dcursos';		
    protected $fillable = [		
    	//'semestre','ccurso','cdocente'
        'curso_id','user_id', 'cdocente', 'ccurso', 'prioridad'
    ];	

    public function curso()
    {
        //return $this->belongsTo('App\Curso')->withTimeStamps();
        return $this->belongsTo('App\Curso');
    }	

    public function user()
    {
        return $this->belongsTo('App\User');
    }
    
    /** SCOPE dcursos SEMESTRE actual 
    public function scopeSsemestre($query){
        return $query->where('semestre', '=', \Auth::user()->semestre);
    }
*/

    /** SCOPE dcursos USER_ID */
    public function scopeSuser_id($query, $user_id){
        return $query->where('user_id', '=', $user_id);
    }

}
