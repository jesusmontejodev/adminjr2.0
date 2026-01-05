@php
    $isEdit = isset($transaccion);
@endphp

{{-- Cuenta --}}
<div class="text-black mb-4">
    <label for="cuenta_id" class="block text-sm font-medium text-black">Cuenta *</label>
    <select name="cuenta_id" id="cuenta_id"
        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
        required>
        <option value="">-- Selecciona una cuenta --</option>
        @foreach($cuentas as $cuenta)
            <option value="{{ $cuenta->id }}"
                {{ old('cuenta_id', $transaccion->cuenta_id ?? '') == $cuenta->id ? 'selected' : '' }}>
                {{ $cuenta->nombre }} (Saldo: ${{ number_format($cuenta->saldo_actual, 2) }})
            </option>
        @endforeach
    </select>
    @error('cuenta_id')
        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
    @enderror
</div>

{{-- Categoría --}}
<div class="text-black mb-4">
    <label for="categoria_id" class="block text-sm font-medium text-black">Categoría *</label>
    <select name="categoria_id" id="categoria_id"
        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
        required>
        <option value="">-- Selecciona una categoría --</option>
        @foreach($categorias as $categoria)
            <option value="{{ $categoria->id }}"
                {{ old('categoria_id', $transaccion->categoria_id ?? '') == $categoria->id ? 'selected' : '' }}>
                {{ $categoria->nombre }}
            </option>
        @endforeach
    </select>
    @error('categoria_id')
        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
    @enderror
</div>

{{-- Monto --}}
<div class="text-black mb-4">
    <label for="monto" class="block text-sm font-medium text-black">Monto *</label>
    <div class="relative mt-1 rounded-md shadow-sm">
        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
            <span class="text-gray-500 sm:text-sm">$</span>
        </div>
        <input type="number" name="monto" id="monto" step="0.01" min="0.01"
            value="{{ old('monto', $transaccion->monto ?? '') }}"
            class="block w-full rounded-md border-gray-300 pl-7 focus:ring-indigo-500 focus:border-indigo-500"
            required
            placeholder="0.00">
    </div>
    @error('monto')
        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
    @enderror
</div>

{{-- Tipo --}}
<div class="text-black mb-4">
    <label for="tipo" class="block text-sm font-medium text-black">Tipo de Transacción *</label>
    <select name="tipo" id="tipo" required
        class="tipo-select mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-black">
        <option value="">-- Selecciona un tipo --</option>
        <option value="ingreso" {{ old('tipo', $transaccion->tipo ?? '') == 'ingreso' ? 'selected' : '' }}>
            💰 Ingreso
        </option>
        <option value="egreso" {{ old('tipo', $transaccion->tipo ?? '') == 'egreso' ? 'selected' : '' }}>
            📤 Egreso
        </option>
        <option value="costo" {{ old('tipo', $transaccion->tipo ?? '') == 'costo' ? 'selected' : '' }}>
            🏗️ Costo
        </option>
        <option value="inversion" {{ old('tipo', $transaccion->tipo ?? '') == 'inversion' ? 'selected' : '' }}>
            📈 Inversión
        </option>
    </select>
    @error('tipo')
        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
    @enderror
</div>

{{-- Descripción --}}
<div class="text-black mb-4">
    <label for="descripcion" class="block text-sm font-medium text-black">Descripción</label>
    <textarea name="descripcion" id="descripcion" rows="3"
        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
        placeholder="Descripción de la transacción">{{ old('descripcion', $transaccion->descripcion ?? '') }}</textarea>
    @error('descripcion')
        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
    @enderror
</div>

{{-- Fecha --}}
<div class="text-black mb-4">
    <label for="fecha" class="block text-sm font-medium text-black">Fecha *</label>
    <input type="date" name="fecha" id="fecha"
        value="{{ old('fecha', $isEdit ? $transaccion->fecha->format('Y-m-d') : now()->format('Y-m-d')) }}"
        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
        required>
    @error('fecha')
        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
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
