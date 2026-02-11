<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet">

    <!-- Google Fonts: Montserrat -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">

    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined"
    rel="stylesheet" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">


    <!-- Stripe.js -->
    <script src="https://js.stripe.com/v3/"></script>

    @vite([
    'resources/css/app.css',
    'resources/css/estructura.css',
    'resources/css/temas-claro.css',
    'resources/css/tema-oscuro.css',
    'resources/js/app.js'
])

</head>

<body id="body" class="font-sans antialiased bg-white text-gray-900 dark:bg-[#0b0b0e] dark:text-gray-100">


<div class="flex h-screen overflow-hidden bg-white dark:bg-[#0b0b0e]">

<!-- BOTÓN MODO CLARO / OSCURO -->
<button id="toggleTheme"
    class="fixed bottom-6 right-6 z-50 px-3 py-2 rounded-lg
           bg-gray-200 text-gray-900
           dark:bg-gray-800 dark:text-gray-100
           shadow hover:scale-105 transition">
    🌙
</button>



    <!-- SIDEBAR (solo mostrar si está autenticado) -->
    @auth
        @include('layouts.navigation')
    @endauth

    <!-- CONTENIDO -->
    <div class="flex-1 flex flex-col overflow-hidden bg-gray-100 dark:bg-[#12141a]">

        <!-- Header dinámico para planes -->
        @if(request()->routeIs('planes') || request()->routeIs('suscripcion.*'))
            <header class="bg-gradient-to-r from-gray-900 to-gray-800 border-b border-white/10 shadow-xl">
                <div class="py-8 px-6">
                    <div class="flex justify-between items-center">
                        <div>
                            <h1 class="text-3xl font-bold bg-gradient-to-r from-red-500 to-pink-600 bg-clip-text text-transparent">
                                @yield('title', 'Planes de Suscripción')
                            </h1>
                            <p class="text-gray-400 mt-2">@yield('subtitle', 'Elige el plan perfecto para tu negocio')</p>
                        </div>

                        @auth
                            <div class="flex items-center space-x-4">
                                <!-- Badge de estado de suscripción -->
                                @if(auth()->user()->tieneSuscripcionActiva())
                                    <div class="px-4 py-2 bg-gradient-to-r from-green-900/30 to-emerald-900/30 border border-green-700/30 rounded-lg">
                                        <span class="text-green-400 text-sm font-semibold">
                                            <i class="fas fa-crown mr-2"></i>
                                            {{-- {{ auth()->user()->getInfoSuscripcion()['plan'] }} --}}
                                        </span>
                                    </div>
                                    <a href="{{ route('dashboard') }}"
                                        class="px-4 py-2 bg-gray-800 hover:bg-gray-700 rounded-lg transition">
                                        <i class="fas fa-tachometer-alt mr-2"></i>Dashboard
                                    </a>
                                @elseif(auth()->user()->enPeriodoDeGracia())
                                    <div class="px-4 py-2 bg-gradient-to-r from-yellow-900/30 to-amber-900/30 border border-yellow-700/30 rounded-lg">
                                        <span class="text-yellow-400 text-sm font-semibold">
                                            <i class="fas fa-clock mr-2"></i>
                                            Período de Gracia
                                        </span>
                                    </div>
                                @endif
                            </div>
                        @endauth
                    </div>
                </div>
            </header>
        @else
        @isset($header)
            <header class="bg-white dark:bg-[#12141a] border-b border-white/5">
                <div class="flex justify-between items-center py-6 px-6">
                    <div>
                        {{ $header }}
                    </div>
                </div>
            </header>
        @endisset
        @endif

        <main class="flex-1 overflow-y-auto p-6 bg-gray-100 dark:bg-[#12141a] relative">


            <!-- Glow rojo -->
            <div class="absolute inset-0 -z-10 flex justify-center items-center pointer-events-none">
                <div class="w-[85%] h-[85%] bg-red-600/30 blur-[140px] rounded-full"></div>
                <div class="absolute w-[55%] h-[55%] bg-red-500/20 blur-[100px] rounded-full"></div>
            </div>

            <!-- Contenedor de contenido -->
            <div class="relative z-10">
                {{ $slot }}
            </div>

        </main>
    </div>

</div>

<!-- Toast Notifications -->
<div id="toast-container" class="fixed top-4 right-4 z-50 space-y-3"></div>

<!-- Scripts globales -->
<script>
    // Mostrar notificación toast
    function showToast(message, type = 'success') {
        const container = document.getElementById('toast-container');
        const toastId = 'toast-' + Date.now();

        const bgColors = {
            success: 'bg-green-900/90 border-green-700',
            error: 'bg-red-900/90 border-red-700',
            warning: 'bg-yellow-900/90 border-yellow-700',
            info: 'bg-blue-900/90 border-blue-700'
        };

        const icons = {
            success: 'fas fa-check-circle text-green-400',
            error: 'fas fa-exclamation-circle text-red-400',
            warning: 'fas fa-exclamation-triangle text-yellow-400',
            info: 'fas fa-info-circle text-blue-400'
        };

        const toast = document.createElement('div');
        toast.id = toastId;
        toast.className = `${bgColors[type]} border rounded-lg p-4 shadow-xl backdrop-blur-sm transform transition-all duration-300 translate-x-full opacity-0 max-w-sm`;
        toast.innerHTML = `
            <div class="flex items-start">
                <i class="${icons[type]} text-lg mt-0.5 mr-3"></i>
                <div class="flex-1">
                    <p class="text-sm font-medium text-gray-100">${message}</p>
                </div>
                <button onclick="removeToast('${toastId}')" class="ml-3 text-gray-400 hover:text-gray-200">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        `;

        container.appendChild(toast);

        // Animación de entrada
        setTimeout(() => {
            toast.classList.remove('translate-x-full', 'opacity-0');
            toast.classList.add('translate-x-0', 'opacity-100');
        }, 10);

        // Auto-remover después de 5 segundos
        setTimeout(() => {
            removeToast(toastId);
        }, 5000);
    }

    function removeToast(id) {
        const toast = document.getElementById(id);
        if (toast) {
            toast.classList.add('translate-x-full', 'opacity-0');
            setTimeout(() => {
                if (toast.parentNode) {
                    toast.parentNode.removeChild(toast);
                }
            }, 300);
        }
    }

    // Mostrar toasts desde sesión Laravel
    @if(session('success'))
        showToast('{{ session("success") }}', 'success');
    @endif

    @if(session('error'))
        showToast('{{ session("error") }}', 'error');
    @endif

    @if(session('warning'))
        showToast('{{ session("warning") }}', 'warning');
    @endif

    @if(session('info'))
        showToast('{{ session("info") }}', 'info');
    @endif
</script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const html = document.documentElement;
    const btn = document.getElementById('toggleTheme');

    if (localStorage.getItem('theme') === 'dark') {
        html.classList.add('dark');
    }

    if (!btn) return;

    btn.textContent = html.classList.contains('dark') ? '☀️' : '🌙';

    btn.addEventListener('click', function () {
        html.classList.toggle('dark');

        if (html.classList.contains('dark')) {
            localStorage.setItem('theme', 'dark');
            btn.textContent = '🌙';
        } else {
            localStorage.setItem('theme', 'light');
            btn.textContent = '☀️';
        }
    });
});
</script>



@stack('scripts')

</body>
</html>