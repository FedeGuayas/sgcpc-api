<?php

namespace App\Transformers;

use App\TypePurchase;
use League\Fractal\TransformerAbstract;

class TypePurchaseTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(TypePurchase $typePurchase)
    {
        return [
            'identificador' => (int)$typePurchase->id,
            'tipoCompra' => (string)$typePurchase->name,
            'estado' => (int)$typePurchase->status,

            'links' => [
                [   'rel' => 'type-purchases.show',
                    'href' => route('type-purchases.show', $typePurchase->id),
                ]
            ]
        ];
    }

    public static  function originalAttribute($index)
    {
        $attributes =[
            'identificador' => 'id',
            'tipoCompra' => 'name',
            'estado' => 'status'
        ];
        return isset($attributes[$index]) ? $attributes[$index] : null;
    }

    public static  function transformedAttribute($index)
    {
        $attributes =[
            'id' => 'identificador',
            'name' => 'tipoCompra',
            'status' => 'estado'
        ];
        return isset($attributes[$index]) ? $attributes[$index] : null;
    }
}
