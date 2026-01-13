<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Laravel\Sanctum\HasApiTokens;
use Laravel\Cashier\Billable; // Añade Billable trait
use Carbon\Carbon; // Para manejar fechas de suscripción

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable, HasApiTokens, Billable; // Agregado Billable trait

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'stripe_id', // Añadido para Cashier
        'pm_type', // Añadido para Cashier
        'pm_last_four', // Añadido para Cashier
        'trial_ends_at', // Añadido para Cashier
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'trial_ends_at' => 'datetime', // Añadido para trial
        ];
    }

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();

        // Evento cuando se crea un usuario
        static::created(function ($user) {
            // Crear cliente de Stripe automáticamente (opcional)
            // $user->createAsStripeCustomer();
        });
    }

    // ==================== MÉTODOS DE SUSCRIPCIÓN ====================

    /**
     * Verificar si el usuario tiene una suscripción activa
     */
    public function tieneSuscripcionActiva(string $subscriptionName = 'default'): bool
    {
        return $this->subscribed($subscriptionName) &&
               !$this->subscription($subscriptionName)->cancelled();
    }

    /**
     * Verificar si el usuario está en período de gracia
     */
    public function enPeriodoDeGracia(string $subscriptionName = 'default'): bool
    {
        return $this->subscription($subscriptionName) &&
               $this->subscription($subscriptionName)->onGracePeriod();
    }

    /**
     * Obtener fecha de finalización de suscripción
     */
    public function getFechaFinSuscripcion(string $subscriptionName = 'default'): ?Carbon
    {
        if ($this->subscription($subscriptionName)) {
            return $this->subscription($subscriptionName)->ends_at;
        }

        return null;
    }

    /**
     * Verificar si el usuario tiene acceso premium
     * (Puedes personalizar según tu lógica de negocio)
     */
    public function tieneAccesoPremium(): bool
    {
        // Opción 1: Solo con suscripción activa
        return $this->tieneSuscripcionActiva();

        // Opción 2: Con suscripción activa o en trial
        // return $this->tieneSuscripcionActiva() || $this->onTrial();

        // Opción 3: Con suscripción activa, en trial o en período de gracia
        // return $this->tieneSuscripcionActiva() ||
        //        $this->onTrial() ||
        //        $this->enPeriodoDeGracia();
    }

    /**
     * Obtener el plan actual del usuario
     */
    public function getPlanActual(): ?string
    {
        if ($this->subscription('default')) {
            return $this->subscription('default')->stripe_price;
        }

        return null;
    }

    /**
     * Verificar si el usuario puede usar características premium
     */
    public function puedeUsarCaracteristica(string $caracteristica): bool
    {
        $plan = $this->getPlanActual();

        if (!$plan) {
            return false;
        }

        // Definir qué características tiene cada plan
        $permisosPorPlan = [
            'price_basico' => ['whatsapp_limit_3', 'accounts_limit_5'],
            'price_pro' => ['whatsapp_unlimited', 'accounts_unlimited', 'reportes_avanzados'],
            'price_empresa' => ['whatsapp_unlimited', 'accounts_unlimited', 'reportes_avanzados', 'soporte_prioritario'],
        ];

        return in_array($caracteristica, $permisosPorPlan[$plan] ?? []);
    }

    /**
     * Obtener límite de números de WhatsApp según plan
     */
    public function getLimiteWhatsApp(): int
    {
        $plan = $this->getPlanActual();

        $limites = [
            'price_basico' => 3,
            'price_pro' => 10,
            'price_empresa' => 50,
        ];

        return $limites[$plan] ?? 1; // Default: 1 número
    }

    /**
     * Obtener límite de cuentas según plan
     */
    public function getLimiteCuentas(): int
    {
        $plan = $this->getPlanActual();

        $limites = [
            'price_basico' => 5,
            'price_pro' => 20,
            'price_empresa' => 100,
        ];

        return $limites[$plan] ?? 3; // Default: 3 cuentas
    }

    /**
     * Verificar si el usuario puede agregar más números de WhatsApp
     */
    public function puedeAgregarWhatsApp(): bool
    {
        if (!$this->tieneAccesoPremium()) {
            return false;
        }

        $limite = $this->getLimiteWhatsApp();
        $actual = $this->numerosWhatsApp()->count();

        return $actual < $limite;
    }

    /**
     * Verificar si el usuario puede agregar más cuentas
     */
    public function puedeAgregarCuenta(): bool
    {
        if (!$this->tieneAccesoPremium()) {
            return false;
        }

        $limite = $this->getLimiteCuentas();
        $actual = $this->cuentas()->count();

        return $actual < $limite;
    }

    /**
     * Obtener información de la suscripción formateada
     */
    public function getInfoSuscripcion(): array
    {
        $subscription = $this->subscription('default');

        if (!$subscription) {
            return [
                'estado' => 'sin_suscripcion',
                'plan' => 'Gratis',
                'vencimiento' => null,
                'en_grace_period' => false,
            ];
        }

        $planId = $subscription->stripe_price;
        $planes = [
            'price_basico' => 'Básico',
            'price_pro' => 'Pro',
            'price_empresa' => 'Empresa',
        ];

        return [
            'estado' => $subscription->active() ? 'activa' : 'cancelada',
            'plan' => $planes[$planId] ?? $planId,
            'vencimiento' => $subscription->ends_at?->format('d/m/Y'),
            'en_grace_period' => $subscription->onGracePeriod(),
            'renovacion_automatica' => !$subscription->cancelled(),
            'fecha_proximo_pago' => $subscription->asStripeSubscription()?->current_period_end ?
                Carbon::createFromTimestamp($subscription->asStripeSubscription()->current_period_end)->format('d/m/Y') : null,
        ];
    }

    // ==================== RELACIONES EXISTENTES ====================

    /**
     * Relación: Un usuario tiene muchas cuentas
     */
    public function cuentas()
    {
        return $this->hasMany(Cuenta::class, 'id_user');
    }

    /**
     * Relación: Un usuario tiene muchas categorías
     */
    public function categorias()
    {
        return $this->hasMany(Categoria::class, 'id_user');
    }

    /**
     * Relación: Un usuario tiene muchas transacciones a través de cuentas
     */
    public function transacciones()
    {
        return $this->hasManyThrough(
            Transaccion::class,
            Cuenta::class,
            'id_user',
            'cuenta_id',
            'id',
            'id'
        );
    }

    /**
     * Relación: Un usuario tiene muchos números de WhatsApp
     */
    public function numerosWhatsApp()
    {
        return $this->hasMany(NumerosWhatsApp::class, 'user_id');
    }

    /**
     * Relación: Obtener el número principal de WhatsApp
     */
    public function numeroWhatsAppPrincipal()
    {
        return $this->hasOne(NumerosWhatsApp::class, 'user_id')
                    ->where('es_principal', true);
    }

    // ==================== SCOPES Y MÉTODOS EXISTENTES ====================

    /**
     * Scope: Usuarios que tienen al menos un número de WhatsApp
     */
    public function scopeConNumerosWhatsApp($query)
    {
        return $query->whereHas('numerosWhatsApp');
    }

    /**
     * Scope: Usuarios con suscripción activa
     */
    public function scopeConSuscripcionActiva($query)
    {
        return $query->whereHas('subscriptions', function ($q) {
            $q->where('stripe_status', 'active');
        });
    }

    /**
     * Scope: Usuarios en período de prueba
     */
    public function scopeEnPeriodoPrueba($query)
    {
        return $query->whereNotNull('trial_ends_at')
                    ->where('trial_ends_at', '>', now());
    }

    /**
     * Verificar si el usuario tiene números de WhatsApp
     */
    public function tieneNumerosWhatsApp(): bool
    {
        return $this->numerosWhatsApp()->exists();
    }

    /**
     * Obtener el número principal formateado
     */
    public function getNumeroPrincipalAttribute(): ?string
    {
        $principal = $this->numeroWhatsAppPrincipal()->first();
        return $principal ? $principal->numero_formateado : null;
    }

    /**
     * Attribute: Estado de suscripción formateado
     */
    public function getEstadoSuscripcionAttribute(): string
    {
        if ($this->onTrial()) {
            return 'En Período de Prueba';
        }

        if ($this->tieneSuscripcionActiva()) {
            return 'Activa';
        }

        if ($this->enPeriodoDeGracia()) {
            return 'Período de Gracia';
        }

        return 'Sin Suscripción';
    }

    /**
     * Attribute: Días restantes de trial
     */
    public function getDiasRestantesTrialAttribute(): ?int
    {
        if ($this->onTrial()) {
            return now()->diffInDays($this->trial_ends_at, false);
        }

        return null;
    }
}
