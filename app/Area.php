<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    const AREA_HABILITADA='h';
    const AREA_NO_HABILITADA='d';

    public $timestamps=false;

    protected $fillable=[
        'name',
        'code',
        'status'
    ];

    public function estaHabilitada()
    {
        return $this->status == Area::AREA_HABILITADA;
    }


    public function departments(){
        return $this->hasMany('App\Department');
    }
}
