<?php

namespace App\Http\Controllers\Program;

use App\Activity;
use App\Http\Controllers\ApiController;
use App\Program;
use Illuminate\Http\Request;

class ProgramActivityController extends ApiController
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Actividades de un programa
     */
    public function index(Program $program)
    {
        $actividades=$program->activities;

        return $this->showAll($actividades);
    }

    /**
     * sync -> sincroniza el pivot quitando lo anterior y dejando los id nuevos
     * attach -> va agregando los nuevos id al pivot, puede duplicar id existentes
     * syncWithoutDetaching -> sincroniza pero no quita los id anteriores
     * @param Request $request
     * @param Program $program
     * @param Activity $activity
     */
    public function update(Program $program, Activity $activity)
    {
        $program->activities()->syncWithoutDetaching([$activity->id]);

        return $this->showAll($program->activities);
    }

    /**
     * @param Request $request
     * @param Program $program
     * @param Activity $activity
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Program $program, Activity $activity)
    {
        if (!$program->activities()->find($activity->id)){
            return $this->errorResponse('La actividad especificada no pertenece a este programa',404);
        }

        $program->activities()->detach([$activity->id]);

        return $this->showAll($program->activities);
    }

}
