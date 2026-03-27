<x-guest-layout>

    <!-- CARD con animación y efecto flotante -->
    <div class="relative group animate-fade-in-up">
        
        <!-- Glow animado detrás de la card -->
        <div class="absolute -inset-6 bg-gradient-to-r from-red-500/30 via-amber-500/20 to-red-500/30 rounded-3xl blur-2xl opacity-0 group-hover:opacity-70 transition-opacity duration-700 animate-pulse-slow"></div>
        
        <!-- Card principal con animación hover -->
        <div class="bg-white rounded-2xl border-2 border-gray-900 shadow-[8px_8px_0_0_#000000] p-6 sm:p-8 transition-all duration-500 hover:shadow-[12px_12px_0_0_#dc2626] hover:border-red-600 hover:-translate-y-1 relative z-10">
            
            <!-- Logo con animación de rotación sutil -->
            <div class="text-center mb-6">
                <div class="flex justify-center mb-4">
                    <div class="relative group/logo">
                        <img src="{{ asset('avaspace.svg') }}" class="h-12 sm:h-14 transition-transform duration-500 group-hover/logo:scale-110" alt="Admin Jr">
                        <div class="absolute -inset-2 bg-red-500/20 rounded-full blur-xl opacity-0 group-hover/logo:opacity-100 transition-opacity duration-500"></div>
                    </div>
                </div>
                
                <h1 class="text-3xl sm:text-4xl font-light text-gray-900 mb-1 animate-slide-in">
                    Admin <span class="text-red-600 font-bold">Jr</span>
                </h1>
                
                <div class="w-12 h-0.5 bg-gradient-to-r from-red-600 to-amber-500 rounded-full mx-auto mt-3 mb-4 animate-width-grow"></div>
                
                <p class="text-gray-500 text-sm animate-fade-in">
                    Inicia sesión para continuar
                </p>
            </div>

            <!-- Status -->
            <x-auth-session-status
                class="mb-4 text-center text-green-600 text-sm font-medium animate-fade-in"
                :status="session('status')" />

            <!-- Form con animación escalonada en inputs -->
            <form method="POST" action="{{ route('login') }}" class="space-y-5">
                @csrf

                <!-- Email -->
                <div class="animate-slide-up" style="animation-delay: 0.1s">
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
                        autofocus
                        autocomplete="username"
                        placeholder="tu@email.com">
                    <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-600 text-sm" />
                </div>

                <!-- Password -->
                <div class="animate-slide-up" style="animation-delay: 0.2s">
                    <label for="password" class="block text-gray-700 text-sm font-semibold mb-2">
                        Contraseña
                    </label>
                    <input
                        id="password"
                        class="w-full px-4 py-3 rounded-xl border-2 border-gray-300 bg-gray-50 text-gray-900 focus:border-red-500 focus:ring-2 focus:ring-red-200 focus:bg-white transition-all duration-300 outline-none hover:border-gray-400"
                        type="password"
                        name="password"
                        required
                        autocomplete="current-password"
                        placeholder="••••••••">
                    <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-600 text-sm" />
                </div>

                <!-- Remember y Forgot -->
                <div class="flex items-center justify-between animate-slide-up" style="animation-delay: 0.3s">
                    <label class="flex items-center gap-2 cursor-pointer group/check">
                        <input
                            type="checkbox"
                            name="remember"
                            class="rounded border-2 border-gray-300 text-red-600 focus:ring-red-500 focus:ring-2 w-4 h-4 transition-all duration-200 group-hover/check:border-red-400">
                        <span class="text-sm text-gray-600 group-hover/check:text-red-600 transition-colors">Recordarme</span>
                    </label>

                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}"
                           class="text-sm text-gray-500 hover:text-red-600 transition-all duration-300 hover:translate-x-1 inline-block">
                            ¿Olvidaste tu contraseña?
                        </a>
                    @endif
                </div>

                <!-- Botón submit animado -->
                <button type="submit"
                        class="relative w-full inline-flex items-center justify-center gap-2 px-6 py-3.5 bg-gradient-to-r from-red-600 to-red-500 hover:from-red-700 hover:to-red-600 text-white font-bold text-sm rounded-xl transition-all duration-300 shadow-[3px_3px_0_0_#000000] hover:shadow-[5px_5px_0_0_#000000] hover:scale-[1.02] overflow-hidden group animate-slide-up mt-6"
                        style="animation-delay: 0.4s">
                    
                    <span class="absolute inset-0 bg-white/30 translate-x-[-100%] group-hover:translate-x-[100%] transition-transform duration-700"></span>
                    
                    <span class="relative z-10">Iniciar sesión</span>
                    <svg class="w-4 h-4 relative z-10 transition-transform duration-300 group-hover:translate-x-1" 
                         fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                    </svg>
                </button>
            </form>

            <!-- Link para registrarse -->
            <div class="mt-6 text-center pt-4 border-t border-gray-200 animate-fade-in" style="animation-delay: 0.5s">
                <p class="text-sm text-gray-500">
                    ¿No tienes cuenta?
                    <a href="{{ route('register') }}" class="text-red-600 font-semibold hover:text-red-700 transition-all duration-300 hover:translate-x-0.5 inline-block">
                        Crear cuenta gratis
                    </a>
                </p>
            </div>
        </div>
    </div>

    <style>
        /* Animaciones personalizadas */
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
    </style>

</x-guest-layout>