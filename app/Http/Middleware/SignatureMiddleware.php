<?php

/**
 * Middleware para agregar una cabecera con el nombre de la app en cada respuesta
 */

namespace App\Http\Middleware;

use Closure;

class SignatureMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next,$header = 'X-Name')
    {
        //obtengo la respuesta
        $response = $next($request);

        //la modifico
        $response->headers->set($header,config('app.name'));

        //la retorno
        return $response;
    }
}
