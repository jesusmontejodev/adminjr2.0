<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Documento extends Model
{
    protected $fillable = [
        'user_id',
        'nombre',
        'path',
        'tipo',
        'estado',
        'filas_detectadas',
        'filas_importadas',
        'resumen',
    ];

    protected $casts = [
        'resumen' => 'array',
    ];

    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
