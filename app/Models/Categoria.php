<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'descripcion',
    ];

    /**
     * Relación: Una categoría tiene muchas transacciones
     */
    public function transacciones()
    {
        return $this->hasMany(Transaccion::class);
    }

    /**
     * Obtiene el ID de la categoría dado su nombre.
     *
     * @param  string  $nombre
     * @return int|null
     */
    public static function getIdByName(string $nombre): ?int
    {
        return self::where('nombre', $nombre)->value('id');
    }
}
