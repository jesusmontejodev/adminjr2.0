<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cuenta;
use App\Models\Categoria;
use App\Models\Transaccion;
use Carbon\Carbon;

class TransaccionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $transacciones = Transaccion::with(['cuenta', 'categoria'])
            ->latest()
            ->get();

        return response()->json([
            'success' => true,
            'transacciones' => $transacciones
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            // Validación básica de datos
            $data = $request->validate([
                'cuenta'    => 'required|string',
                'categoria' => 'required|string',
                'tipo'      => 'required|string|in:ingreso,gasto,inversion',
                'monto'     => 'required|numeric|min:0.01',
                'descripcion'=> 'nullable|string',
            ]);

            // Verificar existencia de la cuenta
            $cuenta = Cuenta::where('nombre', $data['cuenta'])->first();
            if (!$cuenta) {
                return response()->json([
                    'success' => false,
                    'message' => "La cuenta '{$data['cuenta']}' no existe."
                ], 404);
            }

            // Verificar existencia de la categoría
            $categoria = Categoria::where('nombre', $data['categoria'])->first();
            if (!$categoria) {
                return response()->json([
                    'success' => false,
                    'message' => "La categoría '{$data['categoria']}' no existe."
                ], 404);
            }

            // Crear la transacción
            $transaccion = Transaccion::create([
                'cuenta_id'    => $cuenta->id,
                'categoria_id' => $categoria->id,
                'monto'        => $data['monto'],
                'descripcion'  => $data['descripcion'] ?? null,
                'fecha'        => Carbon::now(),
                'tipo'         => $data['tipo']
            ]);

            // Actualizar saldo de la cuenta
            if ($data['tipo'] === 'ingreso') {
                $cuenta->saldo_actual += $data['monto'];
            } else { // gasto o inversion
                $cuenta->saldo_actual -= $data['monto'];
            }
            $cuenta->save();

            return response()->json([
                'success' => true,
                'message' => 'Transacción registrada correctamente.',
                'transaccion' => $transaccion
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Ocurrió un error inesperado.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function show(string $id)
    {
        $transaccion = Transaccion::with(['cuenta', 'categoria'])->find($id);
        if (!$transaccion) {
            return response()->json(['success' => false, 'message' => 'Transacción no encontrada.'], 404);
        }
        return response()->json(['success' => true, 'transaccion' => $transaccion]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $transaccion = Transaccion::find($id);
        if (!$transaccion) {
            return response()->json(['success' => false, 'message' => 'Transacción no encontrada.'], 404);
        }

        $data = $request->validate([
            'tipo'        => 'sometimes|string|in:ingreso,gasto,inversion',
            'monto'       => 'sometimes|numeric|min:0.01',
            'descripcion' => 'nullable|string',
        ]);

        // Actualizar saldo de la cuenta si cambia el monto
        if (isset($data['monto'])) {
            $diferencia = $data['monto'] - $transaccion->monto;
            if ($transaccion->tipo === 'ingreso') {
                $transaccion->cuenta->saldo_actual += $diferencia;
            } else {
                $transaccion->cuenta->saldo_actual -= $diferencia;
            }
            $transaccion->cuenta->save();
        }

        $transaccion->update($data);

        return response()->json(['success' => true, 'message' => 'Transacción actualizada.', 'transaccion' => $transaccion]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $transaccion = Transaccion::find($id);
        if (!$transaccion) {
            return response()->json(['success' => false, 'message' => 'Transacción no encontrada.'], 404);
        }

        // Ajustar saldo antes de eliminar
        if ($transaccion->tipo === 'ingreso') {
            $transaccion->cuenta->saldo_actual -= $transaccion->monto;
        } else {
            $transaccion->cuenta->saldo_actual += $transaccion->monto;
        }
        $transaccion->cuenta->save();

        $transaccion->delete();

        return response()->json(['success' => true, 'message' => 'Transacción eliminada correctamente.']);
    }

    /**
     * Nueva función para obtener todas las cuentas
     */
    public function cuentas()
    {
        $cuentas = Cuenta::all();

        return response()->json([
            'success' => true,
            'cuentas' => $cuentas
        ]);
    }

    public function graficos()
    {
        // Obtener todas las cuentas
        $cuentas = Cuenta::all();

        // Obtener todas las transacciones con relaciones
        $transacciones = Transaccion::with(['cuenta', 'categoria'])->get();

        // Datos para gráficos de transacciones por categoría
        $transaccionesPorCategoria = Transaccion::with('categoria')
            ->selectRaw('categoria_id, COUNT(*) as total, SUM(monto) as monto_total')
            ->groupBy('categoria_id')
            ->get();

        // Datos para gráficos de transacciones por tipo
        $transaccionesPorTipo = Transaccion::selectRaw('tipo, COUNT(*) as total, SUM(monto) as monto_total')
            ->groupBy('tipo')
            ->get();

        // Datos para gráficos de transacciones por cuenta
        $transaccionesPorCuenta = Transaccion::with('cuenta')
            ->selectRaw('cuenta_id, COUNT(*) as total, SUM(monto) as monto_total')
            ->groupBy('cuenta_id')
            ->get();

        return response()->json([
            'success' => true,
            'cuentas' => $cuentas,
            'transacciones' => $transacciones,
            'graficos' => [
                'por_categoria' => $transaccionesPorCategoria,
                'por_tipo' => $transaccionesPorTipo,
                'por_cuenta' => $transaccionesPorCuenta,
                'resumen' => [
                    'total_cuentas' => $cuentas->count(),
                    'total_transacciones' => $transacciones->count(),
                    'saldo_total' => $cuentas->sum('saldo_actual'),
                    'monto_total_transacciones' => $transacciones->sum('monto')
                ]
            ]
        ]);
    }
}
