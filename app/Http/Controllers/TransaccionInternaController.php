<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cuenta;
use App\Models\TransaccionesInternas;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TransaccionInternaController extends Controller
{
    /**
     * Aplicar middleware de autenticación
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Obtener solo las cuentas del usuario autenticado
     */
    private function getUserCuentas()
    {
        return Cuenta::where('id_user', Auth::id())->get();
    }

    /**
     * Verificar que una cuenta pertenezca al usuario
     */
    private function authorizeCuenta($cuentaId)
    {
        $cuenta = Cuenta::find($cuentaId);
        if (!$cuenta || $cuenta->id_user !== Auth::id()) {
            abort(403, 'No tienes permiso para acceder a esta cuenta.');
        }
        return $cuenta;
    }

    /**
     * Verificar que una transacción interna pertenezca al usuario
     */
    private function authorizeTransaccionInterna($transaccion)
    {
        // Verificar que ambas cuentas pertenezcan al usuario
        $cuentaOrigen = $transaccion->cuentaOrigen;
        $cuentaDestino = $transaccion->cuentaDestino;

        if (!$cuentaOrigen || $cuentaOrigen->id_user !== Auth::id() ||
            !$cuentaDestino || $cuentaDestino->id_user !== Auth::id()) {
            abort(403, 'No tienes permiso para acceder a esta transacción.');
        }
    }

    /**
     * Mostrar todas las transacciones internas del usuario
     */
    public function index()
    {
        // Solo transacciones donde ambas cuentas pertenezcan al usuario
        $transaccionesinternas = TransaccionesInternas::with(['cuentaOrigen', 'cuentaDestino'])
            ->whereHas('cuentaOrigen', function($q) {
                $q->where('id_user', Auth::id());
            })
            ->whereHas('cuentaDestino', function($q) {
                $q->where('id_user', Auth::id());
            })
            ->latest()
            ->get();

        return view("transaccionesinternas.index", compact('transaccionesinternas'));
    }

    /**
     * Mostrar formulario para crear transacción interna
     */
    public function create()
    {
        $cuentas = $this->getUserCuentas();

        if ($cuentas->count() < 2) {
            return redirect()->route('cuentas.index')
                ->with('warning', 'Necesitas al menos dos cuentas para realizar transferencias internas.');
        }

        return view("transaccionesinternas.create", compact('cuentas'));
    }

    /**
     * Mostrar formulario para editar transacción interna
     */
    public function edit($id)
    {
        $transaccion = TransaccionesInternas::findOrFail($id);

        // Verificar autorización
        $this->authorizeTransaccionInterna($transaccion);

        $cuentas = $this->getUserCuentas();

        return view('transaccionesinternas.edit', compact('transaccion', 'cuentas'));
    }

    /**
     * Almacenar nueva transacción interna
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'cuenta_origen_id' => 'required|exists:cuentas,id|different:cuenta_destino_id',
            'cuenta_destino_id' => 'required|exists:cuentas,id|different:cuenta_origen_id',
            'monto' => 'required|numeric|min:0.01',
            'descripcion' => 'nullable|string',
            'fecha' => 'nullable|date',
        ]);

        // Verificar que ambas cuentas pertenezcan al usuario
        $this->authorizeCuenta($data['cuenta_origen_id']);
        $this->authorizeCuenta($data['cuenta_destino_id']);

        $cuentaOrigen = Cuenta::findOrFail($data['cuenta_origen_id']);
        $cuentaDestino = Cuenta::findOrFail($data['cuenta_destino_id']);

        // Verificar que el usuario sea dueño de ambas cuentas
        if ($cuentaOrigen->id_user !== Auth::id() || $cuentaDestino->id_user !== Auth::id()) {
            abort(403, 'No tienes permiso para realizar esta operación.');
        }

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
            TransaccionesInternas::create([
                'cuenta_origen_id' => $data['cuenta_origen_id'],
                'cuenta_destino_id' => $data['cuenta_destino_id'],
                'monto'            => $data['monto'],
                'descripcion'      => $data['descripcion'],
                'fecha'            => $data['fecha'] ?? now(),
            ]);

            DB::commit();

            return redirect()
                ->route('transaccionesinternas.index')
                ->with('success', 'Transacción interna realizada con éxito.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()
                ->withErrors(['error' => 'Ocurrió un error en la transacción: ' . $e->getMessage()])
                ->withInput();
        }
    }

    /**
     * Actualizar transacción interna existente
     */
    public function update(Request $request, $id)
    {
        $transaccion = TransaccionesInternas::findOrFail($id);

        // Verificar autorización de la transacción original
        $this->authorizeTransaccionInterna($transaccion);

        $data = $request->validate([
            'cuenta_origen_id' => 'required|exists:cuentas,id|different:cuenta_destino_id',
            'cuenta_destino_id' => 'required|exists:cuentas,id|different:cuenta_origen_id',
            'monto' => 'required|numeric|min:0.01',
            'descripcion' => 'nullable|string',
            'fecha' => 'nullable|date',
        ]);

        // Verificar que las nuevas cuentas pertenezcan al usuario
        $this->authorizeCuenta($data['cuenta_origen_id']);
        $this->authorizeCuenta($data['cuenta_destino_id']);

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
                'fecha' => $data['fecha'] ?? now(),
            ]);

            DB::commit();

            return redirect()
                ->route('transaccionesinternas.index')
                ->with('success', 'Transacción interna actualizada con éxito.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()
                ->withErrors(['error' => 'Ocurrió un error al actualizar la transacción: ' . $e->getMessage()])
                ->withInput();
        }
    }

    /**
     * Eliminar transacción interna
     */
    public function destroy($id)
    {
        $transaccion = TransaccionesInternas::findOrFail($id);

        // Verificar autorización
        $this->authorizeTransaccionInterna($transaccion);

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
                ->with('success', 'Transacción interna eliminada con éxito.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()
                ->withErrors(['error' => 'Ocurrió un error al eliminar la transacción: ' . $e->getMessage()]);
        }
    }
}
