<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UsuarioMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        // Obtener usuario autenticado mediante Sanctum
        $usuario = $request->user('sanctum');


        if (!$usuario) {
            return response()->json([
                'mensaje' => 'Necesita un token válido para acceder'
            ], 401);
        }


        // Validar que sea administrador
        if ($usuario->role !== 'admin') {
            return response()->json([
                'mensaje' => 'El usuario no tiene permisos de administrador'
            ], 403);
        }


        // Pasar usuario al controlador
        $request->merge([
            'usuario' => $usuario
        ]);


        return $next($request);
    }
}