<head>
    <!-- Google Fonts: Montserrat -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        nav {
            font-family: 'Montserrat', system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
        }

        /* ===== LINKS ===== */
        .sidebar-link {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 14px 18px;
            border-radius: 14px;
            font-size: 13.5px;
            font-weight: 500;
            color: #d1d5db;
            text-decoration: none;
            border-left: 4px solid transparent;
            transition: background-color .2s ease, color .2s ease;
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
            width: 20px;
            height: 20px;
            flex-shrink: 0;
            color: inherit;
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

        <!-- Dashboard -->
        <a href="{{ route('dashboard') }}"
           @class(['sidebar-link','is-active' => request()->routeIs('dashboard')])>
            <svg class="sidebar-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                <path d="M3 13h8V3H3v10Zm10 8h8V11h-8v10ZM3 21h8v-6H3v6Zm10-18v6h8V3h-8Z"/>
            </svg>
            <span>Dashboard</span>
        </a>

        <!-- Cuentas -->
        <a href="{{ route('cuentas.index') }}"
           @class(['sidebar-link','is-active' => request()->routeIs('cuentas.*')])>
            <svg class="sidebar-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                <path d="M3 10h18M5 6h14a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2Z"/>
            </svg>
            <span>Cuentas</span>
        </a>

        <!-- Categorías -->
        <a href="{{ route('categorias.index') }}"
           @class(['sidebar-link','is-active' => request()->routeIs('categorias.*')])>
            <svg class="sidebar-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                <path d="M4 4h6v6H4zM14 4h6v6h-6zM4 14h6v6H4zM14 14h6v6h-6z"/>
            </svg>
            <span>Categorías</span>
        </a>

        <!-- Transacciones -->
        <a href="{{ route('transacciones.index') }}"
           @class(['sidebar-link','is-active' => request()->routeIs('transacciones.*')])>
            <svg class="sidebar-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                <path d="M7 7h10l-3-3M17 17H7l3 3"/>
            </svg>
            <span>Transacciones</span>
        </a>

        <!-- Transacciones internas -->
        <a href="{{ route('transaccionesinternas.index') }}"
           @class(['sidebar-link','is-active' => request()->routeIs('infocomisionesinternas.*')])>
            <svg class="sidebar-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                <path d="M8 7l-4 4 4 4M16 7l4 4-4 4"/>
            </svg>
            <span>Transacciones internas</span>
        </a>

        <!-- WhatsApp -->
        <a href="{{ route('numeros-whatsapp.index') }}"
           @class(['sidebar-link','is-active' => request()->routeIs('numeros-whatsapp.*')])>
            <svg class="sidebar-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                <path d="M3 21l1.5-4.5A9 9 0 1 1 21 12a9 9 0 0 1-9 9c-1.6 0-3.1-.4-4.5-1.1L3 21Z"/>
            </svg>
            <span>WhatsApp</span>
        </a>

    </div>

    <!-- USUARIO -->
    <div class="p-4 border-t border-white/10 relative">

        <!-- DROPDOWN -->
        <div id="user-menu" class="absolute bottom-full left-4 right-4 mb-3 z-50 hidden">
            <div class="bg-[#14161c] border border-white/10 rounded-xl shadow-xl overflow-hidden">
                <a href="{{ route('profile.edit') }}"
                   class="block px-4 py-3 text-sm text-gray-300 hover:bg-red-500/15 hover:text-red-300 transition">
                    Perfil
                </a>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="w-full text-left px-4 py-3 text-sm text-gray-300 hover:bg-red-500/15 hover:text-red-300 transition">
                        Cerrar sesión
                    </button>
                </form>
            </div>
        </div>

        <!-- TARJETA -->
        <div
            class="flex items-center justify-between bg-white/5 rounded-xl px-4 py-3 cursor-pointer"
            onclick="document.getElementById('user-menu').classList.toggle('hidden')"
        >
            <div class="flex items-center gap-4 min-w-0">
                <div class="w-9 h-9 rounded-full bg-red-500/20 flex items-center justify-center">
                    <svg class="w-5 h-5 text-red-300" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                        <path d="M20 21a8 8 0 0 0-16 0M12 11a4 4 0 1 0 0-8 4 4 0 0 0 0 8Z"/>
                    </svg>
                </div>

                <div class="min-w-0">
                    <p class="text-sm font-medium truncate">{{ Auth::user()->name }}</p>
                    <p class="text-xs text-gray-400 truncate">{{ Auth::user()->email }}</p>
                </div>
            </div>

            <svg class="w-5 h-5 text-gray-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                <path d="M6 9l6 6 6-6"/>
            </svg>
        </div>

    </div>

</nav>