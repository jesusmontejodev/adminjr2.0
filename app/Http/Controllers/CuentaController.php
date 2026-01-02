<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cuenta;
use Illuminate\Support\Facades\Auth;

class CuentaController extends Controller
{
    /**
     * Mostrar todas las cuentas del usuario autenticado
     */
    public function index()
    {
        $cuentas = Cuenta::where('id_user', Auth::id())
                        ->orderBy('nombre')
                        ->get();

        $saldoTotal = $cuentas->sum('saldo_actual');
        $cuentasActivas = $cuentas->where('saldo_actual', '>', 0)->count();

        return view('cuentas.index', compact('cuentas', 'saldoTotal', 'cuentasActivas'));
    }

    /**
     * Mostrar formulario para crear nueva cuenta
     */
    public function create()
    {
        return view('cuentas.create');
    }

    /**
     * Almacenar una nueva cuenta
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'nombre' => 'required|string|max:100',
                'saldo_inicial' => 'required|numeric|min:0',
                'descripcion' => 'nullable|string|max:500',
            ]);

            $validated['saldo_actual'] = $validated['saldo_inicial'];
            $validated['id_user'] = Auth::id();

            $existeCuenta = Cuenta::where('id_user', Auth::id())
                                 ->where('nombre', $validated['nombre'])
                                 ->exists();

            if ($existeCuenta) {
                return redirect()->back()
                               ->withInput()
                               ->with('error', 'Ya tienes una cuenta con ese nombre.');
            }

            Cuenta::create($validated);

            return redirect()->route('cuentas.index')
                           ->with('success', 'Cuenta creada exitosamente.');

        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()
                           ->withInput()
                           ->withErrors($e->errors());
        } catch (\Exception $e) {
            return redirect()->back()
                           ->withInput()
                           ->with('error', 'Error al crear la cuenta: ' . $e->getMessage());
        }
    }

    /**
     * Mostrar detalles de una cuenta específica
     */
    public function show($id)
    {
        $cuenta = Cuenta::where('id_user', Auth::id())
                        ->where('id', $id)
                        ->firstOrFail();

        $cuenta->load(['transacciones' => function ($query) {
            $query->latest()->take(10);
        }]);

        $totalIngresos = $cuenta->transacciones()
                              ->where('tipo', 'ingreso')
                              ->sum('monto');

        $totalEgresos = $cuenta->transacciones()
                             ->where('tipo', 'egreso')
                             ->sum('monto');

        return view('cuentas.show', compact('cuenta', 'totalIngresos', 'totalEgresos'));
    }

    /**
     * Mostrar formulario para editar cuenta
     */
    public function edit($id)
    {
        $cuenta = Cuenta::where('id_user', Auth::id())
                        ->where('id', $id)
                        ->firstOrFail();

        return view('cuentas.edit', compact('cuenta'));
    }

    /**
     * Actualizar una cuenta existente
     * NO permite cambiar el saldo_inicial
     */
    public function update(Request $request, $id)
    {
        $cuenta = Cuenta::where('id_user', Auth::id())
                        ->where('id', $id)
                        ->firstOrFail();

        try {
            // Validación SIN saldo_inicial
            $validated = $request->validate([
                'nombre' => 'required|string|max:100',
                'descripcion' => 'nullable|string|max:500',
                // NOTA: saldo_inicial NO está incluido aquí
            ]);

            // Verificar si el nuevo nombre ya existe (excluyendo la cuenta actual)
            $existeNombre = Cuenta::where('id_user', Auth::id())
                                 ->where('nombre', $validated['nombre'])
                                 ->where('id', '!=', $cuenta->id)
                                 ->exists();

            if ($existeNombre) {
                return redirect()->back()
                               ->withInput()
                               ->with('error', 'Ya tienes otra cuenta con ese nombre.');
            }

            // Actualizar solo nombre y descripción
            $cuenta->update([
                'nombre' => $validated['nombre'],
                'descripcion' => $validated['descripcion']
            ]);

            return redirect()->route('cuentas.index')
                           ->with('success', 'Cuenta actualizada exitosamente.');

        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()
                           ->withInput()
                           ->withErrors($e->errors());
        } catch (\Exception $e) {
            return redirect()->back()
                           ->withInput()
                           ->with('error', 'Error al actualizar la cuenta: ' . $e->getMessage());
        }
    }

    /**
     * Eliminar una cuenta
     */
    public function destroy($id)
    {
        $cuenta = Cuenta::where('id_user', Auth::id())
                        ->where('id', $id)
                        ->firstOrFail();

        try {
            if ($cuenta->transacciones()->count() > 0) {
                return redirect()->route('cuentas.index')
                            ->with('error', 'No se puede eliminar la cuenta porque tiene transacciones asociadas.');
            }

            $cuenta->delete();

            return redirect()->route('cuentas.index')
                        ->with('success', 'Cuenta eliminada exitosamente.');

        } catch (\Exception $e) {
            return redirect()->route('cuentas.index')
                        ->with('error', 'Error al eliminar la cuenta: ' . $e->getMessage());
        }
    }

    /**
     * API: Obtener cuentas en formato JSON
     */
    public function getCuentasJson()
    {
        $cuentas = Cuenta::where('id_user', Auth::id())
                         ->select('id', 'nombre', 'saldo_actual')
                         ->orderBy('nombre')
                         ->get();

        return response()->json($cuentas);
    }

    /**
     * Obtener estadísticas de cuentas
     */
    public function estadisticas()
    {
        $estadisticas = [
            'total_cuentas' => Cuenta::where('id_user', Auth::id())->count(),
            'cuentas_con_saldo' => Cuenta::where('id_user', Auth::id())
                                        ->where('saldo_actual', '>', 0)
                                        ->count(),
            'saldo_total' => Cuenta::where('id_user', Auth::id())
                                  ->sum('saldo_actual'),
            'saldo_promedio' => Cuenta::where('id_user', Auth::id())
                                     ->avg('saldo_actual'),
            'cuenta_mayor_saldo' => Cuenta::where('id_user', Auth::id())
                                         ->orderBy('saldo_actual', 'desc')
                                         ->first(),
        ];

        return view('cuentas.estadisticas', compact('estadisticas'));
    }
}
