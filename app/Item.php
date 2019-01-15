<?php

namespace App;

use App\Transformers\ItemTransformer;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Item extends Model
{

    use SoftDeletes;

    protected $dates=['deleted_at'];

    protected $fillable=[
        'name',
        'code'
    ];


    public $transformer = ItemTransformer::class;

    public function setNameAttribute($value) {
        $this->attributes['name']=mb_strtolower($value);
    }

    public function getNameAttribute($value) {
        return mb_strtoupper($value);
    }


    /** Relaciones **/

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function partidas() {
        return $this->belongsTo('App\Partida');
    }

}
