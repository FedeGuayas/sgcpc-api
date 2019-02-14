<?php

namespace App\Transformers;

use App\TypeProcedure;
use League\Fractal\TransformerAbstract;

class TypeProcedureTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(TypeProcedure $typeProcedure)
    {
        return [
            'identificador' => (int)$typeProcedure->id,
            'tipoProcedimiento' => (string)$typeProcedure->name,
            'estado' => (int)$typeProcedure->status,

            'links' => [
                [   'rel' => 'type-procedures.show',
                    'href' => route('type-procedures.show', $typeProcedure->id),
                ]
            ]
        ];
    }

    public static  function originalAttribute($index)
    {
        $attributes =[
            'identificador' => 'id',
            'tipoProcedimiento' => 'name',
            'estado' => 'status'
        ];
        return isset($attributes[$index]) ? $attributes[$index] : null;
    }

    public static  function transformedAttribute($index)
    {
        $attributes =[
            'id' => 'identificador',
            'name' => 'tipoProcedimiento',
            'status' => 'estado'
        ];
        return isset($attributes[$index]) ? $attributes[$index] : null;
    }
}
