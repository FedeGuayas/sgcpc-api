<?php

namespace App\Http\Controllers\Department;

use App\Area;
use App\Department;
use App\Http\Controllers\ApiController;
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
     * @param Department $department
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Department $department)
    {
        return $this->showOne($department);
    }

}
