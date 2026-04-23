<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Chat extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'title',
        'model',
        'system_prompt',
    ];

    /**
     * Get the user that owns the chat.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the messages for the chat.
     */
    public function messages(): HasMany
    {
        return $this->hasMany(ChatMessage::class);
    }

    /**
     * Generate system prompt with user's financial data context
     */
    public function generateFinancialContext(): string
    {
        $user = $this->user;
        
        // Obtener datos de cuentas del usuario (usando la relación correcta: id_user)
        $cuentas = Cuenta::where('id_user', $user->id)->get();
        
        // Obtener todas las transacciones de las cuentas del usuario
        $cuentaIds = $cuentas->pluck('id')->toArray();
        $transactions = Transaccion::whereIn('cuenta_id', $cuentaIds)
            ->latest()
            ->limit(20)
            ->get();
        
        $totalBalance = $cuentas->sum('saldo_actual');
        $totalIncome = $transactions->where('tipo', 'ingreso')->sum('monto');
        $totalExpense = $transactions->where('tipo', 'gasto')->sum('monto');
        
        $context = "Eres un asesor financiero experto que analiza datos financieros del usuario.\n\n";
        $context .= "DATOS FINANCIEROS DEL USUARIO:\n";
        $context .= "- Saldo Total: \$" . number_format($totalBalance, 2) . "\n";
        $context .= "- Ingresos Totales (últimas transacciones): \$" . number_format($totalIncome, 2) . "\n";
        $context .= "- Gastos Totales (últimas transacciones): \$" . number_format($totalExpense, 2) . "\n";
        $context .= "\nCuentas del usuario:\n";
        
        foreach ($cuentas as $cuenta) {
            $context .= "- {$cuenta->nombre}: \$" . number_format($cuenta->saldo_actual, 2) . "\n";
        }
        
        $context .= "\nÚltimas Transacciones:\n";
        foreach ($transactions as $trans) {
            $fecha = $trans->fecha ? $trans->fecha->format('d/m/Y') : $trans->created_at->format('d/m/Y');
            $context .= "- {$fecha}: {$trans->descripcion} - \${$trans->monto}\n";
        }
        
        $context .= "\nProporcionas análisis, recomendaciones y respuestas basadas en estos datos financieros.";
        
        return $context;
    }
}
