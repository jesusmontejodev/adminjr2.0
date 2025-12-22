<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cuenta;
use App\Models\TransaccionesInternas;

use Illuminate\Support\Facades\DB;

class TransaccionInternaController extends Controller
{
    public function index()
    {
        // Con modelo y relaciones
        $transaccionesinternas = TransaccionesInternas::with(['cuentaOrigen', 'cuentaDestino'])
            ->latest()
            ->get();

        return view("transaccionesinternas.index", compact('transaccionesinternas'));
    }

    public function create()
    {
        $cuentas = Cuenta::all();
        return view("transaccionesinternas.create", compact('cuentas'));
    }
    public function edit($id)
    {
        $transaccion = TransaccionesInternas::findOrFail($id);
        $cuentas = Cuenta::all();

        return view('transaccionesinternas.edit', compact('transaccion', 'cuentas'));
    }
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
            return back()
                ->withErrors(['monto' => 'Saldo insuficiente en la cuenta de origen.'])
                ->withInput();
        }

        DB::beginTransaction();
        try {
            // Restar monto de la cuenta de origen
            $cuentaOrigen->saldo_actual -= $data['monto'];
            $cuentaOrigen->save();

            // Sumar monto a la cuenta de destino
            $cuentaDestino->saldo_actual += $data['monto'];
            $cuentaDestino->save();

            // Registrar en la tabla transaccionesinternas
            \App\Models\TransaccionesInternas::create([
                'cuenta_origen_id' => $data['cuenta_origen_id'],
                'cuenta_destino_id' => $data['cuenta_destino_id'],
                'monto'            => $data['monto'],
                'descripcion'      => $data['descripcion'],
                'fecha'            => now(), // o $request->input('fecha') si lo quieres manual
            ]);

            DB::commit();

            return redirect()
                ->route('transaccionesinternas.index')
                ->with('success', 'Transacción realizada con éxito.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Ocurrió un error en la transacción.']);
        }
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'cuenta_origen_id' => 'required|exists:cuentas,id|different:cuenta_destino_id',
            'cuenta_destino_id' => 'required|exists:cuentas,id|different:cuenta_origen_id',
            'monto' => 'required|numeric|min:0.01',
            'descripcion' => 'nullable|string',
        ]);

        $transaccion = TransaccionesInternas::findOrFail($id);

        DB::beginTransaction();
        try {
            // Revertir saldos originales
            $oldOrigen = Cuenta::findOrFail($transaccion->cuenta_origen_id);
            $oldDestino = Cuenta::findOrFail($transaccion->cuenta_destino_id);

            $oldOrigen->saldo_actual += $transaccion->monto; // devolver saldo al origen
            $oldDestino->saldo_actual -= $transaccion->monto; // quitar saldo al destino
            $oldOrigen->save();
            $oldDestino->save();

            // Nuevos valores
            $cuentaOrigen = Cuenta::findOrFail($data['cuenta_origen_id']);
            $cuentaDestino = Cuenta::findOrFail($data['cuenta_destino_id']);

            if ($cuentaOrigen->saldo_actual < $data['monto']) {
                DB::rollBack();
                return back()->withErrors(['monto' => 'Saldo insuficiente en la nueva cuenta de origen.']);
            }

            $cuentaOrigen->saldo_actual -= $data['monto'];
            $cuentaOrigen->save();

            $cuentaDestino->saldo_actual += $data['monto'];
            $cuentaDestino->save();

            // Actualizar transacción
            $transaccion->update([
                'cuenta_origen_id' => $data['cuenta_origen_id'],
                'cuenta_destino_id' => $data['cuenta_destino_id'],
                'monto' => $data['monto'],
                'descripcion' => $data['descripcion'],
                'fecha' => now(),
            ]);

            DB::commit();

            return redirect()
                ->route('transaccionesinternas.index')
                ->with('success', 'Transacción actualizada con éxito.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Ocurrió un error al actualizar la transacción.']);
        }
    }

    public function destroy($id)
    {
        $transaccion = TransaccionesInternas::findOrFail($id);

        DB::beginTransaction();
        try {
            // Revertir saldos
            $cuentaOrigen = Cuenta::findOrFail($transaccion->cuenta_origen_id);
            $cuentaDestino = Cuenta::findOrFail($transaccion->cuenta_destino_id);

            $cuentaOrigen->saldo_actual += $transaccion->monto;
            $cuentaDestino->saldo_actual -= $transaccion->monto;

            $cuentaOrigen->save();
            $cuentaDestino->save();

            // Eliminar transacción
            $transaccion->delete();

            DB::commit();

            return redirect()
                ->route('transaccionesinternas.index')
                ->with('success', 'Transacción eliminada con éxito.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Ocurrió un error al eliminar la transacción.']);
        }
    }

}
