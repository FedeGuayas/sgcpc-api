<?php

namespace App;

use App\Transformers\DepartmentTransformer;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Department extends Model
{
    use SoftDeletes;

    protected $dates=['deleted_at'];

    protected $fillable=[
        'area_id',
        'name'
    ];

    public $transformer = DepartmentTransformer::class;


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
