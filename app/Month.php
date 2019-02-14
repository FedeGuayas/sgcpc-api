<?php

namespace App;

use App\Transformers\MonthTransformer;
use Illuminate\Database\Eloquent\Model;

class Month extends Model
{
    public $timestamps = false;

    protected $fillable=[
        'month',
        'cod'
    ];

    public $transformer = MonthTransformer::class;

    public function setMonthAttribute($value) {
        $this->attributes['month']=mb_strtolower($value);
    }

    public function getMonthAttribute($value) {
        return mb_strtoupper($value);
    }

}
