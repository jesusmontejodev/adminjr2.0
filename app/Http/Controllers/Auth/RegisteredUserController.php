<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        Log::info('Iniciando proceso de registro', ['email' => $request->email]);

        // Determinar el código de país
        $countryCode = $request->country_code;
        if ($request->country_code === 'other' && $request->filled('custom_country_code')) {
            $countryCode = $request->custom_country_code;
        }

        Log::debug('Country code procesado', ['country_code' => $countryCode]);

        // Reglas de validación
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ];

        // Validar teléfono si existe
        $hasPhone = $request->filled('phone_number') || ($request->filled('country_code') && $request->country_code !== '');
        Log::debug('Has phone check', ['has_phone' => $hasPhone, 'phone' => $request->phone_number, 'country' => $request->country_code]);

        if ($hasPhone) {
            $rules['phone_number'] = ['required', 'string', 'max:20', 'regex:/^[0-9\s\-\+\(\)\.]{7,20}$/'];

            if ($countryCode && $countryCode !== 'other') {
                Log::debug('Agregando regla para country code', ['country_code' => $countryCode]);
            }
        }

        // Validar
        try {
            Log::debug('Validando datos del request', $request->all());
            $validated = $request->validate($rules, [
                'phone_number.regex' => 'El número de teléfono solo puede contener dígitos, espacios, guiones y paréntesis',
                'country_code_field.regex' => 'El código de país debe tener el formato +XXX (ej: +1, +34, +52)',
            ]);
            Log::debug('Validación exitosa', $validated);
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Error de validación', ['errors' => $e->errors()]);
            throw $e;
        }

        // Limpiar teléfono
        $cleanPhoneNumber = null;
        if ($request->filled('phone_number')) {
            $cleanPhoneNumber = preg_replace('/[^0-9]/', '', $request->phone_number);
            Log::debug('Teléfono limpiado', ['original' => $request->phone_number, 'limpio' => $cleanPhoneNumber]);

            if (strlen($cleanPhoneNumber) < 7 || strlen($cleanPhoneNumber) > 15) {
                Log::warning('Teléfono con longitud inválida', ['longitud' => strlen($cleanPhoneNumber)]);
                return back()->withErrors([
                    'phone_number' => 'El número de teléfono debe tener entre 7 y 15 dígitos.',
                ])->withInput();
            }
        }

        // Crear usuario
        $userData = [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ];

        // Agregar teléfono si existe
        if ($cleanPhoneNumber && $countryCode && $countryCode !== 'other') {
            $userData['phone_number'] = $cleanPhoneNumber;
            $userData['country_code'] = $countryCode;
            Log::debug('Agregando teléfono al usuario', ['phone' => $cleanPhoneNumber, 'country' => $countryCode]);
        }

        try {
            Log::debug('Creando usuario', ['data' => array_merge($userData, ['password' => '***'])]);
            $user = User::create($userData);
            Log::info('Usuario creado exitosamente', ['user_id' => $user->id, 'email' => $user->email]);
        } catch (\Exception $e) {
            Log::error('Error al crear usuario', ['error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            throw $e;
        }

        event(new Registered($user));

        // ENVIAR A GOHIGHLEVEL (VERSIÓN SIMPLE - SINCRONO)
        $webhookUrl = env('WEBHOOK_CONTACTO_GHL');
        Log::debug('URL Webhook', ['url' => $webhookUrl ? 'Definida' : 'No definida']);

        if ($webhookUrl) {
            try {
                $fullPhone = null;
                if ($user->phone_number && $user->country_code) {
                    $fullPhone = $user->country_code . $user->phone_number;
                }

                $data = [
                    'name' => $user->name,
                    'email' => $user->email,
                    'phone' => $fullPhone,
                    'source' => 'Website Registration',
                    'user_id' => $user->id,
                ];

                Log::debug('Enviando a GHL', $data);

                // Envío simple y directo con timeout corto
                $response = Http::timeout(5)->post($webhookUrl, $data);
                Log::info('Respuesta GHL', [
                    'status' => $response->status(),
                    'body' => $response->body(),
                ]);

            } catch (\Exception $e) {
                Log::warning('Error al enviar a GHL', [
                    'error' => $e->getMessage(),
                    'url' => $webhookUrl
                ]);
            }
        } else {
            Log::warning('WEBHOOK_CONTACTO_GHL no está definido en .env');
        }

        Auth::login($user);
        Log::info('Usuario autenticado y redirigiendo a dashboard', ['user_id' => $user->id]);

        return redirect(route('dashboard', absolute: false));
    }
}
