<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Franja extends Model
{
    protected $table = 'franjas';		
    protected $fillable = [		
    	//'semestre',
        'csede','dia', 'turno', 'hora', 'wfranja', 'sede_id'	
    ];	

    public function dhoras()
    {
         return $this->hasMany('App\DHora');
    }

/*    public function semestre()
    {
        return $this->belongsTo('App\Semestre');
    }
*/
    public function sede()
    {
        return $this->belongsTo('App\Sede');
    }

    /** SCOPE Franjas SEMESTRE actual 
    public function scopeSsemestre($query)
    {
        return $query->where('semestre', '=', \Auth::user()->semestre);
    }
 */
}
