<head>
    <!-- Google Fonts: Montserrat -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Material Icons -->
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet"/>

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
            font-size: 13.5px; /* reducido */
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

        /* ===== SCROLL ===== */
        nav ::-webkit-scrollbar {
            width: 6px;
        }

        nav ::-webkit-scrollbar-thumb {
            background-color: rgba(255, 255, 255, 0.15);
            border-radius: 10px;
        }

        /* ===== DROPDOWN USUARIO OVERLAY ===== */
        .user-dropdown {
            position: absolute;
            bottom: 72px; /* se monta sobre el perfil */
            right: 16px;
            z-index: 50;
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

    <!-- Navegación Principal -->
    <div class="flex-1 px-4 py-6 space-y-2 overflow-y-auto">
        <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
            📊 Dashboard
        </x-nav-link>
        {{-- <x-nav-link :href="route('analistajr.index')" :active="request()->routeIs('analistajr.index')">
            🧠 Analista de datos Jr.
        </x-nav-link> --}}
        <x-nav-link :href="route('cuentas.index')" :active="request()->routeIs('cuentas.*')">
            💳 Cuentas
        </x-nav-link>
        <x-nav-link :href="route('categorias.index')" :active="request()->routeIs('categorias.*')">
            🗂️ Categorías
        </x-nav-link>
        <x-nav-link :href="route('transacciones.index')" :active="request()->routeIs('transacciones.*')">
            💸 Transacciones
        </x-nav-link>
        <x-nav-link :href="route('transaccionesinternas.index')" :active="request()->routeIs('infocomisionesinternas.*')">
            🔁 Transacciones internas
        </x-nav-link>

    </div>

    <!-- USUARIO -->
    <div class="p-4 border-t border-white/10 relative">

        <div class="flex items-center justify-between bg-white/5 rounded-xl px-4 py-3">

            <div class="flex items-center gap-4 min-w-0">
                <div class="w-9 h-9 rounded-full bg-red-500/20 flex items-center justify-center">
                    <span class="material-symbols-outlined text-red-300">person</span>
                </div>

                <div class="min-w-0">
                    <p class="text-sm font-medium truncate">{{ Auth::user()->name }}</p>
                    <p class="text-xs text-gray-400 truncate">{{ Auth::user()->email }}</p>
                </div>
            </div>

            <!-- DROPDOWN -->
            <x-dropdown align="right" width="48" class="user-dropdown">
                <x-slot name="trigger">
                    <button class="text-gray-400 hover:text-white transition">
                        <span class="material-symbols-outlined">expand_more</span>
                    </button>
                </x-slot>

                <x-slot name="content">
                    <x-dropdown-link :href="route('profile.edit')">
                        Perfil
                    </x-dropdown-link>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <x-dropdown-link
                            :href="route('logout')"
                            onclick="event.preventDefault(); this.closest('form').submit();">
                            Cerrar sesión
                        </x-dropdown-link>
                    </form>
                </x-slot>
            </x-dropdown>

        </div>
    </div>

</nav>