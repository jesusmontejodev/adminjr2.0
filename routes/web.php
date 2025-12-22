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



Route::get('/', function () {
    return view('welcome');
    //ProfileController poner el controler GraficaController
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});




Route::middleware(['auth', 'verified'])->group(function () {
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

});


require __DIR__.'/auth.php';

