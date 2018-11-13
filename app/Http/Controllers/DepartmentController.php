<?php

namespace App\Http\Controllers;

use App\Area;
use App\Department;
use Illuminate\Http\Request;

class DepartmentController extends ApiController
{
    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $departamentos=Department::with('area')->get();

        return $this->showAll($departamentos);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
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

       return $this->showOne($departamento,201);
    }

    /**
     * @param Department $department
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Department $department)
    {
        return $this->showOne($department);
    }


    /**
     * @param Request $request
     * @param Department $department
     * @return \Illuminate\Http\JsonResponse
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
            return $this->errorResponse('Se debe especificar algun valor para actualizar',422);
        }

        $department->save();

        return $this->showOne($department);
    }

    /**
     * @param Department $department
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Department $department)
    {
        $department->delete();

        return $this->showOne($department);
    }
}
