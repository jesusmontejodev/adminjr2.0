<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Infocomisiones;
use App\Models\Transaccion;
use App\Models\Cuenta;
use App\Models\Categoria;


class InfocomisionesController extends Controller
{
    //
    public function index()
    {
        $comisiones = Infocomisiones::all();
        return view( 'comisiones.index', compact('comisiones') );
    }

    public function create(){
        return view('comisiones.create');
    }

    public function edit($id)
    {
        $comision = Infocomisiones::findOrFail($id);
        return view('comisiones.edit', compact('comision'));
    }

    public function concretarView($id)
    {
        $cuentas = Cuenta::all();
        $categorias = Categoria::all();
        $comision = Infocomisiones::findOrFail($id);

        return view('comisiones.concretar', compact('comision', 'cuentas', 'categorias'));
    }

public function concretar(Request $request, $id)
{
    $comision = Infocomisiones::findOrFail($id);

    $data = $request->validate([
        'cuenta_id'    => 'required|exists:cuentas,id',
        'categoria_id' => 'required|exists:categorias,id',
        'monto'        => 'required|numeric|min:0',
        'descripcion'  => 'nullable|string|max:500',
        'tipo'         => 'required|string|in:ingreso,gasto,inversion',
    ]);

    // Marcar comisión como concretada
    Infocomisiones::where('id', $id)->update(['concretado' => true]);

    // Crear la transacción
    $transaccion = Transaccion::create([
        'cuenta_id'    => $data['cuenta_id'],
        'categoria_id' => $data['categoria_id'],
        'monto'        => $data['monto'],
        'descripcion'  => $data['descripcion'] ?? null,
        'fecha'        => now(),
        'tipo'         => $data['tipo'],
    ]);

    // Actualizar el saldo de la cuenta
    $cuenta = Cuenta::findOrFail($data['cuenta_id']);
    if ($data['tipo'] === 'ingreso') {
        $cuenta->saldo_actual += $data['monto'];
    } elseif ($data['tipo'] === 'gasto' || $data['tipo'] === 'inversion') {
        $cuenta->saldo_actual -= $data['monto'];
    }
    $cuenta->save();

    return redirect()
        ->route('comisiones.index')
        ->with('success', 'La comisión se concretó y la transacción fue registrada con éxito.');
}


    public function store(Request $request)
    {
        $data = $request->validate([
            'nombre'          => 'required|string|max:255',
            'lote'            => 'required|string|max:255',
            'nombre_proyecto' => 'required|string|max:255',
            'modelo'          => 'required|string|max:255',
            'cliente'         => 'required|string|max:255',
            'precio'          => 'required|numeric|min:0',
            'apartado'        => 'required|date',
            'enganche'        => 'required|date',
            'contrato'        => 'required|date',
            'observaciones'   => 'nullable|string|max:500',
        ]);

        Infocomisiones::create($data);

        return redirect()->route('comisiones.index')
            ->with('success', 'Registro creado con éxito');
    }


    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'nombre'          => 'required|string|max:255',
            'lote'            => 'required|numeric',
            'nombre_proyecto' => 'required|string|max:255',
            'modelo'          => 'required|string|max:255',
            'cliente'         => 'required|string|max:255',
            'precio'          => 'required|numeric|min:0',
            'apartado'        => 'required|date',
            'enganche'        => 'required|date',
            'contrato'        => 'required|date',
            'observaciones'   => 'nullable|string|max:500',
        ]);

        $comision = Infocomisiones::findOrFail($id);
        $comision->update($data);

        return redirect()->route('comisiones.index')
            ->with('success', 'Registro actualizado con éxito');
    }


    public function destroy($id)
    {
        $comision = Infocomisiones::findOrFail($id);
        $comision->delete();

        return redirect()->route('comisiones.index')
            ->with('success', 'Registro eliminado con éxito');
    }

}
