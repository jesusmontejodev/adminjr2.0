<x-app-layout>

    <!-- Fondo -->
    <div class="absolute inset-0 -z-20 bg-[#111318]"></div>

    <!-- Glow -->
    <div class="absolute inset-0 -z-10 flex justify-center items-center">
        <div class="w-[90%] h-[90%] bg-red-600/25 blur-[160px] rounded-full"></div>
    </div>

    <div class="relative z-10 p-6 sm:p-10">

        <!-- HEADER -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-6 mb-10">
            <h1 class="flex items-center gap-3 text-white text-xl font-bold">
                <span class="icon-circle">
                    <!-- icon: bank -->
                    <svg class="icon-svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                        <path d="M3 10h18M5 6h14M6 10v8M10 10v8M14 10v8M18 10v8M4 18h16"/>
                    </svg>
                </span>
                Mis Cuentas
            </h1>

            <a href="{{ route('cuentas.create') }}" class="btn-primary">
                <!-- icon: plus -->
                <svg class="icon-svg-sm" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M12 5v14M5 12h14"/>
                </svg>
                Nueva Cuenta
            </a>
        </div>

        <!-- SALDO TOTAL -->
        <div class="saldo-card mb-10">
            <div>
                <p class="saldo-label">Saldo Total</p>
                <p class="saldo-monto">
                    ${{ number_format($cuentas->sum('saldo_actual'), 2) }}
                </p>
            </div>

            <div class="icon-circle">
                <!-- icon: money -->
                <svg class="icon-svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                    <rect x="2" y="6" width="20" height="12" rx="2"/>
                    <circle cx="12" cy="12" r="3"/>
                </svg>
            </div>
        </div>

        <!-- TABLA -->
        <div class="tabla-container overflow-x-auto">
            <table class="tabla min-w-[720px]">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Cuenta</th>
                        <th>Saldo</th>
                        <th class="hidden md:table-cell">Descripción</th>
                        <th class="text-right">Acciones</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($cuentas as $cuenta)
                        <tr>
                            <td>{{ $cuenta->id }}</td>

                            <td class="font-semibold flex items-center gap-2">
                                <!-- icon: bank small -->
                                <svg class="icon-inline text-red-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                    <path d="M3 10h18M5 6h14M6 10v8M10 10v8M14 10v8M18 10v8M4 18h16"/>
                                </svg>
                                {{ $cuenta->nombre }}
                            </td>

                            <td class="saldo-verde">
                                ${{ number_format($cuenta->saldo_actual, 2) }}
                            </td>

                            <td class="hidden md:table-cell">
                                {{ $cuenta->descripcion }}
                            </td>

                            <td class="acciones">
                                <a href="{{ route('cuentas.edit', $cuenta->id) }}" class="btn-action btn-edit">
                                    <!-- icon: edit -->
                                    <svg class="icon-btn-svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                        <path d="M4 20h4l10-10-4-4L4 16v4Z"/>
                                    </svg>
                                    <span class="hidden sm:inline">Editar</span>
                                </a>

                                <form action="{{ route('cuentas.destroy', $cuenta->id) }}"
                                      method="POST"
                                      onsubmit="return confirm('¿Eliminar esta cuenta?')">
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit" class="btn-action btn-delete">
                                        <!-- icon: trash -->
                                        <svg class="icon-btn-svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                            <path d="M3 6h18M8 6V4h8v2M9 10v6M15 10v6M6 6l1 14h10l1-14"/>
                                        </svg>
                                        <span class="hidden sm:inline">Eliminar</span>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </div>

    <!-- ESTILOS -->
    <style>
        /* SVG sizes */
        .icon-svg {
            width:20px;
            height:20px;
        }

        .icon-svg-sm {
            width:18px;
            height:18px;
        }

        .icon-inline {
            width:18px;
            height:18px;
        }

        .icon-btn-svg {
            width:18px;
            height:18px;
        }

        /* Círculo iconos */
        .icon-circle {
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

        /* Botón principal */
        .btn-primary {
            display:inline-flex;
            align-items:center;
            gap:8px;
            padding:8px 16px;
            border-radius:14px;
            background:rgba(239,68,68,.22);
            border:1px solid rgba(239,68,68,.45);
            color:#fff;
            font-weight:600;
            transition:.25s;
        }

        .btn-primary:hover {
            background:rgba(239,68,68,.35);
            transform:translateY(-2px);
        }

        /* Saldo */
        .saldo-card {
            display:flex;
            justify-content:space-between;
            align-items:center;
            max-width:420px;
            padding:22px 26px;
            border-radius:20px;
            background:rgba(255,255,255,.04);
            border:1px solid rgba(239,68,68,.35);
        }

        .saldo-label {
            font-size:13px;
            color:#fca5a5;
        }

        .saldo-monto {
            font-size:26px;
            font-weight:800;
            color:#fff;
        }

        /* Tabla */
        .tabla-container {
            background:rgba(255,255,255,.04);
            border:1px solid rgba(239,68,68,.35);
            border-radius:22px;
        }

        .tabla {
            width:100%;
            border-collapse:collapse;
        }

        .tabla th {
            padding:14px 18px;
            font-size:13px;
            color:#fca5a5;
            text-align:left;
        }

        .tabla td {
            padding:16px 18px;
            color:#e5e5e5;
            border-top:1px solid rgba(255,255,255,.06);
        }

        .saldo-verde {
            color:#22c55e;
            font-weight:700;
        }

        /* Acciones */
        .acciones {
            display:flex;
            justify-content:flex-end;
            gap:8px;
            flex-wrap:wrap;
        }

        .btn-action {
            display:flex;
            align-items:center;
            gap:6px;
            height:34px;
            padding:0 12px;
            border-radius:10px;
            font-size:13px;
            font-weight:600;
            color:#fff;
            transition:.25s;
            white-space:nowrap;
        }

        .btn-edit {
            background:rgba(234,179,8,.18);
            border:1px solid rgba(234,179,8,.45);
        }

        .btn-delete {
            background:rgba(239,68,68,.18);
            border:1px solid rgba(239,68,68,.45);
        }

        .btn-action:hover {
            transform:translateY(-2px);
        }
    </style>

</x-app-layout>
