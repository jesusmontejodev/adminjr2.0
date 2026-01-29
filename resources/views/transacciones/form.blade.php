@php
    $isEdit = isset($transaccion);
@endphp

{{-- Cuenta --}}
<div class="mb-4">
    <label for="cuenta_id" class="label">Cuenta *</label>
    <select name="cuenta_id" id="cuenta_id" class="input" required>
        <option value="">-- Selecciona una cuenta --</option>
        @foreach($cuentas as $cuenta)
            <option value="{{ $cuenta->id }}"
                {{ old('cuenta_id', $transaccion->cuenta_id ?? '') == $cuenta->id ? 'selected' : '' }}>
                {{ $cuenta->nombre }} (Saldo: ${{ number_format($cuenta->saldo_actual, 2) }})
            </option>
        @endforeach
    </select>
    @error('cuenta_id')
        <p class="error-text">{{ $message }}</p>
    @enderror
</div>

{{-- Categoría --}}
<div class="mb-4">
    <label for="categoria_id" class="label">Categoría *</label>
    <select name="categoria_id" id="categoria_id" class="input" required>
        <option value="">-- Selecciona una categoría --</option>
        @foreach($categorias as $categoria)
            <option value="{{ $categoria->id }}"
                {{ old('categoria_id', $transaccion->categoria_id ?? '') == $categoria->id ? 'selected' : '' }}>
                {{ $categoria->nombre }}
            </option>
        @endforeach
    </select>
    @error('categoria_id')
        <p class="error-text">{{ $message }}</p>
    @enderror
</div>

{{-- Monto --}}
<div class="mb-4">
    <label for="monto" class="label">Monto *</label>

    <div class="flex items-center bg-white/5 border border-white/10 rounded-xl px-2">

        <!-- SIGNO $ -->
        <span class="px-3 text-red-400 select-none">
            $
        </span>

        <!-- INPUT -->
        <input
            type="number"
            name="monto"
            id="monto"
            value="{{ old('monto', $transaccion->monto ?? '') }}"
            step="0.01"
            min="0.01"
            class="bg-transparent border-0 focus:ring-0 focus:outline-none text-white w-full py-3 pl-1"
            placeholder="0.00"
            required
        >
    </div>

    @error('monto')
        <p class="error-text">{{ $message }}</p>
    @enderror
</div>


{{-- Tipo --}}
<div class="mb-4">
    <label for="tipo" class="label">Tipo de Transacción *</label>
    <select name="tipo" id="tipo" class="input" required>
        <option value="">-- Selecciona un tipo --</option>
        <option value="ingreso" {{ old('tipo', $transaccion->tipo ?? '') == 'ingreso' ? 'selected' : '' }}>💰 Ingreso</option>
        <option value="egreso" {{ old('tipo', $transaccion->tipo ?? '') == 'egreso' ? 'selected' : '' }}>📤 Egreso</option>
        <option value="costo" {{ old('tipo', $transaccion->tipo ?? '') == 'costo' ? 'selected' : '' }}>🏗️ Costo</option>
        <option value="inversion" {{ old('tipo', $transaccion->tipo ?? '') == 'inversion' ? 'selected' : '' }}>📈 Inversión</option>
    </select>
    @error('tipo')
        <p class="error-text">{{ $message }}</p>
    @enderror
</div>

{{-- Descripción --}}
<div class="mb-4">
    <label for="descripcion" class="label">Descripción</label>
    <textarea name="descripcion" id="descripcion" rows="3" class="input"
        placeholder="Descripción de la transacción">{{ old('descripcion', $transaccion->descripcion ?? '') }}</textarea>
    @error('descripcion')
        <p class="error-text">{{ $message }}</p>
    @enderror
</div>

{{-- Fecha --}}
<div class="mb-4">
    <label for="fecha" class="label">Fecha *</label>
    <input type="date"
        name="fecha"
        id="fecha"
        value="{{ old('fecha', $isEdit ? $transaccion->fecha->format('Y-m-d') : now()->format('Y-m-d')) }}"
        class="input"
        required>
    @error('fecha')
        <p class="error-text">{{ $message }}</p>
    @enderror
</div>


{{-- Script para cambiar placeholder según tipo --}}
<script>
document.addEventListener('DOMContentLoaded', function() {
    const tipoSelect = document.getElementById('tipo');
    const descripcionTextarea = document.getElementById('descripcion');

    function actualizarPlaceholder() {
        switch(tipoSelect.value) {
            case 'ingreso':
                descripcionTextarea.placeholder = 'Ej: Salario, ventas, servicios, intereses, préstamos recibidos...';
                break;
            case 'egreso':
                descripcionTextarea.placeholder = 'Ej: Alquiler, servicios básicos, supermercado, transporte, salud...';
                break;
            case 'costo':
                descripcionTextarea.placeholder = 'Ej: Materias primas, producción, operación, mantenimiento...';
                break;
            case 'inversion':
                descripcionTextarea.placeholder = 'Ej: Acciones, bienes raíces, bonos, criptomonedas...';
                break;
            default:
                descripcionTextarea.placeholder = 'Descripción de la transacción';
        }
    }

    // Ejecutar al cargar si ya hay un tipo seleccionado
    if (tipoSelect.value) {
        actualizarPlaceholder();
    }

    // Ejecutar al cambiar tipo
    tipoSelect.addEventListener('change', actualizarPlaceholder);
});
</script>