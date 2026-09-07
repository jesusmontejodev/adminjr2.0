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
        Schema::create('documentos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('nombre');
            $table->string('path');
            $table->enum('tipo', ['exportacion', 'importacion']);
            $table->enum('estado', ['listo', 'pendiente_revision', 'importado', 'descartado', 'error'])->default('listo');
            $table->unsignedInteger('filas_detectadas')->nullable();
            $table->unsignedInteger('filas_importadas')->nullable();
            $table->json('resumen')->nullable();
            $table->timestamps();

            $table->index(['user_id', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('documentos');
    }
};
