<?php

namespace App\Http\Controllers\Activity;

use App\Activity;
use App\Http\Controllers\ApiController;
use App\Transformers\ActivityTransformer;
use Illuminate\Http\Request;

class ActivityController extends ApiController
{
    /**
     * ActivityController constructor.
     */
    public function __construct()
    {

        $this->middleware('client.credentials')->only(['index','show']);
        $this->middleware('transform.input:'. ActivityTransformer::class)->only(['store','update']);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $actividades=Activity::all();

        return $this->showAll($actividades);
    }


    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $rules=[
            'name'=>'required',
            'code'=>'required|max:3|unique:activities'
        ];

        $this->validate($request,$rules);

        $actividad=Activity::create($request->all());

        return $this->showOne($actividad,201);
    }

    /**
     * @param Activity $activity
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Activity $activity)
    {
        return $this->showOne($activity);
    }


    /**
     * @param Request $request
     * @param Activity $activity
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Activity $activity)
    {
        $rules=[
            'code'=>'max:3|unique:activities,code,'.$activity->id
        ];

        $this->validate($request,$rules);

        $activity->fill($request->intersect([
            'name',
            'code'
        ]));

        if ($activity->isClean()){
            return $this->errorResponse('Se debe especificar algun valor para actualizar',422);
        }

        $activity->save();

        return $this->showOne($activity);
    }

    /**
     * @param Activity $activity
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Activity $activity)
    {
        $activity->delete();

        return $this->showOne($activity);
    }
}
