<x-app-layout>

    <!-- Fondo -->
    <div class="absolute inset-0 -z-20 bg-[#111318]"></div>

    <!-- Glow -->
    <div class="absolute inset-0 -z-10 flex justify-center items-center">
        <div class="w-[90%] h-[90%] bg-red-600/25 blur-[160px] rounded-full"></div>
    </div>

    <div class="relative z-10 max-w-lg mx-auto px-4 sm:px-6 lg:px-8 py-10">

        <!-- HEADER -->
        <div class="flex items-center gap-3 mb-8">
            <span class="icon-circle">
                <span class="material-symbols-outlined">edit</span>
            </span>
            <h1 class="text-white text-xl font-bold">
                Editar transferencia
            </h1>
            <a href="{{ route('transaccionesinternas.index') }}" class="btn-secondary">
                <span class="material-symbols-outlined">arrow_back</span>
                Volver
            </a>
        </div>

        <!-- CARD -->
        <div class="card">
            <form action="{{ route('transaccionesinternas.update', $transaccion->id) }}"
                  method="POST"
                  class="p-6 space-y-6">
                @csrf
                @method('PUT')

                {{-- Cuenta origen --}}
                <div>
                    <label for="cuenta_origen_id" class="label">
                        Cuenta origen *
                    </label>
                    <select name="cuenta_origen_id"
                            id="cuenta_origen_id"
                            class="input"
                            required>
                        <option value="">-- Selecciona una cuenta --</option>
                        @foreach($cuentas as $cuenta)
                            <option value="{{ $cuenta->id }}"
                                {{ old('cuenta_origen_id', $transaccion->cuenta_origen_id) == $cuenta->id ? 'selected' : '' }}>
                                {{ $cuenta->nombre }}
                                (Saldo: {{ number_format($cuenta->saldo_actual, 2) }})
                            </option>
                        @endforeach
                    </select>
                    @error('cuenta_origen_id')
                        <p class="error-text">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Cuenta destino --}}
                <div>
                    <label for="cuenta_destino_id" class="label">
                        Cuenta destino *
                    </label>
                    <select name="cuenta_destino_id"
                            id="cuenta_destino_id"
                            class="input"
                            required>
                        <option value="">-- Selecciona una cuenta --</option>
                        @foreach($cuentas as $cuenta)
                            <option value="{{ $cuenta->id }}"
                                {{ old('cuenta_destino_id', $transaccion->cuenta_destino_id) == $cuenta->id ? 'selected' : '' }}>
                                {{ $cuenta->nombre }}
                                (Saldo: {{ number_format($cuenta->saldo_actual, 2) }})
                            </option>
                        @endforeach
                    </select>
                    @error('cuenta_destino_id')
                        <p class="error-text">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Monto --}}
                <div>
                    <label for="monto" class="label">
                        Monto *
                    </label>
                    <input type="number"
                           step="0.01"
                           min="0.01"
                           name="monto"
                           id="monto"
                           value="{{ old('monto', $transaccion->monto) }}"
                           class="input"
                           placeholder="0.00"
                           required>
                    @error('monto')
                        <p class="error-text">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Descripción --}}
                <div>
                    <label for="descripcion" class="label">
                        Descripción
                    </label>
                    <textarea name="descripcion"
                              id="descripcion"
                              rows="3"
                              class="input"
                              placeholder="Descripción opcional...">{{ old('descripcion', $transaccion->descripcion) }}</textarea>
                    @error('descripcion')
                        <p class="error-text">{{ $message }}</p>
                    @enderror
                </div>

                {{-- FOOTER --}}
                <div class="flex justify-between pt-6 border-t border-white/10">
                    <a href="{{ route('transaccionesinternas.index') }}"
                       class="btn-secondary">
                        Cancelar
                    </a>

                    <button type="submit" class="btn-primary">
                        <span class="material-symbols-outlined">save</span>
                        Guardar cambios
                    </button>
                </div>

            </form>
        </div>

    </div>

    <!-- ESTILOS -->
    <style>
        body { background:#111318 }

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

        .btn-secondary{
            padding:10px 18px;
            border-radius:14px;
            background:rgba(255,255,255,.08);
            border:1px solid rgba(255,255,255,.18);
            color:#fff;
            transition:.25s;
        }

        .btn-secondary:hover{
            background:rgba(255,255,255,.15);
        }

        .error-text{
            margin-top:6px;
            font-size:12px;
            color:#fecaca;
        }

        select option{
            background-color:#111318;
            color:#fff;
        }

        select option:checked,
        select option:hover{
            background-color:#ef4444;
            color:#fff;
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
    </style>

</x-app-layout>