<x-app-layout>
 <!-- Glow rojo -->
    <div class="absolute inset-0 -z-10 flex justify-center items-center">
        <div class="w-[85%] h-[85%] rounded-full blur-[180px]"
            style="background: radial-gradient(circle, rgba(239,68,68,0.35) 0%, rgba(239,68,68,0.05) 45%, transparent 70%);">
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        {{-- HEADER --}}
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
            <div>
                <div class="flex items-center gap-3 mb-2">
                    <h2 class="text-2xl font-bold text-white">
                        WhatsApp connection
                    </h2>

                    <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-sm font-semibold border border-green-500/40 bg-green-500/10 text-green-400">
                        <svg class="w-4 h-4"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M9 12l2 2 4-4"/>
                            <path stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M12 21a9 9 0 100-18 9 9 0 000 18z"/>
                        </svg>
                        WhatsApp On
                    </span>

                </div>

                <p class="text-gray-400">
                    Gestiona y configura tus números de WhatsApp
                </p>
            </div>

            <a href="{{ route('numeros-whatsapp.create') }}"
                class="inline-flex items-center gap-2 px-5 py-3 rounded-xl bg-green-500/20 border border-green-500/40 text-white font-semibold hover:bg-green-500/35 transition">
                <svg class="w-4 h-4"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M12 5v14"/>
                    <path stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M5 12h14"/>
                </svg>
                Nuevo número
            </a>
        </div>

        {{-- SUCCESS --}}
        @if (session('success'))
            <div class="mb-6 p-4 rounded-xl border border-green-500/40 bg-green-500/15 text-green-300 flex items-center gap-3">
                <svg class="w-5 h-5"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24">
                    <!-- Primer check -->
                    <path stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M4 12l3 3 5-5"/>

                    <!-- Segundo check -->
                    <path stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M10 12l3 3 7-7"/>
                </svg>

                {{ session('success') }}
            </div>
        @endif

        {{-- LISTA VERTICAL --}}
<div class="space-y-6 mb-10">

    {{-- NUMEROS TOTALES (solo si hay números) --}}
    @if($numeros->isNotEmpty())
        <div class="list-card">
            <div class="flex items-start gap-6">
                <div class="icon-box shrink-0">
                    <svg class="w-6 h-6 text-green-400"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2l-3 3v-3H9a2 2 0 01-2-2v-1"/>
                        <path stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M15 4H5a2 2 0 00-2 2v6a2 2 0 002 2h2l3 3v-3h5a2 2 0 002-2V6a2 2 0 00-2-2z"/>
                    </svg>

                </div>

                <div>
                    <h3 class="text-xl font-semibold text-white mb-1">
                        <span class="text-red-500 font-bold">Números Totales</span>
                    </h3>

                    <p class="text-2xl font-bold text-white">
                        {{ $numeros->count() }}
                    </p>

                    <p class="text-sm text-gray-500 mt-3">
                        Total de números conectados a WhatsApp Business
                    </p>
                </div>
            </div>
        </div>
    @endif

    {{-- VACÍO --}}
    @if($numeros->isEmpty())
        <div class="list-card">
            <div class="flex items-start gap-6">
                <div class="icon-box shrink-0">
                    <svg class="w-6 h-6 text-green-400"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24">
                <!-- Burbuja de chat -->
                <path stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M7 6h8a3 3 0 013 3v4a3 3 0 01-3 3h-2l-3 3v-3H7a3 3 0 01-3-3V9a3 3 0 013-3z"/>
                    </svg>

                </div>

                <div>
                    <h3 class="text-xl font-semibold text-white mb-1">
                        <span class="text-red-500 font-bold">Sin números configurados</span>
                    </h3>

                    <p class="text-gray-400 text-sm mb-4">
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

        {{-- GRID TARJETAS --}}
        @if(!$numeros->isEmpty())
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

            @foreach($numeros as $numero)
<div class="numero-card relative bg-white/5 border border-red-500/30 rounded-2xl backdrop-blur-xl overflow-hidden transition hover:-translate-y-1">

    {{-- HEADER --}}
    <div class="p-6 border-b border-white/10 flex justify-between items-start relative">

        <div class="flex items-center gap-3">
            <div class="w-12 h-12 rounded-xl bg-green-500/15 border border-green-500/40 flex items-center justify-center">
                <svg class="w-4 h-4 text-gray-400"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M3 5.5a2.5 2.5 0 012.5-2.5h1.2
                            a2 2 0 012 1.6l.6 2.4
                            a2 2 0 01-.5 1.9l-1.2 1.2
                            a16 16 0 006.9 6.9l1.2-1.2
                            a2 2 0 011.9-.5l2.4.6
                            a2 2 0 011.6 2v1.2
                            A2.5 2.5 0 0118.5 21
                            A15.5 15.5 0 013 5.5z"/>
                </svg>

            </div>

            <div>
                <h3 class="font-semibold text-white text-base leading-tight">
                    {{ $numero->numero_internacional }}
                </h3>
                <p class="text-xs text-gray-500">
                    ID: {{ substr($numero->id, 0, 8) }}...
                </p>
            </div>
        </div>

        {{-- BOTÓN EDITAR / OPCIONES --}}
        <button class="p-2 text-gray-400 hover:text-white transition cursor-pointer">
            <svg class="w-5 h-5 text-gray-400"
                fill="currentColor"
                viewBox="0 0 24 24">
                <circle cx="12" cy="5" r="1.8"/>
                <circle cx="12" cy="12" r="1.8"/>
                <circle cx="12" cy="19" r="1.8"/>
            </svg>

        </button>
    </div>

    {{-- BADGE --}}
    <div class="px-6 pt-4 flex gap-2">
        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs bg-white/10 border border-white/20 text-gray-300">
            Personal
        </span>
    </div>

    {{-- INFO --}}
    <div class="p-6 space-y-4">

        <div class="grid grid-cols-2 gap-4">
            <div class="info-box flex items-center gap-2">
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
                <div>
                    <p>Número local</p>
                    <strong>{{ $numero->numero_local }}</strong>
                </div>
            </div>
             <div class="info-box flex items-center gap-3">
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
            <div>
                <p>País</p>
                <strong>{{ $numero->pais }}</strong>
            </div>
        </div>
        </div>
    </div>

    {{-- FOOTER --}}
    <div class="px-6 py-4 bg-white/5 border-t border-white/10 flex justify-between items-center">

        <div class="flex items-center gap-2 text-gray-500 text-sm">
            <span class="w-2 h-2 rounded-full bg-gray-400"></span>
            Inactivo
        </div>

        <span class="text-sm text-gray-500">
            {{ $numero->created_at->diffForHumans() }}
        </span>
    </div>

</div>
@endforeach

        </div>
        @endif

    </div>

    {{-- STYLES --}}
    <style>
        body{background:#0f1115}

        .list-card{
            background:rgba(255,255,255,.05);
            border:1px solid rgba(239,68,68,.35);
            border-radius:18px;
            padding:24px;
            backdrop-filter:blur(14px);
            transition:.3s;
        }

        .list-card:hover{transform:translateY(-3px)}

        .icon-box{
    width:42px;
    height:42px;
    border-radius:12px;
    background:rgba(34,197,94,.15);
    border:1px solid rgba(34,197,94,.4);
    display:flex;
    align-items:center;
    justify-content:center;
}


        .btn-secondary{
            display:inline-flex;
            justify-content:center;
            padding:12px 18px;
            border-radius:14px;
            background:rgba(34,197,94,.18);
            border:1px solid rgba(34,197,94,.4);
            color:white;font-weight:600;
            transition:.25s;
        }

        .btn-secondary:hover{
            background:rgba(34,197,94,.35);
            transform:translateY(-2px);
        }

        .info-box{
            background:rgba(255,255,255,.05);
            border:1px solid rgba(255,255,255,.08);
            border-radius:14px;
            padding:14px;
            color:white;
        }

        .info-box p{
            font-size:12px;
            color:#9ca3af;
        }
        .numero-card{
    pointer-events: auto;
}

.numero-card *{
    pointer-events: auto;
}

.numero-card::before,
.numero-card::after{
    content:none !important;
}
.material-symbols-rounded{
    font-variation-settings:
        'FILL' 0,
        'wght' 400,
        'GRAD' 0,
        'opsz' 24;
}
    </style>
</x-app-layout>