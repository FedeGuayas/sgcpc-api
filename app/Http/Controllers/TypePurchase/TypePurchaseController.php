<?php

namespace App\Http\Controllers\TypePurchase;

use App\Http\Controllers\ApiController;
use App\Transformers\TypePurchaseTransformer;
use App\TypePurchase;
use Illuminate\Http\Request;

class TypePurchaseController extends ApiController
{
    public function __construct()
    {
        parent::__construct();

        $this->middleware('transform.input:'. TypePurchaseTransformer::class) -> only(['store','update']);
    }

    /**
     *  Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {

        $tipo_compras = TypePurchase::where('status',TypePurchase::ENABLED) -> get();

        return $this -> showAll($tipo_compras);

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
            'name' => 'required|max:20|unique:types_purchases'
        ];

        $this->validate($request,$rules);

        $data=$request->all();

        $data['status'] = TypePurchase::ENABLED;

        $tipoCompra = TypePurchase::create($data);

        return $this->showOne($tipoCompra,201);
    }

    /**
     * Display the specified resource.
     *
     * @param TypePurchase $typePurchase
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(TypePurchase $typePurchase)
    {
        return $this->showOne($typePurchase);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param TypePurchase $typePurchase
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, TypePurchase $typePurchase)
    {
        $rules=[
            'name'=>'max:20|unique:types_purchases,name,'.$typePurchase->id,
            'status'=>'in:'. TypePurchase::ENABLED . ',' . TypePurchase::DISABLED
        ];

        $this->validate($request,$rules);

        $typePurchase->fill($request->intersect([
            'name',
            'status'
        ]));

        if ($typePurchase->isClean()){
            return $this->errorResponse('Se debe especificar algun valor para actualizar',422);
        }

        $typePurchase->save();

        return $this->showOne($typePurchase);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param TypePurchase $typePurchase
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(TypePurchase $typePurchase)
    {
        $typePurchase->delete();

        return $this->showOne($typePurchase);
    }
}
