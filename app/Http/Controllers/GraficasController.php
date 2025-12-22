<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaccion;
use App\Models\Cuenta;
use Illuminate\Support\Facades\DB;

class GraficasController extends Controller
{
    public function index()
    {
        $transacciones = Transaccion::with(['cuenta', 'categoria'])
            ->latest()
            ->get();

        $cuentas = Cuenta::all();

        // Datos para gráficos
        $datosGraficos = $this->obtenerDatosGraficos();

        return view('analistajr.index', compact('transacciones', 'cuentas', 'datosGraficos'));
    }

    public function obtenerDatosApi()
    {
        try {
            $transacciones = Transaccion::with(['cuenta', 'categoria'])->get();
            $cuentas = Cuenta::all();

            $datosGraficos = $this->obtenerDatosGraficos();

            return response()->json([
                'success' => true,
                'transacciones' => $transacciones,
                'cuentas' => $cuentas,
                'graficos' => $datosGraficos
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }

    private function obtenerDatosGraficos()
    {
        // Resumen general
        $resumen = [
            'total_transacciones' => Transaccion::count(),
            'total_ingresos' => Transaccion::where('tipo', 'ingreso')->sum('monto'),
            'total_gastos' => Transaccion::where('tipo', 'gasto')->sum('monto'),
            'balance_total' => Transaccion::where('tipo', 'ingreso')->sum('monto') -
                            Transaccion::where('tipo', 'gasto')->sum('monto')
        ];

        // Por categoría
        $porCategoria = Transaccion::with('categoria')
            ->select('categoria_id', DB::raw('SUM(monto) as monto_total'), DB::raw('COUNT(*) as total'))
            ->groupBy('categoria_id')
            ->get()
            ->map(function($item) {
                return [
                    'categoria' => $item->categoria,
                    'monto_total' => $item->monto_total,
                    'total' => $item->total
                ];
            });

        // Por tipo
        $porTipo = Transaccion::select('tipo', DB::raw('SUM(monto) as monto_total'), DB::raw('COUNT(*) as total'))
            ->groupBy('tipo')
            ->get();

        // Flujo mensual (últimos 6 meses)
        $flujoMensual = Transaccion::select(
                DB::raw('YEAR(fecha) as year'),
                DB::raw('MONTH(fecha) as month'),
                'tipo',
                DB::raw('SUM(monto) as total')
            )
            ->where('fecha', '>=', now()->subMonths(6))
            ->groupBy('year', 'month', 'tipo')
            ->orderBy('year', 'desc')
            ->orderBy('month', 'desc')
            ->get();

        return [
            'resumen' => $resumen,
            'por_categoria' => $porCategoria,
            'por_tipo' => $porTipo,
            'flujo_mensual' => $flujoMensual
        ];
    }
}
