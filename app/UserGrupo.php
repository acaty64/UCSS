<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserGrupo extends Model
{
    protected $table = 'usergrupos';		
    protected $fillable = [		
    	'user_id', 'grupo_id', 'cdocente', 'cgrupo'
    ];	

    public function user()
    {
         return $this->belongsTo('App\User');
    }

    public function grupo()
    {
         return $this->belongsTo('App\Grupo');
    }

    /** SCOPE user_id */
    public function scopeSuser($query, $user_id){
        return $query->where('user_id', '=', "$user_id");
    }
}
