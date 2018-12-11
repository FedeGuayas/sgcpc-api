<?php
/**
 * Trait para servir las respuestas de la API, estos metodos podran ser utilizados en cualquier clase del proyecto
 */

namespace App\Traits;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;

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

        // validar que la coleccion no este vacia
        if ($collection->isEmpty()) {
            return $this->successResponse(['data' => $collection], $code);
        }

        // las respuestas deben ser datos de un solo recurso, sin hacer mezclas en la colleccion para que el  tranformer funciona mas simple
        $transformer = $collection->first()->transformer;
        $collection = $this->filterData($collection, $transformer); //filtrar antes de ordenar
        $collection = $this->sortData($collection, $transformer); // se debe ordenar antes de transformar los datos para que funcione
        $collection = $this->paginate($collection); // paginacion para grandes cantidades de datos
        $collection = $this->transformData($collection, $transformer);
        $collection = $this->cacheResponse($collection); // chachear la respuesta

        return $this->successResponse(['data'=>$collection],$code);
    }

    /**
     * Muestra una instancia de un modelo especifico
     * @param Model $instance
     * @param int $code
     * @return \Illuminate\Http\JsonResponse
     */
    protected  function showOne(Model $instance, $code=200){

        $transformer = $instance->transformer;
        $data = $this->transformData($instance, $transformer);

        return $this->successResponse(['data'=>$instance],$code);
    }

    /**
     * @param $message
     * @param int $code
     * @return \Illuminate\Http\JsonResponse
     */
    protected  function showMessage($message, $code=200){
        return $this->successResponse(['data'=>$message],$code);
    }

    /**
     * Para filtrar la data antes de ordenarla y optimizar el proceso de ordenamiento
     * localhost/sgcpc-api/api/users?esVerificado=1&identificador=7
     * @param Collection $collection
     * @param $transformer
     * @return Collection|static
     */
    protected function filterData(Collection $collection, $transformer){
        // es posible filtrar por varios atributos

        //obtener la lista de todos los parametros que se reciben por url
        foreach (request()->query() as $query => $value){
        // verfificar si el parametro es un attribute original del modelo y
            $attribute = $transformer::originalAttribute($query);

            if (isset($attribute, $value)){
                //filtro la colleccion verficicando si el attributo es igual al valor
                $collection = $collection->where($attribute, $value);

            }
        }

        return $collection;

    }

    /**
     *  localhost/sgcpc-api/api/users?sort_by=nombre
     * Organizar los datos segun los atributos . Solo se ordenara si se recibe el parametro sort_by en la url
     * @param Collection $collection
     * @return Collection
     */
    protected  function sortData(Collection $collection, $transformer){
        if (request()->has('sort_by')){
            $attribute =  $transformer::originalAttribute(request()->sort_by);
            $collection = $collection->sortBy->{$attribute};
        }

        return $collection;
    }

    /**
     * Paginar los resultados de la colleccion de la respuesta cuando la cantidad de datos es muy grande
     * @param Collection $collection
     * @return LengthAwarePaginator
     */
    protected  function paginate(Collection $collection){
        // regla para permitir al usuario personalizar la cantidad de elementos por pagina que desea
        $rules = [
            'per_page' => 'integer | min:2 | max:50'
        ];

        Validator::validate(request()->all(), $rules);

         // nos permite resolver  la pagina actual en que estamos para mostar el segmento de la coleccion a mostrar
        $page = LengthAwarePaginator::resolveCurrentPage();
        // valor predefinido de elementos por pagina
        $perPage = 15;

        if (request()->has('per_page')){
            $perPage = (int) request()->per_page;
        }

        // dividir la coleccion en secciones dependiendo del tamaño de la pagina
        $result = $collection->slice( ($page-1) * $perPage, $perPage ) -> values();
        // crear la instancia del paginador. Ojo aqui se eliminan los parametros que vengan por url
        $paginated = new LengthAwarePaginator($result, $collection->count(), $perPage, $page, [
            'path' => LengthAwarePaginator::resolveCurrentPath(), // ruta que se utilizara para la pagina en que estamos, indica cual es la siguiente y anterior pagina
        ]);

        // para conservar los parametros por url se vuelven a agregar
        $paginated->appends(request()->all());

        return $paginated;
    }


    /**
     *  Metodo para utilizar los transformers en las respuestas
     * @param $data
     * @param $transformer
     * @return array
     */
    protected  function transformData( $data, $transformer) {

        $transformation = fractal($data, new $transformer);

        return $transformation->toArray();

    }

    /**
     *  Metodo para mantener la respuesta en cache y disminuir las peticiones a la base de datos
     * @param $data
     * @return mixed
     */
    protected function cacheResponse($data){
        // url actual
        $url = request()->url();

        //parametros de la url
        $queryParams = request()->query();

        // metodo para ordenar array (el de los parametros de la url) dependiendo de la clave
        ksort($queryParams); // no se realiza asignacion porque este parametro actua por referencia

        // construir el string a partir del array de los parametros ordenados
        $queryString = http_build_query($queryParams);

        //construir la url completa. Es necesario reconstruir la url de esta forma para evitar problemas con la cache cuando se va
        // a paginar, ordenar, etc
        $fullUrl = "{$url}?{$queryString}";

        // Cache::remember($url, min/seg, closure)  Cambiar el tiempo (min/seg) que se desea guardar en cache el resultado segun se desee
        return  Cache::remember($fullUrl, 15/60, function () use ($data) {
            return $data;
        });
    }
}