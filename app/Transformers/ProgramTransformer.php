<?php

namespace App\Transformers;

use App\Program;
use League\Fractal\TransformerAbstract;

class ProgramTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(Program $program)
    {
        return [
            'identificador' => (int)$program->id,
            'nombre' => (string)$program->name,
            'codigo' => (string)$program->code,
            'fechaCreacion' => (string)$program->created_at,
            'fechaActualizacion' => (string)$program->updated_at,
            'fechaEliminacion' => isset($program->deleted_at) ? (string)$program->deleted_at : null,
            'links' => [
                [ 'rel' => 'programs.show',
                    'href' => route('programs.show', $program->id),
                ],
                [ 'rel' => 'programs.activities',
                    'href' => route('programs.activities.index', $program->id),
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
