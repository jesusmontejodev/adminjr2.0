<x-guest-layout>

    <!-- CONTENEDOR ÚNICO -->
    <div class="login-card relative z-10 max-w-md mx-auto mt-16
                border border-red-500/30
                rounded-3xl
                px-8 py-10">

        <!-- Logo -->
        <div class="flex items-center justify-center gap-3 mb-4">
            <img src="{{ asset('avaspace.svg') }}" alt="" class="h-10">
        </div>

        <!-- Títulos -->
        <h1 class="text-center text-white text-xl font-bold mb-1">
            Crear cuenta en <span class="text-red-500">Admin Jr</span>
        </h1>

        <p class="text-center text-gray-400 text-sm mb-8">
            Regístrate para comenzar
        </p>

        <form method="POST" action="{{ route('register') }}" class="space-y-5">
            @csrf

            <!-- Name -->
            <div>
                <x-input-label for="name" value="Nombre" class="login-label" />
                <x-text-input
                    id="name"
                    class="login-input block w-full"
                    type="text"
                    name="name"
                    :value="old('name')"
                    required
                    autofocus
                    autocomplete="name" />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <!-- Email -->
            <div>
                <x-input-label for="email" value="Correo Electrónico" class="login-label" />
                <x-text-input
                    id="email"
                    class="login-input block w-full"
                    type="email"
                    name="email"
                    :value="old('email')"
                    required
                    autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Teléfono (Opcional) -->
            <div>
                <x-input-label for="phone" value="Teléfono (Opcional)" class="login-label" />

                <!-- Grupo de inputs para teléfono -->
                <div class="flex gap-2 mt-2">
                    <!-- Código de país -->
                    <div class="flex-1">
                        <select
                            id="country_code"
                            name="country_code"
                            class="login-input w-full text-gray-300 appearance-none cursor-pointer"
                            style="padding-right: 2.5rem;">
                            <option value="" class="bg-gray-900 text-gray-400">Código</option>
                            <option value="+1" {{ old('country_code') == '+1' ? 'selected' : '' }} class="bg-gray-900">+1 (USA/Canadá)</option>
                            <option value="+52" {{ old('country_code') == '+52' ? 'selected' : '' }} class="bg-gray-900">+52 (México)</option>
                            <option value="+34" {{ old('country_code') == '+34' ? 'selected' : '' }} class="bg-gray-900">+34 (España)</option>
                            <option value="+51" {{ old('country_code') == '+51' ? 'selected' : '' }} class="bg-gray-900">+51 (Perú)</option>
                            <option value="+56" {{ old('country_code') == '+56' ? 'selected' : '' }} class="bg-gray-900">+56 (Chile)</option>
                            <option value="+54" {{ old('country_code') == '+54' ? 'selected' : '' }} class="bg-gray-900">+54 (Argentina)</option>
                            <option value="+55" {{ old('country_code') == '+55' ? 'selected' : '' }} class="bg-gray-900">+55 (Brasil)</option>
                            <option value="+57" {{ old('country_code') == '+57' ? 'selected' : '' }} class="bg-gray-900">+57 (Colombia)</option>
                            <option value="other" {{ old('country_code') == 'other' ? 'selected' : '' }} class="bg-gray-900">Otro</option>
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-400">
                            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/>
                            </svg>
                        </div>
                    </div>

                    <!-- Número de teléfono -->
                    <div class="flex-2">
                        <x-text-input
                            id="phone_number"
                            class="login-input block w-full"
                            type="tel"
                            name="phone_number"
                            :value="old('phone_number')"
                            placeholder="Ej: 5512345678"
                            autocomplete="tel" />
                    </div>
                </div>

                <!-- Input para código de país personalizado (oculto inicialmente) -->
                <div id="custom-country-code" class="mt-2 hidden">
                    <x-input-label for="custom_country_code" value="Código de país personalizado" class="login-label" />
                    <x-text-input
                        id="custom_country_code"
                        class="login-input block w-full mt-1"
                        type="text"
                        name="custom_country_code"
                        :value="old('custom_country_code')"
                        placeholder="Ej: +44"
                        autocomplete="off" />
                </div>

                <!-- Mensaje informativo -->
                <p class="text-xs text-gray-500 mt-2">
                    Solo para notificaciones importantes. Ej: 55-1234-5678 o (55) 1234 5678
                </p>

                <!-- Errores -->
                <x-input-error :messages="$errors->get('country_code')" class="mt-2" />
                <x-input-error :messages="$errors->get('phone_number')" class="mt-2" />
            </div>

            <!-- Password -->
            <div>
                <x-input-label for="password" value="Contraseña" class="login-label" />
                <x-text-input
                    id="password"
                    class="login-input block w-full"
                    type="password"
                    name="password"
                    required
                    autocomplete="new-password" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Confirm Password -->
            <div>
                <x-input-label
                    for="password_confirmation"
                    value="Confirmar Contraseña"
                    class="login-label" />
                <x-text-input
                    id="password_confirmation"
                    class="login-input block w-full"
                    type="password"
                    name="password_confirmation"
                    required
                    autocomplete="new-password" />
                <x-input-error
                    :messages="$errors->get('password_confirmation')"
                    class="mt-2" />
            </div>

            <!-- Terms and Privacy -->
            <div class="mt-2">
                <p class="text-xs text-gray-500 text-center">
                    Al registrarte, aceptas nuestros
                    <a href="#" class="text-red-400 hover:text-red-300 transition">Términos de Servicio</a> y
                    <a href="#" class="text-red-400 hover:text-red-300 transition">Política de Privacidad</a>.
                </p>
            </div>

            <!-- Actions -->
            <div class="flex items-center justify-between pt-2">
                <a
                    href="{{ route('login') }}"
                    class="text-sm text-gray-400 hover:text-red-400 transition">
                    ¿Ya tienes cuenta?
                </a>

                <x-primary-button class="login-btn">
                    REGISTRARSE
                </x-primary-button>
            </div>
        </form>
    </div>

    <!-- ESTILOS (MISMO QUE LOGIN) -->
    <style>
        main {
            min-height: 100vh;
            position: relative;
            overflow: hidden;
            justify-content: flex-start !important;
            padding-top: 4rem;
        }

        /* CARD */
        .login-card {
            background: linear-gradient(
                180deg,
                rgba(255,255,255,0.06),
                rgba(255,255,255,0.02)
            );
            backdrop-filter: blur(18px);
            transition: all .35s ease;
            position: relative;
            overflow: hidden;
        }

        .login-card::before {
            content: "";
            position: absolute;
            inset: -40%;
            background: radial-gradient(
                circle,
                rgba(104, 26, 26, 0.44),
                transparent 30%
            );
            opacity: 0;
            transition: opacity .4s ease;
            z-index: -1;
        }

        .login-card:hover::before {
            opacity: 1;
        }

        .login-card:hover {
            border-color: rgba(239,68,68,.55);
            box-shadow: 0 0 35px rgba(239,68,68,.15);
        }

        /* LABELS */
        .login-label {
            color: #ef4444;
            font-size: 13px;
            font-weight: 600;
            letter-spacing: .3px;
        }

        .login-input {
            margin-top: 6px;
            padding: 12px 16px;
            border-radius: 14px;
            background: rgba(255, 255, 255, 0.06);
            border: 1px solid rgba(255, 255, 255, 0.12);
            color: #e5e7eb;
            transition: .25s ease;
            width: 100%;
        }

        .login-input::placeholder {
            color: rgba(255, 255, 255, 0.45);
        }

        .login-input:focus {
            outline: none;
            border-color: #ef4444;
            background: rgba(255, 255, 255, 0.08);
            box-shadow: 0 0 0 2px rgba(239, 68, 68, .35);
        }

        /* Estilos específicos para el select */
        select.login-input {
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3E%3Cpath stroke='%239ca3af' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 0.75rem center;
            background-size: 1.25em 1.25em;
            padding-right: 2.5rem;
        }

        /* BOTÓN OUTLINE */
        .login-btn {
            background: transparent;
            border: 1.5px solid rgba(239,68,68,.6);
            color: #ef4444;
            padding: 10px 22px;
            border-radius: 14px;
            font-weight: 600;
            letter-spacing: .5px;
            transition: all .3s ease;
        }

        .login-btn:hover {
            background: linear-gradient(135deg, #ef4444, #b91c1c);
            color: #fff;
            box-shadow: 0 6px 20px rgba(239,68,68,.35);
            transform: translateY(-2px);
        }
    </style>

    <!-- JavaScript para manejar el código de país personalizado -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const countryCodeSelect = document.getElementById('country_code');
            const customCountryCodeDiv = document.getElementById('custom-country-code');
            const customCountryCodeInput = document.getElementById('custom_country_code');
            const phoneNumberInput = document.getElementById('phone_number');
            const form = document.querySelector('form');

            // Mostrar/ocultar campo de código personalizado
            countryCodeSelect.addEventListener('change', function() {
                if (this.value === 'other') {
                    customCountryCodeDiv.classList.remove('hidden');
                    customCountryCodeInput.required = true;
                } else {
                    customCountryCodeDiv.classList.add('hidden');
                    customCountryCodeInput.required = false;
                }
            });

            // Formateo automático del número de teléfono
            phoneNumberInput.addEventListener('input', function(e) {
                let value = e.target.value.replace(/\D/g, '');

                // Limitar a 15 dígitos máximo
                if (value.length > 15) {
                    value = value.substring(0, 15);
                }

                // Formato opcional: puedes comentar esto si prefieres que el usuario ingrese libremente
                // if (value.length > 6) {
                //     value = value.replace(/(\d{2})(\d{4})(\d{0,4})/, '$1-$2-$3');
                // } else if (value.length > 2) {
                //     value = value.replace(/(\d{2})(\d{0,4})/, '$1-$2');
                // }

                e.target.value = value;
            });

            // Manejar envío del formulario para código de país personalizado
            form.addEventListener('submit', function(e) {
                if (countryCodeSelect.value === 'other') {
                    if (!customCountryCodeInput.value) {
                        e.preventDefault();
                        alert('Por favor ingresa un código de país válido');
                        customCountryCodeInput.focus();
                        return;
                    }

                    // Validar formato del código de país personalizado
                    const countryCodeRegex = /^\+[0-9]{1,4}$/;
                    if (!countryCodeRegex.test(customCountryCodeInput.value)) {
                        e.preventDefault();
                        alert('El código de país debe tener el formato +XXX (ej: +1, +34, +52)');
                        customCountryCodeInput.focus();
                        return;
                    }

                    // Crear un campo oculto con el código de país personalizado
                    const hiddenInput = document.createElement('input');
                    hiddenInput.type = 'hidden';
                    hiddenInput.name = 'country_code';
                    hiddenInput.value = customCountryCodeInput.value;
                    form.appendChild(hiddenInput);

                    // Deshabilitar el select original para que no se envíe
                    countryCodeSelect.disabled = true;
                }

                // Validación consistencia teléfono
                const hasCountryCode = countryCodeSelect.value && countryCodeSelect.value !== 'other';
                const hasCustomCountryCode = countryCodeSelect.value === 'other' && customCountryCodeInput.value;
                const hasPhoneNumber = phoneNumberInput.value.trim().length > 0;

                if ((hasCountryCode || hasCustomCountryCode) && !hasPhoneNumber) {
                    e.preventDefault();
                    alert('Por favor ingresa un número de teléfono');
                    phoneNumberInput.focus();
                    return;
                }

                if (hasPhoneNumber && !hasCountryCode && !hasCustomCountryCode) {
                    e.preventDefault();
                    alert('Por favor selecciona un código de país');
                    countryCodeSelect.focus();
                    return;
                }
            });

            // Inicializar: mostrar campo personalizado si ya estaba seleccionado
            if (countryCodeSelect.value === 'other') {
                customCountryCodeDiv.classList.remove('hidden');
            }
        });
    </script>
</x-guest-layout>
