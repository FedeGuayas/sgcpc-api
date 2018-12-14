<?php

namespace App\Http\Controllers\Item;

use App\Http\Controllers\ApiController;
use App\Item;
use App\Transformers\ItemTransformer;
use Illuminate\Http\Request;

class ItemController extends ApiController
{
    public function __construct()
    {
        parent::__construct();

        $this->middleware('transform.input:'. ItemTransformer::class)->only(['store','update']);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $items=Item::all();
        return $this->showAll($items);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $rules=[
            'name'=>'required|unique:items',
            'code'=>'required|max:6|unique:items',
            'description' => 'required'
        ];

        $this->validate($request,$rules);

        $data = $request->all();

        $item = Item::create($data);

        return $this->showOne($item,201);
    }

    /**
     * @param Item $item
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Item $item)
    {
        return $this->showOne($item);
    }

    /**
     * @param Request $request
     * @param Item $item
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Item $item)
    {
        $rules=[
            'name'=>'unique:items,name,'.$item->id,
            'code'=>'max:6|unique:items,code,'.$item->id
        ];

        $this->validate($request,$rules);

        $item->fill($request->intersect([
            'name',
            'code',
        ]));

        if ($item->isClean()){
            return $this->errorResponse('Se debe especificar algun valor para actualizar',422);
        }

        $item->save();

        return $this->showOne($item);
    }

    /**
     * @param Item $item
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Item $item)
    {
        $item->delete();

        return $this->showOne($item);
    }
}
