<x-guest-layout>

    <div class="relative w-full max-w-md mx-auto mt-16">

        <!-- Card -->
        <div class="relative
                    backdrop-blur-xl
                     bg-black/40
                    border border-red-500/30
                    rounded-3xl
                    p-8
                    text-center
                    shadow-xl">

            <!-- Icono -->
            <div class="flex justify-center mb-5">
                <div class="w-14 h-14 rounded-full 
                            bg-red-600
                            flex items-center justify-center
                            text-white text-xl
                            shadow-lg shadow-red-600/40">
                    <svg xmlns="http://www.w3.org/2000/svg" 
                    fill="none" 
                    viewBox="0 0 24 24" 
                    stroke-width="1.5" 
                    stroke="currentColor" 
                    class="w-7 h-7">
                    <path stroke-linecap="round" stroke-linejoin="round" 
                        d="M21.75 7.5v9A2.25 2.25 0 0119.5 18.75h-15A2.25 2.25 0 012.25 16.5v-9m19.5 0A2.25 2.25 0 0019.5 5.25h-15A2.25 2.25 0 002.25 7.5m19.5 0l-9.19 5.74a1.5 1.5 0 01-1.62 0L2.25 7.5"/>
                </svg>
                </div>
            </div>

            <!-- Título -->
            <h2 class="text-2xl font-semibold text-white mb-2">
                Verifica tu correo
            </h2>

            <!-- Texto -->
            <p class="text-sm text-gray-300 leading-relaxed mb-6">
                Gracias por registrarte en 
                <span class="text-red-500 font-semibold">Admin JR</span>.
                Antes de comenzar, verifica tu correo haciendo clic en el enlace que enviamos.
            </p>

            @if (session('status') == 'verification-link-sent')
                <div class="mb-6 text-green text-sm
                            bg-green-500/10
                            border border-green-500/30
                            rounded-lg p-3">
                    Hemos enviado un nuevo enlace de verificación a tu correo.
                </div>
            @endif

            <!-- Botón -->
            <form method="POST" action="{{ route('verification.send') }}">
                @csrf

                <button type="submit"
                    class="w-full py-3 rounded-xl
                           bg-red-600
                           hover:bg-red-700
                           text-white font-medium
                           transition
                           shadow-lg shadow-red-600/30">
                    Reenviar correo de verificación
                </button>
            </form>

            <!-- Logout -->
            <form method="POST" action="{{ route('logout') }}" class="mt-6">
                @csrf

                <button type="submit"
                    class="text-sm text-gray-400 hover:text-red-400 transition">
                    Cerrar sesión
                </button>
            </form>

        </div>

    </div>

</x-guest-layout>