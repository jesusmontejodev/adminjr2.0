<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class McpTokenController extends Controller
{
    private const DURACIONES_DIAS = [
        '7' => 7,
        '30' => 30,
        '90' => 90,
        '365' => 365,
    ];

    public function index(Request $request)
    {
        $user = Auth::user();

        $tokens = $user->tokens()->orderByDesc('created_at')->get();

        return view('mcp-tokens.index', [
            'tokens' => $tokens,
            'terminosAceptados' => !is_null($user->mcp_terms_accepted_at),
            'nuevoToken' => session('mcp_token_plano'),
        ]);
    }

    public function aceptarTerminos(Request $request)
    {
        $user = Auth::user();
        $user->forceFill(['mcp_terms_accepted_at' => now()])->save();

        return redirect()->route('mcp-tokens.index')
            ->with('status', 'Términos aceptados. Ya puedes crear tokens de acceso.');
    }

    public function store(Request $request)
    {
        $user = Auth::user();

        if (is_null($user->mcp_terms_accepted_at)) {
            return redirect()->route('mcp-tokens.index')
                ->with('error', 'Primero debes leer y aceptar el aviso de riesgos y beneficios.');
        }

        $data = $request->validate([
            'name' => 'required|string|max:100',
            'description' => 'required|string|max:1000',
            'modo' => ['required', Rule::in(['solo_lectura', 'lectura_escritura'])],
            'duracion' => ['required', Rule::in(array_keys(self::DURACIONES_DIAS))],
        ], [], [
            'name' => 'nombre',
            'description' => 'descripción',
            'modo' => 'modo de acceso',
            'duracion' => 'duración',
        ]);

        $abilities = $data['modo'] === 'lectura_escritura'
            ? ['read:own', 'write:own']
            : ['read:own'];

        $expiresAt = now()->addDays(self::DURACIONES_DIAS[$data['duracion']]);

        $nuevoToken = $user->createToken($data['name'], $abilities, $expiresAt);

        $nuevoToken->accessToken->forceFill([
            'description' => $data['description'],
        ])->save();

        return redirect()->route('mcp-tokens.index')
            ->with('status', 'Token creado correctamente. Cópialo ahora, no se volverá a mostrar.')
            ->with('mcp_token_plano', $nuevoToken->plainTextToken);
    }

    public function destroy(Request $request, int $tokenId)
    {
        $user = Auth::user();

        $token = $user->tokens()->where('id', $tokenId)->first();

        if (!$token) {
            return redirect()->route('mcp-tokens.index')
                ->with('error', 'El token no existe o no te pertenece.');
        }

        $token->delete();

        return redirect()->route('mcp-tokens.index')
            ->with('status', 'Token revocado.');
    }
}
