<x-app-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 space-y-12">

        {{-- ================= HEADER ================= --}}
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">

            <div class="space-y-3">
                <div class="flex flex-wrap items-center gap-3">
                    <section class="whatsapp-section">
                        <h2 class="text-2xl font-bold">
                            WhatsApp connection
                        </h2>
                    </section>
                    <span
                        class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-sm font-semibold
                               border border-green-500/40 bg-green-500/10 text-green-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 21a9 9 0 100-18 9 9 0 000 18z"/>
                        </svg>
                        WhatsApp On
                    </span>
                </div>
                <p class="text-gray-700 max-w-xl">
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
                        <div class="icon-box shrink-0">
                            <svg class="w-6 h-6 text-green-400" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2l-3 3v-3H9a2 2 0 01-2-2v-1"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 4H5a2 2 0 00-2 2v6a2 2 0 002 2h2l3 3v-3h5a2 2 0 002-2V6a2 2 0 00-2-2z"/>
                            </svg>
                        </div>

                        <div>
                            <h3 class="text-lg font-semibold text-black">
                                Números Totales
                            </h3>

                            <p class="text-3xl font-bold text-green-600 mt-1">
                                {{ $numeros->count() }}
                            </p>


                            <p class="text-sm text-white-500 mt-2">
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
                            <svg class="w-6 h-6 text-green-400" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M7 6h8a3 3 0 013 3v4a3 3 0 01-3 3h-2l-3 3v-3H7a3 3 0 01-3-3V9a3 3 0 013-3z"/>
                            </svg>
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
                    <div
                        class="numero-card relative bg-white/5 border border-red-500/30 rounded-2xl
                                backdrop-blur-xl overflow-hidden transition hover:-translate-y-1
                                shadow-lg shadow-black/20">

                        {{-- HEADER --}}
                        <div class="p-6 border-b border-white/10 flex justify-between items-start">
                            <div class="flex items-center gap-3">
                                <div
                                    class="w-12 h-12 rounded-xl bg-green-500/15 border border-green-500/40
                                            flex items-center justify-center">
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
                                </div>

                                <div>
                                    <h3 class="font-semibold text-white">
                                        {{ $numero->numero_internacional }}
                                    </h3>
                                    <p class="text-xs text-gray-500">
                                        ID: {{ substr($numero->id, 0, 8) }}...
                                    </p>
                                </div>
                            </div>

                            <button class="p-2 text-gray-400 hover:text-white transition">
                                ⋮
                            </button>
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
                            class="px-6 py-4 bg-white/5 border-t border-white/10
                                   flex justify-between items-center text-sm text-gray-500">
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
