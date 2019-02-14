<?php

namespace App;

use App\Transformers\AreaTransformer;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Area extends Model
{
    use SoftDeletes;

    protected $dates=['deleted_at'];

    protected $fillable = [
        'name',
        'code'
    ];

    public $transformer = AreaTransformer::class;

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

    /**Relaciones**/

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function departments()
    {
        return $this->hasMany('App\Department');
    }

    /**
     * Trabajadores de un area
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function workers()
    {
        return $this->hasManyThrough('App\Worker', 'App\Department');
    }
}
