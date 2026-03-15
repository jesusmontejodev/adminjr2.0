<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RequiereSuscripcion
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login');
        }

        // Verificar si el usuario tiene acceso premium
        if (!$user->tieneAccesoPremium()) {
            $message = $user->tienePagoVencido()
                ? 'Tu pago mensual está vencido. Actualiza tu método de pago para recuperar el acceso.'
                : ($user->tienePagoIncompleto()
                    ? 'Tu suscripción requiere completar el pago o autenticación pendiente.'
                    : 'Se requiere una suscripción activa para acceder a esta sección.');

            return redirect()->route('planes')
                ->with('error', $message)
                ->with('show_modal', true);
        }

        // Advertencia si el trial está por terminar
        if ($user->onTrial() && $user->trial_ends_at && $user->trial_ends_at->diffInDays(now()) <= 3) {
            session()->flash('trial_ending_soon', [
                'days' => $user->trial_ends_at->diffInDays(now()),
                'ends_at' => $user->trial_ends_at->format('d/m/Y'),
            ]);
        }

        return $next($request);
    }
}
