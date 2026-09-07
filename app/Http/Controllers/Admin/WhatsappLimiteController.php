<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class WhatsappLimiteController extends Controller
{
    public function index(Request $request)
    {
        $busqueda = trim((string) $request->query('q', ''));

        $usuarios = collect();
        if ($busqueda !== '') {
            $usuarios = User::query()
                ->where('name', 'like', "%{$busqueda}%")
                ->orWhere('email', 'like', "%{$busqueda}%")
                ->withCount('numerosWhatsApp')
                ->orderBy('name')
                ->limit(20)
                ->get();
        }

        return view('admin.whatsapp-limites', [
            'busqueda' => $busqueda,
            'usuarios' => $usuarios,
        ]);
    }

    public function update(Request $request, User $usuario)
    {
        $validated = $request->validate([
            'limite_whatsapp_override' => 'nullable|integer|min:0|max:100',
        ]);

        $usuario->limite_whatsapp_override = $validated['limite_whatsapp_override'] ?? null;
        $usuario->save();

        return redirect()
            ->route('admin.whatsapp-limites.index', ['q' => $request->input('q')])
            ->with('success', "Límite de WhatsApp de {$usuario->name} actualizado.");
    }
}
