<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaccion extends Model
{
    protected $table = 'transacciones';

    // Campos que se pueden asignar de manera masiva
    protected $fillable = [
        'cuenta_id',
        'categoria_id',
        'monto',
        'tipo',
        'descripcion',
        'fecha',
    ];

    // Conversiones automáticas de tipos
    protected $casts = [
        'fecha' => 'date:Y-m-d',
    ];

    // Relaciones
    public function cuenta()
    {
        return $this->belongsTo(Cuenta::class);
    }

    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }
}
