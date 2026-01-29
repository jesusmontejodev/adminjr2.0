<x-app-layout>

    {{-- GOOGLE MATERIAL ICONS --}}
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@20..48,400,0,0" rel="stylesheet" />

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

    {{-- HEADER --}}
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
        <div>
            <div class="flex items-center gap-3 mb-2">
                <h2 class="text-2xl font-bold text-white">
                    WhatsApp connection
                </h2>

                    <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-sm font-semibold border border-green-500/40 bg-green-500/10 text-green-400">
                        <span class="material-symbols-rounded text-base">
                            check_circle
                        </span>
                        WhatsApp On
                    </span>
                </div>

            <p class="text-gray-400">
                Gestiona y configura tus números de WhatsApp
            </p>
        </div>

            <a href="{{ route('numeros-whatsapp.create') }}"
               class="inline-flex items-center gap-2 px-5 py-3 rounded-xl bg-green-500/20 border border-green-500/40 text-white font-semibold hover:bg-green-500/35 transition">
                <span class="material-symbols-rounded">
                    add
                </span>
                Nuevo número
            </a>
        </div>

        {{-- SUCCESS --}}
        @if (session('success'))
            <div class="mb-6 p-4 rounded-xl border border-green-500/40 bg-green-500/15 text-green-300 flex items-center gap-3">
                <span class="material-symbols-rounded">
                    done_all
                </span>
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
                    <span class="material-symbols-rounded text-green-400 text-2xl">
                        forum
                    </span>
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
                    <span class="material-symbols-rounded text-green-400 text-2xl">
                        mark_chat_unread
                    </span>
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

    {{-- GRID --}}
    @if(!$numeros->isEmpty())
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

        @foreach($numeros as $numero)
        <div class="numero-card bg-white/5 border border-red-500/30 rounded-2xl backdrop-blur-xl overflow-hidden transition hover:-translate-y-1">

    {{-- HEADER --}}
    <div class="p-6 border-b border-white/10 flex justify-between items-start relative">

        <div class="flex items-center gap-3">
            <div class="w-12 h-12 rounded-xl bg-green-500/15 border border-green-500/40 flex items-center justify-center">
                <span class="material-symbols-rounded text-gray-400 text-sm">
                    call
                </span>
            </div>

                    <div>
                        <h3 class="font-semibold text-white text-base">
                            {{ $numero->numero_internacional }}
                        </h3>
                        <p class="text-xs text-gray-500">
                            ID: {{ substr($numero->id, 0, 8) }}...
                        </p>
                    </div>
                </div>

        {{-- BOTÓN EDITAR / OPCIONES --}}
        <button class="p-2 text-gray-400 hover:text-white transition cursor-pointer">
            <span class="material-symbols-rounded">
                more_vert
            </span>
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
                <span class="material-symbols-rounded text-gray-400 text-sm">
                    call
                </span>
                <div>
                    <p>Número local</p>
                    <strong>{{ $numero->numero_local }}</strong>
                </div>
            </div>
             <div class="info-box flex items-center gap-3">
            <span class="material-symbols-rounded text-gray-400">
                public
            </span>
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

<style>
body{background:#0f1115}
.icon-svg{width:18px;height:18px}
.list-card{
    background:rgba(255,255,255,.05);
    border:1px solid rgba(239,68,68,.35);
    border-radius:18px;
    padding:24px;
}
.icon-box{
    width:42px;height:42px;border-radius:12px;
    background:rgba(34,197,94,.15);
    border:1px solid rgba(34,197,94,.4);
    display:flex;align-items:center;justify-content:center;
}
.btn-secondary{
    padding:12px 18px;border-radius:14px;
    background:rgba(34,197,94,.18);
    border:1px solid rgba(34,197,94,.4);
    color:white;font-weight:600;
}
.info-box{
    background:rgba(255,255,255,.05);
    border:1px solid rgba(255,255,255,.08);
    border-radius:14px;
    padding:14px;color:white;
}
.info-box p{font-size:12px;color:#9ca3af}
</style>

</x-app-layout>