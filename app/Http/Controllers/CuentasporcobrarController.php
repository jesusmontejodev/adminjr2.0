<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cuentasporcobrar;
use App\Models\Infocomisiones;

class CuentasporcobrarController extends Controller
{

    public function index()
    {
        $cuentas = Cuentasporcobrar::all();
        return view('cuentasporcobrar.index', compact('cuentas'));
    }

    public function show($id)
    {
        $cuenta = Cuentasporcobrar::findOrFail($id);
        return view('cuentasporcobrar.show', compact('cuenta'));
    }

    public function create()
    {
        return view('cuentasporcobrar.create');
    }

    public function edit($id)
    {
        $cuenta = Cuentasporcobrar::findOrFail($id);
        return view('cuentasporcobrar.edit', compact('cuenta'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre_clave' => 'required|string|max:255',
            'descripcion'  => 'nullable|string',
            'monto'        => 'required|numeric|min:0',
            'fecha'        => 'required|date',
            'concretado'   => 'required|boolean',
        ]);

        $cuenta = Cuentasporcobrar::findOrFail($id);
        $cuenta->update($request->all());

        return redirect()->route('cuentasporcobrar.index')->with('success', 'Cuenta actualizada correctamente.');
    }


    public function store(Request $request)
    {
        $request->validate([
            'comision_id' => 'required|exists:infocomisiones,id',
        ]);

        $comision = Infocomisiones::findOrFail($request->comision_id);

        Cuentasporcobrar::create([
            'nombre_clave' => "Venta de: {$comision->nombre}, Proyecto: {$comision->nombre_proyecto}",
            'descripcion'  => 'Transacción generada desde ventas.',
            'monto'        => $comision->precio,
            'fecha'        => now(),
            'concretado'   => false,
        ]);

        return redirect()->back()->with('success', 'Registro concretado.');
    }
}
