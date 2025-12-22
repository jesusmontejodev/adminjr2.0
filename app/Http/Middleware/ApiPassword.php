<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ApiPassword
{
    public function handle(Request $request, Closure $next)
    {
        // Cambia esta contraseña por la que quieras
        $password = env('API_PASSWORD', 'miSuperPassword123');

        // Verifica que exista el header 'api-password'
        if ($request->header('api-password') !== $password) {
            return response()->json([
                'success' => false,
                'message' => 'Acceso denegado. Contraseña incorrecta.'
            ], 401);
        }

        return $next($request);
    }
}
