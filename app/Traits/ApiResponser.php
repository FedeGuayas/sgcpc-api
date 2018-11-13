<?php
/**
 * Trait para servir las respuestas de la API, estos metodos podran ser utilizados en cualquier clase del proyecto
 */

namespace App\Traits;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

trait ApiResponser{

    /**
     * Contruye respuestas satisfactorias
     * @param $data (informacion a retornar)
     * @param $code (codigo de la respuesta)
     * @return \Illuminate\Http\JsonResponse
     */
    private function successResponse($data, $code){
        return response()->json($data,$code);
    }

    /**
     * Respuestas de error
     * @param $message
     * @param $code
     * @return \Illuminate\Http\JsonResponse
     */
    protected function errorResponse($message, $code){
        return response()->json(['error'=>$message, 'code'=>$code],$code);
    }

    /**Lista completa de elementos, recibe una coleccion
     * @param Collection $collection
     * @param int $code
     * @return \Illuminate\Http\JsonResponse
     */
    protected  function showAll(Collection $collection, $code=200){
        return $this->successResponse(['data'=>$collection],$code);
    }

    /**
     * Muestra una instancia de un modelo especifico
     * @param Model $instance
     * @param int $code
     * @return \Illuminate\Http\JsonResponse
     */
    protected  function showOne(Model $instance, $code=200){
        return $this->successResponse(['data'=>$instance],$code);
    }
}