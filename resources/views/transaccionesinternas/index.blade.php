<x-app-layout>

<div class="absolute inset-0 -z-20 bg-[#0f1115]"></div>

<div class="relative z-10 p-6 sm:p-10 max-w-[1440px] mx-auto">

    <!-- HEADER -->
    <div class="flex justify-between items-center mb-10">
        <h1 class="flex items-center gap-3 text-white text-2xl font-bold">
            <span class="icon-circle">
                <!-- SVG swap -->
                <svg class="icon-svg" viewBox="0 0 24 24">
                    <path d="M7 7h11l-4-4m4 14H7l4 4" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </span>
            Transacciones internas
        </h1>

        <a href="{{ route('transaccionesinternas.create') }}" class="btn-primary">
            <!-- SVG plus -->
            <svg class="icon-svg" viewBox="0 0 24 24">
                <path d="M12 5v14M5 12h14" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
            </svg>
            Nueva transferencia
        </a>
    </div>

    <!-- TABLA -->
    <div class="tabla-container">
        <table class="tabla">
            <thead>
                <tr>
                    <th>Fecha</th>
                    <th>Cuenta origen</th>
                    <th>Cuenta destino</th>
                    <th>Monto</th>
                    <th>Descripción</th>
                    <th class="text-right">Acciones</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($transaccionesinternas as $t)
                <tr>
                    <td>{{ $t->created_at->format('d/m/Y H:i') }}</td>
                    <td>{{ $t->cuentaOrigen->nombre }}</td>
                    <td>{{ $t->cuentaDestino->nombre }}</td>
                    <td class="font-semibold">${{ number_format($t->monto, 2) }}</td>
                    <td>{{ $t->descripcion ?? '-' }}</td>

                    <td class="acciones-td">
                        <div class="acciones">
                            <a href="{{ route('transaccionesinternas.edit', $t) }}" class="btn-action btn-edit">
                                <!-- SVG edit -->
                                <svg class="icon-btn" viewBox="0 0 24 24">
                                    <path d="M4 20h4l10-10-4-4L4 16v4z" fill="none" stroke="currentColor" stroke-width="2"/>
                                </svg>
                                Editar
                            </a>

                            <form action="{{ route('transaccionesinternas.destroy', $t) }}"
                                  method="POST"
                                  onsubmit="return confirm('¿Eliminar transferencia?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn-action btn-delete">
                                    <!-- SVG delete -->
                                    <svg class="icon-btn" viewBox="0 0 24 24">
                                        <path d="M3 6h18M8 6v14m8-14v14M5 6l1 14h12l1-14M9 6V4h6v2"
                                              fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                                    </svg>
                                    Eliminar
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center text-gray-400 py-6">
                        No hay transacciones internas registradas
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<style>
/* ================= ICONOS SVG ================= */
.icon-svg{
    width:18px;
    height:18px;
}

/* ================= ICON CIRCLE ================= */
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

/* ================= BOTÓN PRINCIPAL ================= */
.btn-primary{
    display:inline-flex;
    align-items:center;
    gap:8px;
    height:40px;
    padding:0 16px;
    border-radius:14px;
    background:rgba(239,68,68,.22);
    border:1px solid rgba(239,68,68,.45);
    color:#fff;
    font-weight:600;
    transition:.25s;
}
.btn-primary:hover{
    background:rgba(239,68,68,.35);
    transform:translateY(-2px);
}

/* ================= TABLA ================= */
.tabla-container{
    background:rgba(255,255,255,.04);
    border:1px solid rgba(239,68,68,.35);
    border-radius:22px;
    overflow:hidden;
}

.tabla{
    width:100%;
    border-collapse:collapse;
}

.tabla th{
    padding:14px 18px;
    font-size:13px;
    color:#fca5a5;
    text-align:left;
}

.tabla td{
    padding:16px 18px;
    color:#e5e5e5;
    border-top:1px solid rgba(255,255,255,.06);
}

/* ================= ACCIONES ================= */
.acciones-td{
    text-align:right;
}

.acciones{
    display:flex;
    justify-content:flex-end;
    gap:10px;
}

/* ================= BOTONES ================= */
.btn-action{
    display:inline-flex;
    align-items:center;
    gap:6px;
    height:34px;
    padding:0 14px;
    border-radius:10px;
    font-size:13px;
    font-weight:600;
    color:#fff;
    transition:.25s;
}

.icon-btn{
    width:18px;
    height:18px;
}

/* Editar */
.btn-edit{
    background:rgba(234,179,8,.18);
    border:1px solid rgba(234,179,8,.45);
}
.btn-edit:hover{
    background:rgba(234,179,8,.32);
}

/* Eliminar */
.btn-delete{
    background:rgba(239,68,68,.18);
    border:1px solid rgba(239,68,68,.45);
}
.btn-delete:hover{
    background:rgba(239,68,68,.32);
}

.btn-action:hover{
    transform:translateY(-2px);
}
</style>

</x-app-layout>