<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use  Cviebrock\EloquentSluggable\Sluggable;

class DataUser 
extends Model
{
    

   	protected $table = 'datausers';		
    protected $fillable = [		
    	'cdocente',
    	'fono1',
    	'fono2',
    	'email1',
    	'email2',
        'whatsapp'
    ];	

     /**
     * Get the user that owns the data.
     */
    public function user()
    {
        /* return $this->belongsTo('App\User', 'foreign_key'); */
        return $this->belongsTo('App\User');
    }	

    

}
