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
        Schema::create('transacciones', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cuenta_id')->constrained('cuentas')->onDelete('cascade');
            $table->foreignId('categoria_id')->constrained('categorias')->onDelete('cascade');
            $table->decimal('monto', 12, 2);
            $table->enum('tipo', ['ingreso', 'egreso', 'inversion', 'costo']);
            $table->text('descripcion')->nullable();
            $table->date('fecha');
            $table->timestamps();

            // Índices para mejor performance
            $table->index('fecha');
            $table->index('tipo');
            $table->index(['cuenta_id', 'fecha']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transacciones');
    }
};
