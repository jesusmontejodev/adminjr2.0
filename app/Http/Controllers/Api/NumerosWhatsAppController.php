<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\NumerosWhatsApp;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class NumerosWhatsAppController extends Controller
{
    /**
     * Obtener todos los números de WhatsApp de un usuario
     */
    public function index(Request $request): JsonResponse
    {
        $user = $request->user();

        $numeros = NumerosWhatsApp::where('user_id', $user->id)
            ->orderBy('es_principal', 'desc')
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $numeros,
            'count' => $numeros->count()
        ]);
    }

    /**
     * Crear un nuevo número de WhatsApp
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'numero_whatsapp' => 'required|string|max:20',
            'numero_internacional' => 'required|string|max:20',
            'codigo_pais' => 'required|string|max:5',
            'numero_local' => 'required|string|max:15',
            'pais' => 'required|string|size:2',
            'etiqueta' => 'nullable|string|max:50',
            'es_principal' => 'boolean'
        ]);

        $user = $request->user();

        // Si se marca como principal, quitar principal de otros números
        if ($request->boolean('es_principal')) {
            NumerosWhatsApp::where('user_id', $user->id)
                ->where('es_principal', true)
                ->update(['es_principal' => false]);
        }

        $numero = NumerosWhatsApp::create([
            'user_id' => $user->id,
            'numero_whatsapp' => $validated['numero_whatsapp'],
            'numero_internacional' => $validated['numero_internacional'],
            'codigo_pais' => $validated['codigo_pais'],
            'numero_local' => $validated['numero_local'],
            'pais' => $validated['pais'],
            'etiqueta' => $validated['etiqueta'] ?? null,
            'es_principal' => $validated['es_principal'] ?? false,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Número de WhatsApp creado exitosamente',
            'data' => $numero
        ], 201);
    }

    /**
     * Mostrar un número específico
     */
    public function show(NumerosWhatsApp $numerosWhatsApp): JsonResponse
    {
        // Verificar que el número pertenezca al usuario autenticado
        if ($numerosWhatsApp->user_id !== request()->user()->id) {
            return response()->json([
                'success' => false,
                'message' => 'No autorizado'
            ], 403);
        }

        return response()->json([
            'success' => true,
            'data' => $numerosWhatsApp
        ]);
    }

    /**
     * Actualizar un número de WhatsApp
     */
    public function update(Request $request, NumerosWhatsApp $numerosWhatsApp): JsonResponse
    {
        // Verificar que el número pertenezca al usuario autenticado
        if ($numerosWhatsApp->user_id !== $request->user()->id) {
            return response()->json([
                'success' => false,
                'message' => 'No autorizado'
            ], 403);
        }

        $validated = $request->validate([
            'numero_whatsapp' => 'sometimes|string|max:20',
            'numero_internacional' => 'sometimes|string|max:20',
            'codigo_pais' => 'sometimes|string|max:5',
            'numero_local' => 'sometimes|string|max:15',
            'pais' => 'sometimes|string|size:2',
            'etiqueta' => 'nullable|string|max:50',
            'es_principal' => 'boolean'
        ]);

        // Si se marca como principal, quitar principal de otros números
        if (isset($validated['es_principal']) && $validated['es_principal']) {
            NumerosWhatsApp::where('user_id', $request->user()->id)
                ->where('id', '!=', $numerosWhatsApp->id)
                ->where('es_principal', true)
                ->update(['es_principal' => false]);
        }

        $numerosWhatsApp->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Número de WhatsApp actualizado exitosamente',
            'data' => $numerosWhatsApp->fresh()
        ]);
    }

    /**
     * Eliminar un número de WhatsApp
     */
    public function destroy(NumerosWhatsApp $numerosWhatsApp): JsonResponse
    {
        // Verificar que el número pertenezca al usuario autenticado
        if ($numerosWhatsApp->user_id !== request()->user()->id) {
            return response()->json([
                'success' => false,
                'message' => 'No autorizado'
            ], 403);
        }

        // No permitir eliminar si es el único número
        $totalNumeros = NumerosWhatsApp::where('user_id', $numerosWhatsApp->user_id)->count();

        if ($totalNumeros <= 1) {
            return response()->json([
                'success' => false,
                'message' => 'No puedes eliminar tu único número de WhatsApp'
            ], 400);
        }

        // Si es el principal, marcar otro como principal
        if ($numerosWhatsApp->es_principal) {
            $nuevoPrincipal = NumerosWhatsApp::where('user_id', $numerosWhatsApp->user_id)
                ->where('id', '!=', $numerosWhatsApp->id)
                ->first();

            if ($nuevoPrincipal) {
                $nuevoPrincipal->update(['es_principal' => true]);
            }
        }

        $numerosWhatsApp->delete();

        return response()->json([
            'success' => true,
            'message' => 'Número de WhatsApp eliminado exitosamente'
        ]);
    }

    /**
     * Marcar un número como principal
     */
    public function marcarPrincipal(NumerosWhatsApp $numerosWhatsApp): JsonResponse
    {
        // Verificar que el número pertenezca al usuario autenticado
        if ($numerosWhatsApp->user_id !== request()->user()->id) {
            return response()->json([
                'success' => false,
                'message' => 'No autorizado'
            ], 403);
        }

        // Quitar principal de otros números
        NumerosWhatsApp::where('user_id', $numerosWhatsApp->user_id)
            ->where('id', '!=', $numerosWhatsApp->id)
            ->update(['es_principal' => false]);

        // Marcar este número como principal
        $numerosWhatsApp->update(['es_principal' => true]);

        return response()->json([
            'success' => true,
            'message' => 'Número marcado como principal',
            'data' => $numerosWhatsApp->fresh()
        ]);
    }

    /**
     * Validar y formatear un número de teléfono
     */
    public function validarNumero(Request $request): JsonResponse
    {
        $request->validate([
            'numero' => 'required|string'
        ]);

        $numero = $request->input('numero');

        // Lógica de validación y formateo
        $formateador = new \App\Services\NumeroWhatsAppFormatter();
        $resultado = $formateador->formatear($numero);

        return response()->json([
            'success' => true,
            'data' => $resultado
        ]);
    }
}
