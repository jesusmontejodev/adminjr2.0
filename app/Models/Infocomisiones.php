<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Infocomisiones extends Model
{
    use HasFactory;

    protected $table = 'infocomisiones';

    protected $fillable = [
        'nombre',
        'lote',
        'nombre_proyecto',
        'modelo',
        'cliente',
        'precio',
        'apartado',
        'enganche',
        'contrato',
        'observaciones',
    ];
}
