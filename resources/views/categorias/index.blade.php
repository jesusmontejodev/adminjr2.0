<x-app-layout>

<!-- Glow rojo -->
    <div class="absolute inset-0 -z-10 flex justify-center items-center">
        <div class="w-[85%] h-[85%] rounded-full blur-[180px]"
            style="background: radial-gradient(circle, rgba(239,68,68,0.35) 0%, rgba(239,68,68,0.05) 45%, transparent 70%);">
        </div>
    </div>


<div class="relative z-10 p-6 sm:p-10 max-w-[1440px] mx-auto">

    <!-- HEADER -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-6 mb-10">
            <h1 class="flex items-center gap-3 text-white text-xl font-bold">
                <span class="icon-circle">
                    <!-- SVG account_balance -->
                   <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5
                        a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9
                        a2 2 0 00-2-2M5 11V9a2 2 0 012-2
                        m0 0V5a2 2 0 012-2h6
                        a2 2 0 012 2v2M7 7h10"/>
                </svg>
            </span>
                Categorias
            </h1>

        <a href="{{ route('categorias.create') }}" class="btn-primary">
           <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M12 4v16m8-8H4"/>
                </svg>
            Nueva categoría
        </a>
    </div>

    <!-- TABLA -->
    <div class="tabla-container">
        <table class="tabla">
            <thead>
                <tr>
                    <th>Nombre</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($categorias as $categoria)
                    <tr>
                        <!-- NOMBRE -->
                        <td>
                            <div class="flex items-center gap-2 font-semibold">
                                <svg class="w-[18px] h-[18px] text-red-400"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M7 7h10l4 5-4 5H7a2 2 0 01-2-2V9a2 2 0 012-2z"/>
                                </svg>
                                {{ $categoria->nombre }}
                            </div>
                        </td>
                        
                    
                        <!-- ACCIONES -->
                        <td class="acciones-td">
                            <div class="acciones">
                                <a href="{{ route('categorias.edit', $categoria) }}"
                                   class="btn-action btn-edit">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M16.5 3.5a2.1 2.1 0 013 3L7 19l-4 1 1-4 12.5-12.5z"/>
                                    </svg>
                                    <span class="hidden sm:inline">Editar</span>
                                </a>

                                <form action="{{ route('categorias.destroy', $categoria) }}"
                                      method="POST"
                                      onsubmit="return confirm('¿Eliminar esta categoría?')">
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit" class="btn-action btn-delete">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M3 6h18M8 6V4h8v2M6 6v14a2 2 0 002 2h8
                                                a2 2 0 002-2V6M10 11v6M14 11v6"/>
                                        </svg>
                                        <span class="hidden sm:inline">Eliminar</span>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>

        </table>
    </div>
</div>

<style>
/* ================= ICONOS ================= */
.material-symbols-outlined {
    font-variation-settings:
        'FILL' 0,
        'wght' 400,
        'GRAD' 0,
        'opsz' 20;
    font-size:18px;
}

/* ================= ICON CIRCLE ================= */
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

/* ================= BOTÓN PRINCIPAL ================= */
.btn-primary {
    display:inline-flex;
    align-items:center;
    gap:8px;
    padding:0 16px;
    height:40px;
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

/* ================= TABLA ================= */
.tabla-container {
    background:rgba(255,255,255,.04);
    border:1px solid rgba(239,68,68,.35);
    border-radius:22px;
    overflow:hidden;
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
    padding:14px 18px;
    color:#e5e5e5;
    border-top:1px solid rgba(255,255,255,.06);
    vertical-align:middle;
}

/* ================= ACCIONES ================= */
.acciones-td {
    text-align:right;
}

.acciones {
    display:flex;
    justify-content:flex-end;
    align-items:center;
    gap:10px;
}

/* ================= BOTONES ================= */
.btn-action {
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
    white-space:nowrap;
}

.icon-btn {
    width:18px;
    height:18px;
    display:flex;
    align-items:center;
    justify-content:center;
}

/* ================= COLORES ================= */
.btn-edit {
    background:rgba(234,179,8,.18);
    border:1px solid rgba(234,179,8,.45);
}

.btn-edit:hover {
    background:rgba(234,179,8,.3);
}

.btn-delete {
    background:rgba(239,68,68,.18);
    border:1px solid rgba(239,68,68,.45);
}

.btn-delete:hover {
    background:rgba(239,68,68,.32);
}

.btn-action:hover {
    transform:translateY(-2px);
}

/* ===== FIX DEFINITIVO FORM EN ACCIONES ===== */
.acciones form {
    display:inline-flex;
    align-items:center;
    margin:0;
}

.acciones form button {
    display:inline-flex;
    align-items:center;
}

</style>

</x-app-layout>