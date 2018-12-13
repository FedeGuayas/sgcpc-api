<?php

namespace App\Transformers;

use App\Partida;
use League\Fractal\TransformerAbstract;

class PartidaTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(Partida $partida)
    {
        return [
            'identificador' => (int)$partida->id,
            'programa_id' => (int)$partida->program_id,
            'actividad_id' => (int)$partida->activity_id,
            'item_id' => (int)$partida->item_id,
            'programa_cod' => (string)$partida->programa,
            'actividad_cod' => (string)$partida->actividad,
            'renglon_cod' => (string)$partida->renglon ,
            'monto' => (float)$partida->presupuesto,
            'saldo' => (float)$partida->disponible,
            'origen' => (string)$partida->origen,
            'fechaCreacion' => (string)$partida->created_at,
            'fechaActualizacion' => (string)$partida->updated_at,
            'fechaEliminacion' => isset($partida->deleted_at) ? (string)$partida->deleted_at : null,

            'links' => [
                [ 'rel' => 'self',
                    'href' => route('partidas.show', $partida->id),
                ]
            ]
        ];
    }

    public static  function originalAttribute($index)
    {
        $attributes =[
            'identificador' => 'id',
            'programa_id' => 'program_id',
            'actividad_id' => 'activity_id',
            'item_id' => 'item_id',
            'programa_cod' => 'programa',
            'actividad_cod' => 'actividad',
            'renglon_cod' => 'renglon' ,
            'monto' => 'presupuesto',
            'saldo' => 'disponible',
            'origen' => 'origen',
            'fechaCreacion' => 'created_at',
            'fechaActualizacion' => 'updated_at',
            'fechaEliminacion' => 'deleted_at'
        ];
        return isset($attributes[$index]) ? $attributes[$index] : null;
    }

    public static  function transformedAttribute($index)
    {
        $attributes =[
            'id' => 'identificador',
            'program_id' => 'programa_id',
            'activity_id' => 'actividad_id',
            'item_id' => 'item_id',
            'programa' =>'programa_cod',
            'actividad' => 'actividad_cod',
            'renglon'  => 'renglon_cod',
            'presupuesto' => 'monto',
            'disponible' => 'saldo',
            'origen' => 'origen',
            'created_at' => 'fechaCreacion',
            'updated_at' => 'fechaActualizacion',
            'deleted_at' => 'fechaEliminacion'
        ];
        return isset($attributes[$index]) ? $attributes[$index] : null;
    }
}
