<?php

namespace App\Http\Controllers\Area;

use App\Area;
use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;


class AreaWorkerController extends ApiController
{
    /**
     * los trabajadores de un area
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Area $area)
    {
        $trabajadores=$area->workers;

        return $this->showAll($trabajadores);
    }
}
