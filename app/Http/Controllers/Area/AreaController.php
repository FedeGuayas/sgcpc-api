<?php

namespace App\Http\Controllers\Area;

use App\Area;
use App\Http\Controllers\ApiController;
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
            'code'=>'required|max:5|unique:areas',
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
     *  isDirty => verifica si la instancia a cambiado
     * isClean => verifica que la instancia no haya cambiado
     *
     * @param Request $request
     * @param Area $area
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Area $area)
    {
        $rules=[
            'name'=>'max:100|unique:areas,name,'.$area->id,
            'code'=>'max:5|unique:areas,code,'.$area->id,
            'status'=>'in:'. Area::AREA_HABILITADA . ',' . Area::AREA_NO_HABILITADA
        ];

        $this->validate($request,$rules);

        $area->fill($request->intersect([
            'name',
            'code',
            'status'
        ]));

        if ($area->isClean()){
            return $this->errorResponse('Se debe especificar algun valor para actualizar',422);
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
