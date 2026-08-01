<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

use App\Models\User;

class UserController extends Controller
{
    public function index(){
        $usuarios = User::all();
        return response()->json([
            'success'=>true,
            'usuario'=>$usuarios
        ],200);
    }
    public function contarUsuarios(){
        $totalUsuarios= User::all()->count();
        return response()->json([
            'success'=>true,
            'total'=>$totalUsuarios
        ],200);
    }
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
            'success' => true,
            'usuario' => $usuarioEncontrado,
            'token' => $token
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
            'success' => true,
            'usuario' => $usuarioCreado
        ], 201);
    }
    public function update(Request $request,  $usuario)
    {
        $usuarioEncontrado = User::where('id', $usuario)->first();
        if (!$usuarioEncontrado) {
            return response()->json([
                'mensaje' => 'El usuario no se encontro'
            ]);
        }
        $request->validate([
            'name' => 'required',
            'email' => 'required'
        ]);
        $usuarioEncontrado->name = $request->name;
        $usuarioEncontrado->email = $request->email;
        $usuarioEncontrado->save();
        return response()->json([
            'success' => true,
            'usuario'=>$usuarioEncontrado
        ]);
    }
}
