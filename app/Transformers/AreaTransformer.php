<?php

namespace App\Transformers;

use App\Area;
use League\Fractal\TransformerAbstract;

class AreaTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(Area $area)
    {
        return [
            'identificador' => (int)$area->id,
            'nombre' => (string)$area->name,
            'codigo' => (string)$area->code,
            'fechaCreacion' => (string)$area->created_at,
            'fechaActualizacion' => (string)$area->updated_at,
            'fechaEliminacion' => isset($area->deleted_at) ? (string)$area->deleted_at : null,
            'links' => [
               [ 'rel' => 'areas.show',
                'href' => route('areas.show', $area->id),
               ],
                [ 'rel' => 'area.departments',
                    'href' => route('areas.departments.index', $area->id),
                ],
                [ 'rel' => 'area.workers',
                    'href' => route('areas.workers.index', $area->id),
                ],
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

    public static  function transformedAttribute($index)
    {
        $attributes =[
            'id' => 'identificador',
            'name' => 'nombre',
            'code' => 'codigo',
            'created_at' => 'fechaCreacion',
            'updated_at' => 'fechaActualizacion',
            'deleted_at' => 'fechaEliminacion',

        ];
        return isset($attributes[$index]) ? $attributes[$index] : null;
    }
}
