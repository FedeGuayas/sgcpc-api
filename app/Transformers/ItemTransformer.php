<?php

namespace App\Transformers;

use App\Item;
use League\Fractal\TransformerAbstract;

class ItemTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(Item $item)
    {
        return [
            'identificador' => (int)$item->id,
            'nombre' => (string)$item->name,
            'codigo' => (string)$item->code,
            'descripcion' => (string)$item->description,
            'fechaCreacion' => (string)$item->created_at,
            'fechaActualizacion' => (string)$item->updated_at,
            'fechaEliminacion' => isset($item->deleted_at) ? (string)$item->deleted_at : null,

            'links' => [
                [   'rel' => 'self',
                    'href' => route('items.show', $item->id),
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
            'descripcion' => 'description',
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
            'name' => 'nombre',
            'code' => 'codigo',
            'description' => 'descripcion',
            'created_at' => 'fechaCreacion',
            'updated_at' => 'fechaActualizacion',
            'deleted_at' => 'fechaEliminacion'
        ];
        return isset($attributes[$index]) ? $attributes[$index] : null;
    }
}
