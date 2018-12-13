<?php

namespace App\Exceptions;

use App\Traits\ApiResponser;


use Asm89\Stack\CorsService;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Session\TokenMismatchException;
use Illuminate\Validation\ValidationException;
//use function Psy\debug;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class Handler extends ExceptionHandler
{
    use ApiResponser;

    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        \Illuminate\Auth\AuthenticationException::class,
        \Illuminate\Auth\Access\AuthorizationException::class,
        \Symfony\Component\HttpKernel\Exception\HttpException::class,
        \Illuminate\Database\Eloquent\ModelNotFoundException::class,
        \Illuminate\Session\TokenMismatchException::class,
        \Illuminate\Validation\ValidationException::class,
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * MODIFICADO PARA MOSTRAR SOLO LA INFO QUE NECESITO ME MUESTRE
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
        // metodo donde se manejan las excepciones
        $response = $this->handlerException($request, $exception);

        /** Incluir las cabeceras de CORS en las respuestas de validacion de errores **/
        app(CorsService::class)->addActualRequestHeaders($response, $request);

        return $response;

    }

    /**
     * Metodo para manejar las respuestas  a las excepciones de la API
     * @param $request
     * @param Exception $exception
     * @return $this|\Illuminate\Http\JsonResponse|\Illuminate\Http\Response|\Symfony\Component\HttpFoundation\Response
     */
    public function handlerException($request, Exception $exception){

        /**Para manejar los errores de validacion con respuestas json***/
        if ($exception instanceof ValidationException){
            return $this->convertValidationExceptionToResponse($exception,$request);
        }
        /***Manejar excepcion not found 404***/
        if ($exception instanceof ModelNotFoundException){
            $modelo=strtolower(class_basename($exception->getModel())); //retorna el nombre de la clase del modelo, User x ejemplo
            return $this->errorResponse("No se encontró la instancia de {$modelo} con el id solicitado",404);
        }
        /***Excepciones de authenticacion****/
        if ($exception instanceof AuthenticationException) {
            return $this->unauthenticated($request, $exception);
        }
        /***Excepciones de autorizacion, permisos****/
        if ($exception instanceof AuthorizationException) {
            return $this->errorResponse("Acceso denegado",403);
        }
        /***Excepciones de rutas no encontradas***/
        if ($exception instanceof NotFoundHttpException) {
            return $this->errorResponse("No se encontró la URL especificada",404);
        }
        /***Excepciones de Metodo no Permitido***/
        if ($exception instanceof MethodNotAllowedHttpException) {
            return $this->errorResponse("El Método de la petición no es válido",405);
        }
        /***Excepcion Generica, cualquier otra diferente a las anterirores***/
        if ($exception instanceof HttpException) {
            return $this->errorResponse($exception->getMessage(),$exception->getStatusCode());
        }
        /***Excepcion al tratar de eliminar un recurso relacionado con foreing key error 1451***/
        if ($exception instanceof QueryException) {
            $codigo=$exception->errorInfo[1];
            if ($codigo==1451){
                return $this->errorResponse("No se puede eliminar el recurso porque está relacionado con otro.",409);
            }
        }
        /***Excepcion al tratar de insertar duplicados en campos unicos, error 1062***/
        if ($exception instanceof QueryException) {
            $codigo=$exception->errorInfo[1];
            if ($codigo==1062){
                return $this->errorResponse('No se puede entrar información duplicada',500);
            }
        }

        /*** Exception de la proteccion csfr ,  no es necesario para la api ***/
        if ($exception instanceof TokenMismatchException) {
            return redirect()->back()->withInput($request->input());
        }


        /**Si se esta en desarrollo mostrar la mayor cantidad de informacion posible de los errores,  **/
        if (config('app.debug')){
            return parent::render($request, $exception);
        }
        /**Sino mostra mensage general, Excepcion por falla inesperada, error 500***/
        return $this->errorResponse('Falla inesperada. Intente luego',500);


    }


    /**MODIFICADO PARA MOSTRAR SOLO RESPUESTAS JSON Y NO REDIRECT
     *
     * Convert an authentication exception into an unauthenticated response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Auth\AuthenticationException  $exception
     * @return \Illuminate\Http\Response
     */
    protected function unauthenticated($request, AuthenticationException $exception)
    {

            return $this->errorResponse('No autenticado.', 401);


    }

    /**
     * Se sobreescribe este metodo para obtener todas las respuestas de error en json y no redirecciones
     *
     * Create a response object from the given validation exception.
     *
     * @param  \Illuminate\Validation\ValidationException  $e
     * @param  \Illuminate\Http\Request  $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function convertValidationExceptionToResponse(ValidationException $e, $request)
    {
        $errors = $e->validator->errors()->getMessages();
        //metodo del trait ApiResponser
        return $this->errorResponse($errors,422);

    }
}
