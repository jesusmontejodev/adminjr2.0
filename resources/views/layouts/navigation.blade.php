<head>
    <!-- Google Fonts: Montserrat -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">

    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined"
    rel="stylesheet" />

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
        font-size: 13.5px; /* 👈 REDUCIDO */
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


    </div>

    <!-- USUARIO -->
    <div class="p-4 border-t border-white/10">
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

            <x-dropdown align="right" width="48">
                <x-slot name="trigger">
                    <button class="text-gray-400 hover:text-white transition">
                        <span class="material-symbols-outlined">expand_more</span>
                    </button>
                </x-slot>

                <x-slot name="content">
                    <x-dropdown-link :href="route('profile.edit')">Perfil</x-dropdown-link>
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