<?php
/* MODEL User */
namespace App;
    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
/*    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'wdoc2'.'-'.'wdoc3'.','.'wdoc1'
            ]
        ];
    }
*/
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
    */

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
//    use Sluggable;
    protected $table = 'users';
    protected $fillable = [
        'username', 
        'wdoc1',
        'wdoc2',
        'wdoc3',
        'type', 
        'swcierre',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 
    ];

    public function datauser()
    {
        return $this->hasOne('App\DataUser');
    }

    public function dcursos()
    {
         return $this->hasMany('App\DCurso');
    }

    public function dhora()
    {
         return $this->hasOne('App\DHora');
    }

    public function denvios()
    {
         return $this->hasMany('App\Denvio');
    }

    public function usergrupo()
    {
        return $this->hasOne('App\UserGrupo');
    }
/* 
    public function getNameAttribute(){
        return this->wdoc2." ".this->wdoc3.", ".this->wdoc1;
    }
*/
    /************** SCOPEs **********************/
    /** SCOPE apellido paterno */
    public function scopeSdocente($query, $wdocente){
        return $query->where('wdoc2', 'LIKE', "%$wdocente%");
    }
    /** SCOPE tipo de usuario */
    public function scopeStype($query, $type){
        return $query->where('type', '=', "$type");
    }
    

    /************* FUNCIONES ********************/
    public function wDocente($id){
        $user = User::find($id);
        return $user->wdoc2." ".$user->wdoc3.", ".$user->wdoc1;
    }

    
}
