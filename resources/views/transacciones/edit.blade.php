<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Editar Transacción') }}
        </h2>
    </x-slot>

    <div class="form-create relative">
    <div class="relative z-10 max-w-lg mx-auto px-4 sm:px-6 lg:px-8 py-10">

        <!-- HEADER -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-6 mb-10">
            <div>
                <h1 class="flex items-center gap-3 text-xl font-bold">
                    <span class="icon-circle">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16.5 3.5a2.1 2.1 0 013 3L7 19l-4 1 1-4 12.5-12.5z"/>
                        </svg>
                    </span>
                    Editar transacción
                </h1>
            </div>

            <a href="{{ route('transacciones.index') }}" class="btn-secondary">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M15 18l-6-6 6-6"/>
                </svg>
                Volver
            </a>
        </div>

        <!-- CARD -->
        <div class="card">
            <form action="{{ route('transacciones.update', $transaccion->id) }}"
                  method="POST"
                  class="p-6 space-y-6">
                @csrf
                @method('PUT')

                @include('transacciones.form')

                <!-- FOOTER -->
                <div class="flex justify-between pt-6 border-t border-white/10">
                    <a href="{{ route('transacciones.index') }}" class="btn-secondary">
                        Cancelar
                    </a>

                    <button type="submit" class="btn-primary">
                        Actualizar
                    </button>
                </div>
            </form>
        </div>

    </div>
    </div>

    <!-- ESTILOS -->
    <style>
        body { background:#111318 }

        .card{
            background:rgba(255,255,255,.04);
            border:1px solid rgba(237, 70, 92,.35);
            border-radius:22px;
            backdrop-filter:blur(14px);
        }

        .icon-circle{
            width:38px;
            height:38px;
            border-radius:12px;
            background:rgba(237, 70, 92,.18);
            border:1px solid rgba(237, 70, 92,.45);
            display:flex;
            align-items:center;
            justify-content:center;
            color:#ed465c;
        }

        .label{
            display:block;
            margin-bottom:6px;
            font-size:13px;
            color:#fba6b1;
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

        .input:focus{
            outline:none;
            border-color:#ed465c;
            box-shadow:0 0 0 2px rgba(237, 70, 92,.25);
        }

        .btn-primary{
            display:inline-flex;
            align-items:center;
            gap:6px;
            padding:10px 18px;
            border-radius:14px;
            background:rgba(237, 70, 92,.25);
            border:1px solid rgba(237, 70, 92,.45);
            color:#fff;
            font-weight:600;
            transition:.25s;
        }

        .btn-primary:hover{
            transform:translateY(-2px);
            background:rgba(237, 70, 92,.35);
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
            transition:.25s;
        }

        .btn-secondary:hover{
            background:rgba(255,255,255,.15);
        }

        .error-text{
            margin-top:6px;
            font-size:12px;
            color:#fdcbd1;
        }

        select option{
            background-color:#111318;
            color:#fff;
        }

        select option:checked,
        select option:hover{
            background-color:#ed465c;
            color:#fff;
        }
    </style>
</x-app-layout>
