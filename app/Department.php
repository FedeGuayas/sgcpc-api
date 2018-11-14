<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Department extends Model
{
    use SoftDeletes;

    public $timestamps=false;

    protected $dates=['deleted_at'];

    protected $fillable=[
        'area_id',
        'name'
    ];


    public function setNameAttribute($value)
    {
        $this->attributes['name']=mb_strtolower($value);
    }

    public function getNameAttribute($value)
    {
        return mb_strtoupper($value);

    }

    /**Relaciones**/

    public function area(){
        return $this->belongsTo('App\Area');
    }

    public function workers(){
        return $this->hasMany('App\Worker');
    }
}
