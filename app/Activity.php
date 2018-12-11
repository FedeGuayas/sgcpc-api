<?php

namespace App;

use App\Transformers\ActivityTransformer;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Activity extends Model
{
    use SoftDeletes;

    protected $dates=['deleted_at'];

    protected $fillable = [
        'name',
        'code'
    ];

    protected $hidden=[
        'pivot'
    ];

    public $transformer = ActivityTransformer::class;

    public function setNameAttribute($value)
    {
        $this->attributes['name']=mb_strtolower($value);
    }

    public function getNameAttribute($value)
    {
        return mb_strtoupper($value);

    }

    public function setCodeAttribute($value)
    {
        $this->attributes['code']=strtolower($value);
    }

    public function getCodeAttribute($value)
    {
        return strtoupper($value);

    }

    /*
     * Relaciones
     */
    public function programs(){
        return $this->belongsToMany('App\Program');
    }
}
