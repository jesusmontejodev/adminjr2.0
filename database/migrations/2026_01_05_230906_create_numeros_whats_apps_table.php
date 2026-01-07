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
        Schema::create('numeros_whats_apps', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')
                ->constrained()
                ->onDelete('cascade');

            // Campos para números
            $table->string('numero_whatsapp', 20);      // Formato WhatsApp: 5219992055875, 15551234567
            $table->string('numero_internacional', 20); // Formato estándar: +5219992055875, +15551234567
            $table->string('codigo_pais', 5);           // +52, +1, +34
            $table->string('numero_local', 15);         // 19992055875, 5551234567
            $table->string('pais', 2);                  // MX, US, ES (código ISO 3166-1 alpha-2)

            // Otros campos
            $table->string('etiqueta')->nullable();
            $table->boolean('es_principal')->default(false);

            $table->timestamps();

            // Índices
            $table->unique(['user_id', 'numero_whatsapp']);
            $table->index('es_principal');
            $table->index('pais');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('numeros_whats_apps');
    }
};
