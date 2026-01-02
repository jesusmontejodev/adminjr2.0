<?php

namespace App\Http\Controllers;

use App\Models\Transaccion;
use App\Models\Cuenta;
use App\Models\Categoria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TransaccionController extends Controller
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
     * Obtener solo las categorías del usuario autenticado
     */
    private function getUserCategorias()
    {
        return Categoria::where('id_user', Auth::id())->get();
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
     * Verificar que una transacción pertenezca al usuario
     */
    private function authorizeTransaccion($transaccion)
    {
        // Verificar que la cuenta de la transacción pertenezca al usuario
        $cuenta = $transaccion->cuenta;
        if (!$cuenta || $cuenta->id_user !== Auth::id()) {
            abort(403, 'No tienes permiso para acceder a esta transacción.');
        }
    }

    /**
     * Mostrar todas las transacciones del usuario
     */
    public function index(Request $request)
    {
        // Obtener solo transacciones de las cuentas del usuario
        $query = Transaccion::with(['cuenta', 'categoria'])
            ->whereHas('cuenta', function($q) {
                $q->where('id_user', Auth::id());
            });

        // Filtros
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                $q->where('descripcion', 'LIKE', "%{$search}%")
                    ->orWhereHas('cuenta', function($q2) use ($search) {
                        $q2->where('nombre', 'LIKE', "%{$search}%");
                    })
                    ->orWhereHas('categoria', function($q2) use ($search) {
                        $q2->where('nombre', 'LIKE', "%{$search}%");
                    });
            });
        }

        if ($request->filled('tipo')) {
            $query->where('tipo', $request->input('tipo'));
        }

        if ($request->filled('cuenta_id')) {
            // Verificar que la cuenta filtrada pertenezca al usuario
            $cuenta = Cuenta::where('id', $request->cuenta_id)
                        ->where('id_user', Auth::id())
                        ->first();
            if ($cuenta) {
                $query->where('cuenta_id', $cuenta->id);
            }
        }

        if ($request->filled('categoria_id')) {
            $query->where('categoria_id', $request->input('categoria_id'));
        }

        if ($request->filled('fecha_desde')) {
            $query->whereDate('fecha', '>=', $request->input('fecha_desde'));
        }

        if ($request->filled('fecha_hasta')) {
            $query->whereDate('fecha', '<=', $request->input('fecha_hasta'));
        }

        // Ordenamiento
        $sortField = $request->input('sort_by', 'fecha');
        $sortDirection = $request->input('sort_dir', 'desc');
        $query->orderBy($sortField, $sortDirection);

        // Paginación (recomendado)
        $transacciones = $query->paginate(20);

        // Obtener datos para los filtros (solo del usuario)
        $cuentas = $this->getUserCuentas();
        $categorias = $this->getUserCategorias();
        $tipos = ['ingreso', 'gasto', 'inversion'];

        return view('transacciones.index', compact(
            'transacciones',
            'cuentas',
            'categorias',
            'tipos'
        ));
    }

    /**
     * Mostrar formulario para crear transacción
     */
    public function create()
    {
        $cuentas = $this->getUserCuentas();
        $categorias = $this->getUserCategorias();

        if ($cuentas->isEmpty()) {
            return redirect()->route('cuentas.index')
                ->with('warning', 'Debes crear una cuenta antes de registrar transacciones.');
        }

        return view('transacciones.create', compact('cuentas', 'categorias'));
    }

    /**
     * Mostrar formulario para editar transacción
     */
    public function edit(Transaccion $transaccion)
    {
        // Verificar autorización
        $this->authorizeTransaccion($transaccion);

        $cuentas = $this->getUserCuentas();
        $categorias = $this->getUserCategorias();

        return view('transacciones.edit', compact('transaccion', 'cuentas', 'categorias'));
    }

    /**
     * Almacenar nueva transacción
     */
    public function store(Request $request)
    {
        try {
            // Validación directa
            $validated = $request->validate([
                'cuenta_id' => 'required|exists:cuentas,id',
                'categoria_id' => 'required|exists:categorias,id',
                'monto' => 'required|numeric|min:0.01',
                'descripcion' => 'nullable|string|max:500',
                'fecha' => 'required|date',
                'tipo' => 'required|in:ingreso,gasto,inversion',
            ]);

            // Verificar que la cuenta pertenezca al usuario
            $this->authorizeCuenta($request->cuenta_id);

            DB::transaction(function () use ($request) {
                // Crear transacción
                $transaccion = Transaccion::create([
                    'cuenta_id'    => $request->cuenta_id,
                    'categoria_id' => $request->categoria_id,
                    'monto'        => $request->monto,
                    'descripcion'  => $request->descripcion,
                    'fecha'        => $request->fecha,
                    'tipo'         => $request->tipo,
                ]);

                // Actualizar saldo de la cuenta
                $cuenta = Cuenta::find($request->cuenta_id);

                if ($request->tipo === 'ingreso') {
                    $cuenta->saldo_actual += $request->monto;
                } elseif (in_array($request->tipo, ['gasto', 'inversion'])) {
                    $cuenta->saldo_actual -= $request->monto;
                }

                $cuenta->save();
            });

            return redirect()
                ->route('transacciones.index')
                ->with('success', 'Transacción registrada correctamente.');

        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Error al registrar la transacción: ' . $e->getMessage());
        }
    }

    /**
     * Actualizar transacción existente
     */
    public function update(Request $request, Transaccion $transaccion)
    {
        // Verificar autorización de la transacción original
        $this->authorizeTransaccion($transaccion);

        try {
            // Validación directa
            $validated = $request->validate([
                'cuenta_id' => 'required|exists:cuentas,id',
                'categoria_id' => 'required|exists:categorias,id',
                'monto' => 'required|numeric|min:0.01',
                'descripcion' => 'nullable|string|max:500',
                'fecha' => 'required|date',
                'tipo' => 'required|in:ingreso,gasto,inversion',
            ]);

            // Verificar que la nueva cuenta (si cambia) pertenezca al usuario
            if ($request->cuenta_id != $transaccion->cuenta_id) {
                $this->authorizeCuenta($request->cuenta_id);
            }

            DB::transaction(function () use ($request, $transaccion) {
                // 1. Revertir saldo anterior de la cuenta original
                $cuentaAnterior = Cuenta::find($transaccion->cuenta_id);
                if ($cuentaAnterior) {
                    if ($transaccion->tipo === 'ingreso') {
                        $cuentaAnterior->saldo_actual -= $transaccion->monto;
                    } elseif (in_array($transaccion->tipo, ['gasto', 'inversion'])) {
                        $cuentaAnterior->saldo_actual += $transaccion->monto;
                    }
                    $cuentaAnterior->save();
                }

                // 2. Actualizar transacción
                $transaccion->update([
                    'cuenta_id'    => $request->cuenta_id,
                    'categoria_id' => $request->categoria_id,
                    'monto'        => $request->monto,
                    'descripcion'  => $request->descripcion,
                    'fecha'        => $request->fecha,
                    'tipo'         => $request->tipo,
                ]);

                // 3. Aplicar nuevo saldo (puede ser en cuenta diferente)
                $cuentaNueva = Cuenta::find($request->cuenta_id);
                if ($cuentaNueva) {
                    if ($request->tipo === 'ingreso') {
                        $cuentaNueva->saldo_actual += $request->monto;
                    } elseif (in_array($request->tipo, ['gasto', 'inversion'])) {
                        $cuentaNueva->saldo_actual -= $request->monto;
                    }
                    $cuentaNueva->save();
                }
            });

            return redirect()
                ->route('transacciones.index')
                ->with('success', 'Transacción actualizada correctamente.');

        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Error al actualizar la transacción: ' . $e->getMessage());
        }
    }

    /**
     * Eliminar transacción
     */
    public function destroy(Transaccion $transaccion)
    {
        // Verificar autorización
        $this->authorizeTransaccion($transaccion);

        try {
            DB::transaction(function () use ($transaccion) {
                // Revertir saldo de la cuenta
                $cuenta = Cuenta::find($transaccion->cuenta_id);
                if ($cuenta) {
                    if ($transaccion->tipo === 'ingreso') {
                        $cuenta->saldo_actual -= $transaccion->monto;
                    } elseif (in_array($transaccion->tipo, ['gasto', 'inversion'])) {
                        $cuenta->saldo_actual += $transaccion->monto;
                    }
                    $cuenta->save();
                }

                // Eliminar transacción
                $transaccion->delete();
            });

            return redirect()->route('transacciones.index')
                ->with('success', 'Transacción eliminada correctamente.');

        } catch (\Exception $e) {
            return redirect()->route('transacciones.index')
                ->with('error', 'Error al eliminar la transacción: ' . $e->getMessage());
        }
    }

    /**
     * Obtener estadísticas de transacciones
     */
    public function estadisticas(Request $request)
    {
        $userId = Auth::id();

        $query = Transaccion::whereHas('cuenta', function($q) use ($userId) {
            $q->where('id_user', $userId);
        });

        // Filtros por período
        if ($request->filled('periodo')) {
            $periodo = $request->input('periodo');
            $fecha = now();

            switch ($periodo) {
                case 'mes':
                    $query->whereMonth('fecha', $fecha->month)
                          ->whereYear('fecha', $fecha->year);
                    break;
                case 'ano':
                    $query->whereYear('fecha', $fecha->year);
                    break;
                case 'semana':
                    $query->whereBetween('fecha', [
                        $fecha->startOfWeek(),
                        $fecha->endOfWeek()
                    ]);
                    break;
            }
        }

        $estadisticas = [
            'total_ingresos' => $query->clone()->where('tipo', 'ingreso')->sum('monto'),
            'total_gastos' => $query->clone()->where('tipo', 'gasto')->sum('monto'),
            'total_inversiones' => $query->clone()->where('tipo', 'inversion')->sum('monto'),
            'transacciones_count' => $query->clone()->count(),
            'promedio_ingreso' => $query->clone()->where('tipo', 'ingreso')->avg('monto'),
            'promedio_gasto' => $query->clone()->where('tipo', 'gasto')->avg('monto'),
        ];

        // Top categorías
        $topCategorias = DB::table('transacciones')
            ->join('categorias', 'transacciones.categoria_id', '=', 'categorias.id')
            ->join('cuentas', 'transacciones.cuenta_id', '=', 'cuentas.id')
            ->where('cuentas.id_user', $userId)
            ->select('categorias.nombre', DB::raw('SUM(transacciones.monto) as total'))
            ->where('transacciones.tipo', 'gasto')
            ->groupBy('categorias.id', 'categorias.nombre')
            ->orderBy('total', 'desc')
            ->limit(5)
            ->get();

        return view('transacciones.estadisticas', compact('estadisticas', 'topCategorias'));
    }
}
