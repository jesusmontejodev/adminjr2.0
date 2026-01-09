<head>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet">
</head>

<x-app-layout>

<div class="absolute inset-0 -z-20 bg-[#0f1115]"></div>

<div class="relative z-10 p-6 sm:p-10 max-w-[1440px] mx-auto">

    <!-- HEADER -->
    <div class="flex justify-between items-center mb-10">
        <h1 class="flex items-center gap-3 text-white text-2xl font-bold">
            <span class="icon-circle">
                <span class="material-symbols-outlined">category</span>
            </span>
            Categorías
        </h1>

        <a href="{{ route('categorias.create') }}" class="btn-primary">
            <span class="material-symbols-outlined">add</span>
            Nueva categoría
        </a>
    </div>

    <!-- TABLA -->
    <div class="tabla-container">
        <table class="tabla">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th class="text-right">Acciones</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($categorias as $categoria)
                    <tr>
                        <!-- NOMBRE -->
                        <td>
                            <div class="flex items-center gap-2 font-semibold">
                                <span class="material-symbols-outlined text-red-400 text-[18px]">
                                    label
                                </span>
                                {{ $categoria->nombre }}
                            </div>
                        </td>

                        <!-- ACCIONES -->
                        <td class="acciones-td">
                            <div class="acciones">
                                <a href="{{ route('categorias.edit', $categoria) }}"
                                   class="btn-action btn-edit">
                                    <span class="material-symbols-outlined icon-btn">
                                        edit_square
                                    </span>
                                    <span class="hidden sm:inline">Editar</span>
                                </a>

                                <form action="{{ route('categorias.destroy', $categoria) }}"
                                      method="POST"
                                      onsubmit="return confirm('¿Eliminar esta categoría?')">
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit" class="btn-action btn-delete">
                                        <span class="material-symbols-outlined icon-btn">
                                            delete
                                        </span>
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