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
        Schema::create('categorias', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_user'); // Añadido
            $table->string('nombre');
            $table->text('descripcion')->nullable(); // Añadido
            $table->timestamps();

            // Clave foránea para users
            $table->foreign('id_user')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');

            // Índice para mejorar rendimiento
            $table->index('id_user');

            // Evitar categorías duplicadas por usuario
            $table->unique(['id_user', 'nombre']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categorias');
    }
};
