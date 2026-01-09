<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
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
        ];
    }

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

    /**
     * Scope: Usuarios que tienen al menos un número de WhatsApp
     */
    public function scopeConNumerosWhatsApp($query)
    {
        return $query->whereHas('numerosWhatsApp');
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
}
