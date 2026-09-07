<?php

namespace App\Http\Controllers;

use App\Models\Cuenta;
use App\Models\Transaccion;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        $cuentas = Cuenta::where('id_user', $userId)->get();
        $saldoTotal = $cuentas->sum('saldo_actual');
        $cuentasActivas = $cuentas->count();

        $inicioMes = now()->startOfMonth();
        $finMes = now()->endOfMonth();

        $transaccionesUsuario = fn () => Transaccion::whereHas('cuenta', function ($q) use ($userId) {
            $q->where('id_user', $userId);
        });

        $ingresosMes = $transaccionesUsuario()
            ->where('tipo', 'ingreso')
            ->whereBetween('fecha', [$inicioMes, $finMes])
            ->sum('monto');

        $egresosMes = $transaccionesUsuario()
            ->where('tipo', 'egreso')
            ->whereBetween('fecha', [$inicioMes, $finMes])
            ->sum('monto');

        $actividadReciente = $transaccionesUsuario()
            ->with(['cuenta', 'categoria'])
            ->orderByDesc('fecha')
            ->orderByDesc('created_at')
            ->limit(5)
            ->get();

        $fechasActivas = $transaccionesUsuario()
            ->select('fecha')
            ->distinct()
            ->get()
            ->pluck('fecha')
            ->sort()
            ->values();

        $racha = $this->calcularRacha($fechasActivas);

        return view('dashboard', [
            'saldoTotal' => $saldoTotal,
            'cuentasActivas' => $cuentasActivas,
            'ingresosMes' => $ingresosMes,
            'egresosMes' => $egresosMes,
            'balanceMes' => $ingresosMes - $egresosMes,
            'actividadReciente' => $actividadReciente,
            'racha' => $racha,
        ]);
    }

    /**
     * Calcula la racha de disciplina financiera a partir de las fechas
     * (ordenadas ascendente, sin duplicados) en que el usuario registró
     * al menos una transacción.
     */
    private function calcularRacha($fechasActivas): array
    {
        $fechaSet = $fechasActivas
            ->map(fn (Carbon $fecha) => $fecha->format('Y-m-d'))
            ->flip();

        // Racha actual: cuenta hacia atrás desde hoy. Si hoy aún no tiene
        // registro, se permite empezar desde ayer para no "romper" la racha
        // antes de que termine el día.
        $rachaActual = 0;
        $cursor = now()->startOfDay();
        if (!$fechaSet->has($cursor->format('Y-m-d'))) {
            $cursor = $cursor->subDay();
        }
        while ($fechaSet->has($cursor->format('Y-m-d'))) {
            $rachaActual++;
            $cursor = $cursor->subDay();
        }

        // Mejor racha histórica: la corrida consecutiva más larga.
        $mejorRacha = 0;
        $rachaTemp = 0;
        $anterior = null;
        foreach ($fechasActivas as $fecha) {
            $rachaTemp = ($anterior !== null && abs($fecha->diffInDays($anterior)) == 1)
                ? $rachaTemp + 1
                : 1;
            $mejorRacha = max($mejorRacha, $rachaTemp);
            $anterior = $fecha;
        }

        // Últimos 7 días, para el mini calendario de actividad.
        $ultimos7Dias = collect(range(6, 0))->map(function (int $i) use ($fechaSet) {
            $dia = now()->subDays($i)->startOfDay();
            return [
                'etiqueta' => $dia->isoFormat('dd'),
                'activo' => $fechaSet->has($dia->format('Y-m-d')),
                'esHoy' => $i === 0,
            ];
        });

        return [
            'actual' => $rachaActual,
            'mejor' => $mejorRacha,
            'totalDiasActivos' => $fechasActivas->count(),
            'ultimos7Dias' => $ultimos7Dias,
            'activaHoy' => $fechaSet->has(now()->format('Y-m-d')),
        ];
    }
}
