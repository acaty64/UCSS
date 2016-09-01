<?php
/* MODEL User */
namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
//    use Sluggable;

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
         return $this->hasMany('App\Dcurso');
    }

    public function dhoras()
    {
         return $this->hasMany('App\Dhora');
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
    

    /************* FUNCIONES ********************/
    public function wDocente($id){
        $user = User::find($id);
        return $user->wdoc2." ".$user->wdoc3.", ".$user->wdoc1;
    }

}