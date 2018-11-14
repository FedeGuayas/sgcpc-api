<?php

namespace App;

use App\Scopes\UserScope;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Hash;

class User extends Authenticatable
{

    //Este Scope global hace que las consultas de user solo me devuelvan los que son trabajadores
    protected static function boot(){
        parent::boot(); //necesario para mantener el correcto funcionamiento del framework
        static::addGlobalScope(new UserScope());
    }


    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];


    public function setPasswordAttribute($value)
    {
        if ( ! empty ($value))
        {
            $this->attributes['password'] = Hash::make($value);
        }
    }

    public function setEmailAttribute($value)
    {
        $this->attributes['email']=strtolower($value);
    }

    public function setNameAttribute($value)
    {
        $this->attributes['name']=strtolower($value);
    }

    public function getNameAttribute($value)
    {
        return ucwords($value);

    }



    /*** Relaciones***/

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function worker(){
        return $this->hasOne('App\Worker');
    }
}
