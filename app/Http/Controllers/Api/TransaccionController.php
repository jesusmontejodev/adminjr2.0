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
    // Token de prueba - ponlo en tu .env como API_TEST_TOKEN
    private $apiToken;

    public function __construct()
    {
        // Obtener el token desde .env
        $this->apiToken = env('API_TEST_TOKEN', 'test-token-123456');
    }

    /**
     * Verificar el token Bearer
     */
    private function verifyToken(Request $request)
    {
        $authHeader = $request->header('Authorization');

        if (!$authHeader) {
            return [
                'success' => false,
                'message' => 'Token de autorización no proporcionado'
            ];
        }

        // Extraer el token Bearer
        $token = str_replace('Bearer ', '', $authHeader);

        // Verificar si el token coincide
        if ($token !== $this->apiToken) {
            return [
                'success' => false,
                'message' => 'Token inválido o expirado'
            ];
        }

        return ['success' => true];
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Verificar token
        $tokenCheck = $this->verifyToken($request);
        if (!$tokenCheck['success']) {
            return response()->json($tokenCheck, 401);
        }

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
        // Verificar token
        $tokenCheck = $this->verifyToken($request);
        if (!$tokenCheck['success']) {
            return response()->json($tokenCheck, 401);
        }

        try {
            // Validación básica de datos
            $data = $request->validate([
                'id_usuario' => 'required|integer|exists:users,id',
                'cuenta'    => 'required|string',
                'categoria' => 'required|string',
                'tipo'      => 'required|string|in:ingreso,gasto,egreso,inversion',
                'monto'     => 'required|numeric|min:0.01',
                'descripcion'=> 'nullable|string',
                'fecha'     => 'nullable|date',
            ]);

            // Verificar existencia de la cuenta - usando id_user
            $cuenta = Cuenta::where('nombre', $data['cuenta'])
                ->where('id_user', $data['id_usuario'])
                ->first();

            if (!$cuenta) {
                return response()->json([
                    'success' => false,
                    'message' => "La cuenta '{$data['cuenta']}' no existe para este usuario."
                ], 404);
            }

            // Verificar existencia de la categoría - usando id_user
            $categoria = Categoria::where('nombre', $data['categoria'])
                ->where('id_user', $data['id_usuario'])
                ->first();

            if (!$categoria) {
                return response()->json([
                    'success' => false,
                    'message' => "La categoría '{$data['categoria']}' no existe para este usuario."
                ], 404);
            }

            // Determinar la fecha a usar
            $fecha = isset($data['fecha']) ? Carbon::parse($data['fecha']) : Carbon::now();

            // Crear la transacción
            $transaccion = Transaccion::create([
                'cuenta_id'    => $cuenta->id,
                'categoria_id' => $categoria->id,
                'monto'        => $data['monto'],
                'descripcion'  => $data['descripcion'] ?? null,
                'fecha'        => $fecha,
                'tipo'         => $data['tipo']
            ]);

            // Actualizar saldo de la cuenta
            if ($data['tipo'] === 'ingreso') {
                $cuenta->saldo_actual += $data['monto'];
            } else { // gasto, egreso o inversion
                $cuenta->saldo_actual -= $data['monto'];

                // Verificar que el saldo no sea negativo (opcional)
                if ($cuenta->saldo_actual < 0) {
                    // Opcional: puedes decidir si permitir saldo negativo o rechazar
                    // return response()->json([
                    //     'success' => false,
                    //     'message' => 'Saldo insuficiente en la cuenta.'
                    // ], 400);
                }
            }
            $cuenta->save();

            return response()->json([
                'success' => true,
                'message' => 'Transacción registrada correctamente.',
                'transaccion' => $transaccion->load(['cuenta', 'categoria'])
            ], 201);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error de validación',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Ocurrió un error inesperado.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function show(Request $request, string $id)
    {
        // Verificar token
        $tokenCheck = $this->verifyToken($request);
        if (!$tokenCheck['success']) {
            return response()->json($tokenCheck, 401);
        }

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
        // Verificar token
        $tokenCheck = $this->verifyToken($request);
        if (!$tokenCheck['success']) {
            return response()->json($tokenCheck, 401);
        }

        $transaccion = Transaccion::find($id);
        if (!$transaccion) {
            return response()->json(['success' => false, 'message' => 'Transacción no encontrada.'], 404);
        }

        $data = $request->validate([
            'tipo'        => 'sometimes|string|in:ingreso,gasto,egreso,inversion',
            'monto'       => 'sometimes|numeric|min:0.01',
            'descripcion' => 'nullable|string',
            'fecha'       => 'sometimes|date',
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
    public function destroy(Request $request, string $id)
    {
        // Verificar token
        $tokenCheck = $this->verifyToken($request);
        if (!$tokenCheck['success']) {
            return response()->json($tokenCheck, 401);
        }

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
    public function cuentas(Request $request)
    {
        // Verificar token
        $tokenCheck = $this->verifyToken($request);
        if (!$tokenCheck['success']) {
            return response()->json($tokenCheck, 401);
        }

        $cuentas = Cuenta::all();

        return response()->json([
            'success' => true,
            'cuentas' => $cuentas
        ]);
    }

    /**
     * Obtener cuentas por usuario
     */
    public function cuentasPorUsuario(Request $request, $id_usuario)
    {
        // Verificar token
        $tokenCheck = $this->verifyToken($request);
        if (!$tokenCheck['success']) {
            return response()->json($tokenCheck, 401);
        }

        $cuentas = Cuenta::where('id_user', $id_usuario)->get();

        return response()->json([
            'success' => true,
            'cuentas' => $cuentas
        ]);
    }

    public function graficos(Request $request)
    {
        // Verificar token
        $tokenCheck = $this->verifyToken($request);
        if (!$tokenCheck['success']) {
            return response()->json($tokenCheck, 401);
        }

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

    /**
     * Nuevo método para obtener transacciones por usuario
     */
    public function porUsuario(Request $request, $id_usuario)
    {
        // Verificar token
        $tokenCheck = $this->verifyToken($request);
        if (!$tokenCheck['success']) {
            return response()->json($tokenCheck, 401);
        }

        $transacciones = Transaccion::with(['cuenta', 'categoria'])
            ->whereHas('cuenta', function($query) use ($id_usuario) {
                $query->where('id_user', $id_usuario);
            })
            ->orWhereHas('categoria', function($query) use ($id_usuario) {
                $query->where('id_user', $id_usuario);
            })
            ->latest()
            ->get();

        return response()->json([
            'success' => true,
            'transacciones' => $transacciones
        ]);
    }

    /**
     * Método para obtener estadísticas por usuario
     */
    public function estadisticasPorUsuario(Request $request, $id_usuario)
    {
        // Verificar token
        $tokenCheck = $this->verifyToken($request);
        if (!$tokenCheck['success']) {
            return response()->json($tokenCheck, 401);
        }

        // Obtener cuentas del usuario
        $cuentas = Cuenta::where('id_user', $id_usuario)->get();

        // Obtener transacciones del usuario
        $transacciones = Transaccion::with(['cuenta', 'categoria'])
            ->whereHas('cuenta', function($query) use ($id_usuario) {
                $query->where('id_user', $id_usuario);
            })
            ->get();

        // Cálculos de estadísticas
        $ingresos = $transacciones->where('tipo', 'ingreso')->sum('monto');
        $gastos = $transacciones->whereIn('tipo', ['gasto', 'egreso'])->sum('monto');
        $inversiones = $transacciones->where('tipo', 'inversion')->sum('monto');

        return response()->json([
            'success' => true,
            'estadisticas' => [
                'total_cuentas' => $cuentas->count(),
                'total_transacciones' => $transacciones->count(),
                'saldo_total' => $cuentas->sum('saldo_actual'),
                'ingresos_total' => $ingresos,
                'gastos_total' => $gastos,
                'inversiones_total' => $inversiones,
                'balance' => $ingresos - $gastos - $inversiones
            ],
            'cuentas' => $cuentas,
            'transacciones_recientes' => $transacciones->take(10)
        ]);
    }

    /**
     * Método para verificar si el token es válido (útil para pruebas)
     */
    public function verify(Request $request)
    {
        $tokenCheck = $this->verifyToken($request);

        if ($tokenCheck['success']) {
            return response()->json([
                'success' => true,
                'message' => 'Token válido'
            ]);
        } else {
            return response()->json($tokenCheck, 401);
        }
    }
}
