<x-app-layout>
    <div class="max-w-4xl mx-auto px-6 py-10">
        <h1 class="text-2xl font-bold text-gray-900 dark:text-gray-100 mb-6">Editar Cuenta por Cobrar</h1>

        <form action="{{ route('cuentasporcobrar.update', $cuenta->id) }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-gray-700 dark:text-gray-300 mb-1">Nombre clave</label>
                <input type="text" name="nombre_clave" value="{{ old('nombre_clave', $cuenta->nombre_clave) }}"
                    class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-800 text-gray-900 dark:text-gray-100">
            </div>

            <div>
                <label class="block text-gray-700 dark:text-gray-300 mb-1">Descripción</label>
                <textarea name="descripcion"
                    class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-800 text-gray-900 dark:text-gray-100">{{ old('descripcion', $cuenta->descripcion) }}</textarea>
            </div>

            <div>
                <label class="block text-gray-700 dark:text-gray-300 mb-1">Monto</label>
                <input type="number" name="monto" step="0.01" value="{{ old('monto', $cuenta->monto) }}"
                    class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-800 text-gray-900 dark:text-gray-100">
            </div>

            <div>
                <label class="block text-gray-700 dark:text-gray-300 mb-1">Fecha</label>
                <input type="date" name="fecha" value="{{ old('fecha', $cuenta->fecha ? \Carbon\Carbon::parse($cuenta->fecha)->format('Y-m-d') : '') }}"
                    class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-800 text-gray-900 dark:text-gray-100">
            </div>

            <div>
                <label class="block text-gray-700 dark:text-gray-300 mb-1">Estado</label>
                <select name="concretado" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-800 text-gray-900 dark:text-gray-100">
                    <option value="0" {{ !$cuenta->concretado ? 'selected' : '' }}>Pendiente</option>
                    <option value="1" {{ $cuenta->concretado ? 'selected' : '' }}>Pagado</option>
                </select>
            </div>

            <div>
                <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg shadow">
                    Actualizar
                </button>
                <a href="{{ route('cuentasporcobrar.index') }}"
                    class="px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white rounded-lg shadow">
                    Cancelar
                </a>
            </div>
        </form>
    </div>
</x-app-layout>
