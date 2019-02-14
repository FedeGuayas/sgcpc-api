<?php

namespace App\Transformers;

use App\TypeReform;
use League\Fractal\TransformerAbstract;

class TypeReformTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(TypeReform $typeReform)
    {
        return [
            'identificador' => (int)$typeReform->id,
            'tipoReforma' => (string)$typeReform->name,
            'estado' => (int)$typeReform->status,

            'links' => [
                [   'rel' => 'type-reforms.show',
                    'href' => route('type-reforms.show', $typeReform->id),
                ]
            ]
        ];
    }

    public static  function originalAttribute($index)
    {
        $attributes =[
            'identificador' => 'id',
            'tipoReforma' => 'name',
            'estado' => 'status'
        ];
        return isset($attributes[$index]) ? $attributes[$index] : null;
    }

    public static  function transformedAttribute($index)
    {
        $attributes =[
            'id' => 'identificador',
            'name' => 'tipoReforma',
            'status' => 'estado'
        ];
        return isset($attributes[$index]) ? $attributes[$index] : null;
    }
}
