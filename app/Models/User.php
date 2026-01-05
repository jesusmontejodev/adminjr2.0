<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Laravel\Sanctum\HasApiTokens; // <-- Añade esta línea

class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasApiTokens; // <-- Añade HasApiTokens aquí

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
        // No es necesario ocultar los tokens aquí, Sanctum los maneja por separado
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
     * Opcional: Relación con cuentas del usuario
     */
    public function cuentas()
    {
        return $this->hasMany(Cuenta::class, 'id_user');
    }

    /**
     * Opcional: Relación con categorías del usuario
     */
    public function categorias()
    {
        return $this->hasMany(Categoria::class, 'id_user');
    }

    /**
     * Opcional: Relación con transacciones a través de cuentas
     */
    public function transacciones()
    {
        return $this->hasManyThrough(
            Transaccion::class,
            Cuenta::class,
            'id_user', // Foreign key on Cuenta table
            'cuenta_id', // Foreign key on Transaccion table
            'id', // Local key on User table
            'id' // Local key on Cuenta table
        );
    }
}
