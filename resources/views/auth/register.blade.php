<x-guest-layout>

    <!-- CARD con animación y efecto flotante - MISMO ESTILO QUE LOGIN -->
    <div class="relative group animate-fade-in-up">
        
        <!-- Glow animado detrás de la card -->
        <div class="absolute -inset-6 bg-gradient-to-r from-red-500/30 via-amber-500/20 to-red-500/30 rounded-3xl blur-2xl opacity-0 group-hover:opacity-70 transition-opacity duration-700 animate-pulse-slow"></div>
        
        <!-- Card principal con animación hover -->
        <div class="bg-white rounded-2xl border-2 border-gray-900 shadow-[8px_8px_0_0_#000000] p-6 sm:p-8 transition-all duration-500 hover:shadow-[12px_12px_0_0_#dc2626] hover:border-red-600 hover:-translate-y-1 relative z-10">
            
            <!-- Logo con animación -->
            <div class="text-center mb-6">
                <div class="flex justify-center mb-4">
                    <div class="relative group/logo">
                        <img src="{{ asset('avaspace.svg') }}" class="h-12 sm:h-14 transition-transform duration-500 group-hover/logo:scale-110" alt="Admin Jr">
                        <div class="absolute -inset-2 bg-red-500/20 rounded-full blur-xl opacity-0 group-hover/logo:opacity-100 transition-opacity duration-500"></div>
                    </div>
                </div>
                
                <h1 class="text-3xl sm:text-4xl font-light text-gray-900 mb-1 animate-slide-in">
                    Crear cuenta en <span class="text-red-600 font-bold">Admin Jr</span>
                </h1>
                
                <div class="w-12 h-0.5 bg-gradient-to-r from-red-600 to-amber-500 rounded-full mx-auto mt-3 mb-4 animate-width-grow"></div>
                
                <p class="text-gray-500 text-sm animate-fade-in">
                    Regístrate para comenzar
                </p>
            </div>

            <form method="POST" action="{{ route('register') }}" class="space-y-5">
                @csrf

                <!-- Name -->
                <div class="animate-slide-up" style="animation-delay: 0.1s">
                    <label for="name" class="block text-gray-700 text-sm font-semibold mb-2">
                        Nombre
                    </label>
                    <input
                        id="name"
                        class="w-full px-4 py-3 rounded-xl border-2 border-gray-300 bg-gray-50 text-gray-900 focus:border-red-500 focus:ring-2 focus:ring-red-200 focus:bg-white transition-all duration-300 outline-none hover:border-gray-400"
                        type="text"
                        name="name"
                        value="{{ old('name') }}"
                        required
                        autofocus
                        autocomplete="name"
                        placeholder="Tu nombre">
                    <x-input-error :messages="$errors->get('name')" class="mt-2 text-red-600 text-sm" />
                </div>

                <!-- Email -->
                <div class="animate-slide-up" style="animation-delay: 0.15s">
                    <label for="email" class="block text-gray-700 text-sm font-semibold mb-2">
                        Correo electrónico
                    </label>
                    <input
                        id="email"
                        class="w-full px-4 py-3 rounded-xl border-2 border-gray-300 bg-gray-50 text-gray-900 focus:border-red-500 focus:ring-2 focus:ring-red-200 focus:bg-white transition-all duration-300 outline-none hover:border-gray-400"
                        type="email"
                        name="email"
                        value="{{ old('email') }}"
                        required
                        autocomplete="username"
                        placeholder="tu@email.com">
                    <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-600 text-sm" />
                </div>

                <!-- Teléfono (Opcional) -->
                <div class="animate-slide-up" style="animation-delay: 0.2s">
                    <label class="block text-gray-700 text-sm font-semibold mb-2">
                        Teléfono (Opcional)
                    </label>

                    <div class="flex gap-2">
                        <!-- Código de país - TAMAÑO REDUCIDO -->
                        <div class="w-28 relative">
                            <select
                                id="country_code"
                                name="country_code"
                                class="w-full px-3 py-3 rounded-xl border-2 border-gray-300 bg-gray-50 text-gray-700 focus:border-red-500 focus:ring-2 focus:ring-red-200 focus:bg-white transition-all duration-300 outline-none appearance-none cursor-pointer hover:border-gray-400 text-sm">
                                <option value="" class="text-gray-500">Código</option>
                                < <option value="+1" {{ old('country_code') == '+1' ? 'selected' : '' }}>+1(USA/Canadá)</option>
                            <option value="+52" {{ old('country_code') == '+52' ? 'selected' : '' }}>+52(México)</option>
                            <option value="+34" {{ old('country_code') == '+34' ? 'selected' : '' }}>+34(España)</option>
                            <option value="+51" {{ old('country_code') == '+51' ? 'selected' : '' }}>+51(Perú)</option>
                            <option value="+56" {{ old('country_code') == '+56' ? 'selected' : '' }}>+56(Chile)</option>
                            <option value="+54" {{ old('country_code') == '+54' ? 'selected' : '' }}>+54(Argentina)</option>
                            <option value="+55" {{ old('country_code') == '+55' ? 'selected' : '' }}>+55(Brasil)</option>
                            <option value="+57" {{ old('country_code') == '+57' ? 'selected' : '' }}>+57(Colombia)</option>
                            <option value="other" {{ old('country_code') == 'other' ? 'selected' : '' }}>Otro</option>
                            </select>
                        </div>

                        <!-- Número de teléfono -->
                        <div class="flex-1">
                            <input
                                id="phone_number"
                                class="w-full px-4 py-3 rounded-xl border-2 border-gray-300 bg-gray-50 text-gray-900 focus:border-red-500 focus:ring-2 focus:ring-red-200 focus:bg-white transition-all duration-300 outline-none hover:border-gray-400"
                                type="tel"
                                name="phone_number"
                                value="{{ old('phone_number') }}"
                                placeholder="9991234567"
                                autocomplete="tel">
                        </div>
                    </div>

                    <!-- Input para código de país personalizado (oculto inicialmente) -->
                    <div id="custom-country-code" class="mt-2 hidden">
                        <label for="custom_country_code" class="block text-gray-700 text-sm font-semibold mb-2">
                            Código de país personalizado
                        </label>
                        <input
                            id="custom_country_code"
                            class="w-full px-4 py-3 rounded-xl border-2 border-gray-300 bg-gray-50 text-gray-900 focus:border-red-500 focus:ring-2 focus:ring-red-200 focus:bg-white transition-all duration-300 outline-none"
                            type="text"
                            name="custom_country_code"
                            value="{{ old('custom_country_code') }}"
                            placeholder="Ej: +44">
                    </div>

                    <p class="text-xs text-gray-500 mt-2">
                        Solo para notificaciones importantes. Ej: 55-1234-5678 o (55) 1234 5678
                    </p>

                    <x-input-error :messages="$errors->get('country_code')" class="mt-2 text-red-600 text-sm" />
                    <x-input-error :messages="$errors->get('phone_number')" class="mt-2 text-red-600 text-sm" />
                </div>

                <!-- Password -->
                <div class="animate-slide-up" style="animation-delay: 0.25s">
                    <label for="password" class="block text-gray-700 text-sm font-semibold mb-2">
                        Contraseña
                    </label>
                    <input
                        id="password"
                        class="w-full px-4 py-3 rounded-xl border-2 border-gray-300 bg-gray-50 text-gray-900 focus:border-red-500 focus:ring-2 focus:ring-red-200 focus:bg-white transition-all duration-300 outline-none hover:border-gray-400"
                        type="password"
                        name="password"
                        required
                        autocomplete="new-password"
                        placeholder="Crea una contraseña segura">
                    <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-600 text-sm" />
                </div>

                <!-- Confirm Password -->
                <div class="animate-slide-up" style="animation-delay: 0.3s">
                    <label for="password_confirmation" class="block text-gray-700 text-sm font-semibold mb-2">
                        Confirmar Contraseña
                    </label>
                    <input
                        id="password_confirmation"
                        class="w-full px-4 py-3 rounded-xl border-2 border-gray-300 bg-gray-50 text-gray-900 focus:border-red-500 focus:ring-2 focus:ring-red-200 focus:bg-white transition-all duration-300 outline-none hover:border-gray-400"
                        type="password"
                        name="password_confirmation"
                        required
                        autocomplete="new-password"
                        placeholder="Repite tu contraseña">
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-red-600 text-sm" />
                </div>

                <!-- Terms and Privacy -->
                <div class="mt-2 animate-fade-in" style="animation-delay: 0.35s">
                    <p class="text-xs text-gray-500 text-center">
                        Al registrarte, aceptas nuestros
                        <a href="{{ route('aviso-de-privacidad') }}" class="text-red-600 hover:text-red-700 transition">Aviso de privacidad</a> y
                        <a href="{{ route('terminos') }}" class="text-red-600 hover:text-red-700 transition">Términos y condiciones</a>.
                    </p>
                </div>

                <!-- Actions -->
                <div class="flex items-center justify-between pt-2 animate-slide-up" style="animation-delay: 0.4s">
                    <a href="{{ route('login') }}" class="text-sm text-gray-500 hover:text-red-600 transition-all duration-300 hover:translate-x-0.5 inline-block">
                        ¿Ya tienes cuenta?
                    </a>

                    <button type="submit"
                            class="relative inline-flex items-center justify-center gap-2 px-6 py-3 bg-gradient-to-r from-red-600 to-red-500 hover:from-red-700 hover:to-red-600 text-white font-bold text-sm rounded-xl transition-all duration-300 shadow-[3px_3px_0_0_#000000] hover:shadow-[5px_5px_0_0_#000000] hover:scale-[1.02] overflow-hidden group">
                        
                        <span class="absolute inset-0 bg-white/30 translate-x-[-100%] group-hover:translate-x-[100%] transition-transform duration-700"></span>
                        
                        <span class="relative z-10">REGISTRARSE</span>
                        <svg class="w-4 h-4 relative z-10 transition-transform duration-300 group-hover:translate-x-1" 
                             fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                        </svg>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <style>
        /* Animaciones personalizadas - MISMAS QUE LOGIN */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateX(-20px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }
        
        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }
        
        @keyframes widthGrow {
            from {
                width: 0;
                opacity: 0;
            }
            to {
                width: 3rem;
                opacity: 1;
            }
        }
        
        @keyframes pulseSlow {
            0%, 100% {
                opacity: 0.3;
            }
            50% {
                opacity: 0.7;
            }
        }
        
        .animate-fade-in-up {
            animation: fadeInUp 0.8s cubic-bezier(0.2, 0.9, 0.4, 1.1) forwards;
        }
        
        .animate-slide-in {
            animation: slideIn 0.6s ease-out forwards;
        }
        
        .animate-slide-up {
            opacity: 0;
            animation: slideUp 0.5s ease-out forwards;
        }
        
        .animate-fade-in {
            opacity: 0;
            animation: fadeIn 0.8s ease-out forwards;
        }
        
        .animate-width-grow {
            animation: widthGrow 0.8s ease-out forwards;
        }
        
        .animate-pulse-slow {
            animation: pulseSlow 3s ease-in-out infinite;
        }
        
        /* Estilo para el select personalizado */
        select {
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3E%3Cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3E%3C/svg%3E");
            background-position: right 0.6rem center;
            background-repeat: no-repeat;
            background-size: 1rem;
            padding-right: 2rem;
            appearance: none;
        }
        
        select option {
            background-color: white;
            color: #1f2937;
        }
    </style>

    <script>
        // Mostrar campo de código personalizado cuando se selecciona "Otro"
        document.addEventListener('DOMContentLoaded', function() {
            const countryCodeSelect = document.getElementById('country_code');
            const customCodeDiv = document.getElementById('custom-country-code');
            
            if (countryCodeSelect && customCodeDiv) {
                function toggleCustomCode() {
                    if (countryCodeSelect.value === 'other') {
                        customCodeDiv.classList.remove('hidden');
                    } else {
                        customCodeDiv.classList.add('hidden');
                    }
                }
                
                countryCodeSelect.addEventListener('change', toggleCustomCode);
                toggleCustomCode();
            }
        });
    </script>

</x-guest-layout>