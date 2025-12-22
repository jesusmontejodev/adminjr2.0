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
        Schema::create('mensajesdeentrenamiento', function (Blueprint $table) {
            $table->id();
            $table->text('mensaje');   // Agregado campo mensaje
            $table->string('categoria');
            $table->string('cuenta');  // Corregido cuetna -> cuenta
            $table->float('monto');
            $table->string('tipo');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mensajesdeentrenamiento');
    }
};
