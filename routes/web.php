<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\CuentaController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\TransaccionController;
use App\Http\Controllers\TransaccionInternaController;
use App\Http\Controllers\InfocomisionesController;
use App\Http\Controllers\CuentasporcobrarController;
use App\Http\Controllers\GraficasController;
use App\Http\Controllers\MensajesDeEntrenamientoController;
use App\Http\Controllers\NumerosWhatsAppController;

// ============= NUEVAS IMPORTACIONES PARA SUSCRIPCIÓN =============
use App\Http\Controllers\SuscripcionController; // Agrega esto

Route::get('/', function () {
    return view('welcome');
});

// Ruta de nosotros
Route::get('/nosotros', function () {
    return view('nosotros');
})->name('nosotros');

// ============= NUEVA RUTA PÚBLICA PARA PLANES =============
Route::get('/planes', [SuscripcionController::class, 'planes'])
    ->name('planes');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ============= GRUPO PRINCIPAL CON TUS RUTAS EXISTENTES + SUSCRIPCIÓN =============
Route::middleware(['auth', 'verified'])->group(function () {

    // ==================== NUEVAS RUTAS DE SUSCRIPCIÓN ====================
    Route::prefix('suscripcion')->group(function () {
        Route::post('/crear', [SuscripcionController::class, 'crear'])
            ->name('suscripcion.crear');

        Route::post('/cancelar', [SuscripcionController::class, 'cancelar'])
            ->name('suscripcion.cancelar');

        Route::post('/reanudar', [SuscripcionController::class, 'reanudar'])
            ->name('suscripcion.reanudar');

        Route::post('/actualizar-metodo-pago', [SuscripcionController::class, 'actualizarMetodoPago'])
            ->name('suscripcion.actualizar-metodo-pago');

        Route::get('/facturas', [SuscripcionController::class, 'facturas'])
            ->name('suscripcion.facturas');

        Route::get('/facturas/{id}/descargar', [SuscripcionController::class, 'descargarFactura'])
            ->name('suscripcion.descargar-factura');

        Route::get('/portal-facturacion', [SuscripcionController::class, 'portalFacturacion'])
            ->name('suscripcion.portal-facturacion');
    });

    // ==================== TUS RUTAS EXISTENTES (MANTENER) ====================
    Route::resource('cuentas', CuentaController::class);
    Route::resource('categorias', CategoriaController::class);
    Route::resource('transaccionesinternas', TransaccionInternaController::class);
    Route::resource('transacciones', TransaccionController::class)
        ->parameters(['transacciones' => 'transaccion']);
    Route::resource('mensajes', MensajesDeEntrenamientoController::class);

    // Rutas para CRUD de comisiones
    Route::resource('comisiones', InfocomisionesController::class);

    // Mostrar formulario para concretar
    Route::get('comisiones/{id}/concretar', [InfocomisionesController::class, 'concretarView'])
        ->name('comisiones.concretar.view');

    // Guardar la transacción de la comisión
    Route::post('comisiones/{id}/concretar', [InfocomisionesController::class, 'concretar'])
        ->name('comisiones.concretar');

    Route::resource('analistajr', GraficasController::class);

    // ============= RUTAS PARA NÚMEROS DE WHATSAPP =============
    Route::resource('numeros-whatsapp', NumerosWhatsAppController::class)
        ->names([
            'index' => 'numeros-whatsapp.index',
            'create' => 'numeros-whatsapp.create',
            'store' => 'numeros-whatsapp.store',
            'show' => 'numeros-whatsapp.show',
            'edit' => 'numeros-whatsapp.edit',
            'update' => 'numeros-whatsapp.update',
            'destroy' => 'numeros-whatsapp.destroy',
        ]);

    // Ruta adicional para marcar como principal
    Route::post('numeros-whatsapp/{numerosWhatsApp}/marcar-principal',
        [NumerosWhatsAppController::class, 'marcarPrincipal'])
        ->name('numeros-whatsapp.marcar-principal');
});

require __DIR__.'/auth.php';
