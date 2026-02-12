<x-app-layout>
<div class="form-create relative">
    <div class="relative z-10 max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-10 text-white">

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
                    Editar Cuenta
                </h1>
                <p class="mt-2 text-sm text-red-300">
                    Modifica la información de tu cuenta
                </p>
            </div>

            <a href="{{ route('cuentas.index') }}">
             <button type="submit" class="btn-primary">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M15 18l-6-6 6-6"/>
            </svg>
            Volver
            </button>   
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
            <form action="{{ route('cuentas.update', $cuenta) }}" method="POST" class="p-6">
                @csrf
                @method('PUT')

                <!-- NOMBRE -->
                <div class="mb-6">
                    <label class="label">Nombre *</label>
                    <input
                        type="text"
                        name="nombre"
                        value="{{ old('nombre', $cuenta->nombre) }}"
                        class="input"
                        required
                        autofocus
                    >
                </div>

                <!-- DESCRIPCIÓN -->
                <div class="mb-8">
                    <label class="label">Descripción</label>
                    <textarea
                        name="descripcion"
                        rows="4"
                        class="input"
                        placeholder="Descripción opcional..."
                    >{{ old('descripcion', $cuenta->descripcion) }}</textarea>
                </div>

                <!-- FOOTER -->
                <div class="flex flex-col sm:flex-row sm:justify-between gap-4 pt-6 border-t border-white/10">
                    <p class="text-xs text-gray-400">
                        Los campos marcados con * son obligatorios
                    </p>

                    <div class="flex gap-3">
                        <a href="{{ route('cuentas.index') }}" class="btn-cancel">
                            Cancelar
                        </a>
                        <button type="submit" class="btn-primary">
                            Actualizar
                        </button>
                    </div>
                </div>

            </form>
        </div>

    </div>
</div>
 <style>
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

        .label{
            display:block;
            margin-bottom:6px;
            font-size:13px;
            color:#fca5a5;
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
            border-color:#ef4444;
            box-shadow:0 0 0 2px rgba(239,68,68,.25);
        }
    </style>

</x-app-layout>