<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Nueva Cuenta por Cobrar') }}
        </h2>
    </x-slot>

    <div class="max-w-4xl mx-auto px-6 py-10">

        <form action="{{ route('cuentasporcobrar.store') }}" method="POST" class="space-y-4">
            @csrf

            <div>
                <label class="block text-gray-700 dark:text-gray-300 mb-1">Nombre clave</label>
                <input type="text" name="nombre_clave" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-800 text-gray-900 dark:text-gray-100">
            </div>

            <div>
                <label class="block text-gray-700 dark:text-gray-300 mb-1">Descripción</label>
                <textarea name="descripcion" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-800 text-gray-900 dark:text-gray-100"></textarea>
            </div>

            <div>
                <label class="block text-gray-700 dark:text-gray-300 mb-1">Monto</label>
                <input type="number" name="monto" step="0.01" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-800 text-gray-900 dark:text-gray-100">
            </div>

            <div>
                <label class="block text-gray-700 dark:text-gray-300 mb-1">Fecha</label>
                <input type="date" name="fecha" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-800 text-gray-900 dark:text-gray-100">
            </div>

            <div>
                <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg shadow">
                    Guardar
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
