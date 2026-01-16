<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Cashier\Exceptions\IncompletePayment;
use Stripe\Stripe;
use Stripe\Price;
use Stripe\Product;

class SuscripcionController extends Controller
{
    // Mostrar página de planes
    public function planes()
    {
        $planes = [
            [
                'id' => 'basico',
                'nombre' => 'Básico',
                'descripcion' => 'Perfecto para empezar',
                'precio_mensual' => 10,
                'precio_anual' => 96,
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
                'precio_id_mensual' => config('services.stripe.price_basico'),
                'popular' => false,
            ],
            [
                'id' => 'pro',
                'nombre' => 'Pro',
                'descripcion' => 'Para hacer crecer tu negocio',
                'precio_mensual' => 20,
                'precio_anual' => 192,
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
                'precio_id_mensual' => config('services.stripe.price_pro'),
                'popular' => true,
            ],
            [
                'id' => 'empresa',
                'nombre' => 'Empresa',
                'descripcion' => 'Para equipos y grandes volúmenes',
                'precio_mensual' => 50,
                'precio_anual' => 480,
                'caracteristicas' => [
                    'Números de WhatsApp ilimitados',
                    'Cuentas bancarias ilimitadas',
                    'Dashboard personalizado',
                    'API Access completo',
                    'Soporte 24/7 dedicado',
                    'Entrenamiento personalizado',
                    'Migración asistida',
                ],
                'limites' => [
                    'whatsapp' => 'Ilimitado',
                    'cuentas' => 'Ilimitado',
                ],
                'precio_id_mensual' => config('services.stripe.price_empresa'),
                'popular' => false,
            ],
        ];

        return view('suscripcion.planes', compact('planes'));
    }

    // Crear nueva suscripción
    public function crear(Request $request)
    {
        $request->validate([
            'payment_method' => 'required|string',
            'plan' => 'required|string',
            'plan_name' => 'nullable|string',
            'billing_period' => 'nullable|in:monthly,annual',
        ]);

        $user = Auth::user();
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
                ->create($paymentMethod, [
                    'email' => $user->email,
                ]);

            // Registrar en logs
            \Log::info('Nueva suscripción creada', [
                'user_id' => $user->id,
                'stripe_subscription_id' => $subscription->stripe_id,
                'plan' => $plan,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Suscripción creada exitosamente. ¡Disfruta de 14 días de prueba!',
                'action' => 'created',
                'subscription' => $subscription->stripe_id
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
            \Log::error('Error al crear suscripción: ' . $e->getMessage(), [
                'user_id' => $user->id ?? null,
                'plan' => $plan,
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
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

        // Cancelar suscripción (mantiene activa hasta el final del período)
        $user->subscription('default')->cancel();

        // Guardar razón de cancelación
        if ($request->reason) {
            // Aquí puedes guardar en tu base de datos
            \Log::info('Suscripción cancelada', [
                'user_id' => $user->id,
                'reason' => $request->reason,
                'ends_at' => $user->subscription('default')->ends_at,
            ]);
        }

        return redirect()->route('dashboard')
            ->with('success', 'Suscripción cancelada. Tendrás acceso hasta ' .
                   $user->subscription('default')->ends_at->format('d/m/Y') . '.');
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

        \Log::info('Suscripción reanudada', [
            'user_id' => $user->id,
        ]);

        return redirect()->route('dashboard')
            ->with('success', 'Suscripción reanudada exitosamente.');
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

            \Log::info('Método de pago actualizado', [
                'user_id' => $user->id,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Método de pago actualizado exitosamente'
            ]);

        } catch (\Exception $e) {
            \Log::error('Error al actualizar método de pago: ' . $e->getMessage(), [
                'user_id' => $user->id,
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    // Obtener facturas
    public function facturas()
    {
        $user = Auth::user();
        $invoices = $user->invoices();

        return view('suscripcion.facturas', compact('invoices'));
    }

    // Descargar factura
    public function descargarFactura($id)
    {
        $user = Auth::user();

        return $user->downloadInvoice($id, [
            'vendor' => config('app.name'),
            'product' => 'Suscripción ' . config('app.name'),
            'street' => 'Dirección de tu empresa',
            'location' => 'Ciudad, País',
            'phone' => '+1234567890',
            'email' => 'facturacion@tudominio.com',
            'url' => config('app.url'),
            'vendor_vat' => 'NIF/VAT si aplica',
        ]);
    }

    // Portal de facturación
    public function portalFacturacion()
    {
        $user = Auth::user();

        return $user->redirectToBillingPortal(route('dashboard'));
    }

    // Sincronizar planes desde Stripe (para administradores)
    public function sincronizarPlanes()
    {
        Stripe::setApiKey(config('services.stripe.secret'));

        try {
            // Obtener productos de Stripe
            $products = Product::all(['limit' => 10]);
            $prices = Price::all(['limit' => 10, 'active' => true]);

            // Aquí puedes sincronizar con tu base de datos
            foreach ($products as $product) {
                // Guardar en tu tabla de productos
            }

            return response()->json([
                'success' => true,
                'message' => 'Planes sincronizados exitosamente',
                'products' => count($products->data),
                'prices' => count($prices->data),
            ]);

        } catch (\Exception $e) {
            \Log::error('Error al sincronizar planes: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    // Obtener información de suscripción actual (API)
    public function infoSuscripcion()
    {
        $user = Auth::user();

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
            ]
        ]);
    }
}
