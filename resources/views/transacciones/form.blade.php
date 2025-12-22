@php
    $isEdit = isset($transaccion);
@endphp

{{-- Cuenta --}}
<div class="text-black">
    <label for="cuenta_id" class="block text-sm font-medium text-black">Cuenta</label>
    <select name="cuenta_id" id="cuenta_id"
        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
        required>
        <option value="">-- Selecciona una cuenta --</option>
        @foreach($cuentas as $cuenta)
            <option value="{{ $cuenta->id }}"
                {{ old('cuenta_id', $transaccion->cuenta_id ?? '') == $cuenta->id ? 'selected' : '' }}>
                {{ $cuenta->nombre }} (Saldo: {{ number_format($cuenta->saldo_actual, 2) }})
            </option>
        @endforeach
    </select>
    @error('cuenta_id')
        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
    @enderror
</div>

{{-- Categoría --}}
<div class="text-black">
    <label for="categoria_id" class="block text-sm font-medium text-black">Categoría</label>
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
<div class="text-black">
    <label for="monto" class="block text-sm font-medium text-black">Monto</label>
    <input type="number" name="monto" id="monto" step="0.01"
        value="{{ old('monto', $transaccion->monto ?? '') }}"
        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
        required>
    @error('monto')
        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
    @enderror
</div>

{{-- Descripción --}}
<div class="text-black">
    <label for="descripcion" class="block text-sm font-medium text-black">Descripción</label>
    <textarea name="descripcion" id="descripcion" rows="3"
        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">{{ old('descripcion', $transaccion->descripcion ?? '') }}</textarea>
    @error('descripcion')
        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
    @enderror
</div>

{{-- Tipo --}}
<div class="text-black">
    <label for="tipo" class="block text-sm font-medium text-black">Tipo</label>
    <select name="tipo" id="tipo" required
        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-black">
        <option value="">-- Usar tipo de la categoría --</option>
        <option value="ingreso" {{ old('tipo', $transaccion->tipo ?? '') == 'ingreso' ? 'selected' : '' }}>Ingreso</option>
        <option value="gasto" {{ old('tipo', $transaccion->tipo ?? '') == 'gasto' ? 'selected' : '' }}>Gasto</option>
        <option value="inversion" {{ old('tipo', $transaccion->tipo ?? '') == 'inversion' ? 'selected' : '' }}>Inversión</option>
    </select>
    @error('tipo')
        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
    @enderror
</div>


{{-- Fecha --}}
<div class="text-black">
    <label for="fecha" class="block text-sm font-medium text-black">Fecha</label>
    <input type="date" name="fecha" id="fecha"
        value="{{ old('fecha', $isEdit ? $transaccion->fecha->format('Y-m-d') : now()->format('Y-m-d')) }}"
        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
        required>
    @error('fecha')
        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
    @enderror
</div>
