<?php

namespace App\Http\Controllers;

use App\Models\Transaccion;
use App\Models\Cuenta;
use App\Models\Categoria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class TransaccionController extends Controller
{
    public function index(Request $request)
    {
        $query = Transaccion::with(['cuenta', 'categoria']);

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
            $query->where('cuenta_id', $request->input('cuenta_id'));
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

        $transacciones = $query->get();

        // Obtener datos para los filtros
        $cuentas = Cuenta::all();
        $categorias = Categoria::all();
        $tipos = ['ingreso', 'gasto', 'inversion'];

        return view('transacciones.index', compact(
            'transacciones',
            'cuentas',
            'categorias',
            'tipos'
        ));
    }

    public function create()
    {
        $cuentas = Cuenta::all();
        $categorias = Categoria::all();
        return view('transacciones.create', compact('cuentas', 'categorias'));
    }

    public function edit(Transaccion $transaccion)
    {
        $cuentas = Cuenta::all();
        $categorias = Categoria::all();

        return view('transacciones.edit', compact('transaccion', 'cuentas', 'categorias'));
    }


    public function store(Request $request)
    {
        $data = $request->validate([
            'cuenta_id'    => 'required|exists:cuentas,id',
            'categoria_id' => 'required|exists:categorias,id',
            'monto'        => 'required|numeric|min:0',
            'descripcion'  => 'nullable|string',
            'tipo'         => 'required|string|in:ingreso,gasto,inversion',
            'fecha'        => 'required|date',
        ]);

        $transaccion = Transaccion::create([
            'cuenta_id'    => $data['cuenta_id'],
            'categoria_id' => $data['categoria_id'],
            'monto'        => $data['monto'],
            'descripcion'  => $data['descripcion'] ?? null,
            'fecha'        => $data['fecha'],
            'tipo'         => $data['tipo'],
        ]);

        $cuenta = Cuenta::findOrFail($data['cuenta_id']);

        if ($data['tipo'] === 'ingreso') {
            $cuenta->saldo_actual += $data['monto'];
        } elseif (in_array($data['tipo'], ['gasto', 'inversion'])) {
            $cuenta->saldo_actual -= $data['monto'];
        }

        $cuenta->save();

        return redirect()
            ->route('transacciones.index')
            ->with('success', 'Transacción registrada correctamente.');
    }

    public function update(Request $request, Transaccion $transaccion)
    {
        $data = $request->validate([
            'cuenta_id'    => 'required|exists:cuentas,id',
            'categoria_id' => 'required|exists:categorias,id',
            'monto'        => 'required|numeric|min:0',
            'descripcion'  => 'nullable|string',
            'tipo'         => 'required|string|in:ingreso,gasto,inversion',
            'fecha'        => 'required|date', // ✅ añadimos validación de fecha
        ]);

        DB::transaction(function () use ($data, $transaccion) {
            // Revertir saldo anterior
            $cuenta_old = Cuenta::find($transaccion->cuenta_id);
            if ($cuenta_old) {
                if ($transaccion->tipo === 'ingreso') {
                    $cuenta_old->saldo_actual -= $transaccion->monto;
                } elseif (in_array($transaccion->tipo, ['gasto', 'inversion'])) {
                    $cuenta_old->saldo_actual += $transaccion->monto;
                }
                $cuenta_old->save();
            }

            // Actualizar transacción (incluyendo la fecha del request)
            $transaccion->update([
                'cuenta_id'    => $data['cuenta_id'],
                'categoria_id' => $data['categoria_id'],
                'monto'        => $data['monto'],
                'descripcion'  => $data['descripcion'] ?? null,
                'tipo'         => $data['tipo'],
                'fecha'        => $data['fecha'], // ✅ ahora se actualiza la fecha también
            ]);

            // Aplicar saldo nuevo
            $cuenta_new = Cuenta::find($data['cuenta_id']);
            if ($cuenta_new) {
                if ($data['tipo'] === 'ingreso') {
                    $cuenta_new->saldo_actual += $data['monto'];
                } elseif (in_array($data['tipo'], ['gasto', 'inversion'])) {
                    $cuenta_new->saldo_actual -= $data['monto'];
                }
                $cuenta_new->save();
            }
        });

        return redirect()
            ->route('transacciones.index')
            ->with('success', 'Transacción actualizada correctamente.');
    }

    public function destroy($id)
    {
        $transaccion = Transaccion::findOrFail($id);

        $cuenta = Cuenta::find($transaccion->cuenta_id);
        if ($cuenta) {
            if ($transaccion->tipo === 'ingreso') {
                $cuenta->saldo_actual -= $transaccion->monto;
            } elseif ($transaccion->tipo === 'gasto') {
                $cuenta->saldo_actual += $transaccion->monto;
            }
            $cuenta->save();
        }

        $transaccion->delete();

        return redirect()->route('transacciones.index')->with('success', 'Transacción eliminada correctamente.');
    }


}
