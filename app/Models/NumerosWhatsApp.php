<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class NumerosWhatsApp extends Model
{
    use HasFactory;

    protected $table = 'numeros_whats_apps';

    protected $fillable = [
        'user_id',
        'numero_whatsapp',      // Formato WhatsApp: 5219992055875, 15551234567
        'numero_internacional', // Formato estándar: +5219992055875, +15551234567
        'codigo_pais',          // +52, +1, +34
        'numero_local',         // 19992055875, 5551234567
        'pais',                 // MX, US, ES
        'etiqueta',
        'es_principal',
    ];

    protected $casts = [
        'es_principal' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Relación: Un número de WhatsApp pertenece a un usuario.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

}
