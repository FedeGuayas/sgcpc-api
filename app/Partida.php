<?php

namespace App;

use App\Transformers\PartidaTransformer;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Partida extends Model
{
    use SoftDeletes;

    protected $dates=['deleted_at'];

    protected $fillable=[
        'program_id',
        'activity_id',
        'item_id',
        'programa',
        'actividad',
        'renglon',
        'presupuesto',
        'disponible',
        'origen'
    ];

    const ORIGEN_AUTOGESTION = "A";
    const ORIGEN_ESTADO = "E";

    public $transformer = PartidaTransformer::class;



    public function setOrigenAttribute($value){

        $value = strtolower($value);

        if ($value === 'e' || $value === 'estado' ){
            $this->attributes['origen'] = Partida::ORIGEN_ESTADO;
        } else {
            if (($value === 'a' || $value === 'autogestion')) {
                $this->attributes['origen'] = Partida::ORIGEN_AUTOGESTION;
            }
        }
    }

    public function getOrigenAttribute($value){

        if ($value === Partida::ORIGEN_ESTADO){
            return 'Estado';
        } else {
            if ($value === Partida::ORIGEN_AUTOGESTION){
                return 'Autogestión';
            }
        }
    }

    public function setPresupuestoAttribute($value){
        if ( empty($value) ) {
            $this->attributes['presupuesto'] = 0;
        } else {
            $this->attributes['presupuesto'] = $value;
        }
    }

    /**Relaciones**/

    public function activities() {
        return $this->hasMany('App\Activity');
    }

    public function programs() {
        return $this->hasMany('App\Program');
    }

    public function items() {
        return $this->hasMany('App\Item');
    }

}
