<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TransaccionesInternas;
use App\Models\Cuenta;
use Illuminate\Support\Facades\DB;

class TransaccionesInternasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $transacciones = TransaccionesInternas::with(['cuentaOrigen', 'cuentaDestino'])
            ->latest()
            ->get();

        return response()->json($transacciones, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'cuenta_origen_id' => 'required|exists:cuentas,id|different:cuenta_destino_id',
            'cuenta_destino_id' => 'required|exists:cuentas,id|different:cuenta_origen_id',
            'monto' => 'required|numeric|min:0.01',
            'descripcion' => 'nullable|string',
        ]);

        $cuentaOrigen = Cuenta::findOrFail($data['cuenta_origen_id']);
        $cuentaDestino = Cuenta::findOrFail($data['cuenta_destino_id']);

        if ($cuentaOrigen->saldo_actual < $data['monto']) {
            return response()->json(['error' => 'Saldo insuficiente en la cuenta de origen.'], 422);
        }

        DB::beginTransaction();
        try {
            $cuentaOrigen->saldo_actual -= $data['monto'];
            $cuentaOrigen->save();

            $cuentaDestino->saldo_actual += $data['monto'];
            $cuentaDestino->save();

            $transaccion = TransaccionesInternas::create([
                'cuenta_origen_id' => $data['cuenta_origen_id'],
                'cuenta_destino_id' => $data['cuenta_destino_id'],
                'monto'            => $data['monto'],
                'descripcion'      => $data['descripcion'],
                'fecha'            => now(),
            ]);

            DB::commit();

            return response()->json($transaccion->load(['cuentaOrigen', 'cuentaDestino']), 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Ocurrió un error al crear la transacción.'], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $transaccion = TransaccionesInternas::with(['cuentaOrigen', 'cuentaDestino'])
            ->findOrFail($id);

        return response()->json($transaccion, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $transaccion = TransaccionesInternas::findOrFail($id);

        $data = $request->validate([
            'cuenta_origen_id' => 'required|exists:cuentas,id|different:cuenta_destino_id',
            'cuenta_destino_id' => 'required|exists:cuentas,id|different:cuenta_origen_id',
            'monto' => 'required|numeric|min:0.01',
            'descripcion' => 'nullable|string',
        ]);

        DB::beginTransaction();
        try {
            // Revertir saldos antiguos
            $oldOrigen = Cuenta::findOrFail($transaccion->cuenta_origen_id);
            $oldDestino = Cuenta::findOrFail($transaccion->cuenta_destino_id);

            $oldOrigen->saldo_actual += $transaccion->monto;
            $oldDestino->saldo_actual -= $transaccion->monto;

            $oldOrigen->save();
            $oldDestino->save();

            // Aplicar nuevos saldos
            $newOrigen = Cuenta::findOrFail($data['cuenta_origen_id']);
            $newDestino = Cuenta::findOrFail($data['cuenta_destino_id']);

            if ($newOrigen->saldo_actual < $data['monto']) {
                DB::rollBack();
                return response()->json(['error' => 'Saldo insuficiente en la cuenta de origen.'], 422);
            }

            $newOrigen->saldo_actual -= $data['monto'];
            $newDestino->saldo_actual += $data['monto'];

            $newOrigen->save();
            $newDestino->save();

            $transaccion->update([
                'cuenta_origen_id' => $data['cuenta_origen_id'],
                'cuenta_destino_id' => $data['cuenta_destino_id'],
                'monto' => $data['monto'],
                'descripcion' => $data['descripcion'],
                'fecha' => now(),
            ]);

            DB::commit();

            return response()->json($transaccion->load(['cuentaOrigen', 'cuentaDestino']), 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Ocurrió un error al actualizar la transacción.'], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $transaccion = TransaccionesInternas::findOrFail($id);

        DB::beginTransaction();
        try {
            $origen = Cuenta::findOrFail($transaccion->cuenta_origen_id);
            $destino = Cuenta::findOrFail($transaccion->cuenta_destino_id);

            // Revertir saldos
            $origen->saldo_actual += $transaccion->monto;
            $destino->saldo_actual -= $transaccion->monto;

            $origen->save();
            $destino->save();

            $transaccion->delete();

            DB::commit();

            return response()->json(['message' => 'Transacción eliminada con éxito.'], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Ocurrió un error al eliminar la transacción.'], 500);
        }
    }
}
