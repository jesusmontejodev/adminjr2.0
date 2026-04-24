<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Agregar columnas solo si no existen
        if (!Schema::hasColumn('users', 'phone_number') || !Schema::hasColumn('users', 'country_code')) {

            Schema::table('users', function (Blueprint $table) {

                if (!Schema::hasColumn('users', 'phone_number')) {
                    $table->string('phone_number', 20)->nullable()->after('email');
                }

                if (!Schema::hasColumn('users', 'country_code')) {
                    $table->string('country_code', 5)->nullable()->after('phone_number');
                }

            });
        }

        // Crear índice solo si no existe
        try {
            Schema::table('users', function (Blueprint $table) {
                $table->index(['country_code', 'phone_number'], 'users_phone_index');
            });
        } catch (\Exception $e) {
            // El índice ya existe, no hacemos nada
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Eliminar índice si existe
        try {
            Schema::table('users', function (Blueprint $table) {
                $table->dropIndex('users_phone_index');
            });
        } catch (\Exception $e) {
            // No existe, ignoramos
        }

        // Eliminar columnas solo si existen
        Schema::table('users', function (Blueprint $table) {

            if (Schema::hasColumn('users', 'phone_number')) {
                $table->dropColumn('phone_number');
            }

            if (Schema::hasColumn('users', 'country_code')) {
                $table->dropColumn('country_code');
            }

        });
    }
};