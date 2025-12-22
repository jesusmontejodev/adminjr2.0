<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('transaccionesinternas', function (Blueprint $table) {
            $table->id();

            // Relaciones con cuentas
            $table->unsignedBigInteger('cuenta_origen_id');
            $table->unsignedBigInteger('cuenta_destino_id');

            // Datos de la transacción
            $table->decimal('monto', 15, 2);
            $table->string('descripcion')->nullable();
            $table->dateTime('fecha')->default(now());

            $table->timestamps();

            // Llaves foráneas
            $table->foreign('cuenta_origen_id')
                ->references('id')->on('cuentas')
                ->onDelete('cascade'); // si se borra la cuenta, se borran las transacciones

            $table->foreign('cuenta_destino_id')
                ->references('id')->on('cuentas')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaccionesinternas');
    }
};
