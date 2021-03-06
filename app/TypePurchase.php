<?php

namespace App;

use App\Transformers\TypePurchaseTransformer;
use Illuminate\Database\Eloquent\Model;

class TypePurchase extends Model
{
    public $timestamps = false;

    const ENABLED = '1';
    const DISABLED = '0';

    protected $fillable=[
        'name',
        'status'
    ];

    public $transformer = TypePurchaseTransformer::class;

    public function setNameAttribute($value) {
        $this->attributes['name']=mb_strtolower($value);
    }

    public function getNameAttribute($value) {
        return mb_strtoupper($value);
    }
}
