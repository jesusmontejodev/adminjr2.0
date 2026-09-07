@auth
    @php($esPremium = auth()->user()->tieneAccesoPremium())
    <div class="relative" x-data="{ open: false }" @click.outside="open = false">
        <button @click="open = !open"
                class="flex items-center gap-3 pl-3 pr-2 py-1.5 rounded-xl transition hover:bg-red-50 dark:hover:bg-red-500/10">
            <div class="text-right hidden sm:block">
                <p class="text-sm font-semibold text-gray-900 dark:text-gray-100 leading-tight">
                    {{ Auth::user()->name }}
                </p>
                <p class="text-[11px] uppercase tracking-wide leading-tight">
                    @if ($esPremium)
                        <span class="text-red-600 dark:text-red-400 font-semibold">Premium</span>
                    @else
                        <span class="text-gray-400">Plan Gratis</span>
                    @endif
                </p>
            </div>

            <div class="relative shrink-0">
                @if (Auth::user()->profile_photo_url)
                    <img src="{{ Auth::user()->profile_photo_url }}"
                         class="w-9 h-9 rounded-full object-cover {{ $esPremium ? 'ring-2 ring-red-500/50' : '' }}">
                @else
                    <div @class([
                        'w-9 h-9 rounded-full bg-red-100 dark:bg-red-500/10 flex items-center justify-center text-red-600 dark:text-red-300 font-semibold text-sm',
                        'ring-2 ring-red-500/50' => $esPremium,
                    ])>
                        {{ Auth::user()->iniciales }}
                    </div>
                @endif

                @if ($esPremium)
                    <div class="absolute -top-1 -right-1 w-4 h-4 bg-red-600 rounded-full flex items-center justify-center shadow-[0_0_8px_rgba(255,23,68,.7)]">
                        <svg class="w-2 h-2 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                        </svg>
                    </div>
                @endif
            </div>

            <svg class="w-4 h-4 text-gray-400 transition-transform hidden sm:block" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
            </svg>
        </button>

        <div x-show="open"
             x-transition
             style="display: none;"
             class="absolute right-0 top-full mt-2 w-72 z-50 rounded-2xl overflow-hidden
                    bg-white border border-gray-200 shadow-xl
                    dark:bg-black/70 dark:backdrop-blur-2xl dark:border-red-500/15
                    dark:shadow-[0_20px_45px_rgba(0,0,0,.5),inset_0_1px_0_rgba(255,255,255,.08),0_0_28px_rgba(255,23,68,.14)]">

            @if ($esPremium)
                <div class="px-4 py-3 border-b border-gray-100 dark:border-white/5">
                    <p class="text-[11px] uppercase tracking-wide text-red-600 dark:text-red-400 font-semibold mb-0.5">Premium activo</p>
                    @if (Auth::user()->access_until)
                        <p class="text-xs text-gray-500 dark:text-gray-400">
                            Hasta el {{ Auth::user()->access_until->locale('es')->isoFormat('D [de] MMMM, YYYY') }}
                        </p>
                    @endif
                </div>
            @endif

            <div class="p-1.5">
                <a href="{{ route('profile.edit') }}"
                   @click="open = false"
                   class="flex items-center gap-3 px-2.5 py-2 rounded-xl text-sm text-gray-700 dark:text-gray-200 hover:bg-red-50 dark:hover:bg-red-500/10 transition">
                    <span class="flex items-center justify-center w-8 h-8 rounded-lg bg-red-50 text-red-600 dark:bg-red-500/10 dark:text-red-400 shrink-0">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/>
                        </svg>
                    </span>
                    Perfil
                </a>

                @if ($esPremium)
                    <button type="button"
                            @click="open = false; window.__gestionarSuscripcion()"
                            class="w-full flex items-center gap-3 px-2.5 py-2 rounded-xl text-sm text-gray-700 dark:text-gray-200 hover:bg-red-50 dark:hover:bg-red-500/10 transition">
                        <span class="flex items-center justify-center w-8 h-8 rounded-lg bg-red-50 text-red-600 dark:bg-red-500/10 dark:text-red-400 shrink-0">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M2.25 8.25h19.5M2.25 9v10.5A2.25 2.25 0 004.5 21.75h15a2.25 2.25 0 002.25-2.25V9M2.25 9V6.75A2.25 2.25 0 014.5 4.5h15a2.25 2.25 0 012.25 2.25V9M6 15.75h3"/>
                            </svg>
                        </span>
                        <span class="text-left">
                            Gestionar suscripción
                            <span id="gestionar-suscripcion-spinner" class="hidden ml-1">
                                <i class="fas fa-spinner fa-spin text-xs"></i>
                            </span>
                        </span>
                    </button>
                @endif

                <a href="{{ route('planes') }}"
                   @click="open = false"
                   class="flex items-center gap-3 px-2.5 py-2 rounded-xl text-sm text-gray-700 dark:text-gray-200 hover:bg-red-50 dark:hover:bg-red-500/10 transition">
                    <span class="flex items-center justify-center w-8 h-8 rounded-lg bg-red-50 text-red-600 dark:bg-red-500/10 dark:text-red-400 shrink-0">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                        </svg>
                    </span>
                    {{ $esPremium ? 'Ver otros planes' : 'Actualizar a Premium' }}
                </a>

                <div class="border-t border-gray-100 dark:border-white/5 my-1.5"></div>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                            class="w-full flex items-center gap-3 px-2.5 py-2 rounded-xl text-sm text-gray-700 dark:text-gray-200 hover:bg-red-50 dark:hover:bg-red-500/10 hover:text-red-600 dark:hover:text-red-400 transition">
                        <span class="flex items-center justify-center w-8 h-8 rounded-lg bg-gray-100 text-gray-500 dark:bg-white/5 dark:text-gray-400 shrink-0">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75"/>
                            </svg>
                        </span>
                        Cerrar sesión
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script>
        window.__gestionarSuscripcion = function () {
            const spinner = document.getElementById('gestionar-suscripcion-spinner');
            if (spinner) spinner.classList.remove('hidden');

            fetch('{{ route('web.suscripcion.payment-link') }}', {
                method: 'GET',
                headers: {
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                credentials: 'same-origin'
            })
            .then(res => res.json())
            .then(data => {
                if (data.success && data.url) {
                    window.location.href = data.url;
                } else {
                    if (spinner) spinner.classList.add('hidden');
                    showToast(data.message || 'No se pudo abrir tu suscripción.', 'error');
                }
            })
            .catch(() => {
                if (spinner) spinner.classList.add('hidden');
                showToast('Error al conectar con el servidor.', 'error');
            });
        };
    </script>
@endauth
