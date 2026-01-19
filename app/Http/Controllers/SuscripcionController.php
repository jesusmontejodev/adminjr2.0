<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Laravel\Cashier\Exceptions\IncompletePayment;

class SuscripcionController extends Controller
{
    // ==================== ENDPOINTS PÚBLICOS ====================

    /**
     * Mostrar página de planes
     */
    public function planes()
    {
        $precioId = env('STRIPE_PRICE_BASICO');

        if (!$precioId || $precioId === 'price_1MotKDEnLYCXf8OxBASICO') {
            Log::error('STRIPE_PRICE_BASICO no configurado en .env');
            return redirect()->route('dashboard')
                ->with('error', 'El sistema de suscripciones no está disponible temporalmente.');
        }

        $planes = [
            [
                'id' => 'basico',
                'nombre' => 'Plan Básico',
                'descripcion' => 'Todo lo necesario para empezar',
                'precio_mensual' => 459,
                'moneda' => 'MXN',
                'caracteristicas' => [
                    '✅ Hasta 3 números de WhatsApp',
                    '✅ 5 cuentas bancarias',
                    '✅ Reportes básicos',
                    '✅ Soporte por email',
                ],
                'precio_id' => $precioId,
                'popular' => true,
            ]
        ];

        return view('suscripcion.planes', compact('planes'));
    }

    /**
     * Obtener información de suscripción actual (API)
     */
    public function infoSuscripcion()
    {
        $user = Auth::user();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Usuario no autenticado'
            ], 401);
        }

        return response()->json([
            'success' => true,
            'data' => [
                'tiene_suscripcion' => $user->tieneSuscripcionActiva(),
                'tiene_acceso_premium' => $user->tieneAccesoPremium(),
                'plan_actual' => $user->getPlanActualNombre(),
                'plan_id' => $user->getPlanActualId(),
                'estado' => $user->estado_suscripcion,
                'en_trial' => $user->onTrial(),
                'trial_ends_at' => $user->trial_ends_at,
                'en_periodo_gracia' => $user->enPeriodoDeGracia(),
                'limites' => [
                    'whatsapp' => [
                        'limite' => $user->getLimiteWhatsApp(),
                        'actual' => $user->numerosWhatsApp()->count(),
                        'puede_agregar' => $user->puede_agregar_whatsapp,
                    ],
                    'cuentas' => [
                        'limite' => $user->getLimiteCuentas(),
                        'actual' => $user->cuentas()->count(),
                        'puede_agregar' => $user->puede_agregar_cuentas,
                    ],
                ],
                'metodo_pago' => $user->hasDefaultPaymentMethod() ? [
                    'tipo' => $user->pm_type,
                    'ultimos_cuatro' => $user->pm_last_four,
                ] : null,
            ]
        ]);
    }

    // ==================== ENDPOINTS AUTENTICADOS ====================

    /**
     * Crear suscripción (método original)
     */
    public function crear(Request $request)
    {
        $request->validate([
            'payment_method' => 'required|string',
            'plan' => 'required|string|in:basico',
        ]);

        $user = Auth::user();
        $paymentMethod = $request->payment_method;
        $plan = 'basico';
        $precioId = $this->getPrecioBasico();

        try {
            // Si el usuario no tiene cliente Stripe, crearlo
            if (!$user->stripe_id) {
                $user->createAsStripeCustomer();
            }

            // Actualizar método de pago por defecto
            $user->updateDefaultPaymentMethod($paymentMethod);

            // Verificar si ya tiene suscripción
            if ($user->subscribed('default')) {
                return response()->json([
                    'success' => false,
                    'message' => 'Ya tienes una suscripción activa.',
                    'action' => 'already_subscribed'
                ]);
            }

            // Crear nueva suscripción con período de prueba
            $subscription = $user->newSubscription('default', $precioId)
                ->trialDays(14)
                ->create($paymentMethod, [
                    'email' => $user->email,
                    'metadata' => [
                        'plan_name' => 'Plan Básico',
                        'user_id' => $user->id,
                        'pago_manual' => false,
                    ]
                ]);

            Log::info('Nueva suscripción creada', [
                'user_id' => $user->id,
                'stripe_subscription_id' => $subscription->stripe_id,
                'plan' => 'basico',
            ]);

            return response()->json([
                'success' => true,
                'message' => '¡Suscripción creada exitosamente! Disfruta de 14 días de prueba.',
                'action' => 'created',
                'subscription_id' => $subscription->id,
                'trial_ends_at' => $subscription->trial_ends_at?->format('Y-m-d H:i:s'),
            ]);

        } catch (IncompletePayment $exception) {
            // Pago requiere acción adicional (3D Secure)
            return response()->json([
                'success' => false,
                'message' => 'Se requiere autenticación adicional',
                'requires_action' => true,
                'payment_intent_client_secret' => $exception->payment->client_secret
            ]);

        } catch (\Exception $e) {
            Log::error('Error al crear suscripción: ' . $e->getMessage(), [
                'user_id' => $user->id ?? null,
                'plan' => 'basico',
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Error al procesar la suscripción: ' . $this->getErrorMessage($e)
            ], 500);
        }
    }

    /**
     * Método simplificado para suscribirse al básico
     */
    public function suscribirseBasico(Request $request)
    {
        $request->validate([
            'payment_method' => 'required|string',
        ]);

        $user = Auth::user();
        $precioId = $this->getPrecioBasico();

        try {
            // Verificar si ya está suscrito
            if ($user->subscribed('default')) {
                return response()->json([
                    'success' => false,
                    'message' => 'Ya tienes una suscripción activa.',
                    'code' => 'ALREADY_SUBSCRIBED'
                ]);
            }

            // Crear o obtener cliente Stripe
            if (!$user->stripe_id) {
                $user->createAsStripeCustomer();
            }

            // Crear suscripción
            $subscription = $user->newSubscription('default', $precioId)
                ->trialDays(14)
                ->create($request->payment_method, [
                    'email' => $user->email,
                    'metadata' => [
                        'plan' => 'basico',
                        'user_id' => $user->id,
                    ]
                ]);

            Log::info('Usuario suscrito al Plan Básico', [
                'user_id' => $user->id,
                'subscription_id' => $subscription->id,
            ]);

            return response()->json([
                'success' => true,
                'message' => '¡Te has suscrito al Plan Básico! Disfruta de 14 días de prueba.',
                'subscription_id' => $subscription->id,
                'trial_ends_at' => $subscription->trial_ends_at?->format('Y-m-d H:i:s'),
            ]);

        } catch (IncompletePayment $exception) {
            return response()->json([
                'success' => false,
                'message' => 'Se requiere autenticación adicional para completar el pago.',
                'requires_action' => true,
                'payment_intent_client_secret' => $exception->payment->client_secret
            ]);

        } catch (\Exception $e) {
            Log::error('Error en suscribirseBasico: ' . $e->getMessage(), [
                'user_id' => $user->id,
                'error' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Error al procesar la suscripción: ' . $this->getErrorMessage($e)
            ], 500);
        }
    }

    /**
     * Cancelar suscripción
     */
    public function cancelar(Request $request)
    {
        $request->validate([
            'reason' => 'nullable|string|max:500'
        ]);

        $user = Auth::user();

        if (!$user->subscribed('default')) {
            return response()->json([
                'success' => false,
                'message' => 'No tienes una suscripción activa.'
            ], 400);
        }

        try {
            $subscription = $user->subscription('default');
            $endsAt = $subscription->ends_at;

            $subscription->cancel();

            Log::info('Suscripción cancelada', [
                'user_id' => $user->id,
                'reason' => $request->reason,
                'ends_at' => $endsAt,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Suscripción cancelada exitosamente.',
                'ends_at' => $endsAt?->format('Y-m-d H:i:s'),
                'access_until' => $endsAt ? $endsAt->format('d/m/Y') : 'fin del período actual',
            ]);

        } catch (\Exception $e) {
            Log::error('Error al cancelar suscripción: ' . $e->getMessage(), [
                'user_id' => $user->id
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Error al cancelar la suscripción: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Reanudar suscripción cancelada
     */
    public function reanudar(Request $request)
    {
        $user = Auth::user();

        if (!$user->subscription('default')->onGracePeriod()) {
            return response()->json([
                'success' => false,
                'message' => 'No puedes reanudar esta suscripción.'
            ], 400);
        }

        try {
            $user->subscription('default')->resume();

            Log::info('Suscripción reanudada', [
                'user_id' => $user->id
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Suscripción reanudada exitosamente.'
            ]);

        } catch (\Exception $e) {
            Log::error('Error al reanudar suscripción: ' . $e->getMessage(), [
                'user_id' => $user->id
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Error al reanudar la suscripción: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Actualizar método de pago
     */
    public function actualizarMetodoPago(Request $request)
    {
        $request->validate([
            'payment_method' => 'required|string'
        ]);

        $user = Auth::user();

        try {
            $user->updateDefaultPaymentMethod($request->payment_method);

            return response()->json([
                'success' => true,
                'message' => 'Método de pago actualizado correctamente'
            ]);

        } catch (\Exception $e) {
            Log::error('Error al actualizar método de pago: ' . $e->getMessage(), [
                'user_id' => $user->id
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar el método de pago: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Ver facturas
     */
    public function facturas()
    {
        $user = Auth::user();

        if (!$user->subscribed('default')) {
            return redirect()->route('planes')
                ->with('error', 'No tienes suscripciones activas.');
        }

        $invoices = $user->invoices();

        return view('suscripcion.facturas', compact('invoices'));
    }

    /**
     * Descargar factura
     */
    public function descargarFactura($id)
    {
        $user = Auth::user();

        return $user->downloadInvoice($id, [
            'vendor' => config('app.name'),
            'product' => 'Plan Básico - ' . config('app.name'),
        ]);
    }

    /**
     * Portal de facturación de Stripe
     */
    public function portalFacturacion()
    {
        $user = Auth::user();

        if (!$user->subscribed('default')) {
            return redirect()->route('planes')
                ->with('error', 'No tienes una suscripción activa.');
        }

        return $user->redirectToBillingPortal(route('dashboard'));
    }

    // ==================== MÉTODOS DE ADMINISTRACIÓN ====================

    /**
     * Crear suscripción manualmente (para admin)
     */
    public function crearManual(Request $request)
    {
        // Proteger esta ruta solo para admin
        if (!Auth::user()->is_admin) {
            return response()->json([
                'success' => false,
                'message' => 'No autorizado.'
            ], 403);
        }

        $request->validate([
            'user_id' => 'required|exists:users,id',
            'months' => 'required|integer|min:1|max:12',
            'plan' => 'required|string|in:basico',
        ]);

        try {
            $user = \App\Models\User::find($request->user_id);
            $precioId = $this->getPrecioBasico();
            $months = $request->months;

            // Crear cliente en Stripe si no existe
            if (!$user->stripe_id) {
                $user->createAsStripeCustomer();
            }

            // Crear suscripción en Stripe
            $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));

            $subscription = $stripe->subscriptions->create([
                'customer' => $user->stripe_id,
                'items' => [['price' => $precioId]],
                'billing_cycle_anchor' => 'now',
                'proration_behavior' => 'none',
                'metadata' => [
                    'pago_manual' => 'true',
                    'metodo' => 'deposito',
                    'admin_id' => Auth::id(),
                    'months' => $months,
                ]
            ]);

            // Insertar en base de datos
            \DB::table('subscriptions')->insert([
                'user_id' => $user->id,
                'name' => 'default',
                'stripe_id' => $subscription->id,
                'stripe_status' => 'active',
                'stripe_price' => $precioId,
                'quantity' => 1,
                'trial_ends_at' => null,
                'ends_at' => now()->addMonths($months),
                'created_at' => now(),
                'updated_at' => now()
            ]);

            Log::info('Suscripción manual creada por admin', [
                'admin_id' => Auth::id(),
                'user_id' => $user->id,
                'months' => $months,
                'stripe_subscription_id' => $subscription->id,
            ]);

            return response()->json([
                'success' => true,
                'message' => "Suscripción manual creada por $months meses.",
                'subscription_id' => $subscription->id,
                'ends_at' => now()->addMonths($months)->format('Y-m-d'),
            ]);

        } catch (\Exception $e) {
            Log::error('Error al crear suscripción manual: ' . $e->getMessage(), [
                'admin_id' => Auth::id(),
                'user_id' => $request->user_id,
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Error al crear suscripción manual: ' . $e->getMessage()
            ], 500);
        }
    }

    // ==================== MÉTODOS PRIVADOS AUXILIARES ====================

    /**
     * Obtener el precio del plan básico
     */
    private function getPrecioBasico()
    {
        $precioId = env('STRIPE_PRICE_BASICO');

        if (empty($precioId) || $precioId === 'price_1MotKDEnLYCXf8OxBASICO') {
            throw new \Exception('Configuración de Stripe incompleta.');
        }

        return $precioId;
    }

    /**
     * Convertir errores de Stripe a mensajes amigables
     */
    private function getErrorMessage(\Exception $e)
    {
        $message = $e->getMessage();

        $errors = [
            'No such price' => 'El plan seleccionado no existe.',
            'invalid plan' => 'El plan seleccionado no es válido.',
            'card_declined' => 'Tu tarjeta fue rechazada.',
            'insufficient_funds' => 'Fondos insuficientes en tu tarjeta.',
            'expired_card' => 'Tu tarjeta ha expirado.',
            'Your card was declined.' => 'Tu tarjeta fue rechazada.',
        ];

        foreach ($errors as $key => $value) {
            if (str_contains($message, $key)) {
                return $value;
            }
        }

        return 'Ocurrió un error al procesar el pago. Intenta de nuevo.';
    }
}
