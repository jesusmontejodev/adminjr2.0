<nav class="w-[300px] min-h-screen bg-[#0e0f13] text-gray-200 flex flex-col border-r border-white/5">

    <!-- LOGO -->
    <div class="px-6 py-5 border-b border-white/10">
        <a href="{{ route('dashboard') }}" class="flex items-center gap-3">
            <x-application-logo class="w-8 h-8"/>
            <span class="text-xl font-semibold tracking-wide">Avaspace</span>
        </a>
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
                    'route' => 'transaccionesinternas.index',
                    'icon' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/></svg>',
                    'text' => 'Transacciones internas'
                ],
                [
                    'route' => 'numeros-whatsapp.index',
                    'icon' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>',
                    'text' => 'WhatsApp'
                ],
            ];
        @endphp

        @foreach($menuItems as $item)
            <a href="{{ route($item['route']) }}"
               @class([
                   'flex items-center gap-3 px-4 py-3 rounded-lg transition-colors group',
                   'bg-red-500/10 text-red-300 border border-red-500/20' =>
                       ($item['route'] === 'dashboard' && request()->routeIs('dashboard')) ||
                       ($item['route'] === 'cuentas.index' && request()->routeIs('cuentas.*')) ||
                       ($item['route'] === 'categorias.index' && request()->routeIs('categorias.*')) ||
                       ($item['route'] === 'transacciones.index' && request()->routeIs('transacciones.*')) ||
                       ($item['route'] === 'transaccionesinternas.index' && request()->routeIs('transaccionesinternas.*')) ||
                       ($item['route'] === 'numeros-whatsapp.index' && request()->routeIs('numeros-whatsapp.*')),
                   'hover:bg-white/5 text-gray-300' => !(
                       ($item['route'] === 'dashboard' && request()->routeIs('dashboard')) ||
                       ($item['route'] === 'cuentas.index' && request()->routeIs('cuentas.*')) ||
                       ($item['route'] === 'categorias.index' && request()->routeIs('categorias.*')) ||
                       ($item['route'] === 'transacciones.index' && request()->routeIs('transacciones.*')) ||
                       ($item['route'] === 'transaccionesinternas.index' && request()->routeIs('transaccionesinternas.*')) ||
                       ($item['route'] === 'numeros-whatsapp.index' && request()->routeIs('numeros-whatsapp.*'))
                   ),
               ])>
                <div @class([
                    'flex items-center justify-center w-8 h-8 rounded',
                    'text-red-400' =>
                        ($item['route'] === 'dashboard' && request()->routeIs('dashboard')) ||
                        ($item['route'] === 'cuentas.index' && request()->routeIs('cuentas.*')) ||
                        ($item['route'] === 'categorias.index' && request()->routeIs('categorias.*')) ||
                        ($item['route'] === 'transacciones.index' && request()->routeIs('transacciones.*')) ||
                        ($item['route'] === 'transaccionesinternas.index' && request()->routeIs('transaccionesinternas.*')) ||
                        ($item['route'] === 'numeros-whatsapp.index' && request()->routeIs('numeros-whatsapp.*')),
                    'text-gray-400 group-hover:text-gray-300' => !(
                        ($item['route'] === 'dashboard' && request()->routeIs('dashboard')) ||
                        ($item['route'] === 'cuentas.index' && request()->routeIs('cuentas.*')) ||
                        ($item['route'] === 'categorias.index' && request()->routeIs('categorias.*')) ||
                        ($item['route'] === 'transacciones.index' && request()->routeIs('transacciones.*')) ||
                        ($item['route'] === 'transaccionesinternas.index' && request()->routeIs('transaccionesinternas.*')) ||
                        ($item['route'] === 'numeros-whatsapp.index' && request()->routeIs('numeros-whatsapp.*'))
                    ),
                ])>
                    {!! $item['icon'] !!}
                </div>
                <span class="text-sm font-medium">{{ $item['text'] }}</span>
            </a>
        @endforeach

        <!-- Sección de Suscripción -->
        <div class="pt-4 mt-4 border-t border-white/10">
            <div class="px-4 mb-3">
                <span class="text-xs font-semibold text-gray-400 uppercase tracking-wider">
                    Suscripción
                </span>
            </div>

            <!-- Link a Planes -->
            <a href="{{ route('planes') }}"
               @class([
                   'flex items-center gap-3 px-4 py-3 rounded-lg transition-colors',
                   'bg-yellow-500/10 text-yellow-300 border border-yellow-500/20' => request()->routeIs('planes'),
                   'hover:bg-white/5 text-gray-300' => !request()->routeIs('planes'),
               ])>
                <div @class([
                    'flex items-center justify-center w-8 h-8 rounded',
                    'text-yellow-400' => request()->routeIs('planes'),
                    'text-gray-400' => !request()->routeIs('planes'),
                ])>
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                    </svg>
                </div>
                <span class="flex-1 text-sm font-medium">Planes Premium</span>
                @if(auth()->user()->tieneSuscripcionActiva())
                    <span class="px-2 py-1 text-xs font-medium rounded-md bg-gradient-to-r from-green-900/40 to-emerald-900/40 text-green-400 border border-green-700/30">
                        Activo
                    </span>
                @else
                    <span class="px-2 py-1 text-xs font-medium rounded-md bg-gradient-to-r from-yellow-900/40 to-amber-900/40 text-yellow-400 border border-yellow-700/30">
                        Gratis
                    </span>
                @endif
            </a>

            <!-- Estado de Suscripción -->
            @auth
                <div class="px-4 py-3">
                    <div class="mb-2">
                        <div class="flex justify-between items-center mb-3">
                            <span class="text-xs text-gray-400">Plan Actual</span>
                            <span class="text-xs font-medium text-gray-300">
                                @if(auth()->user()->tieneAccesoPremium())
                                    <div class="flex items-center">
                                        <svg class="w-3 h-3 mr-1 text-yellow-500" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                        </svg>
                                        Premium
                                    </div>
                                @else
                                    <div class="flex items-center">
                                        <svg class="w-3 h-3 mr-1 text-gray-500" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                                        </svg>
                                        Básico
                                    </div>
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
                                <div class="h-1.5 w-full bg-gray-800 rounded-full overflow-hidden">
                                    @php
                                        $whatsappUsage = auth()->user()->getLimiteWhatsApp() > 0
                                            ? (auth()->user()->numerosWhatsApp()->count() / auth()->user()->getLimiteWhatsApp()) * 100
                                            : 0;
                                        $whatsappColor = $whatsappUsage >= 90 ? 'bg-red-500' :
                                                        ($whatsappUsage >= 70 ? 'bg-yellow-500' : 'bg-green-500');
                                    @endphp
                                    <div class="h-full {{ $whatsappColor }} transition-all duration-300"
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
                                <div class="h-1.5 w-full bg-gray-800 rounded-full overflow-hidden">
                                    @php
                                        $cuentasUsage = auth()->user()->getLimiteCuentas() > 0
                                            ? (auth()->user()->cuentas()->count() / auth()->user()->getLimiteCuentas()) * 100
                                            : 0;
                                        $cuentasColor = $cuentasUsage >= 90 ? 'bg-red-500' :
                                                       ($cuentasUsage >= 70 ? 'bg-yellow-500' : 'bg-green-500');
                                    @endphp
                                    <div class="h-full {{ $cuentasColor }} transition-all duration-300"
                                         style="width: {{ min($cuentasUsage, 100) }}%"></div>
                                </div>
                            </div>
                        @endif

                        <!-- Estado y Acciones -->
                        <div class="mt-4 space-y-2">
                            @if(auth()->user()->tieneSuscripcionActiva())
                                @if(auth()->user()->enPeriodoDeGracia())
                                    <div class="flex items-center text-xs text-yellow-400 bg-yellow-900/20 px-3 py-2 rounded-lg border border-yellow-800/30">
                                        <svg class="w-3 h-3 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                                        </svg>
                                        Acceso hasta {{ auth()->user()->getFechaFinSuscripcion()->format('d/m') }}
                                    </div>
                                @else
                                    <div class="flex items-center text-xs text-green-400 bg-green-900/20 px-3 py-2 rounded-lg border border-green-800/30">
                                        <svg class="w-3 h-3 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                        </svg>
                                        Activo
                                    </div>
                                @endif

                                <div class="flex gap-2">
                                    <a href="{{ route('suscripcion.portal-facturacion') }}"
                                       target="_blank"
                                       class="flex-1 text-center text-xs px-3 py-2 bg-gray-800 hover:bg-gray-700 text-gray-300 rounded-lg border border-gray-700 transition flex items-center justify-center">
                                        <svg class="w-3 h-3 mr-1.5" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M4 4a2 2 0 00-2 2v1h16V6a2 2 0 00-2-2H4z"/>
                                            <path fill-rule="evenodd" d="M18 9H2v5a2 2 0 002 2h12a2 2 0 002-2V9zM4 13a1 1 0 011-1h1a1 1 0 110 2H5a1 1 0 01-1-1zm5-1a1 1 0 100 2h1a1 1 0 100-2H9z" clip-rule="evenodd"/>
                                        </svg>
                                        Gestionar
                                    </a>

                                    @if(auth()->user()->enPeriodoDeGracia())
                                        <form method="POST" action="{{ route('suscripcion.reanudar') }}" class="flex-1">
                                            @csrf
                                            <button type="submit"
                                                    class="w-full text-center text-xs px-3 py-2 bg-red-900/30 hover:bg-red-800/30 text-red-300 rounded-lg border border-red-700/30 transition flex items-center justify-center">
                                                <svg class="w-3 h-3 mr-1.5" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" clip-rule="evenodd"/>
                                                </svg>
                                                Reanudar
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            @else
                                <!-- Usuario Gratis -->
                                <div class="flex items-center text-xs text-gray-400 bg-gray-800/30 px-3 py-2 rounded-lg border border-gray-700/30">
                                    <svg class="w-3 h-3 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                                    </svg>
                                    Acceso limitado
                                </div>

                                <a href="{{ route('planes') }}"
                                   class="block text-center text-xs px-3 py-2 bg-gradient-to-r from-red-600 to-red-700 hover:from-red-500 hover:to-red-600 text-white font-semibold rounded-lg transition flex items-center justify-center">
                                    <svg class="w-3 h-3 mr-1.5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M11.3 1.046A1 1 0 0112 2v5h4a1 1 0 01.82 1.573l-7 10A1 1 0 018 18v-5H4a1 1 0 01-.82-1.573l7-10a1 1 0 011.12-.38z" clip-rule="evenodd"/>
                                    </svg>
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
        <!-- DROPDOWN FLOTANTE -->
        <div class="absolute bottom-full left-4 right-4 mb-2 z-50 hidden" id="user-menu">
            <div class="bg-[#14161c] border border-white/10 rounded-lg shadow-xl overflow-hidden">
                <!-- Opción de Perfil -->
                <a href="{{ route('profile.edit') }}"
                   class="flex items-center px-4 py-3 text-sm text-gray-300 hover:bg-red-500/10 hover:text-red-300 transition">
                    <svg class="w-4 h-4 mr-3 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                    </svg>
                    Perfil
                </a>

                <!-- Facturas si tiene suscripción -->
                @auth
                    @if(auth()->user()->tieneSuscripcionActiva())
                        <a href="{{ route('suscripcion.facturas') }}"
                           class="flex items-center px-4 py-3 text-sm text-gray-300 hover:bg-red-500/10 hover:text-red-300 transition">
                            <svg class="w-4 h-4 mr-3 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2h6a2 2 0 002-2V6a2 2 0 00-2-2H4zm2 6a1 1 0 011-1h1a1 1 0 110 2H7a1 1 0 01-1-1zm5-1a1 1 0 100 2h1a1 1 0 100-2h-1z" clip-rule="evenodd"/>
                                <path d="M13.828 7.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101a.75.75 0 00-.363-1.176.75.75 0 00-.927.238l-.94 1.004a2.5 2.5 0 113.536-3.536l4-4a2.5 2.5 0 013.536 3.536l-1.004.94a.75.75 0 001.176.363l1.101-1.102a4 4 0 000-5.656z"/>
                            </svg>
                            Facturas
                        </a>

                        <a href="{{ route('suscripcion.portal-facturacion') }}"
                           target="_blank"
                           class="flex items-center px-4 py-3 text-sm text-gray-300 hover:bg-red-500/10 hover:text-red-300 transition">
                            <svg class="w-4 h-4 mr-3 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M4 4a2 2 0 00-2 2v1h16V6a2 2 0 00-2-2H4z"/>
                                <path fill-rule="evenodd" d="M18 9H2v5a2 2 0 002 2h12a2 2 0 002-2V9zM4 13a1 1 0 011-1h1a1 1 0 110 2H5a1 1 0 01-1-1zm5-1a1 1 0 100 2h1a1 1 0 100-2H9z" clip-rule="evenodd"/>
                            </svg>
                            Gestión de Suscripción
                        </a>
                    @endif
                @endauth

                <!-- Planes -->
                <a href="{{ route('planes') }}"
                   class="flex items-center px-4 py-3 text-sm text-gray-300 hover:bg-red-500/10 hover:text-red-300 transition">
                    <svg class="w-4 h-4 mr-3 text-yellow-500" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                    </svg>
                    Planes Premium
                </a>

                <!-- Separador -->
                <div class="border-t border-white/10 my-1"></div>

                <!-- Cerrar Sesión -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button
                        type="submit"
                        class="flex items-center w-full text-left px-4 py-3 text-sm text-gray-300 hover:bg-red-500/10 hover:text-red-300 transition">
                        <svg class="w-4 h-4 mr-3 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M3 3a1 1 0 00-1 1v12a1 1 0 001 1h12a1 1 0 001-1V4a1 1 0 00-1-1H3zm10.293 9.293a1 1 0 001.414 1.414l3-3a1 1 0 000-1.414l-3-3a1 1 0 10-1.414 1.414L14.586 9H7a1 1 0 100 2h7.586l-1.293 1.293z" clip-rule="evenodd"/>
                        </svg>
                        Cerrar sesión
                    </button>
                </form>
            </div>
        </div>

        <!-- TARJETA USUARIO -->
        <div
            class="flex items-center justify-between bg-white/5 rounded-lg px-4 py-3 cursor-pointer hover:bg-white/10 transition"
            onclick="document.getElementById('user-menu').classList.toggle('hidden')"
        >
            <div class="flex items-center gap-3 min-w-0">
                <!-- Avatar -->
                <div class="relative">
                    <div class="w-9 h-9 rounded-full bg-red-500/20 flex items-center justify-center">
                        <svg class="w-5 h-5 text-red-300" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <!-- Indicador de plan premium -->
                    @auth
                        @if(auth()->user()->tieneAccesoPremium())
                            <div class="absolute -top-1 -right-1 w-4 h-4 bg-yellow-500 rounded-full flex items-center justify-center">
                                <svg class="w-2 h-2 text-black" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
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
                                    Premium
                                </span>
                            @else
                                <span class="text-gray-500">Plan Gratis</span>
                            @endif
                        @endauth
                    </p>
                </div>
            </div>

            <svg class="w-5 h-5 text-gray-400 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
            </svg>
        </div>
    </div>

</nav>

<script>
    // Cerrar dropdown al hacer clic fuera
    document.addEventListener('click', function(event) {
        const userMenu = document.getElementById('user-menu');
        const userCard = document.querySelector('.p-4.border-t.border-white\\/10');

        if (!userCard.contains(event.target)) {
            userMenu.classList.add('hidden');
        }
    });
</script>
