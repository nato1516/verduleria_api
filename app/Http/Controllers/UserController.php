<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

use App\Models\User;

class UserController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'password' => 'required'
        ]);
        $usuarioEncontrado = User::where('name', $request->name)->first();
        if (!$usuarioEncontrado) {
            return response()->json(
                [
                    'mensaje' => 'Eror al iniciar secion',
                ],
                404
            );
        }
        if (!Hash::check($request->password, $usuarioEncontrado->password)) {
            return response()->json([
                'mensaje' => 'error la contrasena esta mal'
            ]);
        }
        $token = $usuarioEncontrado->createToken('api-token')->plainTextToken;
        $usuarioEncontrado->remember_token = $token;
        $usuarioEncontrado->save();
        return response()->json([
            $usuarioEncontrado
        ]);
    }
    public function Registrar(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'password' => 'required',
            'role' => 'required',
            'email' => 'required|email'
        ]);


        $usuarioCreado = User::create([
            'name' => $request->name,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'email' => $request->email
        ]);


        return response()->json([
            'mensaje' => 'Usuario registrado correctamente',
            'usuario' => $usuarioCreado
        ], 201);
    }
     public function update(Request $request,  $usuario)
    {
        $usuarioEncontrado = User::where('id',$usuario);
        if(!$usuarioEncontrado){
            return response()->json([
                'mensaje'=>'El usuario no se encontro'
            ]);
        }
        $request->validate([
            'name'=>'required',
            'email'=>'required'
        ]);
        $usuarioEncontrado ->name =$request->name;
        $usuarioEncontrado->emaik=$request->email;
        $usuarioEncontrado->save();
        return response()->json([
            'mensaje'=>'Usuario actualizado con exito'
        ]);
    }
}
