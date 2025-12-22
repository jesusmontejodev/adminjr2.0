<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cuenta extends Model
{
    use HasFactory;

    /**
     * Campos que se pueden asignar masivamente
     */
    protected $fillable = [
        'nombre',
        'saldo_inicial',
        'saldo_actual',
        'descripcion',
    ];

    /**
     * Relación: Una cuenta tiene muchas transacciones
     */
    public function transacciones()
    {
        return $this->hasMany(Transaccion::class);
    }

    /**
     * Obtiene el ID de una cuenta dado su nombre.
     *
     * @param  string  $nombre
     * @return int|null
     */
    public static function getIdByName(string $nombre): ?int
    {
        return self::where('nombre', $nombre)->value('id');
    }
}
