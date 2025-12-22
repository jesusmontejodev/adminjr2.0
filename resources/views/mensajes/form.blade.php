@csrf

{{-- Mensaje --}}
<div class="mb-5">
    <label for="mensaje" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
        Mensaje
    </label>
    <textarea id="mensaje" name="mensaje"
        class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-200 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-300 focus:ring-opacity-50 p-3"
        rows="3">{{ old('mensaje', $mensaje->mensaje ?? '') }}</textarea>
</div>

{{-- Categoría --}}
<div class="mb-5">
    <label for="categoria" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
        Categoría
    </label>
    <select id="categoria" name="categoria"
        class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-200 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-300 focus:ring-opacity-50 p-3">
        <option value="">-- Selecciona una categoría --</option>
        @foreach($categorias as $categoria)
            <option value="{{ $categoria->nombre }}"
                {{ old('categoria', $mensaje->categoria ?? '') == $categoria->nombre ? 'selected' : '' }}>
                {{ $categoria->nombre }}
            </option>
        @endforeach
    </select>
</div>

{{-- Cuenta --}}
<div class="mb-5">
    <label for="cuenta" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
        Cuenta
    </label>
    <select id="cuenta" name="cuenta"
        class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-200 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-300 focus:ring-opacity-50 p-3">
        <option value="">-- Selecciona una cuenta --</option>
        @foreach($cuentas as $cuenta)
            <option value="{{ $cuenta->nombre }}"
                {{ old('cuenta', $mensaje->cuenta ?? '') == $cuenta->nombre ? 'selected' : '' }}>
                {{ $cuenta->nombre }}
            </option>
        @endforeach
    </select>
</div>

{{-- Tipo --}}
<div class="mb-5">
    <label for="tipo" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
        Tipo
    </label>
    <select name="tipo" id="tipo" required
        class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-200 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-300 focus:ring-opacity-50 p-3">
        <option value="">-- Selecciona el tipo --</option>
        <option value="ingreso" {{ old('tipo', $transaccion->tipo ?? '') == 'ingreso' ? 'selected' : '' }}>Ingreso</option>
        <option value="gasto" {{ old('tipo', $transaccion->tipo ?? '') == 'gasto' ? 'selected' : '' }}>Gasto</option>
        <option value="inversion" {{ old('tipo', $transaccion->tipo ?? '') == 'inversion' ? 'selected' : '' }}>Inversión</option>
    </select>
    @error('tipo')
        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
    @enderror
</div>


{{-- Monto --}}
<div class="mb-5">
    <label for="monto" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
        Monto
    </label>
    <input id="monto" type="number" step="0.01" name="monto"
        class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-200 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-300 focus:ring-opacity-50 p-3"
        value="{{ old('monto', $mensaje->monto ?? '') }}">
</div>




{{-- Botones --}}
<div class="flex items-center gap-3">
    <button type="submit"
        class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-lg shadow transition duration-150">
        Guardar
    </button>
    <a href="{{ route('mensajes.index') }}"
        class="text-gray-600 dark:text-gray-400 hover:text-gray-800 dark:hover:text-gray-200 transition">
        Cancelar
    </a>
</div>
