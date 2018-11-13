<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    public $timestamps=false;

    protected $fillable=[
        'area_id',
        'name'
    ];

    public function area(){
        return $this->belongsTo('App\Area');
    }

    public function workers(){
        return $this->hasMany('App\Worker');
    }
}
