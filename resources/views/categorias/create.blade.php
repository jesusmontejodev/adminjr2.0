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

                        {{-- ICONO CATEGORY / EDIT --}}
                        @if(isset($categoria))
                            <!-- edit -->
                            <svg class="icon-svg" viewBox="0 0 24 24">
                                <path d="M4 20h4l10-10-4-4L4 16v4zM14 6l4 4"
                                      fill="none" stroke="currentColor" stroke-width="2"
                                      stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        @else
                            <!-- category -->
                            <svg class="icon-svg" viewBox="0 0 24 24">
                                <path d="M4 4h6v6H4zM14 4h6v6h-6zM4 14h6v6H4zM14 14h6v6h-6z"
                                      fill="none" stroke="currentColor" stroke-width="2"/>
                            </svg>
                        @endif

                    </span>

                    {{ isset($categoria) ? 'Editar Categoría' : 'Nueva Categoría' }}
                </h1>

                <p class="mt-2 text-sm text-red-300">
                    {{ isset($categoria)
                        ? 'Modifica la información de la categoría'
                        : 'Crea una categoría para organizar tus movimientos' }}
                </p>
            </div>

            <a href="{{ route('categorias.index') }}" class="btn-secondary">
                <!-- arrow_back -->
                <svg class="icon-svg" viewBox="0 0 24 24">
                    <path d="M15 18l-6-6 6-6"
                          fill="none" stroke="currentColor" stroke-width="2"
                          stroke-linecap="round"/>
                </svg>
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
            <form
                action="{{ isset($categoria)
                    ? route('categorias.update', $categoria)
                    : route('categorias.store') }}"
                method="POST"
                class="p-6"
            >
                @csrf
                @isset($categoria)
                    @method('PUT')
                @endisset

                <!-- NOMBRE -->
                <div class="mb-6">
                    <label class="label">Nombre de la categoría *</label>
                    <input
                        type="text"
                        name="nombre"
                        value="{{ old('nombre', $categoria->nombre ?? '') }}"
                        class="input"
                        placeholder="Ej: Comidas, Transporte..."
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
                    >{{ old('descripcion', $categoria->descripcion ?? '') }}</textarea>
                </div>

                <!-- FOOTER -->
                <div class="flex flex-col sm:flex-row sm:justify-between gap-4 pt-6 border-t border-white/10">
                    <p class="text-xs text-gray-400">
                        Los campos marcados con * son obligatorios
                    </p>

                    <div class="flex gap-3">
                        <a href="{{ route('categorias.index') }}" class="btn-cancel">
                            Cancelar
                        </a>

                        <button type="submit" class="btn-primary">

                            {{-- ICONO ADD / SAVE --}}
                            @if(isset($categoria))
                                <!-- save -->
                                <svg class="icon-svg" viewBox="0 0 24 24">
                                    <path d="M5 3h14l2 2v16H3V3h2zM7 3v6h10V3"
                                          fill="none" stroke="currentColor" stroke-width="2"
                                          stroke-linejoin="round"/>
                                </svg>
                            @else
                                <!-- add -->
                                <svg class="icon-svg" viewBox="0 0 24 24">
                                    <path d="M12 5v14M5 12h14"
                                          fill="none" stroke="currentColor" stroke-width="2"
                                          stroke-linecap="round"/>
                                </svg>
                            @endif

                            {{ isset($categoria) ? 'Actualizar' : 'Crear Categoría' }}
                        </button>
                    </div>
                </div>

            </form>
        </div>

    </div>

    <!-- ESTILOS -->
    <style>
        body{ background:#111318 }

        .icon-svg{
            width:18px;
            height:18px;
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
            color:#e5e5e5;
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