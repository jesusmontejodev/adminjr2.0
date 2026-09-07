<!-- Overlay para móviles -->
<div class="fixed inset-0 bg-black/50 z-30 lg:hidden hidden" id="sidebar-overlay" onclick="toggleSidebar()"></div>

<!-- Sidebar -->
<nav class="hud-nav w-full lg:w-[300px] min-h-screen bg-white text-gray-600 border-r border-gray-200 dark:bg-black/60 dark:backdrop-blur-2xl dark:text-gray-200 dark:border-red-500/10 flex flex-col fixed lg:static inset-0 z-40 transform -translate-x-full lg:translate-x-0 transition-transform duration-300" id="sidebar">

    <!-- Contenido del sidebar -->
    <div class="relative z-40 bg-white dark:bg-transparent h-full overflow-y-auto flex flex-col">
        <!-- LOGO -->
        <div class="h-20 px-6 border-b border-gray-200 dark:border-red-500/10 flex justify-between items-center">
            <a href="{{ route('dashboard') }}" class="flex items-center gap-3">
                <x-application-logo class="w-8 h-8"/>
                <span class="font-hud text-xl font-bold tracking-wide text-gray-900 dark:text-white">Avaspace</span>
            </a>
            <!-- Botón cerrar en móviles -->
            <button onclick="toggleSidebar()" class="lg:hidden text-gray-500 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        <!-- MENÚ -->
        <div class="flex-1 px-4 py-6 space-y-1 overflow-y-auto">

            <!-- Links del menú principal -->
            @php
                $menuItems = [
                    [
                        'route' => 'dashboard',
                        'icon' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>',
                        'text' => 'Dashboard'
                    ],
                    [
                        'route' => 'cuentas.index',
                        'icon' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>',
                        'text' => 'Cuentas'
                    ],
                    [
                        'route' => 'categorias.index',
                        'icon' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>',
                        'text' => 'Categorías'
                    ],
                    [
                        'route' => 'transacciones.index',
                        'icon' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/></svg>',
                        'text' => 'Transacciones'
                    ],
                    [
                        'route' => 'transacciones.hoja-calculo',
                        'icon' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2m6-2v2M3 9h18M5 9v12a2 2 0 002 2h10a2 2 0 002-2V9M5 9l1-2h12l1 2M7 13h2m4 0h2m4 0h2"/></svg>',
                        'text' => 'Hoja Cálculo'
                    ],
                    [
                        'route' => 'analistajr.index',
                        'icon' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>',
                        'text' => 'Analista Datos'
                    ],
                    [
                        'route' => 'transaccionesinternas.index',
                        'icon' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round"stroke-linejoin="round"stroke-width="2"d="M4 12a8 8 0 0113.66-5.66L20 8"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12a8 8 0 01-13.66 5.66L4 16"/>
                            </svg>',
                        'text' => 'Transacciones internas'
                    ],
                    [
                        'route' => 'numeros-whatsapp.index',
                        'icon' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>',
                        'text' => 'WhatsApp'
                    ],
                    [
                        'route' => 'chat.index',
                        'icon' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>',
                        'text' => 'Asesor IA'
                    ],
                    [
                        'route' => 'mcp-tokens.index',
                        'icon' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/></svg>',
                        'text' => 'Integraciones IA'
                    ],
                ];
            @endphp

            @foreach($menuItems as $item)
                @php
                    $isActive = match($item['route']) {
                        'dashboard' => request()->routeIs('dashboard'),
                        'cuentas.index' => request()->routeIs('cuentas.*'),
                        'categorias.index' => request()->routeIs('categorias.*'),
                        'transacciones.index' => request()->routeIs('transacciones.*'),
                        'transacciones.hoja-calculo' => request()->routeIs('transacciones.hoja-calculo'),
                        'analistajr.index' => request()->routeIs('analistajr.*'),
                        'transaccionesinternas.index' => request()->routeIs('transaccionesinternas.*'),
                        'numeros-whatsapp.index' => request()->routeIs('numeros-whatsapp.*'),
                        'chat.index' => request()->routeIs('chat.*'),
                        'mcp-tokens.index' => request()->routeIs('mcp-tokens.*'),
                        default => false,
                    };
                @endphp
                <a href="{{ route($item['route']) }}"
                   onclick="if(window.innerWidth < 1024) toggleSidebar();"
                   @class([
                       'hud-navitem flex items-center gap-2.5 px-3 py-2 rounded-lg transition-colors group',
                       'is-active bg-red-50 text-red-700 border border-red-200 dark:bg-red-500/10 dark:text-red-300 dark:border-red-500/20' => $isActive,
                       'hover:bg-gray-100 text-gray-600 dark:hover:bg-white/5 dark:text-gray-300' => !$isActive,
                   ])>
                    <div @class([
                        'flex items-center justify-center w-6 h-6 rounded',
                        'text-red-600 dark:text-red-400' => $isActive,
                        'text-gray-400 group-hover:text-gray-600 dark:text-gray-400 dark:group-hover:text-gray-300' => !$isActive,
                    ])>
                        {!! $item['icon'] !!}
                    </div>
                    <span class="text-[13px] font-medium {{ $isActive ? '' : 'group-hover:text-gray-900 dark:group-hover:text-gray-100' }}">{{ $item['text'] }}</span>
                </a>
            @endforeach

        </div>
    </div>
</nav>

<script>
function toggleSidebar() {
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('sidebar-overlay');

    sidebar.classList.toggle('-translate-x-full');
    overlay.classList.toggle('hidden');

    // Prevenir scroll en body cuando el sidebar está abierto
    if (!sidebar.classList.contains('-translate-x-full')) {
        document.body.style.overflow = 'hidden';
    } else {
        document.body.style.overflow = 'auto';
    }
}

// Cerrar sidebar al hacer clic en un enlace (en móviles)
document.querySelectorAll('#sidebar a').forEach(link => {
    link.addEventListener('click', function(e) {
        if (window.innerWidth < 1024 && !this.target === '_blank') {
            toggleSidebar();
        }
    });
});

// Cerrar sidebar al redimensionar a escritorio
window.addEventListener('resize', function() {
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('sidebar-overlay');

    if (window.innerWidth >= 1024) {
        sidebar.classList.remove('-translate-x-full');
        overlay.classList.add('hidden');
        document.body.style.overflow = 'auto';
    } else if (window.innerWidth < 1024 && !sidebar.classList.contains('-translate-x-full')) {
        sidebar.classList.add('-translate-x-full');
        overlay.classList.add('hidden');
        document.body.style.overflow = 'auto';
    }
});

</script>
