<?php
use Illuminate\Http\Request;
use App\Http\Controllers\Api\MensajesDeEntrenamientoApiController;
use App\Http\Controllers\Api\TransaccionesInternasController;
use App\Http\Controllers\Api\TransaccionController;
use Illuminate\Support\Facades\Route;

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

// Nuevas rutas específicas para TransaccionController
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
