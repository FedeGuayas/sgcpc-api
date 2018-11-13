<?php

namespace App\Http\Controllers;

use App\Area;
use App\Department;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $departamentos=Department::with('area')->get();

        return response()->json(['data'=>$departamentos],200);
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
            'area_id'=>'required',
            'name'=>'required|max:100'
        ];

        $area=Area::findOrFail($request->area_id);

        $this->validate($request,$rules);

        $departamento=new Department();
        $departamento->area()->associate($area);
        $departamento->name=$request->name;
        $departamento->save();

        return response()->json(['data'=>$departamento],201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function show(Department $department)
    {
        return response()->json(['data'=>$department],200);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Department $department)
    {
        $rules=[
            'area_id'=>'required',
            'name'=>'max:100'
        ];

        $this->validate($request,$rules);

        if ($request->has('area_id') && $department->area_id!=$request->area_id){
            $area=Area::findOrFail($request->area_id);
            $department->area()->associate($area);
        }

        if ($request->has('name')){
            $department->name=$request->name;
        }

        if (!$department->isDirty()){
            return response()->json(['error'=>'Se debe especificar algun valor para actualizar','code'=>422],422);
        }

        $department->save();

        return response()->json(['data'=>$department],200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function destroy(Department $department)
    {
        $department->delete();

        return response()->json(['data'=>$department],200);
    }
}
