<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CuentaController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\TransaccionController;
use App\Http\Controllers\TransaccionInternaController;
use App\Http\Controllers\InfocomisionesController;
use App\Http\Controllers\GraficasController;
use App\Http\Controllers\MensajesDeEntrenamientoController;
use App\Http\Controllers\NumerosWhatsAppController;
use App\Http\Controllers\SuscripcionController;
use App\Http\Controllers\StripeWebhookController;





Route::post('/stripe/webhook', [StripeWebhookController::class, 'handleWebhook'])
    ->name('cashier.webhook');

// ============= RUTAS PÚBLICAS =============
Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/nosotros', function () {
    return view('nosotros');
})->name('nosotros');

//ruta de aviso de privacidad
Route::get('/privacidad', function () {
    return view('privacidad');
})->name('aviso-de-privacidad');


// ============= RUTAS DE SUSCRIPCIÓN PÚBLICAS =============
Route::get('/planes', [SuscripcionController::class, 'planes'])->name('planes');
Route::get('/suscripcion/info', [SuscripcionController::class, 'infoSuscripcion'])->name('suscripcion.info');


Route::get('/terminos-y-condiciones', function () {
    return view('terminos');
})->name('terminos');

// ============= RUTAS QUE REQUIEREN AUTENTICACIÓN =============
Route::middleware(['auth', 'verified'])->group(function () {

    // Dashboard
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Perfil
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // ==================== RUTAS DE SUSCRIPCIÓN ====================
    Route::prefix('suscripcion')->name('suscripcion.')->group(function () {
        Route::post('/crear', [SuscripcionController::class, 'crear'])->name('crear');
        Route::post('/suscribirse-basico', [SuscripcionController::class, 'suscribirseBasico'])->name('suscribirse-basico');
        Route::post('/cancelar', [SuscripcionController::class, 'cancelar'])->name('cancelar');
        Route::post('/reanudar', [SuscripcionController::class, 'reanudar'])->name('reanudar');
        Route::post('/actualizar-metodo-pago', [SuscripcionController::class, 'actualizarMetodoPago'])->name('actualizar-metodo-pago');
        Route::get('/facturas', [SuscripcionController::class, 'facturas'])->name('facturas');
        Route::get('/facturas/{id}/descargar', [SuscripcionController::class, 'descargarFactura'])->name('descargar-factura');
        Route::get('/portal-facturacion', [SuscripcionController::class, 'portalFacturacion'])->name('portal-facturacion');

        // Admin only
        Route::post('/crear-manual', [SuscripcionController::class, 'crearManual'])
            ->middleware('admin')
            ->name('crear-manual');
    });
});

// ============= RUTAS QUE REQUIEREN SUSCRIPCIÓN ACTIVA =============
Route::middleware(['auth', 'verified', 'verificar.suscripcion'])->group(function () {

    // ==================== FUNCIONALIDADES PREMIUM ====================
    Route::resource('cuentas', CuentaController::class);
    Route::resource('categorias', CategoriaController::class);
    Route::resource('transaccionesinternas', TransaccionInternaController::class);
    Route::resource('transacciones', TransaccionController::class)
        ->parameters(['transacciones' => 'transaccion']);
    Route::resource('mensajes', MensajesDeEntrenamientoController::class);
    Route::resource('comisiones', InfocomisionesController::class);
    Route::resource('analistajr', GraficasController::class);

    // Ruta especial para comisiones
    Route::get('comisiones/{id}/concretar', [InfocomisionesController::class, 'concretarView'])
        ->name('comisiones.concretar.view');
    Route::post('comisiones/{id}/concretar', [InfocomisionesController::class, 'concretar'])
        ->name('comisiones.concretar');

    // ============= NÚMEROS DE WHATSAPP =============
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

    Route::post('numeros-whatsapp/{numerosWhatsApp}/marcar-principal',
        [NumerosWhatsAppController::class, 'marcarPrincipal'])
        ->name('numeros-whatsapp.marcar-principal');
});

require __DIR__.'/auth.php';
