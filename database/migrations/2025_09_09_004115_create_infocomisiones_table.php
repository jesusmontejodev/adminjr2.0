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
        Schema::create('infocomisiones', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string( 'lote' );
            $table->string('nombre_proyecto');
            $table->string('modelo');
            $table->string('cliente');
            $table->float('precio');
            $table->date('apartado');
            $table->date('enganche');
            $table->date('contrato');
            $table->string( 'observaciones' );
            $table->boolean('concretado')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('infocomisiones');
    }
};
