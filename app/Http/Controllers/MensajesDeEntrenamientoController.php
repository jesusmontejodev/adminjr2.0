<?php

namespace App\Http\Controllers;

use App\Models\MensajesDeEntrenamiento;
use App\Models\Cuenta;
use App\Models\Categoria;
use Illuminate\Http\Request;

class MensajesDeEntrenamientoController extends Controller
{
    public function index()
    {
        $mensajes = MensajesDeEntrenamiento::all();
        return view('mensajes.index', compact('mensajes'));
    }

    public function create()
    {
        $cuentas = Cuenta::all();
        $categorias = Categoria::all();
        return view('mensajes.create', compact('cuentas', 'categorias'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'mensaje'   => 'required|string',
            'categoria' => 'required|string',
            'cuenta'    => 'required|string',
            'monto'     => 'required|numeric',
            'tipo'      => 'required|string'
        ]);

        MensajesDeEntrenamiento::create($data);

        return redirect()->route('mensajes.index')->with('success', 'Mensaje creado correctamente');
    }


    public function edit($id)
    {
        $mensaje = MensajesDeEntrenamiento::findOrFail($id);
        $cuentas = Cuenta::all();
        $categorias = Categoria::all();
        return view('mensajes.edit', compact('mensaje', 'cuentas', 'categorias'));
    }


    public function update(Request $request, $id)
    {
        $mensaje = MensajesDeEntrenamiento::findOrFail($id);

        $data = $request->validate([
            'mensaje'   => 'required|string',
            'categoria' => 'required|string',
            'cuenta'    => 'required|string',
            'monto'     => 'required|numeric',
            'tipo'      => 'required|string'
        ]);

        $mensaje->update($data);

        return redirect()->route('mensajes.index')->with('success', 'Mensaje actualizado correctamente');
    }

    public function destroy($id)
    {
        $mensaje = MensajesDeEntrenamiento::findOrFail($id);
        $mensaje->delete();

        return redirect()->route('mensajes.index')->with('success', 'Mensaje eliminado correctamente');
    }
}
