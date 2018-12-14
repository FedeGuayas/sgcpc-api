<?php

namespace App\Transformers;

use App\Department;
use League\Fractal\TransformerAbstract;

class DepartmentTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(Department $depa)
    {
        return [
            'identificador' => (int)$depa->id,
            'nombre' => (string)$depa->name,
            'area' => (int)$depa->area_id,
            'fechaCreacion' => (string)$depa->created_at,
            'fechaActualizacion' => (string)$depa->updated_at,
            'fechaEliminacion' => isset($depa->deleted_at) ? (string)$depa->deleted_at : null,
            'links' => [ //HEATOATS
                [ 'rel' => 'self',
                    'href' => route('departments.show', $depa->id),
                ],
                [ 'rel' => 'departments.workers',
                    'href' => route('departments.workers.index', $depa->id),
                ],
            ]
        ];
    }

    public static  function originalAttribute($index)
    {
        $attributes =[
            'identificador' => 'id',
            'nombre' => 'name',
            'area' => 'area_id',
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
            'area_id' => 'area',
            'created_at' => 'fechaCreacion',
            'updated_at' => 'fechaActualizacion',
            'deleted_at' => 'fechaEliminacion',

        ];
        return isset($attributes[$index]) ? $attributes[$index] : null;
    }
}
