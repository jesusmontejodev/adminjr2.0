<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Categoria;
use App\Models\Cuenta;
use App\Models\NumerosWhatsApp;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class UserDataController extends Controller
{
    /**
     * Obtener todos los datos del usuario por número de teléfono
     */
    public function getUserDataByPhone(Request $request, string $numero): JsonResponse
    {
        try {
            // Normalizar el número
            $numeroNormalizado = $this->normalizarNumero($numero);

            // Buscar el usuario por su número de WhatsApp (con los nuevos campos)
            $user = $this->findUserByPhone($numeroNormalizado);

            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'Usuario no encontrado con este número',
                    'numero_buscado' => $numero,
                    'numero_normalizado' => $numeroNormalizado
                ], 404);
            }

            $data = [
                'usuario' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'telefono' => $numeroNormalizado,
                ],
                'categorias' => $this->getCategorias($user->id),
                'cuentas' => $this->getCuentas($user->id),
                'numeros_whatsapp' => $this->getNumerosWhatsApp($user->id),
            ];

            return response()->json([
                'success' => true,
                'numero_buscado' => $numero,
                'numero_normalizado' => $numeroNormalizado,
                'user_id' => $user->id,
                'data' => $data,
                'timestamp' => now()->toISOString(),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener datos del usuario',
                'numero_buscado' => $numero,
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Helper: Buscar usuario por número de teléfono (actualizado)
     */
    private function findUserByPhone(string $numero): ?User
    {
        $numeroNormalizado = $this->normalizarNumero($numero);

        // Buscar en los nuevos campos de numeros_whats_apps
        if (class_exists(NumerosWhatsApp::class)) {
            $numeroWhatsApp = NumerosWhatsApp::where(function($query) use ($numeroNormalizado) {
                // Buscar en cualquiera de los campos de número
                $query->where('numero_whatsapp', $numeroNormalizado)
                    ->orWhere('numero_internacional', $numeroNormalizado)
                    ->orWhereRaw("CONCAT(codigo_pais, numero_local) = ?", [$this->eliminarSignoMas($numeroNormalizado)])
                    ->orWhere('numero_local', $this->eliminarCodigoPais($numeroNormalizado));
            })->first();

            if ($numeroWhatsApp && $numeroWhatsApp->user_id) {
                return User::find($numeroWhatsApp->user_id);
            }
        }

        // Búsqueda alternativa en tabla users (si existe campo phone)
        return User::where('phone', $numeroNormalizado)
            ->orWhere('phone', 'like', '%' . $this->eliminarSignoMas($numeroNormalizado))
            ->first();
    }

    /**
     * Helper: Normalizar número de teléfono (mejorado)
     */
    private function normalizarNumero(string $numero): string
    {
        // Eliminar todo excepto números y signo +
        $normalizado = preg_replace('/[^\d+]/', '', $numero);

        // Si viene con 0 al inicio, eliminarlo
        $normalizado = ltrim($normalizado, '0');

        // Convertir diferentes formatos
        if (Str::startsWith($normalizado, '1')) {
            // Número local mexicano o americano
            if (strlen($normalizado) == 10 || strlen($normalizado) == 11) {
                // Número local mexicano (10 dígitos: 9992055875)
                $normalizado = '+52' . $normalizado;
            } elseif (strlen($normalizado) == 11) {
                // Número americano (11 dígitos: 15551234567)
                $normalizado = '+' . $normalizado;
            }
        } elseif (Str::startsWith($normalizado, '52') && !Str::startsWith($normalizado, '+')) {
            // Código México sin +
            $normalizado = '+' . $normalizado;
        } elseif (!Str::startsWith($normalizado, '+')) {
            // Si no tiene +, asumir que es número local mexicano
            $normalizado = '+52' . $normalizado;
        }

        // Asegurar formato estándar internacional
        return $normalizado;
    }

    /**
     * Helper: Eliminar el signo + del número
     */
    private function eliminarSignoMas(string $numero): string
    {
        return ltrim($numero, '+');
    }

    /**
     * Helper: Eliminar código de país para obtener número local
     */
    private function eliminarCodigoPais(string $numero): string
    {
        $numeroSinSigno = $this->eliminarSignoMas($numero);

        // Eliminar códigos de país comunes
        if (Str::startsWith($numeroSinSigno, '52')) {
            return substr($numeroSinSigno, 2);
        } elseif (Str::startsWith($numeroSinSigno, '1')) {
            return substr($numeroSinSigno, 1);
        }

        return $numeroSinSigno;
    }

    /**
     * Helper: Respuesta cuando no se encuentra el usuario
     */
    private function userNotFoundResponse(string $numero): JsonResponse
    {
        return response()->json([
            'success' => false,
            'message' => 'Usuario no encontrado con este número',
            'numero_buscado' => $numero,
            'numero_normalizado' => $this->normalizarNumero($numero),
            'formatos_soportados' => [
                'Internacional con +: +5219992055875',
                'WhatsApp sin +: 5219992055875',
                'Local: 9992055875',
                'Con código país sin +: 5219992055875'
            ],
            'sugerencias' => [
                'Verifica que el número esté correcto',
                'Prueba diferentes formatos',
                'Asegúrate de incluir el código de país para números internacionales'
            ]
        ], 404);
    }

    /**
     * Helper: Obtener números de WhatsApp formateados (actualizado)
     */
    private function getNumerosWhatsApp(int $userId): array
    {
        try {
            if (!class_exists(NumerosWhatsApp::class)) {
                return [];
            }

            return NumerosWhatsApp::where('user_id', $userId)
                ->get()
                ->map(function ($numero) {
                    return [
                        'id' => $numero->id,
                        'numero_whatsapp' => $numero->numero_whatsapp,
                        'numero_internacional' => $numero->numero_internacional,
                        'codigo_pais' => $numero->codigo_pais,
                        'numero_local' => $numero->numero_local,
                        'pais' => $numero->pais,
                        'etiqueta' => $numero->etiqueta,
                        'es_principal' => (bool)$numero->es_principal,
                        'created_at' => $numero->created_at->toISOString(),
                        'updated_at' => $numero->updated_at->toISOString(),
                        'formatos' => [
                            'whatsapp' => $numero->numero_whatsapp,
                            'internacional' => $numero->numero_internacional,
                            'local' => $numero->numero_local,
                            'llamada' => $numero->codigo_pais . $numero->numero_local
                        ]
                    ];
                })
                ->toArray();
        } catch (\Exception $e) {
            return [];
        }
    }

    /**
     * Helper: Obtener categorías formateadas
     */
    private function getCategorias(int $userId): array
    {
        try {
            return Categoria::where('id_user', $userId)
                ->get()
                ->map(function ($categoria) {
                    return [
                        'id' => $categoria->id,
                        'nombre' => $categoria->nombre,
                        'descripcion' => $categoria->descripcion,
                        'total_transacciones' => $categoria->total_transacciones, // ¡Corregido!
                        'created_at' => $categoria->created_at->toISOString(),
                        'updated_at' => $categoria->updated_at->toISOString(),
                    ];
                })
                ->toArray();
        } catch (\Exception $e) {
            // Para debug, puedes registrar el error
            // \Log::error('Error al obtener categorías: ' . $e->getMessage());
            return [];
        }
    }

    /**
     * Helper: Obtener cuentas formateadas
     */
    private function getCuentas(int $userId): array
    {
        try {
            return Cuenta::where('id_user', $userId)
                ->get()
                ->map(function ($cuenta) {
                    return [
                        'id' => $cuenta->id,
                        'nombre' => $cuenta->nombre,
                        'descripcion' => $cuenta->descripcion,
                        'saldo_inicial' => $cuenta->saldo_inicial,
                        'saldo_actual' => $cuenta->saldo_actual,
                        'created_at' => $cuenta->created_at->toISOString(),
                        'updated_at' => $cuenta->updated_at->toISOString(),
                    ];
                })
                ->toArray();
        } catch (\Exception $e) {
            return [];
        }
    }

    /**
     * Métodos de query string (permanecen igual)
     */
    public function getUserDataByPhoneQuery(Request $request): JsonResponse
    {
        $request->validate([
            'numero' => 'required|string'
        ]);

        $numero = $request->input('numero');
        return $this->getUserDataByPhone($request, $numero);
    }

    public function getCategoriasByPhoneQuery(Request $request): JsonResponse
    {
        $request->validate([
            'numero' => 'required|string'
        ]);

        $numero = $request->input('numero');
        return $this->getCategoriasByPhone($request, $numero);
    }

    public function getCuentasByPhoneQuery(Request $request): JsonResponse
    {
        $request->validate([
            'numero' => 'required|string'
        ]);

        $numero = $request->input('numero');
        return $this->getCuentasByPhone($request, $numero);
    }

    public function getNumerosWhatsAppByPhoneQuery(Request $request): JsonResponse
    {
        $request->validate([
            'numero' => 'required|string'
        ]);

        $numero = $request->input('numero');
        return $this->getNumerosWhatsAppByPhone($request, $numero);
    }
}
