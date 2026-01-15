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
use App\Http\Controllers\NumerosWhatsAppController; // ← Agrega esta línea

Route::get('/', function () {
    return view('welcome');
});

//ruta de nosotros
Route::get('/nosotros', function () {
    return view('nosotros');
})->name('nosotros');

//ruta de terminos y condiciones
Route::get('/terminos-y-condiciones', function () {
    return view('terminos');
})->name('terminos');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'verified'])->group(function () {
    // Tus rutas existentes
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

    // Guardar la transacción de la comisiónnumeros-whatsapp
    Route::post('comisiones/{id}/concretar', [InfocomisionesController::class, 'concretar'])
        ->name('comisiones.concretar');

    Route::resource('analistajr', GraficasController::class);

    // ============= NUEVAS RUTAS PARA NÚMEROS DE WHATSAPP =============
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

    // Ruta adicional para marcar como principal (sin política)
    Route::post('numeros-whatsapp/{numerosWhatsApp}/marcar-principal',
        [NumerosWhatsAppController::class, 'marcarPrincipal'])
        ->name('numeros-whatsapp.marcar-principal');
});

require __DIR__.'/auth.php';
