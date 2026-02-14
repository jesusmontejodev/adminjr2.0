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

    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Stripe.js -->
    <script src="https://js.stripe.com/v3/"></script>

    @vite([
        'resources/css/app.css',
        'resources/js/app.js'
    ])
</head>

<body id="body" class="font-sans antialiased bg-white text-gray-900 dark:bg-[#0b0b0e] dark:text-gray-100">

<div class="flex h-screen overflow-hidden bg-white dark:bg-[#0b0b0e]">

    <!-- SIDEBAR -->
    @auth
        @include('layouts.navigation')
    @endauth

    <!-- CONTENIDO -->
    <div class="flex-1 flex flex-col overflow-hidden bg-gray-100 dark:bg-[#12141a]">

        @if(request()->routeIs('planes') || request()->routeIs('suscripcion.*'))
            <header class="bg-white dark:bg-gradient-to-r dark:from-gray-900 dark:to-gray-800 border-b border-gray-200 dark:border-white/10 shadow-xl">
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
                            @if(auth()->user()->tieneSuscripcionActiva())
                                <div class="px-4 py-2 bg-green-100 dark:bg-gradient-to-r dark:from-green-900/30 dark:to-emerald-900/30 border border-green-300 dark:border-green-700/30 rounded-lg">
                                    <span class="text-green-700 dark:text-green-400 text-sm font-semibold">
                                        <i class="fas fa-crown mr-2"></i>
                                    </span>
                                </div>

                                <a href="{{ route('dashboard') }}"
                                   class="px-4 py-2 bg-gray-200 dark:bg-gray-800 hover:bg-gray-300 dark:hover:bg-gray-700 rounded-lg transition text-gray-900 dark:text-white">
                                    <i class="fas fa-tachometer-alt mr-2"></i>Dashboard
                                </a>
                            @elseif(auth()->user()->enPeriodoDeGracia())
                                <div class="px-4 py-2 bg-yellow-100 dark:bg-gradient-to-r dark:from-yellow-900/30 dark:to-amber-900/30 border border-yellow-300 dark:border-yellow-700/30 rounded-lg">
                                    <span class="text-yellow-700 dark:text-yellow-400 text-sm font-semibold">
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
                    <div>{{ $header }}</div>
                </div>
            </header>
        @endisset
        @endif
        <main class="flex-1 overflow-y-auto p-6 bg-gray-100 dark:bg-[#12141a] relative">
            <div class="absolute inset-0 -z-10 flex justify-center items-center pointer-events-none">
                <div class="w-[85%] h-[85%] bg-red-600/30 blur-[140px] rounded-full"></div>
                <div class="absolute w-[55%] h-[55%] bg-red-500/20 blur-[100px] rounded-full"></div>
            </div>

            <div class="relative z-10">
                {{ $slot }}
            </div>
        </main>
    </div>
</div>
<div id="toast-container" class="fixed top-4 right-4 z-50 space-y-3"></div>
<!-- BOTÓN TEMA -->
<button id="toggleTheme"
    class="fixed bottom-7 right-7 z-50
            w-9 h-9 rounded-full
            bg-[#141414]/90 dark:bg-[#1a1c23]
            border border-red-500/30
            backdrop-blur-md
            shadow-[0_0_12px_rgba(239,68,68,0.25)]
            hover:shadow-[0_0_20px_rgba(239,68,68,0.45)]
            hover:scale-110 transition-all duration-200
            flex items-center justify-center text-lg">
</button>

<script>
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
        setTimeout(() => toast.classList.remove('translate-x-full','opacity-0'), 10);
        setTimeout(() => removeToast(toastId), 5000);
    }

    function removeToast(id) {
        const toast = document.getElementById(id);
        if (toast) {
            toast.classList.add('translate-x-full','opacity-0');
            setTimeout(() => toast.remove(), 300);
        }
    }
</script>

<script>
(function () {
    const theme = localStorage.getItem('theme');

    if (theme === 'dark') {
        document.documentElement.classList.add('dark');
    } else {
        document.documentElement.classList.remove('dark');
    }
})();
</script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const btn = document.getElementById('toggleTheme');
    const html = document.documentElement;

    if (!btn) return;

    function actualizarEmoji() {
        if (html.classList.contains('dark')) {
            btn.textContent = '🌙'; // estás en dark
        } else {
            btn.textContent = '☀️'; // estás en light
        }
    }

    actualizarEmoji();

    btn.addEventListener('click', function () {
        html.classList.toggle('dark');

        if (html.classList.contains('dark')) {
            localStorage.setItem('theme', 'dark');
        } else {
            localStorage.setItem('theme', 'light');
        }

        actualizarEmoji();
    });
});
</script>
@stack('scripts')
</body>
</html>
