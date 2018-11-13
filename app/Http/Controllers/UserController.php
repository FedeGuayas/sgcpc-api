<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class UserController extends ApiController
{
    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $usuarios=User::with('worker')->get();

        return $this->showAll($usuarios);
    }


    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $rules=[
            'name'=>'required',
            'email'=>'required|email|unique:users',
            'password'=>'required|min:6|confirmed'
        ];

        $this->validate($request,$rules);

        $campos=$request->all();
        $campos['password']=bcrypt($request->password);
        //$campos['verified']=User::USUARIO_NO_VERIFICADO;
        //$campos['verification_token']=User::generarVerificationToken();
        //$campos['admin']=User::USUARIO_REGULAR;

        $usuario=User::create($campos);

        return $this->showOne($usuario,201);
//        return response()->json(['data'=>$usuario],201);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $usuario=User::findOrFail($id);

        return $this->showOne($usuario);
    }


    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $user=User::findOrFail($id);

        $rules=[
            'email'=>'email|unique:users,email,'.$user->id,
            'password'=>'min:6|confirmed',
            //'admin'=>'in:'. User::USUARIO_ADMINISTRADOR. ','.User::USUARIO_REGULAR,
        ];

        $this->validate($request,$rules);

        if ($request->has('name')){
            $user->name=$request->name;
        }

        if ($request->has('email') && $user->email!=$request->email){
               //$user->verified=User::USUARIO_VERIFICADO;
               //$user->varification_token=User::generarVerificationToken();
                $user->email=$request->email;
        }

        if ($request->has('password')){
            $user->password=bcrypt($request->password);
        }

//        if ($request->has('admin')){
//            if (!$user->esVerificado()){
//                return response()->json(['error'=>'Unicamente los verificados pueden cambiar su valor de administrador','code'=>409],409);
//            }
//            $user->admin=$request->admin;
//        }

        if (!$user->isDirty()){
            return $this->errorResponse('Se debe especificar algun valor para actualizar',422);
        }

        $user->save();

        return $this->showOne($user);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $user=User::findOrFail($id);

        $user->delete();

        return $this->showOne($user);
    }
}
