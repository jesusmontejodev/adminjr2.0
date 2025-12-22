<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MensajesDeEntrenamiento extends Model
{
    protected $table = 'mensajesdeentrenamiento';

    protected $fillable = [
        'mensaje',
        'categoria',
        'cuenta',
        'monto',
        'tipo'
    ];

}
