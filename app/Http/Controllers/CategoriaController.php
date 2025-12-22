<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Categoria;

class CategoriaController extends Controller
{
    public function index()
    {
        $categorias = Categoria::all();
        return view('categorias.index', compact('categorias'));
    }

    public function create()
    {
        return view('categorias.form'); // sin $categoria
    }


    public function store(Request $request)
    {
        $data = $request->validate([
            'nombre' => 'required|string|max:255'
        ]);

        Categoria::create($data);

        return redirect()->route('categorias.index')->with('success', 'Categoría creada correctamente.');
    }

    public function edit(Categoria $categoria)
    {
        // Depuración: verificar el valor de tipo
        // dd($categoria->tipo); // o dd($categoria);
        return view('categorias.form', compact('categoria'));
    }

    public function update(Request $request, Categoria $categoria)
    {


        $data = $request->validate([
            'nombre' => 'required|string|max:255'
        ]);

        $categoria->update($data);


        // dd($data); // Muestra todo el objeto y termina la ejecución
        return redirect()->route('categorias.index')->with('success', 'Categoría actualizada correctamente.');
    }

    public function destroy(Categoria $categoria)
    {
        $categoria->delete();
        return redirect()->route('categorias.index')->with('success', 'Categoría eliminada correctamente.');
    }
}
