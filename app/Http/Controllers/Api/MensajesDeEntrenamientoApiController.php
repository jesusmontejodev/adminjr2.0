<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\MensajesDeEntrenamiento;
use App\Models\Cuenta;
use App\Models\Categoria;

use Illuminate\Http\Request;

class MensajesDeEntrenamientoApiController extends Controller
{
    public function index()
    {
        $cuentas = Cuenta::All();
	$categorias = Categoria::All();
            

        return response()->json([
            'Cuentas' => $cuentas,
	    'Categorias' => $categorias
        ], 200);
    }




    public function store(Request $request)
    {
        $data = $request->validate([
            'mensaje'   => 'required|string',
            'categoria' => 'required|string',
            'cuenta'    => 'required|string',
            'monto'     => 'required|numeric',
        ]);

        $mensaje = MensajesDeEntrenamiento::create($data);

        return response()->json($mensaje, 201);
    }

    public function show($id)
    {
        $mensaje = MensajesDeEntrenamiento::find($id);

        if (!$mensaje) {
            return response()->json(['error' => 'No encontrado'], 404);
        }

        return response()->json([
            'ejemplos' => $mensaje
        ], 200);
    }


    public function update(Request $request, $id)
    {
        $mensaje = MensajesDeEntrenamiento::find($id);

        if (!$mensaje) {
            return response()->json(['error' => 'No encontrado'], 404);
        }

        $data = $request->validate([
            'mensaje'   => 'sometimes|string',
            'categoria' => 'sometimes|string',
            'cuenta'    => 'sometimes|string',
            'monto'     => 'sometimes|numeric',
        ]);

        $mensaje->update($data);

        return response()->json($mensaje, 200);
    }

    public function destroy($id)
    {
        $mensaje = MensajesDeEntrenamiento::find($id);

        if (!$mensaje) {
            return response()->json(['error' => 'No encontrado'], 404);
        }

        $mensaje->delete();

        return response()->json(['message' => 'Eliminado correctamente'], 200);
    }
}
