<?php

namespace App\Http\Controllers\TypeReform;

use App\Http\Controllers\ApiController;
use App\Transformers\TypeReformTransformer;
use App\TypeReform;
use Illuminate\Http\Request;

class TypeReformController extends ApiController
{

    public function __construct()
    {
        parent::__construct();

        $this->middleware('transform.input:'. TypeReformTransformer::class) -> only(['store','update']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $tipo_reformas = TypeReform::where('status',TypeReform::ENABLED) -> get();

        return $this -> showAll($tipo_reformas);
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
            'name' => 'required|max:20|unique:types_reforms'
        ];

        $this->validate($request,$rules);

        $data=$request->all();

        $data['status'] = TypeReform::ENABLED;

        $tipoReforma = TypeReform::create($data);

        return $this->showOne($tipoReforma,201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\TypeReform  $typeReform
     * @return \Illuminate\Http\Response
     */
    public function show(TypeReform $typeReform)
    {
        return $this->showOne($typeReform);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param TypeReform $typeReform
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, TypeReform $typeReform)
    {
        $rules=[
            'name'=>'max:20|unique:types_reforms,name,'.$typeReform->id,
            'status'=>'in:'. TypeReform::ENABLED . ',' . TypeReform::DISABLED
        ];

        $this->validate($request,$rules);

        $typeReform->fill($request->intersect([
            'name',
            'status'
        ]));

        if ($typeReform->isClean()){
            return $this->errorResponse('Se debe especificar algun valor para actualizar',422);
        }

        $typeReform->save();

        return $this->showOne($typeReform);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param TypeReform $typeReform
     * @return \Illuminate\Http\JsonResponse
     */

    public function destroy(TypeReform $typeReform)
    {
        $typeReform->delete();

        return $this->showOne($typeReform);
    }
}
