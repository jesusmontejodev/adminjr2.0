<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use Carbon\Carbon;

class WebhookSuscripcionController extends Controller
{
    /**
     * Validar API Key del webhook
     */
    private function validateKey(Request $request)
    {
        $key = config('services.n8n.secret');
        if (!$key || $request->header('x-api-key') !== $key) {
            Log::warning('Webhook N8N: API Key inválida', [
                'received_key' => $request->header('x-api-key'),
                'expected_key' => $key
            ]);
            abort(403, 'Unauthorized');
        }
    }

    /**
     * Primer pago - Activar suscripción
     */
    public function primerPago(Request $request)
    {
        try {
            $this->validateKey($request);

            // Validar que email sea proporcionado
            $email = trim((string) $request->input('email'));
            if ($email === '') {
                Log::error('Webhook N8N: email no proporcionado');
                return response()->json(['error' => 'email es requerido'], 400);
            }

            $user = User::where('email', $email)->first();
            if (!$user) {
                Log::warning('Webhook N8N: Usuario no encontrado', ['email' => $email]);
                return response()->json(['error' => 'User not found'], 404);
            }

            // Actualizar solo los campos necesarios
            $user->estado_suscripcion = 'active';
            $user->access_until = now()->addDays(30);

            // Opcionalmente actualizar Stripe data si está disponible
            if ($request->filled('stripe_customer_id')) {
                $user->stripe_id = $request->stripe_customer_id;
            }
            if ($request->filled('subscription_id')) {
                $user->subscription_id = $request->subscription_id;
            }

            $user->save();

            Log::info('Webhook N8N: Primer pago procesado', [
                'user_id' => $user->id,
                'email' => $user->email,
                'estado_suscripcion' => $user->estado_suscripcion,
                'access_until' => $user->access_until
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Suscripción activada exitosamente',
                'user_id' => $user->id,
                'estado_suscripcion' => $user->attributes['estado_suscripcion'] ?? 'active',
                'access_until' => $user->access_until->format('Y-m-d H:i:s'),
                'estado_mostrado' => $user->estado_suscripcion
            ]);

        } catch (\Exception $e) {
            Log::error('Webhook N8N: Error en primerPago', [
                'error' => $e->getMessage(),
                'email' => $request->input('email') ?? 'N/A',
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'error' => 'Error al procesar el pago',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Renovación - Extender suscripción
     */
    public function renovacion(Request $request)
    {
        try {
            $this->validateKey($request);

            // Validar que email sea proporcionado
            $email = trim((string) $request->input('email'));
            if ($email === '') {
                Log::error('Webhook N8N: email no proporcionado en renovación');
                return response()->json(['error' => 'email es requerido'], 400);
            }

            $user = User::where('email', $email)->first();
            if (!$user) {
                Log::warning('Webhook N8N: Usuario no encontrado en renovación', ['email' => $email]);
                return response()->json(['error' => 'User not found'], 404);
            }

            // Mantener el estado como active
            $user->estado_suscripcion = 'active';

            // Extender 30 días desde la fecha actual de expiración, o desde hoy si ya expiró
            $accessUntil = $user->access_until instanceof Carbon
                ? $user->access_until
                : ($user->access_until ? Carbon::parse($user->access_until) : null);

            if ($accessUntil && $accessUntil > now()) {
                $user->access_until = $accessUntil->addDays(30);
            } else {
                $user->access_until = now()->addDays(30);
            }

            $user->save();

            Log::info('Webhook N8N: Renovación procesada', [
                'user_id' => $user->id,
                'email' => $user->email,
                'access_until' => $user->access_until
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Suscripción renovada exitosamente',
                'user_id' => $user->id,
                'estado_suscripcion' => $user->attributes['estado_suscripcion'] ?? 'active',
                'access_until' => $user->access_until->format('Y-m-d H:i:s'),
                'estado_mostrado' => $user->estado_suscripcion
            ]);

        } catch (\Exception $e) {
            Log::error('Webhook N8N: Error en renovación', [
                'error' => $e->getMessage(),
                'email' => $request->input('email') ?? 'N/A',
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'error' => 'Error al renovar suscripción',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Cancelación - Desactivar suscripción
     */
    public function cancelacion(Request $request)
    {
        try {
            $this->validateKey($request);

            // Validar que email sea proporcionado
            $email = trim((string) $request->input('email'));
            if ($email === '') {
                Log::error('Webhook N8N: email no proporcionado en cancelación');
                return response()->json(['error' => 'email es requerido'], 400);
            }

            $user = User::where('email', $email)->first();
            if (!$user) {
                Log::warning('Webhook N8N: Usuario no encontrado en cancelación', ['email' => $email]);
                return response()->json(['error' => 'User not found'], 404);
            }

            // Cambiar estado a cancelada
            $user->estado_suscripcion = 'cancelada';
            $user->access_until = now(); // Acceso vence inmediatamente
            $user->save();

            Log::info('Webhook N8N: Cancelación procesada', [
                'user_id' => $user->id,
                'email' => $user->email,
                'estado_suscripcion' => $user->estado_suscripcion
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Suscripción cancelada',
                'user_id' => $user->id,
                'estado_suscripcion' => $user->attributes['estado_suscripcion'] ?? 'cancelada',
                'estado_mostrado' => $user->estado_suscripcion
            ]);

        } catch (\Exception $e) {
            Log::error('Webhook N8N: Error en cancelación', [
                'error' => $e->getMessage(),
                'email' => $request->input('email') ?? 'N/A',
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'error' => 'Error al cancelar suscripción',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
