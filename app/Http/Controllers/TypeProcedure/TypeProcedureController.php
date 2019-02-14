<?php

namespace App\Http\Controllers\TypeProcedure;

use App\Http\Controllers\ApiController;
use App\Transformers\TypeProcedureTransformer;
use App\TypeProcedure;
use Illuminate\Http\Request;

class TypeProcedureController extends ApiController
{

    public function __construct()
    {
        parent::__construct();

        $this->middleware('transform.input:'. TypeProcedureTransformer::class) -> only(['store','update']);
    }

    /**
     *  Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */

    public function index()
    {
        $tipo_procedimiento = TypeProcedure::where('status',TypeProcedure::ENABLED) -> get();

        return $this -> showAll($tipo_procedimiento);
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
            'name' => 'required|max:20|unique:types_procedures'
        ];

        $this->validate($request,$rules);

        $data=$request->all();

        $data['status'] = TypeProcedure::ENABLED;

        $tipoProcedimiento = TypeProcedure::create($data);

        return $this->showOne($tipoProcedimiento,201);
    }

    /**
     * Display the specified resource.
     *
     * @param TypeProcedure $typeProcedure
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(TypeProcedure $typeProcedure)
    {
        return $this->showOne($typeProcedure);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param TypeProcedure $typeProcedure
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, TypeProcedure $typeProcedure)
    {
        $rules=[
            'name'=>'max:20|unique:types_procedures,name,'.$typeProcedure->id,
            'status'=>'in:'. TypeProcedure::ENABLED . ',' . TypeProcedure::DISABLED
        ];

        $this->validate($request,$rules);

        $typeProcedure->fill($request->intersect([
            'name',
            'status'
        ]));

        if ($typeProcedure->isClean()){
            return $this->errorResponse('Se debe especificar algun valor para actualizar',422);
        }

        $typeProcedure->save();

        return $this->showOne($typeProcedure);
    }

    /**
     *  Remove the specified resource from storage.
     *
     * @param TypeProcedure $typeProcedure
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(TypeProcedure $typeProcedure)
    {
        $typeProcedure->status = TypeProcedure::DISABLED;

        return $this->showOne($typeProcedure);
    }
}
