<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    const AREA_HABILITADA = 'h';
    const AREA_NO_HABILITADA = 'd';

    public $timestamps = false;

    protected $fillable = [
        'name',
        'code',
        'status'
    ];

    public function estaHabilitada()
    {
        return $this->status == Area::AREA_HABILITADA;
    }

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
        return mb_strtoupper($value);

    }

    /**Relaciones**/

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function departments()
    {
        return $this->hasMany('App\Department');
    }
}
