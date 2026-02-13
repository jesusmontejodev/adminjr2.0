<x-app-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 space-y-12">

        {{-- ================= HEADER ================= --}}
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">

            <div class="space-y-3">
    <div class="flex flex-wrap items-center gap-3">
        <section class="whatsapp-section">
            <h2 class="text-2xl font-bold flex items-center gap-2">
                <span class="icon-circle">
                <svg class="w-6 h-6 text-red-500"
                        xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 32 32"
                        fill="currentColor"
                        aria-hidden="true">
                    <path d="M16 3C9.373 3 4 8.373 4 15c0 2.637.87 5.073 2.33 7.054L4 29l7.194-2.25A11.94 11.94 0 0016 27c6.627 0 12-5.373 12-12S22.627 3 16 3zm0 21.5a9.43 9.43 0 01-4.816-1.324l-.344-.203-4.266 1.332 1.39-4.15-.223-.37A9.454 9.454 0 016.5 15C6.5 9.757 10.757 5.5 16 5.5S25.5 9.757 25.5 15 21.243 24.5 16 24.5zm4.792-6.82c-.262-.132-1.55-.764-1.79-.85-.24-.088-.414-.132-.588.132-.174.262-.676.85-.83 1.026-.152.174-.304.196-.566.064-.262-.132-1.108-.408-2.11-1.3-.78-.696-1.306-1.556-1.458-1.818-.152-.262-.016-.404.116-.536.12-.118.262-.304.394-.458.132-.152.174-.262.262-.436.088-.174.044-.326-.022-.458-.064-.132-.588-1.418-.806-1.946-.212-.51-.426-.44-.588-.448-.152-.008-.326-.01-.5-.01s-.458.064-.698.326c-.24.262-.918.894-.918 2.178 0 1.284.94 2.524 1.072 2.7.132.174 1.85 2.82 4.48 3.954.626.27 1.114.432 1.494.554.628.2 1.2.172 1.652.104.504-.074 1.55-.634 1.77-1.246.218-.612.218-1.136.152-1.246-.064-.108-.24-.174-.502-.306z"/>
                </svg>
                </span>
                WhatsApp connection
            </h2>
        </section>

        <span class="badge-whatsapp-on">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M9 12l2 2 4-4"/>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M12 21a9 9 0 100-18 9 9 0 000 18z"/>
            </svg>
            WhatsApp on
        </span>
                </div>
                <p class="text-gray-700 dark:text-neutral-400 max-w-xl">
                    Gestiona y configura tus números de WhatsApp
                </p>

            </div>

            <a href="{{ route('numeros-whatsapp.create') }}"
               class="btn-secondary inline-flex items-center gap-2 w-fit">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 5v14"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M5 12h14"/>
                </svg>
                Nuevo número
            </a>

        </div>

        {{-- ================= SUCCESS ================= --}}
        @if (session('success'))
            <div
                class="p-4 rounded-xl border border-green-500/40 bg-green-500/15
                       text-green-300 flex items-center gap-3">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4 12l3 3 5-5"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 12l3 3 7-7"/>
                </svg>
                {{ session('success') }}
            </div>
        @endif

        {{-- ================= RESUMEN ================= --}}
        <div class="space-y-6">

            @if($numeros->isNotEmpty())
                <div class="list-card">
                                        <div class="flex items-start gap-6">
                        <span class="icon-circle">
                            <svg class="w-6 h-6 text-red-500"
                                xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 24 24"
                                fill="currentColor"
                                aria-hidden="true">
                                <path d="M21 6.5a2.5 2.5 0 00-2.5-2.5H5.5A2.5 2.5 0 003 6.5v7A2.5 2.5 0 005.5 16H9l3 3 3-3h3.5A2.5 2.5 0 0021 13.5v-7z"/>
                            </svg>
                        </span>
                        <div>

                           <h3 class="text-lg font-semibold text-gray-900 dark:text-neutral-200">
                                Números Totales
                            </h3>

                            <p class="text-3xl font-bold text-red-600 mt-1">
                                {{ $numeros->count() }}
                            </p>


                           <p class="text-sm text-neutral-400 mt-2">
                                Total de números conectados a WhatsApp Business
                            </p>
                        </div>
                    </div>
                </div>
            @endif

            @if($numeros->isEmpty())
                <div class="list-card">
                    <div class="flex items-start gap-6">
                    <div class="icon-box shrink-0">
                        <svg class="w-6 h-6 text-green-400"
                            xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 24 24"
                            fill="currentColor"
                            aria-hidden="true">
                            <path d="M7 5h10a4 4 0 014 4v5a4 4 0 01-4 4h-3l-2.5 2.5L9 18H7a4 4 0 01-4-4V9a4 4 0 014-4z"/>
                        </svg>
                    </div>
                </div>


                        <div>
                            <h3 class="text-xl font-semibold text-white">
                                <span class="text-red-500 font-bold">
                                    Sin números configurados
                                </span>
                            </h3>

                            <p class="text-gray-400 text-sm mt-2 mb-4">
                                Conecta tu primer número de WhatsApp Business
                            </p>

                            <a href="{{ route('numeros-whatsapp.create') }}" class="btn-secondary">
                                + Conectar número
                            </a>
                        </div>
                    </div>
                </div>
            @endif

        </div>

        {{-- ================= GRID TARJETAS ================= --}}
        @if(!$numeros->isEmpty())
            <div class="grid grid-cols-1 md:grid-cols-2 2xl:grid-cols-3 gap-x-10 gap-y-12">


                @foreach($numeros as $numero)
                    <div class="numero-card relative overflow-hidden">

                        {{-- HEADER --}}
                       <div class="p-6 border-b border-white/10 flex justify-between items-start">
                            <div class="flex items-center gap-3">
                                <div>
                                    <span class="icon-circle">
                                        <svg class="w-5 h-5 text-red-500"
                                            xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 24 24"
                                            fill="currentColor"
                                            aria-hidden="true">
                                            <path d="M22 16.92v3a2 2 0 0 1-2.18 2
                                                    19.86 19.86 0 0 1-8.63-3.07
                                                    19.5 19.5 0 0 1-6-6
                                            19.86 19.86 0 0 1-3.07-8.67
                                            A2 2 0 0 1 4.11 2h3
                                            a2 2 0 0 1 2 1.72
                                            c.12.81.3 1.6.54 2.36
                                            a2 2 0 0 1-.45 2.11L8.09 9.91
                                            a16 16 0 0 0 6 6
                                            l1.72-1.72
                                            a2 2 0 0 1 2.11-.45
                                            c.76.24 1.55.42 2.36.54
                                            a2 2 0 0 1 1.72 2z"/>
                                </svg>
                            </span>
                        </div>
                                <div>
                                    <h3 class="font-semibold text-white">
                                        {{ $numero->numero_internacional }}
                                    </h3>
                                   <p class="text-xs text-neutral-500">
                                        ID: {{ substr($numero->id, 0, 8) }}...
                                    </p>
                                </div>
                            </div>

                    {{-- BOTÓN EDITAR / OPCIONES --}}
                <a href="{{ route('numeros-whatsapp.edit', $numero->id) }}"
                class="p-2 text-gray-400 hover:text-white transition cursor-pointer">
                    <svg class="w-5 h-5"
                        fill="currentColor"
                        viewBox="0 0 24 24">
                        <circle cx="12" cy="5" r="1.8"/>
                        <circle cx="12" cy="12" r="1.8"/>
                        <circle cx="12" cy="19" r="1.8"/>
                    </svg>
                </a>


                        </div>

                        {{-- BADGE --}}
                        <div class="px-6 pt-4">
                            <span
                                class="inline-flex px-3 py-1 rounded-full text-xs
                                       bg-white/10 border border-white/20 text-gray-300">
                                Personal
                            </span>
                        </div>

                        {{-- INFO --}}
                        <div class="p-6 grid grid-cols-2 gap-6">
                            <div class="info-box">
                                <svg class="w-4 h-4 text-gray-400"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                    stroke-width="2"
                    stroke-linecap="round"
                    stroke-linejoin="round">
                    <path d="M22 16.92v3a2 2 0 0 1-2.18 2
                            19.86 19.86 0 0 1-8.63-3.07
                            19.5 19.5 0 0 1-6-6
                            19.86 19.86 0 0 1-3.07-8.67
                            A2 2 0 0 1 4.11 2h3
                            a2 2 0 0 1 2 1.72
                            c.12.81.3 1.6.54 2.36
                            a2 2 0 0 1-.45 2.11L8.09 9.91
                            a16 16 0 0 0 6 6
                            l1.72-1.72
                            a2 2 0 0 1 2.11-.45
                            c.76.24 1.55.42 2.36.54
                            a2 2 0 0 1 1.72 2z"/>
                </svg>
                                <p>Número local</p>
                                <strong>{{ $numero->numero_local }}</strong>
                            </div>

                            <div class="info-box">
                                <svg class="w-5 h-5 text-gray-400"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24"
                stroke-width="2"
                stroke-linecap="round"
                stroke-linejoin="round">
                <!-- Círculo del planeta -->
                <circle cx="12" cy="12" r="10"/>

                <!-- Meridiano vertical -->
                <path d="M12 2a15 15 0 010 20"/>

                <!-- Meridiano horizontal -->
                <path d="M2 12h20"/>

                <!-- Paralelos -->
                <path d="M4 8h16"/>
                <path d="M4 16h16"/>
            </svg>
                                <p>País</p>
                                <strong>{{ $numero->pais }}</strong>
                            </div>
                        </div>

                        {{-- FOOTER --}}
                        <div
                            class="px-6 py-4 bg-neutral-900 border-t border-neutral-800
                            flex justify-between items-center text-sm text-neutral-400">
                            <span class="flex items-center gap-2">
                                <span class="w-2 h-2 rounded-full bg-gray-400"></span>
                                Inactivo
                            </span>

                            <span>
                                {{ $numero->created_at->diffForHumans() }}
                            </span>
                        </div>

                    </div>
                @endforeach

            </div>
        @endif

    </div>
</x-app-layout>
