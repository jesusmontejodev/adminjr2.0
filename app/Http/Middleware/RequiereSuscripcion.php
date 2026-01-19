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
            return redirect()->route('planes')
                ->with('error', 'Se requiere una suscripción activa para acceder a esta sección.')
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
