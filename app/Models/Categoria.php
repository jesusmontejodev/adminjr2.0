<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Categoria extends Model
{
    use HasFactory;

    /**
     * Campos que se pueden asignar masivamente
     */
    protected $fillable = [
        'id_user',
        'nombre',
        'descripcion',
    ];

    /**
     * Relación: Una categoría pertenece a un usuario
     */
    public function usuario(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    /**
     * Relación: Una categoría tiene muchas transacciones
     */
    public function transacciones(): HasMany
    {
        return $this->hasMany(Transaccion::class, 'id_categoria');
    }

    /**
     * Obtiene el ID de la categoría dado su nombre.
     * Ahora incluye el usuario para evitar ambigüedades
     */
    public static function getIdByName(string $nombre, int $userId): ?int
    {
        return self::where('nombre', $nombre)
                ->where('id_user', $userId)
                ->value('id');
    }

    /**
     * Scope para filtrar categorías por usuario
     */
    public function scopePorUsuario($query, int $userId)
    {
        return $query->where('id_user', $userId);
    }

    /**
     * Scope para buscar categorías por nombre (búsqueda parcial)
     */
    public function scopeBuscarPorNombre($query, string $nombre)
    {
        return $query->where('nombre', 'like', "%{$nombre}%");
    }

    /**
     * Obtiene categorías con transacciones en un período específico
     */
    public function scopeConTransaccionesEnPeriodo($query, $fechaInicio, $fechaFin)
    {
        return $query->whereHas('transacciones', function ($q) use ($fechaInicio, $fechaFin) {
            $q->whereBetween('fecha', [$fechaInicio, $fechaFin]);
        });
    }

    /**
     * Obtiene el total de transacciones por categoría
     */
    public function getTotalTransaccionesAttribute(): int
    {
        return $this->transacciones()->count();
    }

    /**
     * Valida si la categoría puede ser eliminada
     * (si no tiene transacciones asociadas)
     */
    public function puedeEliminarse(): bool
    {
        return $this->transacciones()->count() === 0;
    }

    /**
     * Obtiene categorías populares (con más transacciones)
     */
    public static function populares(int $userId, int $limite = 5)
    {
        return self::where('id_user', $userId)
                ->withCount('transacciones')
                ->orderBy('transacciones_count', 'desc')
                ->limit($limite)
                ->get();
    }
}
