<nav x-data="{ open: false }" class="w-[300px] bg-white dark:bg-gray-800 shadow-lg border-r border-gray-200 dark:border-gray-700 flex flex-col">
    <style>
        .icon-pro-section{
            padding: 12px;
            border-bottom: 1px solid rgb(55 65 81 );
            gap: 0px;
        }
        .text-perfil{
            font-size: 21px
        }
    </style>

    <!-- Logo -->
    <div class="icon-pro-section">
        <a href="{{ route('dashboard') }}" class="flex items-center gap-2">
            <x-application-logo class="icon-pro"/>
            <span class="text-perfil text-lg font-bold text-gray-800 dark:text-gray-100">Avaspace</span>
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
        <x-nav-link :href="route('numeros-whatsapp.index')" :active="request()->routeIs('numeros-whatsapp.*')">
            📱 WhatsApp
        </x-nav-link>

    </div>

    <!-- Información del Usuario -->
    <div class="border-t border-gray-200 dark:border-gray-700 p-4">
        <div class="flex items-center justify-between">
            <div class="flex-1 min-w-0">
                <p class="text-sm font-medium text-gray-900 dark:text-gray-100 truncate">
                    {{ Auth::user()->name }}
                </p>
                <p class="text-sm text-gray-500 dark:text-gray-400 truncate">
                    {{ Auth::user()->email }}
                </p>
            </div>

            <!-- User Dropdown -->
            <x-dropdown align="right" width="48">
                <x-slot name="trigger">
                    <button class="flex items-center text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition-colors duration-200">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 10.94l3.71-3.71a.75.75 0 011.06 1.06l-4.24 4.24a.75.75 0 01-1.06 0L5.23 8.29a.75.75 0 01.02-1.08z" clip-rule="evenodd"/>
                        </svg>
                    </button>
                </x-slot>

                <x-slot name="content">
                    <x-dropdown-link :href="route('profile.edit')">
                        <div class="flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                            Perfil
                        </div>
                    </x-dropdown-link>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                            <div class="flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                </svg>
                                Cerrar sesión
                            </div>
                        </x-dropdown-link>
                    </form>
                </x-slot>
            </x-dropdown>
        </div>
    </div>
</nav>
