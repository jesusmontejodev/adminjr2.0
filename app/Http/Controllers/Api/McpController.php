<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Transaccion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class McpController extends Controller
{
    /**
     * Info del usuario dueño del token y de los permisos del token actual.
     */
    public function whoami(Request $request)
    {
        $user = $request->user();
        $token = $user->currentAccessToken();

        return response()->json([
            'usuario' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
            ],
            'token' => [
                'name' => $token->name,
                'abilities' => $token->abilities,
                'expires_at' => $token->expires_at,
            ],
        ]);
    }

    /**
     * Cuentas del usuario dueño del token.
     */
    public function cuentas(Request $request)
    {
        return response()->json([
            'success' => true,
            'data' => $request->user()->cuentas()->get(),
        ]);
    }

    /**
     * Categorías del usuario dueño del token.
     */
    public function categorias(Request $request)
    {
        return response()->json([
            'success' => true,
            'data' => $request->user()->categorias()->get(),
        ]);
    }

    /**
     * Transacciones del usuario dueño del token, con filtros opcionales.
     */
    public function transacciones(Request $request)
    {
        $query = $request->user()->transacciones()->with(['cuenta', 'categoria']);

        if ($request->filled('cuenta_id')) {
            $query->where('transacciones.cuenta_id', $request->integer('cuenta_id'));
        }

        if ($request->filled('categoria_id')) {
            $query->where('transacciones.categoria_id', $request->integer('categoria_id'));
        }

        if ($request->filled('desde')) {
            $query->whereDate('transacciones.fecha', '>=', $request->date('desde'));
        }

        if ($request->filled('hasta')) {
            $query->whereDate('transacciones.fecha', '<=', $request->date('hasta'));
        }

        $transacciones = $query->orderByDesc('transacciones.fecha')
            ->limit(min((int) $request->input('limite', 100), 500))
            ->get();

        return response()->json([
            'success' => true,
            'data' => $transacciones,
        ]);
    }

    /**
     * Crea una transacción para el usuario dueño del token.
     * cuenta_id y categoria_id se validan como pertenecientes a ese usuario.
     */
    public function storeTransaccion(Request $request)
    {
        $user = $request->user();

        $validator = Validator::make($request->all(), [
            'cuenta_id' => 'required|integer',
            'categoria_id' => 'required|integer',
            'tipo' => 'required|string|in:ingreso,egreso,inversion,costo',
            'monto' => 'required|numeric|min:0.01',
            'descripcion' => 'nullable|string',
            'fecha' => 'nullable|date',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Datos inválidos',
                'errors' => $validator->errors(),
            ], 422);
        }

        $data = $validator->validated();

        $cuenta = $user->cuentas()->find($data['cuenta_id']);
        if (!$cuenta) {
            return response()->json([
                'success' => false,
                'message' => 'La cuenta indicada no existe o no te pertenece.',
            ], 404);
        }

        $categoria = $user->categorias()->find($data['categoria_id']);
        if (!$categoria) {
            return response()->json([
                'success' => false,
                'message' => 'La categoría indicada no existe o no te pertenece.',
            ], 404);
        }

        $monto = (float) $data['monto'];

        if ($data['tipo'] !== 'ingreso' && $cuenta->saldo_actual < $monto) {
            return response()->json([
                'success' => false,
                'message' => 'Saldo insuficiente en la cuenta.',
                'saldo_actual' => $cuenta->saldo_actual,
            ], 422);
        }

        $transaccion = Transaccion::create([
            'cuenta_id' => $cuenta->id,
            'categoria_id' => $categoria->id,
            'monto' => $monto,
            'tipo' => $data['tipo'],
            'descripcion' => $data['descripcion'] ?? null,
            'fecha' => $data['fecha'] ?? now(),
        ]);

        if ($data['tipo'] === 'ingreso') {
            $cuenta->saldo_actual += $monto;
        } else {
            $cuenta->saldo_actual -= $monto;
        }
        $cuenta->save();

        return response()->json([
            'success' => true,
            'data' => $transaccion->load(['cuenta', 'categoria']),
            'saldo_actualizado' => $cuenta->saldo_actual,
        ], 201);
    }
}
