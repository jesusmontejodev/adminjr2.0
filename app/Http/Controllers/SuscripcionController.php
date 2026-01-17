<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Laravel\Cashier\Exceptions\IncompletePayment;

class SuscripcionController extends Controller
{
    // Mostrar página de planes (sólo básico)
    public function planes()
    {
        // Solo un plan: Básico
        $planes = [
            [
                'id' => 'basico',
                'nombre' => 'Plan Básico',
                'descripcion' => 'Todo lo necesario para empezar',
                'precio_mensual' => 459, // $459 MXN
                'moneda' => 'MXN',
                'caracteristicas' => [
                    '✅ Hasta 3 números de WhatsApp',
                    '✅ 5 cuentas bancarias',
                    '✅ Reportes básicos',
                    '✅ Soporte por email',
                ],
                'precio_id' => $this->getPrecioBasico(),
                'popular' => true,
            ]
        ];

        return view('suscripcion.planes', compact('planes'));
    }

    // Crear nueva suscripción al plan BÁSICO (usado desde formulario tradicional)
    public function crear(Request $request)
    {
        $request->validate([
            'payment_method' => 'required|string',
        ]);

        $user = Auth::user();
        $paymentMethod = $request->payment_method;
        $precioId = $this->getPrecioBasico();

        try {
            // Si el usuario no tiene cliente Stripe, crearlo
            if (!$user->stripe_id) {
                $user->createAsStripeCustomer();
            }

            // Actualizar método de pago por defecto
            $user->updateDefaultPaymentMethod($paymentMethod);

            // Verificar si ya tiene suscripción activa
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
                    ]
                ]);

            Log::info('Nueva suscripción Básica creada', [
                'user_id' => $user->id,
                'stripe_subscription_id' => $subscription->stripe_id,
                'price_id' => $precioId,
            ]);

            return response()->json([
                'success' => true,
                'message' => '¡Suscripción Básica creada exitosamente! Disfruta de 14 días de prueba.',
                'action' => 'created',
                'subscription_id' => $subscription->id
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
            Log::error('Error al crear suscripción Básica: ' . $e->getMessage(), [
                'user_id' => $user->id ?? null,
                'price_id' => $precioId,
                'error_trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Error al procesar la suscripción. Por favor, verifica tu información de pago.'
            ], 500);
        }
    }

    // Método simplificado para suscribirse directamente al básico
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

            // Actualizar método de pago primero
            $user->updateDefaultPaymentMethod($request->payment_method);

            // Crear suscripción - usando 'default' como nombre
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
                'price_id' => $precioId,
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
                'price_id' => $precioId,
                'error' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Error al procesar la suscripción: ' . $this->getErrorMessage($e)
            ], 500);
        }
    }

    // Cancelar suscripción
    public function cancelar(Request $request)
    {
        $request->validate([
            'reason' => 'nullable|string|max:500'
        ]);

        $user = Auth::user();

        if (!$user->subscribed('default')) {
            return redirect()->route('planes')
                ->with('error', 'No tienes una suscripción activa.');
        }

        // Cancelar suscripción
        $subscription = $user->subscription('default');
        $endsAt = $subscription->ends_at;

        $subscription->cancel();

        Log::info('Suscripción Básica cancelada', [
            'user_id' => $user->id,
            'reason' => $request->reason,
            'ends_at' => $endsAt,
        ]);

        return redirect()->route('dashboard')
            ->with('success', 'Suscripción Básica cancelada. Acceso hasta ' .
                   ($endsAt ? $endsAt->format('d/m/Y') : 'fin del período') . '.');
    }

    // Obtener información de suscripción actual
    public function infoSuscripcion()
    {
        $user = Auth::user();

        $data = [
            'tiene_suscripcion' => $user->tieneSuscripcionActiva(),
            'plan_actual' => $user->tieneSuscripcionActiva() ? 'basico' : null,
            'estado' => $this->getEstadoSuscripcion($user),
            'trial_ends_at' => $user->trial_ends_at,
            'en_periodo_gracia' => $user->enPeriodoDeGracia(),
        ];

        // Solo agregar información de límites si está suscrito
        if ($user->tieneSuscripcionActiva()) {
            $data['limites'] = [
                'whatsapp' => [
                    'actual' => $user->numerosWhatsApp()->count(),
                    'limite' => 3,
                    'puede_agregar' => $user->numerosWhatsApp()->count() < 3,
                ],
                'cuentas' => [
                    'actual' => $user->cuentas()->count(),
                    'limite' => 5,
                    'puede_agregar' => $user->cuentas()->count() < 5,
                ],
            ];
        }

        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }

    // Reanudar suscripción
    public function reanudar()
    {
        $user = Auth::user();

        if (!$user->subscription('default')->onGracePeriod()) {
            return redirect()->route('dashboard')
                ->with('error', 'No puedes reanudar esta suscripción.');
        }

        $user->subscription('default')->resume();

        Log::info('Suscripción reanudada', ['user_id' => $user->id]);

        return redirect()->route('dashboard')
            ->with('success', 'Suscripción Básica reanudada.');
    }

    // Actualizar método de pago
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

    // Ver facturas
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

    // Descargar factura
    public function descargarFactura($id)
    {
        $user = Auth::user();

        return $user->downloadInvoice($id, [
            'vendor' => config('app.name'),
            'product' => 'Plan Básico - ' . config('app.name'),
        ]);
    }

    // Portal de facturación de Stripe
    public function portalFacturacion()
    {
        $user = Auth::user();

        if (!$user->subscribed('default')) {
            return redirect()->route('planes')
                ->with('error', 'No tienes una suscripción activa.');
        }

        return $user->redirectToBillingPortal(route('dashboard'));
    }

    // ============================================
    // MÉTODOS PRIVADOS AUXILIARES
    // ============================================

    /**
     * Obtiene el ID del precio del plan básico
     */
    private function getPrecioBasico()
    {
        // Obtener directamente del .env
        $precioId = env('STRIPE_PRICE_BASICO');

        // Si está vacío o es el placeholder, loguear error
        if (empty($precioId) || $precioId === 'price_1MotKDEnLYCXf8OxBASICO') {
            Log::critical('STRIPE_PRICE_BASICO no configurado en .env', [
                'valor_actual' => $precioId
            ]);

            throw new \Exception(
                'El sistema de suscripciones no está configurado correctamente. ' .
                'Por favor, contacta al soporte técnico.'
            );
        }

        // Validar formato básico
        if (!str_starts_with($precioId, 'price_')) {
            Log::error('Formato inválido para STRIPE_PRICE_BASICO', [
                'valor' => $precioId
            ]);

            throw new \Exception('Configuración de precio inválida');
        }

        return $precioId;
    }

    /**
     * Obtiene el estado de la suscripción del usuario
     */

    private function getEstadoSuscripcion($user)
    {
        if (!$user->tieneSuscripcionActiva()) {
            return 'Sin suscripción';
        }

        if ($user->onTrial()) {
            return 'En período de prueba';
        }

        if ($user->enPeriodoDeGracia()) {
            return 'En período de gracia';
        }

        return 'Activa';
    }

    /**
     * Convierte errores de Stripe a mensajes amigables
     */
    private function getErrorMessage(\Exception $e)
    {
        $message = $e->getMessage();

        // Errores comunes de Stripe
        if (str_contains($message, 'No such price')) {
            return 'El plan seleccionado no existe. Contacta al soporte.';
        }

        if (str_contains($message, 'invalid plan')) {
            return 'El plan seleccionado no es válido.';
        }

        if (str_contains($message, 'card_declined')) {
            return 'Tu tarjeta fue rechazada. Por favor, usa otro método de pago.';
        }

        if (str_contains($message, 'insufficient_funds')) {
            return 'Fondos insuficientes en tu tarjeta.';
        }

        if (str_contains($message, 'expired_card')) {
            return 'Tu tarjeta ha expirado. Actualiza tu método de pago.';
        }

        // Si no es un error conocido, devolver mensaje genérico
        return 'Ocurrió un error al procesar el pago. Intenta de nuevo o contacta al soporte.';
    }
}
