@csrf

<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    {{-- Nombre --}}
    <div>
        <label for="nombre" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nombre del asesor</label>
        <input type="text" name="nombre" id="nombre"
            value="{{ old('nombre', $comision->nombre ?? '') }}"
            class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-800 text-gray-900 dark:text-gray-100 shadow-sm focus:ring-blue-500 focus:border-blue-500">
    </div>

    {{-- Lote --}}
    <div>
        <label for="lote" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Lote</label>
        <input type="text" step="0.01" name="lote" id="lote"
            value="{{ old('lote', $comision->lote ?? '') }}"
            class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-800 text-gray-900 dark:text-gray-100 shadow-sm focus:ring-blue-500 focus:border-blue-500">
    </div>

    {{-- Nombre del proyecto --}}
    <div>
        <label for="nombre_proyecto" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nombre del proyecto</label>
        <input type="text" name="nombre_proyecto" id="nombre_proyecto"
            value="{{ old('nombre_proyecto', $comision->nombre_proyecto ?? '') }}"
            class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-800 text-gray-900 dark:text-gray-100 shadow-sm focus:ring-blue-500 focus:border-blue-500">
    </div>

    {{-- Modelo --}}
    <div>
        <label for="modelo" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Modelo</label>
        <input type="text" name="modelo" id="modelo"
            value="{{ old('modelo', $comision->modelo ?? '') }}"
            class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-800 text-gray-900 dark:text-gray-100 shadow-sm focus:ring-blue-500 focus:border-blue-500">
    </div>

    {{-- Cliente --}}
    <div>
        <label for="cliente" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Cliente</label>
        <input type="text" name="cliente" id="cliente"
            value="{{ old('cliente', $comision->cliente ?? '') }}"
            class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-800 text-gray-900 dark:text-gray-100 shadow-sm focus:ring-blue-500 focus:border-blue-500">
    </div>

    {{-- Precio --}}
    <div>
        <label for="precio" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Precio</label>
        <input type="number" step="0.01" name="precio" id="precio"
            value="{{ old('precio', $comision->precio ?? '') }}"
            class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-800 text-gray-900 dark:text-gray-100 shadow-sm focus:ring-blue-500 focus:border-blue-500">
    </div>

    {{-- Apartado --}}
    <div>
        <label for="apartado" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Apartado</label>
        <input type="date" name="apartado" id="apartado"
            value="{{ old('apartado', $comision->apartado ?? '') }}"
            class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-800 text-gray-900 dark:text-gray-100 shadow-sm focus:ring-blue-500 focus:border-blue-500">
    </div>

    {{-- Enganche --}}
    <div>
        <label for="enganche" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Enganche</label>
        <input type="date" name="enganche" id="enganche"
            value="{{ old('enganche', $comision->enganche ?? '') }}"
            class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-800 text-gray-900 dark:text-gray-100 shadow-sm focus:ring-blue-500 focus:border-blue-500">
    </div>

    {{-- Contrato --}}
    <div>
        <label for="contrato" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Contrato</label>
        <input type="date" name="contrato" id="contrato"
            value="{{ old('contrato', $comision->contrato ?? '') }}"
            class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-800 text-gray-900 dark:text-gray-100 shadow-sm focus:ring-blue-500 focus:border-blue-500">
    </div>

    {{-- Observaciones --}}
    <div class="md:col-span-2">
        <label for="observaciones" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Observaciones</label>
        <textarea name="observaciones" id="observaciones" rows="3"
        class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-800 text-gray-900 dark:text-gray-100 shadow-sm focus:ring-blue-500 focus:border-blue-500">{{ old('observaciones', $comision->observaciones ?? '') }}</textarea>
    </div>
</div>

{{-- Botón --}}
<div class="mt-6">
    <button type="submit"
        class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-lg shadow transition">
        💾 Guardar
    </button>
</div>
