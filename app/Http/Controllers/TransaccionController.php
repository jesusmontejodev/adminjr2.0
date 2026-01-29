<?php

namespace App\Http\Controllers;

use App\Models\Transaccion;
use App\Models\Cuenta;
use App\Models\Categoria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

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
     * Verificar que una cuenta pertenezca al usuario autenticado
     */
    private function verificarCuentaUsuario($cuentaId)
    {
        $cuenta = Cuenta::where('id', $cuentaId)
            ->where('id_user', Auth::id())
            ->first();

        if (!$cuenta) {
            abort(403, 'No tienes permiso para acceder a esta cuenta.');
        }

        return $cuenta;
    }

    /**
     * Verificar que una categoría pertenezca al usuario autenticado
     */
    private function verificarCategoriaUsuario($categoriaId)
    {
        $categoria = Categoria::where('id', $categoriaId)
            ->where('id_user', Auth::id())
            ->first();

        if (!$categoria) {
            abort(403, 'No tienes permiso para acceder a esta categoría.');
        }

        return $categoria;
    }

    /**
     * Verificar que una transacción pertenezca al usuario autenticado
     */
    private function verificarTransaccionUsuario(Transaccion $transaccion)
    {
        // Verificar a través de la cuenta asociada
        $cuenta = $transaccion->cuenta;

        if (!$cuenta || $cuenta->id_user !== Auth::id()) {
            abort(403, 'No tienes permiso para acceder a esta transacción.');
        }

        return true;
    }

    /**
     * Scope para obtener solo transacciones del usuario autenticado
     */
    private function transaccionesDelUsuario()
    {
        return Transaccion::with(['cuenta', 'categoria'])
            ->whereHas('cuenta', function($q) {
                $q->where('id_user', Auth::id());
            });
    }

    /**
     * Mostrar todas las transacciones del usuario
     */
   public function index(Request $request)
{
    $query = $this->transaccionesDelUsuario();

    // Filtros seguros
    $this->aplicarFiltros($query, $request);

    // 🔥 TOTALES SIN PAGINAR (CLONANDO EL QUERY)
    $totalIngresos   = (clone $query)->where('tipo', 'ingreso')->sum('monto');
    $totalEgresos    = (clone $query)->where('tipo', 'egreso')->sum('monto');
    $totalCostos     = (clone $query)->where('tipo', 'costo')->sum('monto');
    $totalInversion  = (clone $query)->where('tipo', 'inversion')->sum('monto');

    // Ordenamiento seguro
    $campoOrden = $this->validarCampoOrden($request->input('sort_by', 'fecha'));
    $direccionOrden = $this->validarDireccionOrden($request->input('sort_dir', 'desc'));

    $query->orderBy($campoOrden, $direccionOrden);

    // Paginación con límite máximo
    $porPagina = min($request->input('per_page', 20), 100);
    $transacciones = $query->paginate($porPagina);

    // Obtener datos para los filtros
    $cuentas = $this->getUserCuentas();
    $categorias = $this->getUserCategorias();
    $tipos = ['ingreso', 'egreso', 'inversion', 'costo'];

    return view('transacciones.index', compact(
        'transacciones',
        'cuentas',
        'categorias',
        'tipos',
        'totalIngresos',
        'totalEgresos',
        'totalCostos',
        'totalInversion'
    ));
}


    /**
     * Aplicar filtros seguros
     */
    private function aplicarFiltros($query, Request $request)
    {
        // Búsqueda segura
        if ($request->filled('search')) {
            $busqueda = strip_tags($request->input('search'));
            $query->where(function($q) use ($busqueda) {
                $q->where('descripcion', 'LIKE', "%{$busqueda}%")
                    ->orWhereHas('cuenta', function($q2) use ($busqueda) {
                        $q2->where('nombre', 'LIKE', "%{$busqueda}%");
                    })
                    ->orWhereHas('categoria', function($q2) use ($busqueda) {
                        $q2->where('nombre', 'LIKE', "%{$busqueda}%");
                    });
            });
        }

        // Filtro por tipo (validado)
        if ($request->filled('tipo')) {
            $tipo = $request->input('tipo');
            if (in_array($tipo, ['ingreso', 'egreso', 'inversion', 'costo'])) {
                $query->where('tipo', $tipo);
            }
        }

        // Filtro por cuenta (verificado que pertenece al usuario)
        if ($request->filled('cuenta_id')) {
            $cuenta = Cuenta::where('id', $request->cuenta_id)
                        ->where('id_user', Auth::id())
                        ->first();
            if ($cuenta) {
                $query->where('cuenta_id', $cuenta->id);
            }
        }

        // Filtro por categoría (verificado que pertenece al usuario)
        if ($request->filled('categoria_id')) {
            $categoria = Categoria::where('id', $request->categoria_id)
                            ->where('id_user', Auth::id())
                            ->first();
            if ($categoria) {
                $query->where('categoria_id', $categoria->id);
            }
        }

        // Filtro por fechas
        if ($request->filled('fecha_desde')) {
            $query->whereDate('fecha', '>=', $request->input('fecha_desde'));
        }

        if ($request->filled('fecha_hasta')) {
            $query->whereDate('fecha', '<=', $request->input('fecha_hasta'));
        }
    }

    /**
     * Validar campo de ordenamiento
     */
    private function validarCampoOrden($campo)
    {
        $camposPermitidos = ['fecha', 'monto', 'created_at', 'updated_at'];
        return in_array($campo, $camposPermitidos) ? $campo : 'fecha';
    }

    /**
     * Validar dirección de ordenamiento
     */
    private function validarDireccionOrden($direccion)
    {
        return in_array(strtolower($direccion), ['asc', 'desc']) ? $direccion : 'desc';
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
                ->with('warning', 'Debes crear una cuenta antes de registrar transacciones.')
                ->with('requires_account', true);
        }

        return view('transacciones.create', compact('cuentas', 'categorias'));
    }

    /**
     * Almacenar nueva transacción
     */
    public function store(Request $request)
    {
        // Determinar si es una solicitud JSON (API) o formulario web
        if ($request->wantsJson() || $request->is('api/*')) {
            return $this->guardarDesdeAPI($request);
        }

        return $this->guardarDesdeFormulario($request);
    }

    /**
     * Almacenar desde formulario web
     */
    private function guardarDesdeFormulario(Request $request)
    {
        $validated = $request->validate([
            'cuenta_id' => 'required|exists:cuentas,id',
            'categoria_id' => 'required|exists:categorias,id',
            'monto' => 'required|numeric|min:0.01|max:999999999.99',
            'descripcion' => 'nullable|string|max:500',
            'fecha' => 'required|date',
            'tipo' => 'required|in:ingreso,egreso,inversion,costo',
        ]);

        // Verificar que cuenta y categoría pertenezcan al usuario
        $this->verificarCuentaUsuario($request->cuenta_id);
        $this->verificarCategoriaUsuario($request->categoria_id);

        try {
            DB::transaction(function () use ($validated) {
                $cuenta = Cuenta::find($validated['cuenta_id']);

                // Crear transacción
                $transaccion = Transaccion::create([
                    'cuenta_id'    => $validated['cuenta_id'],
                    'categoria_id' => $validated['categoria_id'],
                    'monto'        => $validated['monto'],
                    'descripcion'  => $validated['descripcion'] ?? null,
                    'fecha'        => $validated['fecha'],
                    'tipo'         => $validated['tipo'],
                ]);

                // Actualizar saldo de la cuenta
                $this->actualizarSaldoCuenta($cuenta, $validated['monto'], $validated['tipo']);
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
     * Almacenar desde API
     */
    private function guardarDesdeAPI(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'cuenta' => 'required|string|max:100',
            'monto' => 'required|numeric|min:0.01|max:999999999.99',
            'tipo' => 'required|in:ingreso,egreso,inversion,costo',
            'descripcion' => 'nullable|string|max:500',
            'categoria' => 'required|string|max:100',
            'fecha' => 'nullable|date',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
                'message' => 'Error de validación'
            ], 422);
        }

        try {
            $transaccion = DB::transaction(function () use ($request) {
                // Obtener usuario autenticado
                $userId = Auth::id();

                if (!$userId) {
                    throw new \Exception('Usuario no autenticado');
                }

                // Buscar la cuenta por nombre para este usuario específico
                $cuenta = Cuenta::where('nombre', $request->cuenta)
                    ->where('id_user', $userId)
                    ->first();

                if (!$cuenta) {
                    throw new \Exception("La cuenta '{$request->cuenta}' no existe para el usuario autenticado");
                }

                // Buscar o crear categoría para este usuario específico
                $categoria = Categoria::firstOrCreate(
                    [
                        'nombre' => $request->categoria,
                        'id_user' => $userId
                    ],
                    [
                        'color' => '#' . str_pad(dechex(mt_rand(0, 0xFFFFFF)), 6, '0', STR_PAD_LEFT),
                        'descripcion' => 'Creada automáticamente desde API',
                    ]
                );

                // Crear transacción
                $transaccion = Transaccion::create([
                    'cuenta_id'    => $cuenta->id,
                    'categoria_id' => $categoria->id,
                    'monto'        => $request->monto,
                    'descripcion'  => $request->descripcion,
                    'fecha'        => $request->fecha ?? now()->format('Y-m-d'),
                    'tipo'         => $request->tipo,
                ]);

                // Actualizar saldo de la cuenta
                $this->actualizarSaldoCuenta($cuenta, $request->monto, $request->tipo);

                return $transaccion;
            });

            // Cargar relaciones para la respuesta
            $transaccion->load(['cuenta', 'categoria']);

            return response()->json([
                'success' => true,
                'data' => [
                    'transaccion' => $transaccion,
                    'saldo_actualizado' => $transaccion->cuenta->saldo_actual,
                    'detalles' => [
                        'cuenta' => $transaccion->cuenta->nombre,
                        'categoria' => $transaccion->categoria->nombre,
                        'usuario_id' => Auth::id(),
                        'tipo_operacion' => $transaccion->tipo
                    ]
                ],
                'message' => 'Transacción registrada correctamente'
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
                'trace' => config('app.debug') ? $e->getTraceAsString() : null
            ], 500);
        }
    }

    /**
     * Actualizar saldo de cuenta de forma segura
     */
    private function actualizarSaldoCuenta($cuenta, $monto, $tipo)
    {
        if (!$cuenta) return;

        switch ($tipo) {
            case 'ingreso':
                $cuenta->saldo_actual += $monto;
                break;
            case 'egreso':
            case 'inversion':
            case 'costo':
                if ($cuenta->saldo_actual < $monto) {
                    throw new \Exception('Saldo insuficiente en la cuenta');
                }
                $cuenta->saldo_actual -= $monto;
                break;
        }

        // Validar que el saldo no sea negativo (excepto para ingresos)
        if ($cuenta->saldo_actual < 0 && $tipo !== 'ingreso') {
            throw new \Exception('La operación dejaría el saldo negativo');
        }

        $cuenta->save();
    }

    /**
     * Mostrar formulario para editar transacción
     */
    public function edit(Transaccion $transaccion)
    {
        // Verificar que la transacción pertenezca al usuario
        $this->verificarTransaccionUsuario($transaccion);

        $cuentas = $this->getUserCuentas();
        $categorias = $this->getUserCategorias();

        return view('transacciones.edit', compact('transaccion', 'cuentas', 'categorias'));
    }

    /**
     * Mostrar detalles de una transacción
     */
    public function show(Transaccion $transaccion)
    {
        // Verificar que la transacción pertenezca al usuario
        $this->verificarTransaccionUsuario($transaccion);

        return view('transacciones.show', compact('transaccion'));
    }

    /**
     * Actualizar transacción existente
     */
    public function update(Request $request, Transaccion $transaccion)
    {
        // Verificar que la transacción pertenezca al usuario
        $this->verificarTransaccionUsuario($transaccion);

        $validated = $request->validate([
            'cuenta_id' => 'required|exists:cuentas,id',
            'categoria_id' => 'required|exists:categorias,id',
            'monto' => 'required|numeric|min:0.01|max:999999999.99',
            'descripcion' => 'nullable|string|max:500',
            'fecha' => 'required|date',
            'tipo' => 'required|in:ingreso,egreso,inversion,costo',
        ]);

        // Verificar que la nueva cuenta y categoría pertenezcan al usuario
        $this->verificarCuentaUsuario($request->cuenta_id);
        $this->verificarCategoriaUsuario($request->categoria_id);

        try {
            DB::transaction(function () use ($request, $transaccion) {
                // 1. Revertir saldo anterior de la cuenta original
                $cuentaAnterior = Cuenta::find($transaccion->cuenta_id);
                if ($cuentaAnterior) {
                    $this->revertirSaldo($cuentaAnterior, $transaccion->monto, $transaccion->tipo);
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

                // 3. Aplicar nuevo saldo
                $cuentaNueva = Cuenta::find($request->cuenta_id);
                if ($cuentaNueva) {
                    $this->actualizarSaldoCuenta($cuentaNueva, $request->monto, $request->tipo);
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
     * Revertir saldo de cuenta
     */
    private function revertirSaldo($cuenta, $monto, $tipo)
    {
        if (!$cuenta) return;

        switch ($tipo) {
            case 'ingreso':
                $cuenta->saldo_actual -= $monto;
                break;
            case 'egreso':
            case 'inversion':
            case 'costo':
                $cuenta->saldo_actual += $monto;
                break;
        }

        $cuenta->save();
    }

    /**
     * Eliminar transacción
     */
    public function destroy(Transaccion $transaccion)
    {
        // Verificar que la transacción pertenezca al usuario
        $this->verificarTransaccionUsuario($transaccion);

        try {
            DB::transaction(function () use ($transaccion) {
                // Revertir saldo de la cuenta
                $cuenta = Cuenta::find($transaccion->cuenta_id);
                if ($cuenta) {
                    $this->revertirSaldo($cuenta, $transaccion->monto, $transaccion->tipo);
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
     * Obtener estadísticas
     */
    public function estadisticas(Request $request)
    {
        $userId = Auth::id();

        $query = Transaccion::whereHas('cuenta', function($q) use ($userId) {
            $q->where('id_user', $userId);
        });

        // Filtros por período
        $this->aplicarFiltroPeriodo($query, $request);

        // Obtener estadísticas
        $estadisticas = $this->calcularEstadisticas($query);

        // Top categorías
        $topCategoriasEgresos = $this->obtenerTopCategorias($userId, 'egreso', 5);
        $topCategoriasCostos = $this->obtenerTopCategorias($userId, 'costo', 5);

        return view('transacciones.estadisticas', compact(
            'estadisticas',
            'topCategoriasEgresos',
            'topCategoriasCostos'
        ));
    }

    /**
     * Aplicar filtro de período
     */
    private function aplicarFiltroPeriodo($query, Request $request)
    {
        if (!$request->filled('periodo')) {
            return;
        }

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
                    $fecha->copy()->startOfWeek(),
                    $fecha->copy()->endOfWeek()
                ]);
                break;
            case 'dia':
                $query->whereDate('fecha', $fecha->toDateString());
                break;
        }
    }

    /**
     * Calcular estadísticas
     */
    private function calcularEstadisticas($query)
    {
        return [
            'total_ingresos' => $query->clone()->where('tipo', 'ingreso')->sum('monto'),
            'total_egresos' => $query->clone()->where('tipo', 'egreso')->sum('monto'),
            'total_costos' => $query->clone()->where('tipo', 'costo')->sum('monto'),
            'total_inversiones' => $query->clone()->where('tipo', 'inversion')->sum('monto'),
            'transacciones_count' => $query->clone()->count(),
            'promedio_ingreso' => round($query->clone()->where('tipo', 'ingreso')->avg('monto') ?? 0, 2),
            'promedio_egreso' => round($query->clone()->where('tipo', 'egreso')->avg('monto') ?? 0, 2),
            'promedio_costo' => round($query->clone()->where('tipo', 'costo')->avg('monto') ?? 0, 2),
            'promedio_inversion' => round($query->clone()->where('tipo', 'inversion')->avg('monto') ?? 0, 2),
        ];
    }

    /**
     * Obtener top categorías
     */
    private function obtenerTopCategorias($userId, $tipo, $limite = 5)
    {
        return DB::table('transacciones')
            ->join('categorias', 'transacciones.categoria_id', '=', 'categorias.id')
            ->join('cuentas', 'transacciones.cuenta_id', '=', 'cuentas.id')
            ->where('cuentas.id_user', $userId)
            ->select('categorias.nombre', DB::raw('SUM(transacciones.monto) as total'))
            ->where('transacciones.tipo', $tipo)
            ->groupBy('categorias.id', 'categorias.nombre')
            ->orderBy('total', 'desc')
            ->limit($limite)
            ->get();
    }

    /**
     * Exportar transacciones (ejemplo adicional)
     */
    public function exportar(Request $request)
    {
        $query = $this->transaccionesDelUsuario();

        // Aplicar filtros
        $this->aplicarFiltros($query, $request);

        $transacciones = $query->get();

        // Verificar que hay transacciones para exportar
        if ($transacciones->isEmpty()) {
            return back()->with('error', 'No hay transacciones para exportar con los filtros seleccionados.');
        }

        // Aquí iría la lógica de exportación (CSV, Excel, PDF, etc.)
        // Por ahora solo redirigimos
        return back()->with('success', 'Exportación iniciada. Esta funcionalidad está en desarrollo.');
    }

    /**
     * Buscar transacciones por descripción (para autocomplete)
     */
    public function buscar(Request $request)
    {
        $request->validate([
            'q' => 'required|string|min:2|max:100'
        ]);

        $busqueda = strip_tags($request->input('q'));

        $transacciones = $this->transaccionesDelUsuario()
            ->where('descripcion', 'LIKE', "%{$busqueda}%")
            ->select('descripcion')
            ->distinct()
            ->limit(10)
            ->get()
            ->pluck('descripcion');

        return response()->json($transacciones);
    }
}
