<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Cashier\Exceptions\IncompletePayment;

class SuscripcionApiController extends Controller
{
    /**
     * Obtener información de la suscripción actual
     */
    public function info(Request $request)
    {
        $user = $request->user();

        return response()->json([
            'success' => true,
            'data' => [
                'tiene_suscripcion' => $user->tieneSuscripcionActiva(),
                'plan_actual' => $user->getPlanActual(),
                'info_suscripcion' => $user->getInfoSuscripcion(),
                'limites' => [
                    'whatsapp' => [
                        'actual' => $user->numerosWhatsApp()->count(),
                        'limite' => $user->getLimiteWhatsApp(),
                        'puede_agregar' => $user->puedeAgregarWhatsApp(),
                    ],
                    'cuentas' => [
                        'actual' => $user->cuentas()->count(),
                        'limite' => $user->getLimiteCuentas(),
                        'puede_agregar' => $user->puedeAgregarCuenta(),
                    ],
                ],
                'estado' => $user->getEstadoSuscripcionAttribute(),
                'trial_ends_at' => $user->trial_ends_at,
                'en_periodo_gracia' => $user->enPeriodoDeGracia(),
                'metodo_pago' => $user->hasPaymentMethod() ? [
                    'type' => $user->pm_type,
                    'last_four' => $user->pm_last_four,
                ] : null,
            ]
        ]);
    }

    /**
     * Crear suscripción desde API
     */
    public function crear(Request $request)
    {
        $request->validate([
            'payment_method' => 'required|string',
            'plan' => 'required|string',
            'plan_name' => 'nullable|string',
        ]);

        $user = $request->user();
        $paymentMethod = $request->payment_method;
        $plan = $request->plan;

        try {
            // Si el usuario no tiene cliente Stripe, crearlo
            if (!$user->stripe_id) {
                $user->createAsStripeCustomer();
            }

            // Actualizar método de pago por defecto
            $user->updateDefaultPaymentMethod($paymentMethod);

            // Verificar si ya tiene suscripción
            if ($user->subscribed('default')) {
                // Cambiar plan si ya tiene suscripción
                $user->subscription('default')->swap($plan);

                return response()->json([
                    'success' => true,
                    'message' => 'Plan actualizado exitosamente',
                    'action' => 'updated'
                ]);
            }

            // Crear nueva suscripción con período de prueba
            $subscription = $user->newSubscription('default', $plan)
                ->trialDays(14)
                ->create($paymentMethod);

            return response()->json([
                'success' => true,
                'message' => 'Suscripción creada exitosamente. ¡Disfruta de 14 días de prueba!',
                'action' => 'created',
                'subscription' => $subscription->stripe_id,
                'trial_ends_at' => $subscription->trial_ends_at,
            ]);

        } catch (IncompletePayment $exception) {
            return response()->json([
                'success' => false,
                'message' => 'Se requiere autenticación adicional',
                'requires_action' => true,
                'payment_intent_client_secret' => $exception->payment->client_secret
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Validar acceso a funcionalidad específica
     */
    public function validarAcceso(Request $request)
    {
        $request->validate([
            'funcionalidad' => 'required|string|in:whatsapp,cuentas,pro,empresa,basico',
            'accion' => 'required|string|in:crear,acceder'
        ]);

        $user = $request->user();
        $funcionalidad = $request->funcionalidad;
        $accion = $request->accion;

        $response = [
            'tiene_acceso' => false,
            'mensaje' => '',
            'plan_actual' => $user->getInfoSuscripcion()['plan'] ?? 'Gratis',
            'requiere_upgrade' => false,
        ];

        switch ($funcionalidad) {
            case 'whatsapp':
                if ($accion === 'crear') {
                    $response['tiene_acceso'] = $user->puedeAgregarWhatsApp();
                    $response['mensaje'] = $response['tiene_acceso']
                        ? 'Puedes agregar más números de WhatsApp'
                        : 'Has alcanzado el límite de números WhatsApp';
                    $response['limite'] = $user->getLimiteWhatsApp();
                    $response['actual'] = $user->numerosWhatsApp()->count();
                    $response['disponibles'] = max(0, $response['limite'] - $response['actual']);
                }
                break;

            case 'cuentas':
                if ($accion === 'crear') {
                    $response['tiene_acceso'] = $user->puedeAgregarCuenta();
                    $response['mensaje'] = $response['tiene_acceso']
                        ? 'Puedes agregar más cuentas'
                        : 'Has alcanzado el límite de cuentas';
                    $response['limite'] = $user->getLimiteCuentas();
                    $response['actual'] = $user->cuentas()->count();
                    $response['disponibles'] = max(0, $response['limite'] - $response['actual']);
                }
                break;

            case 'pro':
                $response['tiene_acceso'] = in_array($user->getPlanActual(), [
                    config('services.stripe.price_pro'),
                    config('services.stripe.price_empresa')
                ]);
                $response['mensaje'] = $response['tiene_acceso']
                    ? 'Tienes acceso a funcionalidades Pro'
                    : 'Esta funcionalidad requiere plan Pro o superior';
                $response['requiere_upgrade'] = !$response['tiene_acceso'];
                break;

            case 'empresa':
                $response['tiene_acceso'] = $user->getPlanActual() === config('services.stripe.price_empresa');
                $response['mensaje'] = $response['tiene_acceso']
                    ? 'Tienes acceso a funcionalidades Empresa'
                    : 'Esta funcionalidad requiere plan Empresa';
                $response['requiere_upgrade'] = !$response['tiene_acceso'];
                break;
        }

        return response()->json($response);
    }

    /**
     * Obtener precios de planes
     */
    public function precios()
    {
        return response()->json([
            'success' => true,
            'data' => [
                [
                    'id' => 'basico',
                    'nombre' => 'Básico',
                    'descripcion' => 'Perfecto para empezar',
                    'precio_mensual' => 10,
                    'precio_anual' => 96,
                    'precio_id' => config('services.stripe.price_basico'),
                    'caracteristicas' => [
                        'Hasta 3 números de WhatsApp',
                        '5 cuentas bancarias',
                        'Reportes básicos',
                        'Soporte por email',
                    ],
                    'limites' => [
                        'whatsapp' => 3,
                        'cuentas' => 5,
                    ],
                ],
                [
                    'id' => 'pro',
                    'nombre' => 'Pro',
                    'descripcion' => 'Para hacer crecer tu negocio',
                    'precio_mensual' => 20,
                    'precio_anual' => 192,
                    'precio_id' => config('services.stripe.price_pro'),
                    'caracteristicas' => [
                        'Hasta 10 números de WhatsApp',
                        '20 cuentas bancarias',
                        'Reportes avanzados',
                        'Análisis de tendencias',
                        'API Access limitado',
                        'Soporte prioritario',
                    ],
                    'limites' => [
                        'whatsapp' => 10,
                        'cuentas' => 20,
                    ],
                ],
                [
                    'id' => 'empresa',
                    'nombre' => 'Empresa',
                    'descripcion' => 'Para equipos y grandes volúmenes',
                    'precio_mensual' => 50,
                    'precio_anual' => 480,
                    'precio_id' => config('services.stripe.price_empresa'),
                    'caracteristicas' => [
                        'Números de WhatsApp ilimitados',
                        'Cuentas bancarias ilimitadas',
                        'Dashboard personalizado',
                        'API Access completo',
                        'Soporte 24/7 dedicado',
                        'Entrenamiento personalizado',
                    ],
                    'limites' => [
                        'whatsapp' => 'Ilimitado',
                        'cuentas' => 'Ilimitado',
                    ],
                ],
            ]
        ]);
    }
}
