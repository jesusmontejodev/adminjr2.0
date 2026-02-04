<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Laravel\Sanctum\HasApiTokens;
use Laravel\Cashier\Billable;
use Carbon\Carbon;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable, HasApiTokens, Billable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'stripe_id',
        'pm_type',
        'pm_last_four',
        'trial_ends_at',
        'phone_number',    // NUEVO: Agregar este campo
        'country_code',    // NUEVO: Agregar este campo
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
        'phone_number',    // OPCIONAL: Oculta el número de teléfono en respuestas JSON si lo prefieres
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
            'trial_ends_at' => 'datetime',
            'phone_number' => 'string',    // NUEVO: Cast para phone_number
            'country_code' => 'string',    // NUEVO: Cast para country_code
        ];
    }

    // =============== MÉTODOS NUEVOS PARA TELÉFONO ===============

    /**
     * Get the full phone number with country code.
     *
     * @return string|null
     */
    public function getFullPhoneNumberAttribute(): ?string
    {
        if ($this->phone_number && $this->country_code) {
            return $this->country_code . $this->phone_number;
        }

        return null;
    }

    /**
     * Check if phone number is complete (both fields present or both absent).
     *
     * @return bool
     */
    public function hasCompletePhone(): bool
    {
        // Both must be present or both absent for consistency
        return ($this->phone_number && $this->country_code) ||
               (!$this->phone_number && !$this->country_code);
    }

    /**
     * Validate phone number format.
     *
     * @return bool
     */
    public function hasValidPhoneFormat(): bool
    {
        if (!$this->phone_number || !$this->country_code) {
            return false;
        }

        // Basic validation: country code should start with +
        if (!str_starts_with($this->country_code, '+')) {
            return false;
        }

        // Basic phone number validation (digits only, optional spaces, hyphens, parentheses)
        $cleanPhone = preg_replace('/[^0-9]/', '', $this->phone_number);

        return strlen($cleanPhone) >= 7 && strlen($cleanPhone) <= 15;
    }

    /**
     * Get the formatted phone number for display.
     *
     * @return string|null
     */
    public function getFormattedPhoneAttribute(): ?string
    {
        if (!$this->full_phone_number) {
            return null;
        }

        return "{$this->country_code} {$this->phone_number}";
    }

    // ==================== MÉTODOS DE SUSCRIPCIÓN ACTUALIZADOS ====================

    /**
     * Verificar si el usuario tiene una suscripción activa
     * VERSIÓN SEGURA para Cashier v16.2.0
     */
    public function tieneSuscripcionActiva(): bool
    {
        try {
            // Primero verificar que tenga suscripción
            if (!$this->subscribed('default')) {
                return false;
            }

            $subscription = $this->subscription('default');

            // Método 1: Usar active() que es más confiable
            if (method_exists($subscription, 'active')) {
                return $subscription->active();
            }

            // Método 2: Verificar manualmente usando ends_at
            if ($subscription->ends_at === null) {
                return true; // No tiene fecha de fin = activa
            }

            return $subscription->ends_at->isFuture(); // Si ends_at es futuro, está activa

        } catch (\Exception $e) {
            \Log::error('Error en tieneSuscripcionActiva: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Verificar si la suscripción está cancelada
     * VERSIÓN SEGURA para Cashier v16.2.0
     */
    public function suscripcionCancelada(): bool
    {
        try {
            if (!$this->subscribed('default')) {
                return false;
            }

            $subscription = $this->subscription('default');

            // Método 1: Usar cancelled() si existe
            if (method_exists($subscription, 'cancelled')) {
                return $subscription->cancelled();
            }

            // Método 2: Verificar manualmente
            return $subscription->ends_at && $subscription->ends_at->isPast();

        } catch (\Exception $e) {
            \Log::error('Error en suscripcionCancelada: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Verificar si el usuario está en período de gracia
     */
    public function enPeriodoDeGracia(): bool
    {
        try {
            if (!$this->subscribed('default')) {
                return false;
            }

            $subscription = $this->subscription('default');

            if (method_exists($subscription, 'onGracePeriod')) {
                return $subscription->onGracePeriod();
            }

            // Lógica alternativa: si tiene ends_at en el futuro pero no está activa
            return $subscription->ends_at &&
                   $subscription->ends_at->isFuture() &&
                   !$this->tieneSuscripcionActiva();

        } catch (\Exception $e) {
            \Log::error('Error en enPeriodoDeGracia: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Verificar si el usuario tiene acceso premium
     */
    public function tieneAccesoPremium(): bool
    {
        return $this->tieneSuscripcionActiva() ||
               $this->onTrial() ||
               $this->enPeriodoDeGracia();
    }

    /**
     * Obtener el ID del plan actual del usuario
     */
    public function getPlanActualId(): ?string
    {
        try {
            $subscription = $this->subscription('default');

            if (!$subscription) {
                return null;
            }

            // En Cashier v16, stripe_price contiene el ID del precio
            return $subscription->stripe_price;

        } catch (\Exception $e) {
            \Log::error('Error en getPlanActualId: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Obtener el nombre del plan actual
     */
    public function getPlanActualNombre(): ?string
    {
        try {
            $planId = $this->getPlanActualId();

            if (!$planId) {
                return null;
            }

            // Mapeo de price_id a nombres
            $precioBasico = env('STRIPE_PRICE_BASICO');

            if ($planId === $precioBasico) {
                return 'Básico';
            }

            // Agregar otros planes aquí cuando los tengas
            return 'Personalizado';

        } catch (\Exception $e) {
            \Log::error('Error en getPlanActualNombre: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Obtener información de suscripción (VERSIÓN SEGURA)
     */
    public function getInfoSuscripcion(): array
    {
        try {
            $subscription = $this->subscription('default');

            if (!$subscription) {
                return [
                    'estado' => 'sin_suscripcion',
                    'plan_nombre' => 'Gratis',
                    'plan_id' => null,
                    'activa' => false,
                    'cancelada' => false,
                    'en_grace_period' => false,
                    'en_trial' => false,
                    'vencimiento' => null,
                    'renovacion_automatica' => false,
                    'fecha_proximo_pago' => null,
                    'dias_restantes_trial' => null,
                ];
            }

            // Determinar estado usando métodos seguros
            $estado = 'activa';
            $cancelada = false;
            $enGracePeriod = false;

            // Usar métodos condicionales para evitar errores
            if (method_exists($subscription, 'cancelled') && $subscription->cancelled()) {
                $estado = 'cancelada';
                $cancelada = true;
            }

            if (method_exists($subscription, 'onGracePeriod') && $subscription->onGracePeriod()) {
                $estado = 'en_grace_period';
                $enGracePeriod = true;
            }

            // Intentar obtener datos de Stripe
            $fechaProximoPago = null;
            try {
                $stripeSubscription = $subscription->asStripeSubscription();
                if ($stripeSubscription?->current_period_end) {
                    $fechaProximoPago = Carbon::createFromTimestamp($stripeSubscription->current_period_end)
                        ->format('d/m/Y');
                }
            } catch (\Exception $e) {
                // Ignorar si no se puede obtener de Stripe
            }

            return [
                'estado' => $estado,
                'plan_nombre' => $this->getPlanActualNombre(),
                'plan_id' => $this->getPlanActualId(),
                'activa' => $this->tieneSuscripcionActiva(),
                'cancelada' => $cancelada,
                'en_grace_period' => $enGracePeriod,
                'en_trial' => $this->onTrial(),
                'vencimiento' => $subscription->ends_at?->format('d/m/Y'),
                'renovacion_automatica' => !$cancelada,
                'fecha_proximo_pago' => $fechaProximoPago,
                'dias_restantes_trial' => $this->onTrial() ?
                    max(0, now()->diffInDays($this->trial_ends_at, false)) : null,
            ];

        } catch (\Exception $e) {
            \Log::error('Error en getInfoSuscripcion: ' . $e->getMessage());

            return [
                'estado' => 'error',
                'plan_nombre' => 'Error',
                'plan_id' => null,
                'activa' => false,
                'cancelada' => false,
                'en_grace_period' => false,
                'en_trial' => false,
                'vencimiento' => null,
                'renovacion_automatica' => false,
                'fecha_proximo_pago' => null,
                'dias_restantes_trial' => null,
            ];
        }
    }

    /**
     * Obtener límite de números de WhatsApp
     */
    public function getLimiteWhatsApp(): int
    {
        if (!$this->tieneAccesoPremium()) {
            return 0;
        }

        $planId = $this->getPlanActualId();
        $precioBasico = env('STRIPE_PRICE_BASICO');

        if ($planId === $precioBasico) {
            return 3;
        }

        return 1;
    }

    /**
     * Obtener límite de cuentas
     */
    public function getLimiteCuentas(): int
    {
        if (!$this->tieneAccesoPremium()) {
            return 0;
        }

        $planId = $this->getPlanActualId();
        $precioBasico = env('STRIPE_PRICE_BASICO');

        if ($planId === $precioBasico) {
            return 5;
        }

        return 1;
    }

    /**
     * Verificar si puede agregar WhatsApp
     */
    public function puedeAgregarWhatsApp(): bool
    {
        if (!$this->tieneAccesoPremium()) {
            return false;
        }

        $limite = $this->getLimiteWhatsApp();
        if ($limite <= 0) return false;

        $actual = $this->numerosWhatsApp()->count();
        return $actual < $limite;
    }

    /**
     * Verificar si puede agregar cuentas
     */
    public function puedeAgregarCuenta(): bool
    {
        if (!$this->tieneAccesoPremium()) {
            return false;
        }

        $limite = $this->getLimiteCuentas();
        if ($limite <= 0) return false;

        $actual = $this->cuentas()->count();
        return $actual < $limite;
    }

    // ==================== RELACIONES (Mantener igual) ====================

    public function cuentas()
    {
        return $this->hasMany(Cuenta::class, 'id_user');
    }

    public function categorias()
    {
        return $this->hasMany(Categoria::class, 'id_user');
    }

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

    public function numerosWhatsApp()
    {
        return $this->hasMany(NumerosWhatsApp::class, 'user_id');
    }

    public function numeroWhatsAppPrincipal()
    {
        return $this->hasOne(NumerosWhatsApp::class, 'user_id')
                    ->where('es_principal', true);
    }

    // ==================== ATTRIBUTES ====================

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

    public function getPuedeAgregarWhatsAppAttribute(): bool
    {
        return $this->puedeAgregarWhatsApp();
    }

    public function getPuedeAgregarCuentasAttribute(): bool
    {
        return $this->puedeAgregarCuenta();
    }

    /**
     * Verificar si el usuario tiene número de teléfono completo
     *
     * @return bool
     */
    public function getTieneTelefonoAttribute(): bool
    {
        return !empty($this->phone_number) && !empty($this->country_code);
    }

    /**
     * Obtener el número de teléfono enmascarado para mostrar
     * Útil para mostrar en interfaces sin exponer el número completo
     *
     * @return string|null
     */
    public function getTelefonoEnmascaradoAttribute(): ?string
    {
        if (!$this->phone_number || !$this->country_code) {
            return null;
        }

        // Enmascarar parte del número: +52 55****8910
        $visibleDigits = 4;
        $maskedNumber = substr($this->phone_number, 0, 2) .
                    str_repeat('*', strlen($this->phone_number) - $visibleDigits - 2) .
                    substr($this->phone_number, -$visibleDigits);

        return $this->country_code . ' ' . $maskedNumber;
    }
}
