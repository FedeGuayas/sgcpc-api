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
                [ 'rel' => 'self',
                    'href' => route('programs.show', $program->id),
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
