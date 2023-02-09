<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\Auth;
use Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller {
    public $successStatus = 200;

    public function register(Request $request)
{
    $validator = Validator::make($request->all(), [
        'firstname' => 'required|string|max:255',
        'email' => 'required|email|unique:users',
        'password' => 'required|string|min:6',
    ], [
        'firstname.required' => 'El campo Nombre es obligatorio.',
        'email.required' => 'El campo Correo electrónico es obligatorio.',
        'email.email' => 'El formato de Correo electrónico es inválido.',
        'email.unique' => 'El Correo electrónico ya ha sido registrado.',
        'password.required' => 'El campo Contraseña es obligatorio.',
        'password.min' => 'La Contraseña debe tener al menos 6 caracteres.',
    ]);

    if ($validator->fails()) {
        return response()->json(['error' => $validator->errors()], 400);
    }

    $input = $request->all();
    $input['password'] = Hash::make($input['password']);
    $user = User::create($input);
    //$token = $user->createToken('MyApp')->accessToken;

    return response()->json([
        //'token' => $token,
        'firstname' => $user->firstname,
    ], 200);
}
    public function login() {
        // Si las credenciales son correctas
        if(Auth::attempt(['email' => request('email'), 'password' => request('password')])) {
            $user = Auth::user();
            // Creamos un token de acceso para ese usuario
            $success['token'] = $user->createToken('MyApp')->accessToken;
            $success['userType'] = $user->type;
            $success['id'] = $user->id;
            $success['firstname'] = $user->firstname;

            // Y lo devolvemos en el objeto 'json'
            return response()->json(['success' => $success], $this->successStatus);
        }
        else {
            return response()->json(['error' => 'No estás autorizado'], 401);
        }
}

}
