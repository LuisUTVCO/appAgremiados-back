<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use App\Models\agremiados;
use App\Models\User;

class AgremiadosController extends Controller
{
    // Función post para CREAR - Agremiado
    public function nuevoAgremiado(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'a_paterno' => 'required',
            'a_materno' => 'required',
            'nombre' => 'required',
            'sexo' => 'required',
            'NUP' => 'required',
            'NUE' => 'required', 
            'RFC' => 'required',
            'NSS' => 'required',
            'fecha_nacimiento' => 'required|date',
            'telefono' => 'required',
            'cuota' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $agremiado = agremiados::create($request->all());
        User::create([
            'NUE' => $request->NUE,
            'password' => bcrypt($request->NUE),
            'id_rol' => 1
        ]);
        return response($agremiado, 200);
    }

    // Función get para OBTENER - Agremiado
    public function getAgremiado()
    {
        return response()->json(agremiados::all(), 200);
    }


    
}
