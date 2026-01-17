
<style>
    nav {
        font-family: 'Montserrat', system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
    }

    /* ===== LINKS ===== */
    .sidebar-link {
        display: flex;
        align-items: center;
        gap: 9px;
        padding: 14px 18px;
        border-radius: 14px;
        font-size: 13.5px;
        font-weight: 500;
        color: #d1d5db;
        text-decoration: none;
        border-left: 4px solid transparent;
        transition: background-color 0.2s ease, color 0.2s ease;
    }

    .sidebar-link:hover {
        background-color: rgba(239, 68, 68, 0.18);
        color: #fee2e2;
    }

    .sidebar-link.is-active {
        background-color: rgba(239, 68, 68, 0.25);
        color: #fecaca;
        border-left: 4px solid #ef4444;
    }

    .sidebar-icon {
        font-size: 20px;
        display: flex;
        align-items: center;
        color: inherit;
    }

    .material-symbols-outlined {
        font-variation-settings:
            'FILL' 0,
            'wght' 400,
            'GRAD' 0,
            'opsz' 24;
    }

    nav ::-webkit-scrollbar {
        width: 6px;
    }

    nav ::-webkit-scrollbar-thumb {
        background-color: rgba(255, 255, 255, 0.15);
        border-radius: 10px;
    }

    /* Estilos para la sección de suscripción */
    .subscription-badge {
        display: inline-block;
        padding: 2px 8px;
        border-radius: 10px;
        font-size: 11px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.3px;
    }

    .subscription-progress {
        height: 4px;
        border-radius: 2px;
        overflow: hidden;
        background-color: rgba(255, 255, 255, 0.1);
    }

    .subscription-progress-bar {
        height: 100%;
        border-radius: 2px;
        transition: width 0.3s ease;
    }
</style>
</head>

<nav class="w-[300px] min-h-screen bg-[#0e0f13] text-gray-200 flex flex-col border-r border-white/5">

    <!-- LOGO -->
    <div class="px-6 py-5 border-b border-white/10">
        <a href="{{ route('dashboard') }}" class="flex items-center gap-3">
            <x-application-logo class="w-8 h-8"/>
            <span class="text-xl font-semibold tracking-wide">Avaspace</span>
        </a>
    </div>

    <!-- MENÚ -->
    <div class="flex-1 px-4 py-6 space-y-3 overflow-y-auto">

        <a href="{{ route('dashboard') }}"
           @class(['sidebar-link','is-active' => request()->routeIs('dashboard')])>
            <span class="material-symbols-outlined sidebar-icon">space_dashboard</span>
            <span>Dashboard</span>
        </a>

        <a href="{{ route('cuentas.index') }}"
           @class(['sidebar-link','is-active' => request()->routeIs('cuentas.*')])>
            <span class="material-symbols-outlined sidebar-icon">account_balance</span>
            <span>Cuentas</span>
        </a>

        <a href="{{ route('categorias.index') }}"
           @class(['sidebar-link','is-active' => request()->routeIs('categorias.*')])>
            <span class="material-symbols-outlined sidebar-icon">category</span>
            <span>Categorías</span>
        </a>

        <a href="{{ route('transacciones.index') }}"
           @class(['sidebar-link','is-active' => request()->routeIs('transacciones.*')])>
            <span class="material-symbols-outlined sidebar-icon">sync_alt</span>
            <span>Transacciones</span>
        </a>

        <a href="{{ route('transaccionesinternas.index') }}"
           @class(['sidebar-link','is-active' => request()->routeIs('infocomisionesinternas.*')])>
            <span class="material-symbols-outlined sidebar-icon">swap_horiz</span>
            <span>Transacciones internas</span>
        </a>

        <a href="{{ route('numeros-whatsapp.index') }}"
        @class(['sidebar-link', 'is-active' => request()->routeIs('numeros-whatsapp.*')])>
            <span class="material-symbols-outlined sidebar-icon">phone_iphone</span>
            <span>WhatsApp</span>
        </a>

        <!-- Sección de Suscripción -->
        <div class="pt-4 mt-4 border-t border-white/10">
            <div class="px-4 mb-3">
                <span class="text-xs font-semibold text-gray-400 uppercase tracking-wider">
                    Suscripción
                </span>
            </div>

            <!-- Link a Planes -->
            <a href="{{ route('planes') }}"
               @class(['sidebar-link', 'is-active' => request()->routeIs('planes')])>
                <span class="material-symbols-outlined sidebar-icon">workspace_premium</span>
                <span class="flex-1">Planes Premium</span>
                @if(auth()->user()->tieneSuscripcionActiva())
                    <span class="subscription-badge bg-gradient-to-r from-green-900/40 to-emerald-900/40 text-green-400 border border-green-700/30">
                        Activo
                    </span>
                @else
                    <span class="subscription-badge bg-gradient-to-r from-yellow-900/40 to-amber-900/40 text-yellow-400 border border-yellow-700/30">
                        Gratis
                    </span>
                @endif
            </a>

            <!-- Estado de Suscripción -->
            @auth
                <div class="px-4 py-3">
                    <div class="mb-2">
                        <div class="flex justify-between items-center mb-1">
                            <span class="text-xs text-gray-400">
                                {{-- @if(auth()->user()->tieneSuscripcionActiva())
                                    {{ auth()->user()->getInfoSuscripcion()['plan'] }}
                                @else
                                    Plan Gratis
                                @endif --}}
                            </span>
                            <span class="text-xs font-medium text-gray-300">
                                @if(auth()->user()->tieneAccesoPremium())
                                    <i class="fas fa-crown text-yellow-500 mr-1"></i>
                                    Premium
                                @else
                                    <i class="fas fa-user text-gray-500 mr-1"></i>
                                    Básico
                                @endif
                            </span>
                        </div>

                        <!-- Límites de Uso -->
                        @if(auth()->user()->tieneSuscripcionActiva())
                            <!-- WhatsApp Usage -->
                            <div class="mb-2">
                                <div class="flex justify-between text-xs mb-1">
                                    <span class="text-gray-400">WhatsApp</span>
                                    <span class="text-gray-300">
                                        {{ auth()->user()->numerosWhatsApp()->count() }}/{{ auth()->user()->getLimiteWhatsApp() }}
                                    </span>
                                </div>
                                <div class="subscription-progress">
                                    @php
                                        $whatsappUsage = auth()->user()->getLimiteWhatsApp() > 0
                                            ? (auth()->user()->numerosWhatsApp()->count() / auth()->user()->getLimiteWhatsApp()) * 100
                                            : 0;
                                        $whatsappColor = $whatsappUsage >= 90 ? 'bg-red-500' :
                                                        ($whatsappUsage >= 70 ? 'bg-yellow-500' : 'bg-green-500');
                                    @endphp
                                    <div class="subscription-progress-bar {{ $whatsappColor }}"
                                         style="width: {{ min($whatsappUsage, 100) }}%"></div>
                                </div>
                            </div>

                            <!-- Cuentas Usage -->
                            <div class="mb-2">
                                <div class="flex justify-between text-xs mb-1">
                                    <span class="text-gray-400">Cuentas</span>
                                    <span class="text-gray-300">
                                        {{ auth()->user()->cuentas()->count() }}/{{ auth()->user()->getLimiteCuentas() }}
                                    </span>
                                </div>
                                <div class="subscription-progress">
                                    @php
                                        $cuentasUsage = auth()->user()->getLimiteCuentas() > 0
                                            ? (auth()->user()->cuentas()->count() / auth()->user()->getLimiteCuentas()) * 100
                                            : 0;
                                        $cuentasColor = $cuentasUsage >= 90 ? 'bg-red-500' :
                                                       ($cuentasUsage >= 70 ? 'bg-yellow-500' : 'bg-green-500');
                                    @endphp
                                    <div class="subscription-progress-bar {{ $cuentasColor }}"
                                         style="width: {{ min($cuentasUsage, 100) }}%"></div>
                                </div>
                            </div>
                        @endif

                        <!-- Estado y Acciones -->
                        <div class="mt-3 space-y-2">
                            @if(auth()->user()->tieneSuscripcionActiva())
                                @if(auth()->user()->enPeriodoDeGracia())
                                    <div class="text-xs text-yellow-400 bg-yellow-900/20 px-3 py-1.5 rounded-lg border border-yellow-800/30">
                                        <i class="fas fa-clock mr-1.5"></i>
                                        Acceso hasta {{ auth()->user()->getFechaFinSuscripcion()->format('d/m') }}
                                    </div>
                                @else
                                    <div class="text-xs text-green-400 bg-green-900/20 px-3 py-1.5 rounded-lg border border-green-800/30">
                                        <i class="fas fa-check-circle mr-1.5"></i>
                                        {{-- Activo hasta {{ auth()->user()->getFechaFinSuscripcion()->format('d/m') }} --}}
                                    </div>
                                @endif

                                <div class="flex space-x-2">
                                    <a href="{{ route('suscripcion.portal-facturacion') }}"
                                       target="_blank"
                                       class="flex-1 text-center text-xs px-3 py-1.5 bg-gray-800 hover:bg-gray-700 text-gray-300 rounded-lg border border-gray-700 transition">
                                        <i class="fas fa-cog mr-1.5"></i>
                                        Gestionar
                                    </a>

                                    @if(auth()->user()->enPeriodoDeGracia())
                                        <form method="POST" action="{{ route('suscripcion.reanudar') }}" class="flex-1">
                                            @csrf
                                            <button type="submit"
                                                    class="w-full text-center text-xs px-3 py-1.5 bg-red-900/30 hover:bg-red-800/30 text-red-300 rounded-lg border border-red-700/30 transition">
                                                <i class="fas fa-play mr-1.5"></i>
                                                Reanudar
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            @else
                                <!-- Usuario Gratis -->
                                <div class="text-xs text-gray-400 bg-gray-800/30 px-3 py-1.5 rounded-lg border border-gray-700/30">
                                    <i class="fas fa-info-circle mr-1.5"></i>
                                    Acceso limitado
                                </div>

                                <a href="{{ route('planes') }}"
                                   class="block text-center text-xs px-3 py-2 bg-gradient-to-r from-red-600 to-red-700 hover:from-red-500 hover:to-red-600 text-white font-semibold rounded-lg transition">
                                    <i class="fas fa-bolt mr-1.5"></i>
                                    Mejorar Plan
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            @endauth

        </div>
        <!-- Fin Sección Suscripción -->

    </div>

    <!-- USUARIO -->
    <div class="p-4 border-t border-white/10 relative">

        <!-- DROPDOWN FLOTANTE ARRIBA -->
        <div class="absolute bottom-full left-4 right-4 mb-3 z-50 hidden group-hover:block" id="user-menu">
            <div class="bg-[#14161c] border border-white/10 rounded-xl shadow-xl overflow-hidden">
                <!-- Opción de Perfil -->
                <a href="{{ route('profile.edit') }}"
                   class="block px-4 py-3 text-sm text-gray-300 hover:bg-red-500/15 hover:text-red-300 transition">
                    <i class="fas fa-user-circle mr-3 text-gray-400"></i>
                    Perfil
                </a>

                <!-- Facturas si tiene suscripción -->
                @auth
                    @if(auth()->user()->tieneSuscripcionActiva())
                        <a href="{{ route('suscripcion.facturas') }}"
                           class="block px-4 py-3 text-sm text-gray-300 hover:bg-red-500/15 hover:text-red-300 transition">
                            <i class="fas fa-receipt mr-3 text-gray-400"></i>
                            Facturas
                        </a>

                        <a href="{{ route('suscripcion.portal-facturacion') }}"
                           target="_blank"
                           class="block px-4 py-3 text-sm text-gray-300 hover:bg-red-500/15 hover:text-red-300 transition">
                            <i class="fas fa-credit-card mr-3 text-gray-400"></i>
                            Gestión de Suscripción
                        </a>
                    @endif
                @endauth

                <!-- Planes -->
                <a href="{{ route('planes') }}"
                   class="block px-4 py-3 text-sm text-gray-300 hover:bg-red-500/15 hover:text-red-300 transition">
                    <i class="fas fa-crown mr-3 text-yellow-500"></i>
                    Planes Premium
                </a>

                <!-- Separador -->
                <div class="border-t border-white/10 my-1"></div>

                <!-- Cerrar Sesión -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button
                        type="submit"
                        class="w-full text-left px-4 py-3 text-sm text-gray-300 hover:bg-red-500/15 hover:text-red-300 transition">
                        <i class="fas fa-sign-out-alt mr-3 text-gray-400"></i>
                        Cerrar sesión
                    </button>
                </form>
            </div>
        </div>

        <!-- TARJETA USUARIO -->
        <div
            class="group flex items-center justify-between bg-white/5 rounded-xl px-4 py-3 cursor-pointer"
            onclick="document.getElementById('user-menu').classList.toggle('hidden')"
        >

            <div class="flex items-center gap-4 min-w-0">
                <!-- Avatar con indicador de plan -->
                <div class="relative">
                    <div class="w-9 h-9 rounded-full bg-red-500/20 flex items-center justify-center">
                        <span class="material-symbols-outlined text-red-300">person</span>
                    </div>
                    <!-- Indicador de plan premium -->
                    @auth
                        @if(auth()->user()->tieneAccesoPremium())
                            <div class="absolute -top-1 -right-1 w-4 h-4 bg-yellow-500 rounded-full flex items-center justify-center">
                                <i class="fas fa-crown text-[8px] text-black"></i>
                            </div>
                        @endif
                    @endauth
                </div>

                <div class="min-w-0">
                    <p class="text-sm font-medium truncate">
                        {{ Auth::user()->name }}
                    </p>
                    <p class="text-xs text-gray-400 truncate">
                        @auth
                            @if(auth()->user()->tieneSuscripcionActiva())
                                <span class="text-green-400 font-semibold">
                                    {{-- {{ auth()->user()->getInfoSuscripcion()['plan'] }} --}}
                                </span>
                            @else
                                <span class="text-gray-500">Plan Gratis</span>
                            @endif
                        @endauth
                    </p>
                </div>
            </div>

            <span class="material-symbols-outlined text-gray-400">
                expand_more
            </span>
        </div>

    </div>

</nav>

<script>
    // Mejorar el dropdown del usuario
    document.addEventListener('DOMContentLoaded', function() {
        const userCard = document.querySelector('.group');
        const userMenu = document.getElementById('user-menu');

        // Cerrar menu al hacer clic fuera
        document.addEventListener('click', function(event) {
            if (!userCard.contains(event.target) && !userMenu.contains(event.target)) {
                userMenu.classList.add('hidden');
            }
        });

        // Cerrar con Escape
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                userMenu.classList.add('hidden');
            }
        });
    });
</script>
