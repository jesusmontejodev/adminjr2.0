<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cuentasporcobrar extends Model
{
    // Nombre de la tabla (opcional porque Laravel lo deduciría bien en este caso)
    protected $table = 'cuentasporcobrar';

    // Campos que se pueden asignar masivamente con create()
    protected $fillable = [
        'nombre_clave',
        'descripcion',
        'monto',
        'fecha',
        'concretado',
    ];

    // Si usas created_at y updated_at (porque tienes $table->timestamps() en la migración)
    public $timestamps = true;
}
