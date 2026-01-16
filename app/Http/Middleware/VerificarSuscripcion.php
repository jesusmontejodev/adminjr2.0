<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VerificarSuscripcion
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $recurso = null): Response
    {
        $user = $request->user();

        // Si no hay usuario autenticado
        if (!$user) {
            if ($request->expectsJson()) {
                return response()->json([
                    'error' => 'No autenticado',
                    'message' => 'Debes iniciar sesión para acceder a esta funcionalidad.'
                ], 401);
            }
            return redirect()->route('login');
        }

        // Verificar si tiene acceso premium
        if (!$user->tieneAccesoPremium()) {
            if ($request->expectsJson()) {
                return response()->json([
                    'error' => 'Se requiere suscripción premium',
                    'message' => '¡Necesitas una suscripción premium para acceder a esta funcionalidad!',
                    'redirect' => route('planes'),
                    'upgrade_required' => true
                ], 403);
            }

            return redirect()->route('planes')
                ->with('error', '¡Necesitas una suscripción premium para acceder a esta funcionalidad!')
                ->with('upgrade_required', true);
        }

        // Verificar límites específicos según el recurso
        if ($recurso) {
            $resultado = $this->verificarLimiteRecurso($user, $recurso, $request);
            if ($resultado !== true) {
                return $resultado;
            }
        }

        return $next($request);
    }

    /**
     * Verificar límite de recurso específico
     */
    private function verificarLimiteRecurso($user, string $recurso, Request $request)
    {
        switch ($recurso) {
            case 'whatsapp':
                if (!$user->puedeAgregarWhatsApp()) {
                    return $this->respuestaLimiteAlcanzado(
                        $request,
                        'números de WhatsApp',
                        $user->getLimiteWhatsApp(),
                        $user->numerosWhatsApp()->count()
                    );
                }
                break;

            case 'cuentas':
                if (!$user->puedeAgregarCuenta()) {
                    return $this->respuestaLimiteAlcanzado(
                        $request,
                        'cuentas bancarias',
                        $user->getLimiteCuentas(),
                        $user->cuentas()->count()
                    );
                }
                break;

            case 'pro':
                // Verificar si tiene plan Pro o superior
                if (!in_array($user->getPlanActual(), [
                    config('services.stripe.price_pro'),
                    config('services.stripe.price_empresa')
                ])) {
                    return $this->respuestaPlanInsuficiente(
                        $request,
                        'Pro'
                    );
                }
                break;

            case 'empresa':
                // Verificar si tiene plan Empresa
                if ($user->getPlanActual() !== config('services.stripe.price_empresa')) {
                    return $this->respuestaPlanInsuficiente(
                        $request,
                        'Empresa'
                    );
                }
                break;

            case 'basico':
                // Verificar si tiene plan Básico o superior
                if (!in_array($user->getPlanActual(), [
                    config('services.stripe.price_basico'),
                    config('services.stripe.price_pro'),
                    config('services.stripe.price_empresa')
                ])) {
                    return $this->respuestaPlanInsuficiente(
                        $request,
                        'Básico'
                    );
                }
                break;
        }

        return true;
    }

    /**
     * Respuesta para límite alcanzado
     */
    private function respuestaLimiteAlcanzado(Request $request, string $recurso, int $limite, int $actual)
    {
        $message = "Has alcanzado el límite de {$limite} {$recurso}. " .
                  "Actualmente tienes {$actual} de {$limite}. " .
                  "Considera actualizar tu plan para obtener más {$recurso}.";

        if ($request->expectsJson()) {
            return response()->json([
                'error' => 'Límite alcanzado',
                'message' => $message,
                'limite' => $limite,
                'actual' => $actual,
                'recurso' => $recurso,
                'upgrade_url' => route('planes')
            ], 403);
        }

        return back()->with('error', $message);
    }

    /**
     * Respuesta para plan insuficiente
     */
    private function respuestaPlanInsuficiente(Request $request, string $planRequerido)
    {
        $message = "Esta funcionalidad requiere el plan {$planRequerido} o superior.";

        if ($request->expectsJson()) {
            return response()->json([
                'error' => 'Plan insuficiente',
                'message' => $message,
                'required_plan' => $planRequerido,
                'current_plan' => $request->user()->getInfoSuscripcion()['plan'] ?? 'Gratis',
                'upgrade_url' => route('planes')
            ], 403);
        }

        return redirect()->route('planes')
            ->with('error', $message)
            ->with('plan_requerido', $planRequerido);
    }
}
