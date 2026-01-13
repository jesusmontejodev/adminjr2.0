<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Cuenta extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_user',
        'nombre',
        'saldo_inicial',
        'saldo_actual',
        'descripcion',
    ];

    /**
     * Casts para los campos decimales
     * Usamos 'float' en lugar de 'decimal' para mayor compatibilidad
     */
    protected $casts = [
        'saldo_inicial' => 'float',
        'saldo_actual' => 'float',
    ];

    /**
     * Relación: Una cuenta pertenece a un usuario
     */
    public function usuario(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    /**
     * Relación: Una cuenta tiene muchas transacciones
     */
    public function transacciones(): HasMany
    {
        return $this->hasMany(Transaccion::class, 'cuenta_id'); // Cambiado: 'id_cuenta' → 'cuenta_id'
    }

    /**
     * Obtiene el ID de una cuenta dado su nombre.
     */
    public static function getIdByName(string $nombre, int $userId): ?int
    {
        return self::where('nombre', $nombre)
                ->where('id_user', $userId)
                ->value('id');
    }

    /**
     * Actualiza el saldo actual de la cuenta
     * Tipos explícitos para evitar el error
     */
    public function actualizarSaldo(float $monto): bool
    {
        // Convertir a float para asegurar el tipo
        $nuevoSaldo = (float) $this->saldo_actual + $monto;
        $this->saldo_actual = $nuevoSaldo;

        return $this->save();
    }

    /**
     * Método alternativo más seguro con verificación
     */
    public function incrementarSaldo(float $monto): bool
    {
        if ($this->saldo_actual === null) {
            $this->saldo_actual = 0;
        }

        $this->saldo_actual += $monto;
        return $this->save();
    }

    /**
     * Obtener saldo como float (getter personalizado)
     */
    public function getSaldoActualAttribute($value): float
    {
        return (float) ($value ?? 0);
    }

    public function getSaldoInicialAttribute($value): float
    {
        return (float) ($value ?? 0);
    }
}
