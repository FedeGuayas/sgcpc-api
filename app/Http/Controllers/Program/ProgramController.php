<?php

namespace App\Http\Controllers\Program;

use App\Http\Controllers\ApiController;
use App\Program;
use App\Transformers\ProgramTransformer;
use Illuminate\Http\Request;

class ProgramController extends ApiController
{
    /**
     * ProgramController constructor.
     */
    public function __construct()
    {
        $this->middleware('client.credentials')->only(['index','show']);
        $this->middleware('transform.input:'. ProgramTransformer::class)->only(['store','update']);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $programa=Program::all();

        return $this->showAll($programa);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $rules=[
            'name'=>'required',
            'code'=>'required|max:3|unique:programs'
        ];

        $this->validate($request,$rules);

        $programa=Program::create($request->all());

        return $this->showOne($programa,201);
    }

    /**
     * @param Program $program
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Program $program)
    {
        return $this->showOne($program);
    }

    /**
     * @param Request $request
     * @param Program $program
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Program $program)
    {
        $rules=[
            'code'=>'max:3|unique:programs,code,'.$program->id
        ];

        $this->validate($request,$rules);

        $program->fill($request->intersect([
            'name',
            'code'
        ]));

        if ($program->isClean()){
            return $this->errorResponse('Se debe especificar algun valor para actualizar',422);
        }

        $program->save();

        return $this->showOne($program);
    }

    /**
     * @param Program $program
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Program $program)
    {
        $program->delete();

        return $this->showOne($program);
    }
}
