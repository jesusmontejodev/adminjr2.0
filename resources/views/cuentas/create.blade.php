<x-app-layout>
    
    <div class="absolute inset-0 -z-10 flex justify-center items-center">
        <div class="w-[85%] h-[85%] rounded-full blur-[180px]"
            style="background: radial-gradient(circle, rgba(239,68,68,0.35) 0%, rgba(239,68,68,0.05) 40%, transparent 35%);">
        </div>
    </div>

    <div class="relative z-10 max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

        <!-- HEADER -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-6 mb-10">
            <div>
                <h1 class="flex items-center gap-3 text-white text-xl font-bold">
                    <span class="icon-circle">
                        <span class="material-symbols-outlined">account_balance</span>
                    </span>
                    Crear Nueva Cuenta
                </h1>
                <p class="mt-2 text-sm text-red-300">
                    Agrega una nueva cuenta para gestionar tus finanzas
                </p>
            </div>

            <a href="{{ route('cuentas.index') }}" class="btn-secondary">
                <span class="material-symbols-outlined">arrow_back</span>
                Volver
            </a>
        </div>

        <!-- MENSAJES -->
        @if (session('success'))
            <div class="alert-success mb-6">
                {{ session('success') }}
            </div>
        @endif

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

        <!-- FORMULARIO -->
        <div class="card">
            <form action="{{ route('cuentas.store') }}" method="POST" class="p-6">
                @csrf

                <!-- Nombre -->
                <div class="mb-6">
                    <label for="nombre" class="label">Nombre de la cuenta *</label>
                    <input type="text"
                           name="nombre"
                           id="nombre"
                           value="{{ old('nombre') }}"
                           class="input"
                           placeholder="Ej: Cuenta Corriente, Ahorros..."
                           required autofocus>
                </div>

                <!-- Saldo -->
                <div class="mb-6">
                    <label for="saldo_inicial" class="label">Saldo inicial *</label>

    <div class="flex items-center bg-white/5 border border-white/10 rounded-xl px-2">

        <!-- SIGNO $ -->
        <span class="px-3 text-red-400 select-none">
            $
        </span>

        <!-- INPUT -->
        <input
            type="number"
            name="saldo_inicial"
            id="saldo_inicial"
            value="{{ old('saldo_inicial', 0) }}"
            step="0.01"
            min="0"
            class="bg-transparent border-0 focus:ring-0 focus:outline-none text-white w-full py-3 pl-1"
            required
        >
    </div>
</div>


                <!-- Descripción -->
                <div class="mb-8">
                    <label for="descripcion" class="label">Descripción</label>
                    <textarea name="descripcion"
                              id="descripcion"
                              rows="4"
                              class="input"
                              placeholder="Descripción opcional...">{{ old('descripcion') }}</textarea>
                </div>

                <!-- BOTONES -->
                <div class="flex flex-col sm:flex-row sm:justify-between gap-4 pt-6 border-t border-white/10">
                    <p class="text-xs text-gray-400">
                        Los campos marcados con * son obligatorios
                    </p>

                    <div class="flex gap-3">
                        <a href="{{ route('cuentas.index') }}" class="btn-cancel">
                            Cancelar
                        </a>

                        <button type="submit" class="btn-primary">
                            <span class="material-symbols-outlined">add</span>
                            Crear Cuenta
                        </button>
                    </div>
                </div>
            </form>
        </div>

    </div>

    <!-- ESTILOS -->
    <style>
        body{background:#111318}

        .material-symbols-outlined{
            font-variation-settings:'FILL' 0,'wght' 400,'GRAD' 0,'opsz' 20;
        }

        /* Card */
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

        .btn-secondary,
        .btn-cancel{
            display:inline-flex;
            align-items:center;
            gap:6px;
            padding:10px 16px;
            border-radius:14px;
            background:rgba(255,255,255,.06);
            border:1px solid rgba(255,255,255,.15);
            color:#fff;
        }

        .btn-cancel{
            padding:10px 16px;
            border-radius:14px;
            background:rgba(255,255,255,.06);
            border:1px solid rgba(255,255,255,.15);
            color:#e5e5e5;
        }

        /* Alerts */
        .alert-success{
            padding:14px 18px;
            border-radius:14px;
            background:rgba(34,197,94,.15);
            border:1px solid rgba(34,197,94,.35);
            color:#86efac;
        }

        .alert-error{
            padding:14px 18px;
            border-radius:14px;
            background:rgba(239,68,68,.15);
            border:1px solid rgba(239,68,68,.35);
            color:#fecaca;
        }
    </style>

</x-app-layout>