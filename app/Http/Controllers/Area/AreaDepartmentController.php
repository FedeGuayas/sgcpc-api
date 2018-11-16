<?php

namespace App\Http\Controllers\Area;

use App\Area;
use App\Department;
use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;

class AreaDepartmentController extends ApiController
{
    /**
     * Los departamentos de una area
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Area $area)
    {
        $departamentos = $area->departments;

        return $this->showAll($departamentos);
    }

    /**
     * Almacenar Departamentos para un area dada
     * @param Request $request
     * @param Area $area
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request, Area $area)
    {
        $rules = [
            'name' => 'required|max:100'
        ];

        $this->validate($request, $rules);

        $data = $request->all();

        $data['area_id'] = $area->id;

        $departamento = Department::create($data);

        return $this->showOne($departamento, 201);

    }

    /**
     * Actualizar el departamento que pertenece a una area
     * @param Request $request
     * @param Area $area
     * @param Department $department
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Area $area, Department $department)
    {
        $rules = [
            'name' => 'max:100'
        ];

        $this->validate($request, $rules);

        $this->verificarArea($area,$department);

        $department->fill($request->intersect([
            'name'
        ]));

        if ($department->isClean()) {
            return $this->errorResponse('Se debe especificar algun valor para actualizar', 422);
        }

        $department->save();

        return $this->showOne($department);

    }

    /**
     * @param Area $area
     * @param Department $department
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Area $area,Department $department)
    {
        $this->verificarArea($area,$department);

        $department->delete();

        return $this->showOne($department);


    }

    /**
     * @param Area $area
     * @param Department $department
     */
    protected function verificarArea(Area $area,Department $department){

        if ($area->id != $department->area_id) {
            throw new HttpException(422,'EL área especificada no es a la que pertenece el departamento');
        }
    }
}
