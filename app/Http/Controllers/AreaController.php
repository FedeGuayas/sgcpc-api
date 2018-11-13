<?php

namespace App\Http\Controllers;

use App\Area;
use Illuminate\Http\Request;

class AreaController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $areas=Area::all();

        return response()->json(['data'=>$areas],200);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
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

        return response()->json(['data'=>$area],201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Area  $area
     * @return \Illuminate\Http\Response
     */
    public function show(Area $area)
    {
        return response()->json(['data'=>$area],200);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Area  $area
     * @return \Illuminate\Http\Response
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
            return response()->json(['error'=>'Se debe especificar algun valor para actualizar','code'=>422],422);
        }

        $area->save();

        return response()->json(['data'=>$area],200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Area  $area
     * @return \Illuminate\Http\Response
     */
    public function destroy(Area $area)
    {
        $area->delete();

        return response()->json(['data'=>$area],200);
    }

}
