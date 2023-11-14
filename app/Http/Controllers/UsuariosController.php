<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\User;

class UsuariosController extends Controller
{
    //public function login (){
       /*  $validator = Validator::make($request->all(), [
            'NUE' => 'required | string',
            'password' => 'required | string'
        ]);
        if ($validator->fails()) {
            return response()->json(['Error' => $validator->errors()], 422);
        }
        $credentials = $request->only(['NUE', 'password']);
        if (!Auth::attempt($credentials)) {
            return response()->json(['error' => 'No autorizado'], 401);
        }
        $usuario = $request->usuario();
        $token = $usuario->createToken('auth-token')->plainTextToken;
        return response()->json(['Token' => $token, 'usuario' => $usuario, 'AccessToken' => $token], 200); 
        */

        public function loginUsuario(Request $request){
            $credentials = $request->only('NUE', 'password');
    
            if(Auth::attempt($credentials)){
                $User = Auth::User();
                return response()->json($User, 200);
            }else {
                return response()->json(['message'=>'credencial incorrecta'], 401);
            }
        }
   // }

    public function getUsuarios(){
        $usuario = User::all();
        return response()->json($usuario, 200);
    }

    public function newUsuario(Request $request){
        $usuario = User::create($request->all());
        return response($usuario, 200);
    }


    public function starlogin(Request $request){
        $credentials = $request->only('NUE', 'password');

        if(Auth::attempt($credentials)){
            $usuario = Auth::usuario();
            return response()->json($usuario, 200);
        }else {
            return response()->json(['message'=>'credencial incorrecta'], 401);
        }
    }
}
