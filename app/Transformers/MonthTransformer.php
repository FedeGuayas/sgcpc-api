<?php

namespace App\Transformers;

use App\Month;
use League\Fractal\TransformerAbstract;

class MonthTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(Month $mes)
    {
        return [
            'identificador' => (int)$mes->id,
            'mes' => (string)$mes->month,
            'codigo' => (int)$mes->cod,

            'links' => [
                [   'rel' => 'months.show',
                    'href' => route('months.show', $mes->id),
                ]
            ]
        ];
    }

    public static  function originalAttribute($index)
    {
        $attributes =[
            'identificador' => 'id',
            'mes' => 'month',
            'codigo' => 'cod'
        ];
        return isset($attributes[$index]) ? $attributes[$index] : null;
    }

    public static  function transformedAttribute($index)
    {
        $attributes =[
            'id' => 'identificador',
            'month' => 'mes',
            'cod' => 'codigo'
        ];
        return isset($attributes[$index]) ? $attributes[$index] : null;
    }
}
