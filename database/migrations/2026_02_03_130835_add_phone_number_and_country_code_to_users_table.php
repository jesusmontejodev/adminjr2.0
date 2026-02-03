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
        Schema::table('users', function (Blueprint $table) {
            $table->string('phone_number', 20)->nullable()->after('email');
            $table->string('country_code', 5)->nullable()->after('phone_number');

            // Índice para búsquedas eficientes (opcional)
            $table->index(['country_code', 'phone_number'], 'users_phone_index');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropIndex('users_phone_index');
            $table->dropColumn(['phone_number', 'country_code']);
        });
    }
};
