<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VerificarSuscripcion
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();

        // Si no está autenticado, redirigir a login
        if (!$user) {
            if ($request->expectsJson()) {
                return response()->json([
                    'error' => 'No autenticado',
                    'message' => 'Debes iniciar sesión para acceder a este recurso.'
                ], 401);
            }
            return redirect()->route('login');
        }

        // IMPORTANTE: Refrescar el usuario de la BD para obtener cambios recientes (ej: webhooks N8N)
        $user = $user->fresh();
        if (!$user) {
            Auth::logout();
            return redirect()->route('login');
        }

        // Usar el método del modelo que tiene toda la lógica centralizada
        if (!$user->tieneAccesoPremium()) {
            $message = 'Tu suscripción no está activa o ha vencido.';

            if ($request->expectsJson()) {
                return response()->json([
                    'error' => 'Suscripción requerida',
                    'message' => $message,
                    'redirect' => route('planes')
                ], 403);
            }

            return redirect()->route('planes')
                ->with('error', $message)
                ->with('show_modal', true);
        }

        // Aviso si está por vencer
        if (!empty($user->access_until)) {
            $accessUntil = $user->access_until instanceof \Carbon\Carbon
                ? $user->access_until
                : \Carbon\Carbon::parse($user->access_until);

            $dias = now()->diffInDays($accessUntil, false);
            if ($dias <= 3 && $dias >= 0) {
                session()->flash('suscripcion_por_vencer', [
                    'days' => $dias,
                    'ends_at' => $accessUntil->format('d/m/Y'),
                ]);
            }
        }

        // Opcional: Verificar límites del plan
        $this->verificarLimitesPlan($user);

        return $next($request);
    }

    /**
     * Verificar límites del plan (opcional)
     */
    private function verificarLimitesPlan($user): void
    {
        // Puedes agregar lógica aquí para verificar límites específicos
        // Por ejemplo, si el usuario ya alcanzó el límite de números WhatsApp
        if ($user->tieneAccesoPremium()) {
            $limiteWhatsApp = $user->getLimiteWhatsApp();
            $actualWhatsApp = $user->numerosWhatsApp()->count();

            if ($actualWhatsApp >= $limiteWhatsApp) {
                session()->flash('limit_warning', [
                    'feature' => 'números de WhatsApp',
                    'limite' => $limiteWhatsApp,
                    'actual' => $actualWhatsApp
                ]);
            }
        }
    }
}
