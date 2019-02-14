<?php

namespace App\Http\Controllers\Month;

use App\Http\Controllers\ApiController;
use App\Month;
use App\Transformers\MonthTransformer;
use Illuminate\Http\Request;


class MonthController extends ApiController
{

    public function __construct()
    {
        parent::__construct();

        $this->middleware('transform.input:'. MonthTransformer::class)->only(['store','update']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $meses=Month::all();
        return $this->showAll($meses);
    }

    /**
     *  Store a newly created resource in storage.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $rules=[
            'month'=>'required|max:10|unique:months',
            'cod'=>'required|unique:months'
        ];

        $this->validate($request,$rules);

        $data = $request->all();

        $mes = Month::create($data);

        return $this->showOne($mes,201);
    }

    /**
     *
     * Display the specified resource.
     *
     * @param Month $month
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Month $month)
    {
        return $this->showOne($month);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Month $month
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Month $month)
    {
        $rules=[
            'month'=>'unique:months,month,'.$month->id,
            'cod'=>'max:10|unique:months,cod,'.$month->id
        ];

        $this->validate($request,$rules);

        $month->fill($request->intersect([
            'month',
            'cod',
        ]));

        if ($month->isClean()){
            return $this->errorResponse('Se debe especificar algun valor para actualizar',422);
        }

        $month->save();

        return $this->showOne($month);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Month $month
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Month $month)
    {
        $month->delete();

        return $this->showOne($month);
    }
}
