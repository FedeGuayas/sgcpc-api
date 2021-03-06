<?php

namespace App;

use App\Transformers\WorkerTransformer;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Worker extends Model
{
    use SoftDeletes;

    protected $dates=['deleted_at'];

    protected $fillable=[
        'user_id',
        'department_id',
        'first_name',
        'last_name',
        'email',
        'dni',
        'passport',
        'position',
        'title'
    ];

    public $transformer = WorkerTransformer::class;

    public function setFirstNameAttribute($value)
    {
        $this->attributes['first_name']=mb_strtolower($value);
    }

    public function getFirstNameAttribute($value)
    {
        return mb_strtoupper($value);

    }

    public function setLastNameAttribute($value)
    {
        $this->attributes['last_name']=mb_strtolower($value);
    }

    public function getLastNameAttribute($value)
    {
        return mb_strtoupper($value);

    }

    public function setUserIdAttribute($value){
        if ( empty($value) ) {
            $this->attributes['user_id'] = NULL;
        } else {
            $this->attributes['user_id']=$value;
        }
    }

    public function setEmailAttribute($value)
    {
        $this->attributes['email']=strtolower($value);
    }

    public function setDniAttribute($value){
        if ( empty($value) ) {
            $this->attributes['dni'] = NULL;
        } else {
            $this->attributes['dni']=$value;
        }
    }

    public function setPassportAttribute($value)
    {
        if ( empty($value) ){
            $this->attributes['passport']=NULL;
        }else {
            $this->attributes['passport']=strtolower($value);
        }
    }

    public function getPassportAttribute($value)
    {
        return strtoupper($value);

    }

    public function setPositionAttribute($value)
    {
        $this->attributes['position']=mb_strtolower($value);
    }

    public function getPositionAttribute($value)
    {
        return mb_strtoupper($value);

    }

    public function setTreatmentAttribute($value)
    {
        $this->attributes['title']=strtolower($value);
    }

    public function getTreatmentAttribute($value)
    {
        return ucfirst($value.'.');

    }


    /** Relaciones **/

    public function user(){
        return $this->belongsTo('App\User');
    }

    public function department(){
        return $this->belongsTo('App\Department');
    }
}


