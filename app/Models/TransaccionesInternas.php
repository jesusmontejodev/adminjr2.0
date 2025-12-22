<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransaccionesInternas extends Model
{
    protected $table = 'transaccionesinternas';

    protected $fillable = [
        'cuenta_origen_id',
        'cuenta_destino_id',
        'monto',
        'descripcion',
    ];

    public function cuentaOrigen()
    {
        return $this->belongsTo(Cuenta::class, 'cuenta_origen_id');
    }

    public function cuentaDestino()
    {
        return $this->belongsTo(Cuenta::class, 'cuenta_destino_id');
    }
}
