<?php

namespace App\Transformers;

use App\Worker;
use League\Fractal\TransformerAbstract;

class WorkerTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(Worker $wk)
    {
        return [
            'identificador' => (int)$wk->id,
            'usuario' => (int)$wk->user_id,
            'departamento' => (int)$wk->department_id,
            'nombres' => (string)$wk->first_name,
            'apellidos' => (string)$wk->last_name,
            'correo' => (string)$wk->email,
            'cedula' => (string)$wk->dni,
            'pasaporte' => (string)$wk->passport,
            'cargo' => (string)$wk->position,
            'titulo' => (string)$wk->title,
            'fechaCreacion' => (string)$wk->created_at,
            'fechaActualizacion' => (string)$wk->updated_at,
            'fechaEliminacion' => isset($wk->deleted_at) ? (string)$wk->deleted_at : null,
            'links' => [
                [ 'rel' => 'self',
                    'href' => route('workers.show', $wk->id),
                ]
            ]
        ];
    }

    public static  function originalAttribute($index)
    {
        $attributes =[
            'identificador' => 'id',
            'usuario' => 'user_id',
            'departamento' => 'deparment_id',
            'nombres' => 'first_name',
            'apellidos' => 'last_name',
            'correo' => 'email',
            'cedula' => 'dni',
            'pasaporte' => 'passport',
            'cargo' => 'position',
            'titulo' => 'title',
            'fechaCreacion' => 'created_at',
            'fechaActualizacion' => 'updated_at',
            'fechaEliminacion' => 'deleted_at',

        ];
        return isset($attributes[$index]) ? $attributes[$index] : null;
    }
}
