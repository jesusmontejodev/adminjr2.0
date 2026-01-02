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
        Schema::create('cuentas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_user'); // Cambié a BigInteger para consistencia
            $table->string('nombre');
            $table->decimal('saldo_inicial', 12, 2)->default(0);
            $table->decimal('saldo_actual', 12, 2)->default(0);
            $table->text('descripcion')->nullable();
            $table->timestamps();

            // Añade estas mejoras:
            $table->foreign('id_user')
                ->references('id')
                ->on('users')
                ->onDelete('cascade'); // Añade clave foránea

            $table->unique(['id_user', 'nombre']); // Evita nombres duplicados por usuario
            $table->index('id_user'); // Mejora rendimiento de búsquedas
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cuentas');
    }
};
