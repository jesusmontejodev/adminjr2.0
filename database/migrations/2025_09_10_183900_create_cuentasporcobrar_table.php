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
        Schema::create('cuentasporcobrar', function (Blueprint $table) {
            $table->id();
            $table->string('nombre_clave');
            $table->string('descripcion');
            $table->decimal('monto', 12, 2);
            $table->date('fecha');
            $table->boolean('concretado')->default(false); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cuentasporcobrar');
    }
};
