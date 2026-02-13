<x-app-layout>
    <div class="relative z-10 max-w-lg mx-auto px-4 sm:px-6 lg:px-8 py-10">

        <!-- HEADER -->
        <div class="flex items-center justify-between mb-8">

    <!-- IZQUIERDA: Icono + Título -->
    <div class="flex items-center gap-3">
        <span class="icon-circle">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M4 12a8 8 0 0113.66-5.66L20 8"/>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M20 12a8 8 0 01-13.66 5.66L4 16"/>
            </svg>
        </span>

        <h1 class="text-white text-xl font-bold">
            Transferencia entre cuentas
        </h1>
    </div>

    <!-- DERECHA: Botón volver -->
    <a href="{{ route('transaccionesinternas.index') }}" class="btn-secondary">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M15 18l-6-6 6-6"/>
        </svg>
    </a>

</div>
        <!-- CARD -->
        <div class="card">
            <form action="{{ route('transaccionesinternas.store') }}"
                  method="POST"
                  class="p-6 space-y-6">
                @csrf

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
                                {{ old('cuenta_origen_id') == $cuenta->id ? 'selected' : '' }}>
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
                                {{ old('cuenta_destino_id') == $cuenta->id ? 'selected' : '' }}>
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
                           value="{{ old('monto') }}"
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
                              placeholder="Descripción opcional...">{{ old('descripcion') }}</textarea>
                    @error('descripcion')
                        <p class="error-text">{{ $message }}</p>
                    @enderror
                </div>

                {{-- FOOTER --}}
                <div class="flex justify-end pt-6 border-t border-white/10">
                    <button type="submit" class="btn-primary">
                        Guardar transferencia
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

        .error-text{
            margin-top:6px;
            font-size:12px;
            color:#fecaca;
        }
        /* Opciones del select (dropdown) */
select option {
    background-color: #111318;
    color: #ffffff;
}

/* Opción seleccionada */
select option:checked {
    background-color: #ef4444;
    color: #ffffff;
}

/* Hover (algunos navegadores) */
select option:hover {
    background-color: #ef4444;
    color: #ffffff;
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