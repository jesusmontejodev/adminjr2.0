<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('📩 Listado de Mensajes') }}
        </h2>
    </x-slot>

    <div class="max-w-6xl mx-auto px-6 py-10">

        {{-- Mensaje de éxito --}}
        @if(session('success'))
            <div class="mb-6 rounded-lg bg-green-100 dark:bg-green-800 text-green-800 dark:text-green-200 px-4 py-3 shadow">
                {{ session('success') }}
            </div>
        @endif

        {{-- Botón nuevo mensaje --}}
        <div class="mb-6">
            <a href="{{ route('mensajes.create') }}"
                class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-lg shadow transition">
                ➕ Nuevo Mensaje
            </a>
        </div>

        {{-- Tabla --}}
        <div class="overflow-x-auto bg-white dark:bg-gray-800 rounded-lg shadow">
            <table class="w-full text-sm text-left">
                <thead class="bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 uppercase text-xs">
                    <tr>
                        <th class="px-4 py-3">ID</th>
                        <th class="px-4 py-3">Mensaje</th>
                        <th class="px-4 py-3">Categoría</th>
                        <th class="px-4 py-3">Cuenta</th>
                        <th class="px-4 py-3">Monto</th>
                        <th class="px-4 py-4">Tipo</th>
                        <th class="px-4 py-3 text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($mensajes as $mensaje)
                        <tr class="border-b dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                            <td class="px-4 py-3 font-medium text-gray-900 dark:text-gray-100">{{ $mensaje->id }}</td>
                            <td class="px-4 py-3 text-gray-700 dark:text-gray-300">{{ $mensaje->mensaje }}</td>
                            <td class="px-4 py-3 text-gray-700 dark:text-gray-300">{{ $mensaje->categoria }}</td>
                            <td class="px-4 py-3 text-gray-700 dark:text-gray-300">{{ $mensaje->cuenta }}</td>
                            <td class="px-4 py-3 text-gray-700 dark:text-gray-300">${{ number_format($mensaje->monto, 2) }}</td>
                            <td class="px-4 py-3 text-gray-700 dark:text-gray-300">{{ $mensaje->tipo }}</td>
                            <td class="px-4 py-3 flex items-center justify-center gap-2">
                                <a href="{{ route('mensajes.edit', $mensaje->id) }}"
                                    class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1.5 rounded-lg text-xs shadow transition">
                                    ✏️ Editar
                                </a>
                                <form action="{{ route('mensajes.destroy', $mensaje->id) }}" method="POST"
                                    onsubmit="return confirm('¿Eliminar este mensaje?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="bg-red-600 hover:bg-red-700 text-white px-3 py-1.5 rounded-lg text-xs shadow transition">
                                        🗑️ Eliminar
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-6 text-center text-gray-500 dark:text-gray-400">
                                No hay mensajes registrados.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
