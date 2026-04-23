<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaccion;
use App\Models\Cuenta;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class GraficasController extends Controller
{
    /**
     * Helper: Query base de transacciones filtradas por usuario
     */
    private function _queryTransaccionesPorUsuario($usuario_id)
    {
        return Transaccion::join('cuentas', 'transacciones.cuenta_id', '=', 'cuentas.id')
            ->where('cuentas.id_user', $usuario_id)
            ->select('transacciones.*');
    }

    /**
     * Mostrar dashboard con datos directos del servidor
     */
    public function index()
    {
        $usuario_id = Auth::id();
        
        // Obtener transacciones base para el usuario
        $transacciones = $this->_queryTransaccionesPorUsuario($usuario_id)
            ->with(['cuenta', 'categoria'])
            ->orderBy('fecha', 'desc')
            ->get();
        
        // Obtener datos
        $datos = [
            'resumen' => $this->_resumen($usuario_id, 0, null),
            'por_categoria' => $this->_categoria($transacciones),
            'por_cuenta' => $this->_cuenta($usuario_id, null),
            'tendencia_mensual' => $this->_tendencia($usuario_id, 0, null),
            'flujo_caja' => $this->_flujo($usuario_id, 0, null),
            'historico_saldo' => $this->_historico($transacciones),
            'top_gastos' => $this->_top($usuario_id, 0, null),
            'transacciones' => $this->_tabla($transacciones),
            'cuentas' => Cuenta::where('id_user', $usuario_id)->get()->toArray()
        ];

        return view('analistajr.dashboard', $datos);
    }

    /**
     * API: Obtener datos para dashboard (para compatibilidad)
     * VERSIÓN CORREGIDA Y SIMPLIFICADA
     */
    public function obtenerDatos(Request $request)
    {
        try {
            $usuario_id = Auth::id();
            $dias = $request->query('dias', 0);
            $cuenta_id = $request->query('cuenta_id', null);
            
            // Asegurar que dias es int
            $dias = intval($dias);

            // Obtener transacciones base (filtradas por usuario a través de cuentas)
            $txQuery = $this->_queryTransaccionesPorUsuario($usuario_id);
            
            if ($dias > 0) {
                $txQuery->where('transacciones.fecha', '>=', now()->subDays($dias));
            }
            
            if ($cuenta_id) {
                $txQuery->where('transacciones.cuenta_id', $cuenta_id);
            }

            $transacciones = $txQuery->with(['cuenta', 'categoria'])
                ->orderBy('transacciones.fecha', 'desc')
                ->get();

            return response()->json([
                'success' => true,
                'resumen' => $this->_resumen($usuario_id, $dias, $cuenta_id),
                'por_categoria' => $this->_categoria($transacciones),
                'por_cuenta' => $this->_cuenta($usuario_id, $cuenta_id),
                'tendencia_mensual' => $this->_tendencia($usuario_id, $dias, $cuenta_id),
                'flujo_caja' => $this->_flujo($usuario_id, $dias, $cuenta_id),
                'historico_saldo' => $this->_historico($transacciones),
                'top_gastos' => $this->_top($usuario_id, $dias, $cuenta_id),
                'transacciones' => $this->_tabla($transacciones)
            ], 200);
        } catch (\Throwable $e) {
            \Log::error('Error GraficasController::obtenerDatos', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'error' => $e->getMessage(),
                'debug' => config('app.debug') ? $e->getTraceAsString() : null
            ], 500);
        }
    }

    /**
     * Calcular resumen (KPIs)
     */
    private function _resumen($usuario_id, $dias = 0, $cuenta_id = null)
    {
        $q = $this->_queryTransaccionesPorUsuario($usuario_id);
        
        if ($dias > 0) {
            $q->where('transacciones.fecha', '>=', now()->subDays($dias));
        }
        
        if ($cuenta_id) {
            $q->where('transacciones.cuenta_id', $cuenta_id);
        }

        $ingresos = (clone $q)->where('transacciones.tipo', 'ingreso')->sum('transacciones.monto');
        $gastos = (clone $q)->where('transacciones.tipo', 'gasto')->sum('transacciones.monto');
        $patrimonio = Cuenta::where('id_user', $usuario_id)->sum('saldo_actual');
        $total = (clone $q)->count();

        return [
            'patrimonio_total' => floatval($patrimonio ?? 0),
            'total_ingresos' => floatval($ingresos ?? 0),
            'total_gastos' => floatval($gastos ?? 0),
            'balance' => floatval(($ingresos ?? 0) - ($gastos ?? 0)),
            'total_transacciones' => intval($total)
        ];
    }

    /**
     * Agrupar por categoría
     */
    private function _categoria($transacciones)
    {
        $result = [];
        
        foreach ($transacciones as $tx) {
            if ($tx->tipo !== 'gasto') continue;
            
            $cat_id = $tx->categoria_id ?? 0;
            $cat_name = $tx->categoria?->nombre ?? 'Sin categoría';
            
            if (!isset($result[$cat_id])) {
                $result[$cat_id] = [
                    'categoria_id' => $cat_id,
                    'categoria_nombre' => $cat_name,
                    'monto_total' => 0,
                    'cantidad' => 0
                ];
            }
            
            $result[$cat_id]['monto_total'] += floatval($tx->monto);
            $result[$cat_id]['cantidad']++;
        }

        // Ordenar por monto descendente
        uasort($result, function($a, $b) {
            return $b['monto_total'] <=> $a['monto_total'];
        });

        return array_values($result);
    }

    /**
     * Agrupar por cuenta
     */
    private function _cuenta($usuario_id, $cuenta_id = null)
    {
        $q = Cuenta::where('id_user', $usuario_id);
        
        if ($cuenta_id) {
            $q->where('id', $cuenta_id);
        }

        return $q->get()->map(function($cuenta) {
            return [
                'cuenta_id' => intval($cuenta->id),
                'cuenta_nombre' => strval($cuenta->nombre),
                'saldo' => floatval($cuenta->saldo_actual ?? 0)
            ];
        })->toArray();
    }

    /**
     * Tendencia mensual (12 meses)
     */
    private function _tendencia($usuario_id, $dias = 0, $cuenta_id = null)
    {
        $meses = [];

        for ($i = 11; $i >= 0; $i--) {
            $fecha = now()->subMonths($i);
            $mes = $fecha->month;
            $año = $fecha->year;

            $q1 = $this->_queryTransaccionesPorUsuario($usuario_id)
                ->whereMonth('transacciones.fecha', $mes)
                ->whereYear('transacciones.fecha', $año);
                
            if ($cuenta_id) {
                $q1->where('transacciones.cuenta_id', $cuenta_id);
            }

            $ingresos = (clone $q1)->where('transacciones.tipo', 'ingreso')->sum('transacciones.monto');
            $gastos = (clone $q1)->where('transacciones.tipo', 'gasto')->sum('transacciones.monto');

            $meses[] = [
                'mes' => intval($mes),
                'año' => intval($año),
                'mes_texto' => $fecha->format('M'),
                'ingresos' => floatval($ingresos ?? 0),
                'gastos' => floatval($gastos ?? 0),
                'balance' => floatval(($ingresos ?? 0) - ($gastos ?? 0))
            ];
        }

        return $meses;
    }

    /**
     * Flujo de caja (6 meses)
     */
    private function _flujo($usuario_id, $dias = 0, $cuenta_id = null)
    {
        $meses = [];

        for ($i = 5; $i >= 0; $i--) {
            $fecha = now()->subMonths($i);
            $mes = $fecha->month;
            $año = $fecha->year;

            $q1 = $this->_queryTransaccionesPorUsuario($usuario_id)
                ->whereMonth('transacciones.fecha', $mes)
                ->whereYear('transacciones.fecha', $año);
                
            if ($cuenta_id) {
                $q1->where('transacciones.cuenta_id', $cuenta_id);
            }

            $entradas = (clone $q1)->where('transacciones.tipo', 'ingreso')->sum('transacciones.monto');
            $salidas = (clone $q1)->where('transacciones.tipo', 'gasto')->sum('transacciones.monto');

            $meses[] = [
                'mes' => intval($mes),
                'año' => intval($año),
                'mes_texto' => $fecha->format('M'),
                'entradas' => floatval($entradas ?? 0),
                'salidas' => floatval($salidas ?? 0)
            ];
        }

        return $meses;
    }

    /**
     * Histórico de saldo
     */
    private function _historico($transacciones)
    {
        $historico = [];
        $saldo = 0;

        // Ordenar por fecha ASC
        $ordenadas = $transacciones->sortBy(function($tx) {
            return $tx->fecha->timestamp;
        })->values();

        foreach ($ordenadas as $tx) {
            if ($tx->tipo === 'ingreso') {
                $saldo += floatval($tx->monto);
            } else {
                $saldo -= floatval($tx->monto);
            }

            $historico[] = [
                'fecha' => strval($tx->fecha->format('Y-m-d')),
                'saldo' => floatval($saldo)
            ];
        }

        return $historico;
    }

    /**
     * Top 10 gastos
     */
    private function _top($usuario_id, $dias = 0, $cuenta_id = null)
    {
        $q = $this->_queryTransaccionesPorUsuario($usuario_id)
            ->where('transacciones.tipo', 'gasto');

        if ($dias > 0) {
            $q->where('transacciones.fecha', '>=', now()->subDays($dias));
        }

        if ($cuenta_id) {
            $q->where('transacciones.cuenta_id', $cuenta_id);
        }

        return $q->orderBy('transacciones.monto', 'desc')
            ->limit(10)
            ->get()
            ->map(function($tx) {
                return [
                    'id' => intval($tx->id),
                    'fecha' => strval($tx->fecha->format('Y-m-d')),
                    'monto' => floatval($tx->monto),
                    'descripcion' => strval($tx->descripcion ?? 'Sin descripción'),
                    'categoria' => strval($tx->categoria?->nombre ?? 'Sin categoría')
                ];
            })
            ->toArray();
    }

    /**
     * Tabla de datos (últimas 20 transacciones)
     */
    private function _tabla($transacciones)
    {
        return $transacciones->take(20)->map(function($tx) {
            return [
                'id' => intval($tx->id),
                'fecha' => strval($tx->fecha->format('Y-m-d')),
                'cuenta' => [
                    'id' => intval($tx->cuenta?->id ?? 0),
                    'nombre' => strval($tx->cuenta?->nombre ?? 'Sin cuenta')
                ],
                'categoria' => [
                    'id' => intval($tx->categoria?->id ?? 0),
                    'nombre' => strval($tx->categoria?->nombre ?? 'Sin categoría')
                ],
                'tipo' => strval($tx->tipo),
                'monto' => floatval($tx->monto),
                'descripcion' => strval($tx->descripcion ?? '')
            ];
        })->toArray();
    }

    // Resumen general
    private function obtenerResumen($usuario_id, $dias = null, $cuenta_id = null)
    {
        $query = $this->_queryTransaccionesPorUsuario($usuario_id);

        if ($dias && $dias > 0) {
            $query->where('transacciones.fecha', '>=', now()->subDays((int)$dias));
        }

        if ($cuenta_id) {
            $query->where('transacciones.cuenta_id', $cuenta_id);
        }

        $total_ingresos = (clone $query)->where('transacciones.tipo', 'ingreso')->sum('transacciones.monto');
        $total_gastos = (clone $query)->where('transacciones.tipo', 'gasto')->sum('transacciones.monto');

        // Patrimonio total (suma de saldos de todas las cuentas)
        $patrimonio = Cuenta::where('id_user', $usuario_id)->sum('saldo_actual');

        return [
            'patrimonio_total' => $patrimonio,
            'total_ingresos' => $total_ingresos,
            'total_gastos' => $total_gastos,
            'balance' => $total_ingresos - $total_gastos,
            'total_transacciones' => (clone $query)->count()
        ];
    }

    // Por categoría
    private function obtenerPorCategoria($usuario_id, $dias = null, $cuenta_id = null)
    {
        $query = $this->_queryTransaccionesPorUsuario($usuario_id)
            ->where('transacciones.tipo', 'gasto');

        if ($dias && $dias > 0) {
            $query->where('transacciones.fecha', '>=', now()->subDays((int)$dias));
        }

        if ($cuenta_id) {
            $query->where('transacciones.cuenta_id', $cuenta_id);
        }

        return $query
            ->select('transacciones.categoria_id', DB::raw('SUM(transacciones.monto) as monto_total'), DB::raw('COUNT(*) as total'))
            ->groupBy('transacciones.categoria_id')
            ->with('categoria')
            ->get()
            ->map(function($item) {
                return [
                    'categoria' => $item->categoria,
                    'monto_total' => $item->monto_total,
                    'total' => $item->total
                ];
            });
    }

    // Por cuenta
    private function obtenerPorCuenta($usuario_id, $dias = null, $cuenta_id = null)
    {
        $query = Cuenta::where('id_user', $usuario_id);

        if ($cuenta_id) {
            $query->where('id', $cuenta_id);
        }

        return $query->select('id', 'nombre', 'saldo_actual')
            ->get()
            ->map(function($item) {
                return [
                    'cuenta' => $item,
                    'saldo' => $item->saldo_actual
                ];
            });
    }

    // Tendencia mensual
    private function obtenerTendenciaMensual($usuario_id, $dias = null, $cuenta_id = null)
    {
        // Últimos 12 meses
        $meses = [];
        for ($i = 11; $i >= 0; $i--) {
            $fecha = now()->subMonths($i);
            $mes = $fecha->month;
            $año = $fecha->year;

            $query = $this->_queryTransaccionesPorUsuario($usuario_id)
                ->whereMonth('transacciones.fecha', $mes)
                ->whereYear('transacciones.fecha', $año);

            if ($cuenta_id) {
                $query->where('transacciones.cuenta_id', $cuenta_id);
            }

            $ingresos = (clone $query)->where('transacciones.tipo', 'ingreso')->sum('transacciones.monto');
            $gastos = (clone $query)->where('transacciones.tipo', 'gasto')->sum('transacciones.monto');

            $meses[] = [
                'mes' => $mes,
                'año' => $año,
                'ingresos' => $ingresos,
                'gastos' => $gastos,
                'balance' => $ingresos - $gastos
            ];
        }

        return $meses;
    }

    // Flujo de caja
    private function obtenerFlujoCaja($usuario_id, $dias = null, $cuenta_id = null)
    {
        $meses = [];
        for ($i = 5; $i >= 0; $i--) {
            $fecha = now()->subMonths($i);
            $mes = $fecha->month;
            $año = $fecha->year;

            $query = $this->_queryTransaccionesPorUsuario($usuario_id)
                ->whereMonth('transacciones.fecha', $mes)
                ->whereYear('transacciones.fecha', $año);

            if ($cuenta_id) {
                $query->where('transacciones.cuenta_id', $cuenta_id);
            }

            $entradas = (clone $query)->where('transacciones.tipo', 'ingreso')->sum('transacciones.monto');
            $salidas = (clone $query)->where('transacciones.tipo', 'gasto')->sum('transacciones.monto');

            $meses[] = [
                'mes' => $mes,
                'año' => $año,
                'entradas' => $entradas,
                'salidas' => $salidas
            ];
        }

        return $meses;
    }

    // Histórico de saldo
    private function obtenerHistoricoSaldo($usuario_id, $dias = null, $cuenta_id = null)
    {
        $transacciones = $this->_queryTransaccionesPorUsuario($usuario_id)
            ->orderBy('transacciones.fecha', 'asc')
            ->select('transacciones.fecha', 'transacciones.monto', 'transacciones.tipo')
            ->get();

        if ($dias && $dias > 0) {
            $transacciones = $transacciones->filter(function($t) use ($dias) {
                return $t->fecha->greaterThanOrEqualTo(now()->subDays($dias));
            });
        }

        $saldo = 0;
        $historico = [];

        foreach ($transacciones as $tx) {
            $saldo += ($tx->tipo === 'ingreso' ? 1 : -1) * $tx->monto;
            $historico[] = [
                'fecha' => $tx->fecha->format('Y-m-d'),
                'saldo' => $saldo
            ];
        }

        return $historico;
    }

    // Top gastos
    private function obtenerTopGastos($usuario_id, $dias = null, $cuenta_id = null)
    {
        $query = $this->_queryTransaccionesPorUsuario($usuario_id)
            ->where('transacciones.tipo', 'gasto');

        if ($dias && $dias > 0) {
            $query->where('transacciones.fecha', '>=', now()->subDays((int)$dias));
        }

        if ($cuenta_id) {
            $query->where('transacciones.cuenta_id', $cuenta_id);
        }

        return $query
            ->select('id', 'monto', 'descripcion', 'fecha')
            ->orderBy('monto', 'desc')
            ->limit(10)
            ->get();
    }

    // Exportar datos
    public function exportarDatos(Request $request)
    {
        try {
            $usuario_id = Auth::id();
            $dias = $request->input('periodo', null);

            $query = $this->_queryTransaccionesPorUsuario($usuario_id)
                ->orderBy('transacciones.fecha', 'desc');

            if ($dias && $dias > 0) {
                $query->where('transacciones.fecha', '>=', now()->subDays((int)$dias));
            }

            $transacciones = $query->with(['cuenta', 'categoria'])->get();

            $csv = "Fecha,Cuenta,Categoría,Tipo,Monto,Descripción\n";
            foreach ($transacciones as $tx) {
                $csv .= sprintf(
                    '"%s","%s","%s","%s",%.2f,"%s"' . "\n",
                    $tx->fecha->format('Y-m-d'),
                    $tx->cuenta?->nombre ?? '',
                    $tx->categoria?->nombre ?? '',
                    $tx->tipo,
                    $tx->monto,
                    str_replace('"', '""', $tx->descripcion ?? '')
                );
            }

            return response($csv, 200)
                ->header('Content-Type', 'text/csv')
                ->header('Content-Disposition', 'attachment; filename="reporte-' . now()->format('Y-m-d') . '.csv"');
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
