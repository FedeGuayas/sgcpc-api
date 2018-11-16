<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\ApiController;
use App\Mail\UserCreated;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class UserController extends ApiController
{
    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $usuarios = User::all();
        return $this->showAll($usuarios);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $rules = [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed'
        ];

        $this->validate($request, $rules);

        $data = $request->all();
        $data['password'] = $request->password;
        $data['verified'] = User::USUARIO_NO_VERIFICADO;
        $data['verification_token'] = User::generarVerificationToken();

        $usuario = User::create($data);

        return $this->showOne($usuario, 201);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(User $user)
    {
        return $this->showOne($user);
    }


    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, User $user)
    {
        $rules = [
            'email' => 'email|unique:users,email,' . $user->id,
            'password' => 'min:6|confirmed',

        ];

        $this->validate($request, $rules);

        if ($request->has('name')) {
            $user->name = $request->name;
        }

        if ($request->has('email') && $user->email != $request->email) {
            $user->verified = User::USUARIO_NO_VERIFICADO;
            $user->verification_token = User::generarVerificationToken();
            $user->email = $request->email;
        }

        if ($request->has('password')) {
            $user->password = $request->password;
        }

//        if ($request->has('admin')){
//            if (!$user->esVerificado()){
//                return response()->json(['error'=>'Unicamente los verificados pueden cambiar su valor de administrador','code'=>409],409);
//            }
//            $user->admin=$request->admin;
//        }

        if (!$user->isDirty()) {
            return $this->errorResponse('Se debe especificar algun valor para actualizar', 422);
        }

        $user->save();

        return $this->showOne($user);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(User $user)
    {
        $user->delete();

        return $this->showOne($user);
    }

    /**
     * Verifica el correo de la cuenta de usuario
     * @param $token
     * @return \Illuminate\Http\JsonResponse
     */
    public function verify($token)
    {
        $user=User::where('verification_token',$token)->firstOrFail();

        $user->verified=User::USUARIO_VERIFICADO;
        $user->verification_token=null;

        $user->save();

        return $this->showMessage('La cuenta ha sido verificada');
    }

    /**
     * Reenviar correo de verificacion de cuenta
     * @param User $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function resend(User $user)
    {
        if ($user->esVerificado()){
            return $this->errorResponse('Este usuario ya ha sido verificado.',409);
        }

        //retry(num_intentos,funcion,tiempo_entre_intentos);
        retry(5,function() use ($user){
            Mail::to($user->email)->send(new UserCreated($user));
        },100);


        return $this->showMessage('El correo de verificación ha sido reenviado');
    }
}
