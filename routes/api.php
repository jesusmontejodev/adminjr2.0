<?php
use Illuminate\Http\Request;
use App\Http\Controllers\Api\MensajesDeEntrenamientoApiController;
use App\Http\Controllers\Api\TransaccionesInternasController;
use App\Http\Controllers\Api\TransaccionController;
use App\Http\Controllers\Api\UserDataController;
use Illuminate\Support\Facades\Route;

// Tus rutas existentes
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

// ============= NUEVAS RUTAS PARA BUSCAR POR TELÉFONO =============

// Buscar datos completos por número de teléfono
Route::get('telefono/{numero}/data', [UserDataController::class, 'getUserDataByPhone'])
    ->name('api.telefono.data');

// Buscar datos específicos por número de teléfono
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
