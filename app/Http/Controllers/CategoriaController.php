<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Categoria;

class CategoriaController extends Controller
{
    public function index()
    {
        // Filtrar solo las categorías del usuario autenticado
        $categorias = Categoria::where('id_user', auth()->id())->get();
        return view('categorias.index', compact('categorias'));
    }

    public function create()
    {
        return view('categorias.form');
    }

    public function edit(Categoria $categoria)
    {
        // Verificar que la categoría pertenece al usuario autenticado
        if ($categoria->id_user !== auth()->id()) {
            abort(403, 'No tienes permiso para editar esta categoría');
        }

        return view('categorias.form', compact('categoria'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string'
        ]);

        // Agregar automáticamente el id del usuario autenticado
        $data['id_user'] = auth()->id();

        Categoria::create($data);

        return redirect()->route('categorias.index')->with('success', 'Categoría creada correctamente.');
    }

    public function update(Request $request, Categoria $categoria)
    {
        // Verificar que la categoría pertenece al usuario autenticado
        if ($categoria->id_user !== auth()->id()) {
            abort(403, 'No tienes permiso para actualizar esta categoría');
        }

        $data = $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string'
        ]);

        $categoria->update($data);

        return redirect()->route('categorias.index')->with('success', 'Categoría actualizada correctamente.');
    }

    public function destroy(Categoria $categoria)
    {
        // Verificar que la categoría pertenece al usuario autenticado
        if ($categoria->id_user !== auth()->id()) {
            abort(403, 'No tienes permiso para eliminar esta categoría');
        }

        $categoria->delete();
        return redirect()->route('categorias.index')->with('success', 'Categoría eliminada correctamente.');
    }
}
