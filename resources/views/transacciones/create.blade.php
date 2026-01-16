<x-app-layout>

    <!-- Fondo -->
    <div class="absolute inset-0 -z-20 bg-[#111318]"></div>

    <!-- Glow -->
    <div class="absolute inset-0 -z-10 flex justify-center items-center">
        <div class="w-[90%] h-[90%] bg-red-600/25 blur-[160px] rounded-full"></div>
    </div>

    <div class="relative z-10 max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

        <!-- HEADER -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-6 mb-10">
            <div>
                <h1 class="flex items-center gap-3 text-white text-xl font-bold">
                    <span class="icon-circle">
                       <span class="material-symbols-outlined sidebar-icon">sync_alt</span>
                    </span>
                    Registrar Transacción
                </h1>
                <p class="mt-2 text-sm text-red-300">
                    Registra un ingreso o gasto en tu sistema
                </p>
            </div>

            <a href="{{ route('transacciones.index') }}" class="btn-secondary">
                <span class="material-symbols-outlined">arrow_back</span>
                Volver
            </a>
        </div>

        <!-- ERRORES -->
        @if ($errors->any())
            <div class="alert-error mb-6">
                <strong>Corrige los errores:</strong>
                <ul class="list-disc pl-5 mt-2 text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- CARD -->
        <div class="card">
            <form action="{{ route('transacciones.store') }}" method="POST" class="p-6 space-y-6">
                @csrf
                @include('transacciones.form')

                <!-- FOOTER -->
                <div class="flex flex-col sm:flex-row sm:justify-between gap-4 pt-6 border-t border-white/10 mt-8">
                    <p class="text-xs text-gray-400">
                        Los campos marcados con * son obligatorios
                    </p>

                    <div class="flex gap-3">
                        <button type="submit" class="btn-primary">
                            <span class="material-symbols-outlined">save</span>
                            Guardar Transacción
                        </button>
                    </div>
                </div>
            </form>
        </div>

    </div>

  <style>
   
    :root{
        color-scheme: dark;
    }

    body{
        background:#111318;
    }

    .material-symbols-outlined{
        font-variation-settings:'FILL' 0,'wght' 400,'GRAD' 0,'opsz' 20;
    }

    .card{
        background:rgba(255,255,255,.04);
        border:1px solid rgba(239,68,68,.35);
        border-radius:22px;
        backdrop-filter:blur(14px);
    }

    .icon-circle{
        width:38px;
        height:38px;
        border-radius:12px;
        background:rgba(239,68,68,.18);
        border:1px solid rgba(239,68,68,.45);
        display:flex;
        align-items:center;
        justify-content:center;
        color:#ef4444;
    }

    /*  LABELS ROJOS  */
    .label,
    .card label{
        display:block;
        margin-bottom:6px;
        font-size:13px;
        color:#fca5a5 !important;
        font-weight:500;
    }

    .input{
        width:100%;
        padding:12px 14px;
        border-radius:14px;
        background:rgba(255,255,255,.06);
        border:1px solid rgba(255,255,255,.12);
        color:#fff;
    }

    .input::placeholder{
        color:#9ca3af;
    }

    .input:focus{
        outline:none;
        border-color:#ef4444;
        box-shadow:0 0 0 2px rgba(239,68,68,.25);
    }

    /* 🔥 SELECT OSCURO REAL */
    select.input{
        background-color:rgba(255,255,255,.06);
        color:#fff;
    }

    select.input option{
        background-color:#111318;
        color:#ffffff;
    }

    select.input option:checked{
        background-color:#ef4444;
        color:#ffffff;
    }

    select.input option:hover{
        background-color:#ef4444;
        color:#ffffff;
    }

    .btn-primary{
        display:inline-flex;
        align-items:center;
        gap:6px;
        padding:10px 18px;
        border-radius:14px;
        background:rgba(239,68,68,.25);
        border:1px solid rgba(239,68,68,.45);
        color:#fff;
        font-weight:600;
        transition:.25s;
    }

    .btn-primary:hover{
        transform:translateY(-2px);
        background:rgba(239,68,68,.35);
    }

    .btn-secondary{
        display:inline-flex;
        align-items:center;
        gap:6px;
        padding:10px 16px;
        border-radius:14px;
        background:rgba(255,255,255,.06);
        border:1px solid rgba(255,255,255,.15);
        color:#fff;
    }

    .error-text{
        margin-top:6px;
        font-size:12px;
        color:#fecaca;
    }
</style>
</x-app-layout>