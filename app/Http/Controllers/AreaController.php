<?php

namespace App\Http\Controllers;

use App\Area;
use Illuminate\Http\Request;

class AreaController extends ApiController
{
    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $areas=Area::all();

        return $this->showAll($areas);
//        return response()->json(['data'=>$areas],200);
    }


    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $rules=[
            'name'=>'required|max:100|unique:areas',
            'code'=>'required|max:5',
        ];

        $this->validate($request,$rules);

        $campos=$request->all();
        $campos['status']=Area::AREA_HABILITADA;

        $area=Area::create($campos);

        return $this->showOne($area,201);
    }

    /**
     * @param Area $area
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Area $area)
    {
        return $this->showOne($area);
    }


    /**
     * @param Request $request
     * @param Area $area
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Area $area)
    {
        $rules=[
            'name'=>'max:100|unique:areas,name,'.$area->id,
            'code'=>'max:5',
            'status'=>'in:'. Area::AREA_HABILITADA . ',' . Area::AREA_NO_HABILITADA
        ];

        $this->validate($request,$rules);

        if ($request->has('name')){
            $area->name=$request->name;
        }

        if ($request->has('code')){
            $area->code=$request->code;
        }

        if ($request->has('status')){
            $area->status=$request->status;
        }

        if (!$area->isDirty()){
            return $this->errorResponse('Se debe especificar algun valor para actualizar',422);
//            return response()->json(['error'=>'Se debe especificar algun valor para actualizar','code'=>422],422);
        }

        $area->save();

        return $this->showOne($area);
    }

    /**
     * @param Area $area
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Area $area)
    {
        $area->delete();

        return $this->showOne($area);
    }

}
