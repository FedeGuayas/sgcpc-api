<?php

namespace App\Http\Controllers;

use App\Department;
use App\User;
use App\Worker;
use Illuminate\Http\Request;

class WorkerController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $trabajadores=Worker::all();

        return response()->json(['data'=>$trabajadores],200);
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
            'user_id'=>'nullable|unique:workers',
            'department_id'=>'required',
            'first_name'=>'required|max:100',
            'last_name'=>'required|max:100',
            'email'=>'required|email|unique:workers',
            'dni' => 'required_without:passport|max:10'
        ];

        $this->validate($request,$rules);

        $usuario=User::findOrFail($request->user_id);
        $departamento=Department::findOrFail($request->department_id);

        $trabajador=new Worker();
        $trabajador->user()->associate($usuario);
        $trabajador->department()->associate($departamento);
        $trabajador->first_name=$request->first_name;
        $trabajador->last_name=$request->last_name;
        $trabajador->email=$request->email;
        $trabajador->dni=$request->dni;
        $trabajador->passport=$request->passport;
        $trabajador->position=$request->position;
        $trabajador->treatment=$request->treatment;
        $trabajador->save();

        return response()->json(['data'=>$trabajador],201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Worker  $worker
     * @return \Illuminate\Http\Response
     */
    public function show(Worker $worker)
    {
        return response()->json(['data'=>$worker],200);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Worker  $worker
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Worker $worker)
    {
        $rules=[
            'user_id'=>'nullable|unique:workers,user_id,'.$worker->id,
            'department_id'=>'required',
            'first_name'=>'required|max:100',
            'last_name'=>'required|max:100',
            'email'=>'required|email|unique:workers,email,'.$worker->id,
            'dni' => 'required_without:passport|max:10'
        ];

        $this->validate($request,$rules);

        if ($request->has('user_id') && $worker->user_id!=$request->user_id){
            $usuario=User::findOrFail($request->user_id);
            $worker->user()->associate($usuario);
        }

        if ($request->has('department_id') && $worker->department_id!=$request->department_id){
            $departamento=Department::findOrFail($request->department_id);
            $worker->department()->associate($departamento);
        }

        if ($request->has('first_name') && $worker->first_name!=$request->first_name){
            $worker->first_name=$request->first_name;
        }

        if ($request->has('last_name') && $worker->last_name!=$request->last_name){
            $worker->last_name=$request->last_name;
        }

        if ($request->has('email') && $worker->email!=$request->email){
            $worker->email=$request->email;
        }

        if ($request->has('dni') && $worker->dni!=$request->dni){
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
            return response()->json(['error'=>'Se debe especificar algun valor para actualizar','code'=>422],422);
        }

        $worker->save();

        return response()->json(['data'=>$worker],200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Worker  $worker
     * @return \Illuminate\Http\Response
     */
    public function destroy(Worker $worker)
    {
        $worker->delete();

        return response()->json(['data'=>$worker],200);
    }
}
