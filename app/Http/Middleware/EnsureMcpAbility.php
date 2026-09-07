<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureMcpAbility
{
    /**
     * Verifica que el token Sanctum autenticado tenga la ability requerida
     * ('read' -> 'read:own', 'write' -> 'write:own').
     */
    public function handle(Request $request, Closure $next, string $scope)
    {
        $ability = "{$scope}:own";
        $user = $request->user();

        if (!$user || !$user->currentAccessToken() || !$user->tokenCan($ability)) {
            return response()->json([
                'error' => 'Permiso insuficiente',
                'message' => "Este token no tiene el permiso '{$ability}' requerido para esta acción.",
            ], 403);
        }

        return $next($request);
    }
}
