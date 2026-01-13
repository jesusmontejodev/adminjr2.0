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
                    <span class="material-symbols-outlined">account_balance</span>
                </span>
                Mis Cuentas
            </h1>

            <a href="{{ route('cuentas.create') }}" class="btn-primary">
                <span class="material-symbols-outlined">add</span>
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
                <span class="material-symbols-outlined">paid</span>
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
                                <span class="material-symbols-outlined text-red-400 text-[18px]">
                                    account_balance
                                </span>
                                {{ $cuenta->nombre }}
                            </td>

                            <!-- SALDO REAL -->
                            <td class="saldo-verde">
                                ${{ number_format($cuenta->saldo_actual, 2) }}
                            </td>

                            <td class="hidden md:table-cell">
                                {{ $cuenta->descripcion }}
                            </td>

                            <td class="acciones">
                                <a href="{{ route('cuentas.edit', $cuenta->id) }}" class="btn-action btn-edit">
                                    <span class="icon-btn material-symbols-outlined">edit_square</span>
                                    <span class="hidden sm:inline">Editar</span>
                                </a>

                                <form action="{{ route('cuentas.destroy', $cuenta->id) }}"
                                    method="POST"
                                    onsubmit="return confirm('¿Eliminar esta cuenta?')">
                                    @csrf
                                    @method('DELETE')

                            <button
                                onclick="eliminarCuenta({{ $cuenta->id }})"
                                class="btn-action btn-delete">
                                <span class="icon-btn material-symbols-outlined">delete</span>
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
        /* ICONOS NORMALIZADOS */
        .material-symbols-outlined {
            font-variation-settings:
                'FILL' 0,
                'wght' 400,
                'GRAD' 0,
                'opsz' 20;
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
            width:100%;
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

        /* ACCIONES */
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

        .icon-btn {
            width:18px;
            height:18px;
            display:flex;
            align-items:center;
            justify-content:center;
            font-size:18px;
            line-height:1;
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