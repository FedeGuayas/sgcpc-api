<?php

namespace App\Http\Controllers\Department;

use App\Department;
use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DepartmentWorkerController extends ApiController
{
    public function __construct()
    {
        $this->middleware('client.credentials')->only(['index']);
    }

    /**
     * los trabajadores de un departamento
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Department $department)
    {
        $trabajadores=$department->workers;

        return $this->showAll($trabajadores);
    }


}
