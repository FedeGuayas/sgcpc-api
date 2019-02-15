<?php

namespace App;

//use App\Scopes\UserScope;
use App\Transformers\UserTransformer;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Hash;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{

    use Notifiable,HasApiTokens,SoftDeletes;

    const USUARIO_VERIFICADO='1';
    const USUARIO_NO_VERIFICADO='0';

    protected $dates=['deleted_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'verified',
        'verification_token'
    ];

    /**
     * Propiedad para realcionar el modelo User con su Transformer
     * @var string
     */
    public $transformer = UserTransformer::class;

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'verification_token'
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

    /**
     * true => si es verificado
     * @return bool
     */
    public function esVerificado(){
        return $this->verified == User::USUARIO_VERIFICADO;
    }

    /**
     * Genera el Token de verificacion del usuario
     * @return string
     */
    public static function generarVerificationToken(){
        return hash_hmac('sha256', str_random(40), config('app.key'));
    }


    /*** Relaciones***/

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function worker(){
        return $this->hasOne('App\Worker');
    }
}
