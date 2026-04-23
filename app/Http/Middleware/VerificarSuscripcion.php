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

        // Verificar si el usuario tiene acceso premium usando el método de tu modelo
        if (!$user->tieneAccesoPremium()) {
            $message = $user->tienePagoVencido()
                ? 'Tu pago mensual está vencido. Actualiza tu método de pago para recuperar el acceso.'
                : ($user->tienePagoIncompleto()
                    ? 'Tu suscripción requiere completar el pago o autenticación pendiente.'
                    : 'Se requiere una suscripción activa para acceder a esta función.');

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

        // Opcional: Mostrar advertencia si el trial está por terminar
        if ($user->onTrial() && $user->trial_ends_at && $user->trial_ends_at->diffInDays(now()) <= 3) {
            session()->flash('trial_ending_soon', [
                'days' => $user->trial_ends_at->diffInDays(now()),
                'ends_at' => $user->trial_ends_at->format('d/m/Y'),
            ]);
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
