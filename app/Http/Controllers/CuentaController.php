<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cuenta;

class CuentaController extends Controller
{
    public function index()
    {
        $cuentas = Cuenta::all();
        return view('cuentas.index', compact('cuentas'));
    }

    public function create()
    {
        return view('cuentas.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nombre' => 'required|string|max:255',
            'saldo_inicial' => 'required|numeric',
            'descripcion' => 'nullable|string',
        ]);

        $data['saldo_actual'] = $data['saldo_inicial'];

        Cuenta::create($data);
        return redirect()->route('cuentas.index')->with('success', 'Cuenta creada correctamente.');
    }

    public function edit(Cuenta $cuenta)
    {
        return view('cuentas.edit', compact('cuenta'));
    }

    public function update(Request $request, Cuenta $cuenta)
    {
        $data = $request->validate([
            'nombre' => 'required|string|max:255',
            'saldo_inicial' => 'required|numeric',
            'descripcion' => 'nullable|string',
        ]);

        $cuenta->update($data);
        return redirect()->route('cuentas.index')->with('success', 'Cuenta actualizada correctamente.');
    }

    public function destroy(Cuenta $cuenta)
    {
        $cuenta->delete();
        return redirect()->route('cuentas.index')->with('success', 'Cuenta eliminada.');
    }
}
