<?php

namespace App\Transformers;

use App\Activity;
use League\Fractal\TransformerAbstract;

class ActivityTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(Activity $activity)
    {
        return [
            'identificador' => (int)$activity->id,
            'nombre' => (string)$activity->name,
            'codigo' => (string)$activity->code,
            'fechaCreacion' => (string)$activity->created_at,
            'fechaActualizacion' => (string)$activity->updated_at,
            'fechaEliminacion' => isset($activity->deleted_at) ? (string)$activity->deleted_at : null,
            'links' => [
                [ 'rel' => 'self',
                    'href' => route('activities.show', $activity->id),
                ]
            ]
        ];
    }


    public static  function originalAttribute($index)
    {
        $attributes =[
            'identificador' => 'id',
            'nombre' => 'name',
            'codigo' => 'code',
            'fechaCreacion' => 'created_at',
            'fechaActualizacion' => 'updated_at',
            'fechaEliminacion' => 'deleted_at',

        ];
        return isset($attributes[$index]) ? $attributes[$index] : null;
    }
}
