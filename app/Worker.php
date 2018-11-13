<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Worker extends Model
{
    protected $fillable=[
        'user_id',
        'department_id',
        'first_name',
        'last_name',
        'email',
        'dni',
        'passport',
        'position',
        'treatment'
    ];

    public function user(){
        return $this->belongsTo('App\User');
    }

    public function department(){
        return $this->belongsTo('App\Department');
    }
}
