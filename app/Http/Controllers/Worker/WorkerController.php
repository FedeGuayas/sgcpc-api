<?php

namespace App\Http\Controllers\Worker;

use App\Department;
use App\Http\Controllers\ApiController;
use App\Transformers\WorkerTransformer;
use App\User;
use App\Worker;
use Illuminate\Http\Request;

class WorkerController extends ApiController
{
    /**
     * WorkerController constructor.
     */
    public function __construct()
    {
        $this->middleware('client.credentials')->only(['index','show']);
        $this->middleware('transform.input:'. WorkerTransformer::class)->only(['store','update']);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $trabajadores=Worker::all();

        return $this->showAll($trabajadores);
    }


    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $rules=[
            'user_id'=>'nullable|unique:workers',
            'department_id'=>'required',
            'first_name'=>'required|max:100',
            'last_name'=>'required|max:100',
            'email'=>'required|email|unique:workers',
            'dni' => 'required_without:passport|max:10'
        ];

        $this->validate($request,$rules);

        $departamento=Department::findOrFail($request->department_id);

        $trabajador=new Worker();

        if ($request->has('user_id')){
            $usuario=User::findOrFail($request->user_id);
            $trabajador->user()->associate($usuario);
        }
        $trabajador->department()->associate($departamento);
        $trabajador->first_name=$request->first_name;
        $trabajador->last_name=$request->last_name;
        $trabajador->email=$request->email;
        $trabajador->dni=$request->dni;
        $trabajador->passport=$request->passport;
        $trabajador->position=$request->position;
        $trabajador->treatment=$request->treatment;
        $trabajador->save();

        return $this->showOne($trabajador,201);
    }

    /**
     * @param Worker $worker
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Worker $worker)
    {
        return $this->showOne($worker);
    }


    /**
     * @param Request $request
     * @param Worker $worker
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Worker $worker)
    {
        $rules=[
            'user_id'=>'nullable|unique:workers,user_id,'.$worker->id,
            'first_name'=>'max:100',
            'last_name'=>'max:100',
            'email'=>'email|unique:workers,email,'.$worker->id,
//            'dni' => 'required_without:passport|max:10'
            'dni' => 'max:10'
        ];

        $this->validate($request,$rules);

        if ($request->has('user_id') && $worker->user_id != $request->user_id){
            $usuario = User::findOrFail($request->user_id);
            $worker->user()->associate($usuario);
        }

        if ($worker->department_id != $request->department_id){
            $departamento = Department::findOrFail($request->department_id);
            $worker->department()->associate($departamento);
        }

        if ($worker->first_name!=$request->first_name){
            $worker->first_name=$request->first_name;
        }

        if ($worker->last_name!=$request->last_name){
            $worker->last_name=$request->last_name;
        }

        if ($worker->email!=$request->email){
            $worker->email=$request->email;
        }

        if ($worker->dni!=$request->dni){
            $worker->dni=$request->dni;
        }

        if ($request->has('passport') && $worker->passport!=$request->passport){
            $worker->passport=$request->passport;
        }

        if ($request->has('position') && $worker->position!=$request->position){
            $worker->position=$request->position;
        }

        if ($request->has('treatment') && $worker->treatment!=$request->treatment){
            $worker->treatment=$request->treatment;
        }

        if (!$worker->isDirty()){
            return $this->errorResponse('Se debe especificar algun valor para actualizar',422);
        }

        $worker->save();

        return $this->showOne($worker);
    }

    /**
     * @param Worker $worker
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Worker $worker)
    {
        $worker->delete();

        return $this->showOne($worker);
    }
}
