<?php

namespace App\Transformers;

use App\User;
use League\Fractal\TransformerAbstract;

class UserTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(User $user)
    {
        return [
            'identificador' => (int)$user->id,
            'nombre' => (string)$user->name,
            'correo' => (string)$user->email,
            'esVerificado' => (int)$user->verified,
            'fechaCreacion' => (string)$user->created_at,
            'fechaActualizacion' => (string)$user->updated_at,
            'fechaEliminacion' => isset($user->deleted_at) ? (string)$user->deleted_at : null,
            'links' => [
                [ 'rel' => 'self',
                    'href' => route('users.show', $user->id),
                ]
            ]

        ];
    }

    /**
     * Metodo para determinar el nombre original del atributo mapeandolo con el del transformer
     * @param $index
     * @return mixed|null
     */
    public static  function originalAttribute($index)
    {
        $attributes =[
            'identificador' => 'id',
            'nombre' => 'name',
            'correo' => 'email',
            'esVerificado' => 'verified',
            'fechaCreacion' => 'created_at',
            'fechaActualizacion' => 'updated_at',
            'fechaEliminacion' => 'deleted_at',

        ];
        return isset($attributes[$index]) ? $attributes[$index] : null;
     }

    /** Realiza el trabajo del metodo anteriro pero en sentido inverso, util para las respuestas de validacion
     * @param $index
     * @return mixed|null
     */
    public static  function tranformedAttribute($index)
    {
        $attributes =[
            'id' => 'identificador',
            'name' => 'nombre',
            'email' => 'correo',
            'verified' => 'esVerificado',
            'created_at' => 'fechaCreacion',
            'updated_at' => 'fechaActualizacion',
            'deleted_at' => 'fechaEliminacion',

        ];
        return isset($attributes[$index]) ? $attributes[$index] : null;
    }

}
