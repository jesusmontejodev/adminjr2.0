<x-app-layout>

    <!-- Glow rojo -->
    <div class="absolute inset-0 -z-10 flex justify-center items-center">
        <div class="w-[85%] h-[85%] rounded-full blur-[180px]"
            style="background: radial-gradient(circle, rgba(239,68,68,0.35) 0%, rgba(239,68,68,0.05) 45%, transparent 70%);">
        </div>
    </div>

    <div class="relative z-10 p-6 sm:p-10">

        <!-- HEADER -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-6 mb-10">
            <h1 class="flex items-center gap-3 text-white text-xl font-bold">
                <span class="icon-circle">
                    <!-- SVG account_balance -->
                   <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                </svg>
            </span>
                Mis Cuentas
            </h1>

            <a href="{{ route('cuentas.create') }}" class="btn-primary">
                <!-- SVG add -->
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M12 4v16m8-8H4"/>
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
                <!-- SVG paid -->
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 2v20M17 6.5c0-2-2.5-3.5-5-3.5S7 4.5 7 6.5
                        9.5 9 12 9s5 1.5 5 3.5-2.5 3.5-5 3.5-5-1.5-5-3.5"/>
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
                                <svg class="w-[18px] h-[18px] text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M3 10h18M5 10V20h14V10M9 20V14h6v6M12 3l8 5H4l8-5z"/>
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
                                    <!-- SVG editar -->
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M16.5 3.5a2.1 2.1 0 013 3L7 19l-4 1 1-4 12.5-12.5z"/>
                                    </svg>
                                    <span class="hidden sm:inline">Editar</span>
                                </a>

                                <form action="{{ route('cuentas.destroy', $cuenta->id) }}"
                                      method="POST"
                                      onsubmit="return confirm('¿Eliminar esta cuenta?')">
                                    @csrf
                                    @method('DELETE')

                                    <button class="btn-action btn-delete">
                                        <!-- SVG eliminar -->
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M3 6h18M8 6V4h8v2M6 6v14a2 2 0 002 2h8
                                                a2 2 0 002-2V6M10 11v6M14 11v6"/>
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
        svg { flex-shrink:0 }

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

        .saldo-label { font-size:13px; color:#fca5a5 }
        .saldo-monto { font-size:26px; font-weight:800; color:#fff }

        .tabla-container {
            background:rgba(255,255,255,.04);
            border:1px solid rgba(239,68,68,.35);
            border-radius:22px;
        }

        .tabla { width:100%; border-collapse:collapse }

        .tabla th {
            padding:14px 18px;
            font-size:13px;
            color:#fca5a5;
            text-align:left;
        }

        .tabla td {
            padding:16px 18px;
            color:#e5e5e5;
        }


        .saldo-verde { color:#22c55e; font-weight:700 }

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