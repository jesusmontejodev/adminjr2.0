<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class VerifyN8nToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // 1. Verificar que el token existe en el header
        $token = $request->bearerToken();

        if (!$token) {
            return response()->json([
                'success' => false,
                'message' => 'Token de acceso no proporcionado',
                'error_code' => 'MISSING_TOKEN'
            ], 401);
        }

        // 2. Verificar IP si está configurado (opcional pero recomendado)
        $allowedIps = config('api.n8n_allowed_ips', []);

        if (!empty($allowedIps)) {
            $clientIp = $request->ip();

            if (!in_array($clientIp, $allowedIps)) {
                Log::warning('Intento de acceso n8n desde IP no autorizada', [
                    'ip' => $clientIp,
                    'token_provided' => substr($token, 0, 10) . '...',
                    'path' => $request->path(),
                    'user_agent' => $request->header('User-Agent')
                ]);

                return response()->json([
                    'success' => false,
                    'message' => 'IP no autorizada para acceso API',
                    'error_code' => 'IP_NOT_ALLOWED',
                    'client_ip' => $clientIp
                ], 403);
            }
        }

        // 3. Sanctum ya valida el token automáticamente
        // El middleware 'auth:sanctum' se encargará de esto

        // 4. Registrar la petición para auditoría (opcional)
        $this->logRequest($request);

        return $next($request);
    }

    /**
     * Registrar petición para auditoría
     */
    private function logRequest(Request $request)
    {
        // Solo registrar en entorno de producción o si está habilitado
        if (config('api.log_n8n_requests', false)) {
            Log::channel('n8n')->info('API Request', [
                'method' => $request->method(),
                'path' => $request->path(),
                'ip' => $request->ip(),
                'user_agent' => $request->header('User-Agent'),
                'timestamp' => now()->toISOString(),
                'payload_size' => strlen($request->getContent())
            ]);
        }
    }
}
