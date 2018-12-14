<?php

/**
 * Middleware para transformar  los input de los request para que conincidan con los Transformers
 */

namespace App\Http\Middleware;

use Closure;
use Illuminate\Validation\ValidationException;

class TransformInput
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $transformer)
    {
        $trasformedInput = [];

        // recorrer los campos recibidos solo en el body de la consulta, no los parametros
        foreach ($request->request->all() as $input => $value){
            $trasformedInput[$transformer::originalAttribute($input)] = $value; //  $trasformedInput['nombre'] = name;
        }

        // rempazar los input de la peticion original, con los trasnformados
        $request->replace($trasformedInput );

        $response = $next($request);

        // En el sentido inverso, para las respuestas de error de las validaciones

        // comprobar si es una respuesta de error y si es de tipo de validacion
        if (isset($response->exception) && $response->exception instanceof ValidationException) {
            $data = $response->getData();

            // arreglo para transformar los errores
            $transformedErrors = [];

            foreach ($data->error as $field => $error){
                // valor del campo transformado a partir del original
                $transformedField = $transformer::transformedAttribute($field);
                // formar la lista para la resp de errores  con los nombres de los atrib tranformados
                $transformedErrors[$transformedField] = str_replace($field, $transformedField, $error);
            }

            // remmplazar los datos de las respuestas de error por los transformados
            $data->error = $transformedErrors;

            // establecer los datos
            $response->setData($data);
        }
        return $response;
    }
}
