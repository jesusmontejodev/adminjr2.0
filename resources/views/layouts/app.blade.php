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
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Google Fonts: Chakra Petch (sidebar HUD) -->
    <link href="https://fonts.googleapis.com/css2?family=Chakra+Petch:wght@500;600;700&display=swap" rel="stylesheet">

    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Stripe.js -->
    <script src="https://js.stripe.com/v3/"></script>

    @vite([
        'resources/css/app.css',
        'resources/css/estructura.css',
        'resources/css/temas-claro.css',
        'resources/css/tema-oscuro.css',
        'resources/css/cuentas.css',
        'resources/css/dashboard.css',
        'resources/css/categorias.css',
        'resources/css/transacciones.css',
        'resources/css/analistajr.css',
        'resources/css/transaccionesinternas.css',
        'resources/css/numeros-whatsapp.css',
        'resources/css/chat.css',
        'resources/css/integraciones-ia.css',
        'resources/css/perfil.css',
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
    <div class="flex-1 flex flex-col overflow-hidden relative z-0 bg-gray-100 dark:bg-[#12141a]">

        {{-- Fondo decorativo: vive en este wrapper (altura fija = viewport), no dentro de <main>,
             para que siempre cubra todo el panel aunque el contenido scrollable sea más alto. --}}
        @if(request()->routeIs('dashboard') || request()->routeIs('cuentas.*') || request()->routeIs('categorias.*') || request()->routeIs('transacciones.index') || request()->routeIs('transacciones.hoja-calculo') || request()->routeIs('analistajr.index') || request()->routeIs('transaccionesinternas.*') || request()->routeIs('numeros-whatsapp.*') || request()->routeIs('chat.index') || request()->routeIs('chat.create') || request()->routeIs('chat.show') || request()->routeIs('mcp-tokens.*') || request()->routeIs('profile.edit'))
            <div class="absolute inset-0 -z-10 overflow-hidden pointer-events-none dashboard-aurora-bg">
                <div class="aurora-blob aurora-ruby"></div>
                <div class="aurora-blob aurora-ruby-2"></div>
                <div class="aurora-blob aurora-ruby-3"></div>
            </div>
        @else
            <div class="absolute inset-0 -z-10 flex justify-center items-center pointer-events-none">
                <div class="w-[85%] h-[85%] bg-red-600/30 blur-[140px] rounded-full"></div>
                <div class="absolute w-[55%] h-[55%] bg-red-500/20 blur-[100px] rounded-full"></div>
            </div>
        @endif

        @if(request()->routeIs('planes') || request()->routeIs('suscripcion.*'))
            <header class="bg-white dark:bg-gradient-to-r dark:from-gray-900 dark:to-gray-800 border-b border-gray-200 dark:border-white/10 shadow-xl">
                <div class="py-4 px-4 sm:py-8 sm:px-6">
                    <div class="flex justify-between items-center gap-3">
                        <div class="flex items-center gap-3 min-w-0">
                            @include('layouts.sidebar-toggle-button')
                            <div class="min-w-0">
                                <h1 class="text-xl sm:text-3xl font-bold bg-gradient-to-r from-red-500 to-pink-600 bg-clip-text text-transparent truncate">
                                    @yield('title', 'Planes de Suscripción')
                                </h1>
                                <p class="text-gray-400 mt-1 sm:mt-2 text-sm sm:text-base hidden sm:block">@yield('subtitle', 'Elige el plan perfecto para tu negocio')</p>
                            </div>
                        </div>

                        @auth
                        <div class="flex items-center space-x-4">
                            @if(auth()->user()->tieneAccesoPremium())
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
            <header class="relative z-20 bg-white dark:bg-[#101011]/90 dark:backdrop-blur-2xl border-b border-white/5 dark:border-red-500/10">
                <div class="h-20 flex justify-between items-center gap-3 px-4 sm:px-6">
                    <div class="flex items-center gap-3 min-w-0">
                        @include('layouts.sidebar-toggle-button')
                        <div class="min-w-0">{{ $header }}</div>
                    </div>
                    <div class="flex items-center gap-2">
                        @include('layouts.theme-toggle')
                        @include('layouts.user-menu')
                    </div>
                </div>
            </header>
        @else
            <div class="lg:hidden flex items-center gap-3 py-3 px-4 bg-white dark:bg-[#101011]/90 dark:backdrop-blur-2xl border-b border-white/5 dark:border-red-500/10">
                @include('layouts.sidebar-toggle-button')
            </div>
        @endisset
        @endif
        <main class="flex-1 overflow-y-auto p-3 sm:p-6 relative z-0 bg-transparent">
            <div class="relative z-10">
                @yield('content', $slot ?? '')
            </div>
        </main>
    </div>
</div>
<div id="toast-container" class="fixed top-4 right-4 z-50 space-y-3"></div>

@auth
@unless(request()->routeIs('chat.*'))
<!-- INVITACIÓN A CHATEAR CON EL ASESOR IA (mascota) -->
<style>
    @keyframes aiTeaserPop {
        0%   { transform: scale(.5) rotate(-10deg); opacity: 0; }
        55%  { transform: scale(1.12) rotate(4deg); opacity: 1; }
        100% { transform: scale(1) rotate(0deg); }
    }
    #ai-teaser.is-visible .mascot-avatar {
        animation: aiTeaserPop .5s cubic-bezier(.34,1.56,.64,1);
    }
    @media (prefers-reduced-motion: reduce) {
        #ai-teaser.is-visible .mascot-avatar { animation: none; }
    }
</style>
<div id="ai-teaser" class="fixed bottom-7 right-7 z-40 max-w-[280px]" style="display:none;">
    <a href="{{ route('chat.index') }}"
       class="flex items-start gap-3 pl-3 pr-8 py-3 rounded-2xl relative
              bg-white border border-gray-200 shadow-xl
              dark:bg-black/70 dark:backdrop-blur-2xl dark:border-red-500/15
              dark:shadow-[0_20px_45px_rgba(0,0,0,.5),inset_0_1px_0_rgba(255,255,255,.08),0_0_28px_rgba(255,23,68,.14)]
              hover:-translate-y-0.5 transition">
        <span class="mascot-avatar flex items-center justify-center w-9 h-9 rounded-full bg-red-50 text-red-600 dark:bg-red-500/15 dark:text-red-400 shrink-0">
            <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                <circle cx="8.5" cy="10.5" r="1.4" fill="currentColor" stroke="none"/>
                <circle cx="15.5" cy="10.5" r="1.4" fill="currentColor" stroke="none"/>
                <path d="M8 15c1.2 1.4 2.8 2 4 2s2.8-.6 4-2" stroke-width="1.75" stroke-linecap="round"/>
            </svg>
        </span>
        <span class="text-sm text-gray-700 dark:text-gray-200 leading-snug pt-1.5" id="ai-teaser-text"></span>
    </a>
    <button type="button" onclick="event.preventDefault(); event.stopPropagation(); window.__dismissAiTeaser();"
            class="absolute top-2 right-2 w-5 h-5 flex items-center justify-center rounded-full text-gray-400 hover:text-gray-700 dark:hover:text-gray-200 hover:bg-gray-100 dark:hover:bg-white/10 transition">
        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
    </button>
</div>

<script>
(function () {
    const messages = [
        '¿Quieres saber cómo están tus finanzas esta semana?',
        '¿Qué es lo nuevo en lo que gastaste?',
        'Pregúntame cuánto llevas de ingresos este mes.',
        '¿Sabes en qué categoría gastas más?',
        'Puedo ayudarte a entender tu saldo actual.',
        '¿Cómo va tu racha de registros?',
        '¿Quieres un resumen rápido de tus cuentas?',
    ];

    const el = document.getElementById('ai-teaser');
    const textEl = document.getElementById('ai-teaser-text');
    if (!el || !textEl) return;

    window.__dismissAiTeaser = function () {
        el.style.display = 'none';
        el.classList.remove('is-visible');
        sessionStorage.setItem('aiTeaserDismissed', '1');
    };

    if (sessionStorage.getItem('aiTeaserDismissed') === '1') return;

    let hideTimer = null;

    function showTeaser() {
        if (sessionStorage.getItem('aiTeaserDismissed') === '1') return;
        textEl.textContent = messages[Math.floor(Math.random() * messages.length)];
        el.style.display = 'block';
        el.classList.remove('is-visible');
        void el.offsetWidth; // fuerza reflow para reiniciar la animación
        el.classList.add('is-visible');
        clearTimeout(hideTimer);
        hideTimer = setTimeout(function () {
            el.style.display = 'none';
            el.classList.remove('is-visible');
        }, 9000);
    }

    showTeaser();
    setInterval(showTeaser, 21000); // se repite cada 21 segundos
})();
</script>
@endunless
@endauth

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

    btn.addEventListener('click', function () {
        html.classList.toggle('dark');

        if (html.classList.contains('dark')) {
            localStorage.setItem('theme', 'dark');
        } else {
            localStorage.setItem('theme', 'light');
        }
    });
});
</script>
@stack('scripts')
</body>
</html>
