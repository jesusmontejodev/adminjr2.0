<?php

use Illuminate\Http\Request;
use App\Http\Controllers\Api\MensajesDeEntrenamientoApiController;
use App\Http\Controllers\Api\TransaccionesInternasController;
use App\Http\Controllers\Api\TransaccionController;
use App\Http\Controllers\Api\UserDataController;
use App\Http\Controllers\Api\SuscripcionController; // Agregar esta línea
use Illuminate\Support\Facades\Route;

// ==================== RUTAS PÚBLICAS ====================

// Webhook de Stripe (debe ser pública, sin autenticación)
Route::post('/stripe/webhook', function () {
    return \Laravel\Cashier\Http\Controllers\WebhookController::class;
})->name('stripe.webhook');

// Webhook de prueba para desarrollo
Route::post('/stripe/webhook-test', function () {
    // Solo en desarrollo
    if (app()->environment('local')) {
        \Log::info('Webhook de prueba recibido', request()->all());
        return response()->json(['message' => 'Webhook test recibido']);
    }
    return response()->json(['error' => 'No disponible'], 404);
})->middleware('api')->name('stripe.webhook-test');

// ==================== RUTAS PROTEGIDAS POR AUTH ====================
Route::middleware(['auth:sanctum'])->group(function () {

    // ============= RUTAS DE SUSCRIPCIÓN =============
    Route::prefix('suscripcion')->name('api.suscripcion.')->group(function () {
        // Información de la suscripción actual
        Route::get('/info', [SuscripcionController::class, 'infoSuscripcion'])
            ->name('info');

        // Crear suscripción
        Route::post('/crear', [SuscripcionController::class, 'crear'])
            ->name('crear');

        // Cancelar suscripción
        Route::post('/cancelar', [SuscripcionController::class, 'cancelar'])
            ->name('cancelar');

        // Reanudar suscripción
        Route::post('/reanudar', [SuscripcionController::class, 'reanudar'])
            ->name('reanudar');

        // Actualizar método de pago
        Route::post('/actualizar-metodo-pago', [SuscripcionController::class, 'actualizarMetodoPago'])
            ->name('actualizar-metodo-pago');

        // Verificar límites
        Route::get('/limites', function (Request $request) {
            $user = $request->user();

            return response()->json([
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
                'plan' => $user->getInfoSuscripcion(),
            ]);
        })->name('limites');

        // Validar acceso a funcionalidad
        Route::post('/validar-acceso', function (Request $request) {
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
        })->name('validar-acceso');
    });

    // ============= RUTAS PROTEGIDAS POR SUSCRIPCIÓN =============
    Route::middleware(['verificar.suscripcion'])->group(function () {

        // API para números WhatsApp (requiere suscripción)
        Route::prefix('numeros-whatsapp')->name('api.numeros-whatsapp.')->group(function () {
            // Verificar límite antes de crear
            Route::post('/verificar-limite', function (Request $request) {
                $user = $request->user();

                return response()->json([
                    'puede_agregar' => $user->puedeAgregarWhatsApp(),
                    'limite' => $user->getLimiteWhatsApp(),
                    'actual' => $user->numerosWhatsApp()->count(),
                    'disponibles' => max(0, $user->getLimiteWhatsApp() - $user->numerosWhatsApp()->count()),
                    'plan' => $user->getInfoSuscripcion()['plan'],
                ]);
            })->name('verificar-limite');
        });

        // API para cuentas (requiere suscripción)
        Route::prefix('cuentas')->name('api.cuentas.')->group(function () {
            // Verificar límite antes de crear
            Route::post('/verificar-limite', function (Request $request) {
                $user = $request->user();

                return response()->json([
                    'puede_agregar' => $user->puedeAgregarCuenta(),
                    'limite' => $user->getLimiteCuentas(),
                    'actual' => $user->cuentas()->count(),
                    'disponibles' => max(0, $user->getLimiteCuentas() - $user->cuentas()->count()),
                    'plan' => $user->getInfoSuscripcion()['plan'],
                ]);
            })->name('verificar-limite');
        });
    });

    // ============= RUTAS EXISTENTES =============
    Route::apiResource('mensajes', MensajesDeEntrenamientoApiController::class)
        ->names([
            'index' => 'api.mensajes.index',
            'store' => 'api.mensajes.store',
            'show' => 'api.mensajes.show',
            'update' => 'api.mensajes.update',
            'destroy' => 'api.mensajes.destroy',
        ]);

    Route::apiResource('transacciones', TransaccionController::class)
        ->names([
            'index' => 'api.transacciones.index',
            'store' => 'api.transacciones.store',
            'show' => 'api.transacciones.show',
            'update' => 'api.transacciones.update',
            'destroy' => 'api.transacciones.destroy',
        ]);

    Route::get('transacciones/graficos/datos', [TransaccionController::class, 'graficos'])
        ->name('api.transacciones.graficos');

    Route::get('transacciones/cuentas/todas', [TransaccionController::class, 'cuentas'])
        ->name('api.transacciones.cuentas');

    Route::apiResource('transaccionesinternas', TransaccionesInternasController::class)
        ->names([
            'index'   => 'api.transaccionesinternas.index',
            'store'   => 'api.transaccionesinternas.store',
            'show'    => 'api.transaccionesinternas.show',
            'update'  => 'api.transaccionesinternas.update',
            'destroy' => 'api.transaccionesinternas.destroy',
        ]);

    // ============= RUTAS PARA BUSCAR POR TELÉFONO =============

    // Rutas públicas por teléfono
    Route::get('telefono/{numero}/data', [UserDataController::class, 'getUserDataByPhone'])
        ->name('api.telefono.data');

    Route::get('telefono/{numero}/categorias', [UserDataController::class, 'getCategoriasByPhone'])
        ->name('api.telefono.categorias');

    Route::get('telefono/{numero}/cuentas', [UserDataController::class, 'getCuentasByPhone'])
        ->name('api.telefono.cuentas');

    Route::get('telefono/{numero}/numeros-whatsapp', [UserDataController::class, 'getNumerosWhatsAppByPhone'])
        ->name('api.telefono.numeros-whatsapp');

    // Versión alternativa con query string
    Route::get('telefono/data', [UserDataController::class, 'getUserDataByPhoneQuery'])
        ->name('api.telefono.data.query');

    Route::get('telefono/categorias', [UserDataController::class, 'getCategoriasByPhoneQuery'])
        ->name('api.telefono.categorias.query');

    Route::get('telefono/cuentas', [UserDataController::class, 'getCuentasByPhoneQuery'])
        ->name('api.telefono.cuentas.query');

    Route::get('telefono/numeros-whatsapp', [UserDataController::class, 'getNumerosWhatsAppByPhoneQuery'])
        ->name('api.telefono.numeros-whatsapp.query');
});

// ==================== RUTA PARA ESTADO DE API ====================
Route::get('/status', function () {
    return response()->json([
        'status' => 'online',
        'timestamp' => now()->toDateTimeString(),
        'version' => '1.0',
        'services' => [
            'stripe' => config('services.stripe.key') ? 'configured' : 'not_configured',
            'suscripciones' => 'enabled',
        ]
    ]);
});
