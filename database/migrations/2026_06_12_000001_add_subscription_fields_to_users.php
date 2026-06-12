<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'estado_suscripcion')) {
                $table->string('estado_suscripcion')->nullable()->after('remember_token');
            }

            if (!Schema::hasColumn('users', 'subscription_id')) {
                $table->string('subscription_id')->nullable()->after('estado_suscripcion');
            }

            if (!Schema::hasColumn('users', 'ultimo_pago_at')) {
                $table->timestamp('ultimo_pago_at')->nullable()->after('subscription_id');
            }

            if (!Schema::hasColumn('users', 'access_until')) {
                $table->timestamp('access_until')->nullable()->after('ultimo_pago_at');
            }
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'access_until')) {
                $table->dropColumn('access_until');
            }

            if (Schema::hasColumn('users', 'ultimo_pago_at')) {
                $table->dropColumn('ultimo_pago_at');
            }

            if (Schema::hasColumn('users', 'subscription_id')) {
                $table->dropColumn('subscription_id');
            }

            if (Schema::hasColumn('users', 'estado_suscripcion')) {
                $table->dropColumn('estado_suscripcion');
            }
        });
    }
};
