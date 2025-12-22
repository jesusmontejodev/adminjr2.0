<x-app-layout>
    <div class="max-w-6xl mx-auto px-6 py-10">
        <h1 class="text-3xl font-bold text-gray-900 dark:text-gray-100 mb-8">Cuentas por Cobrar</h1>

        {{-- Mensaje de éxito --}}
        @if(session('success'))
            <div class="mb-6 rounded-lg bg-green-100 dark:bg-green-800 text-green-800 dark:text-green-200 px-4 py-3 shadow">
                {{ session('success') }}
            </div>
        @endif

        <div class="overflow-x-auto bg-white dark:bg-gray-800 rounded-lg shadow">
            <table class="w-full text-sm text-left">
                <thead class="bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 uppercase text-xs">
                    <tr>
                        <th class="px-4 py-3">Nombre clave</th>
                        <th class="px-4 py-3">Descripción</th>
                        <th class="px-4 py-3 text-center">Monto</th>
                        <th class="px-4 py-3">Fecha</th>
                        <th class="px-4 py-3 text-center">Estado</th>
                        <th class="px-4 py-3 text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($cuentas as $cuenta)
                        <tr class="border-b dark:border-gray-700">
                            <td class="px-4 py-3 dark:text-gray-300">{{ $cuenta->nombre_clave }}</td>
                            <td class="px-4 py-3 dark:text-gray-300">{{ $cuenta->descripcion }}</td>
                            <td class="px-4 py-3 dark:text-gray-300 text-center">${{ number_format($cuenta->monto, 2) }}</td>
                            <td class="px-4 py-3 dark:text-gray-300">{{ $cuenta->fecha }}</td>
                            <td class="px-4 py-3 text-center">
                                @if($cuenta->concretado)
                                    <span class="px-2 py-1 bg-green-200 text-green-800 rounded text-xs">Pagado</span>
                                @else
                                    <span class="px-2 py-1 bg-yellow-200 text-yellow-800 rounded text-xs">Pendiente</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-center">
                                <div class="flex justify-center gap-2">
                                    {{-- Botón Ver --}}
                                    <a href="{{ route('cuentasporcobrar.show', $cuenta->id) }}"
                                        class="px-3 py-1 bg-blue-600 hover:bg-blue-700 text-white text-xs rounded-lg shadow">
                                        Ver
                                    </a>

                                    {{-- Botón Editar --}}
                                    <a href="{{ route('cuentasporcobrar.edit', $cuenta->id) }}"
                                        class="px-3 py-1 bg-yellow-500 hover:bg-yellow-600 text-white text-xs rounded-lg shadow">
                                        Editar
                                    </a>

                                    {{-- Botón Eliminar --}}
                                    <form action="{{ route('cuentasporcobrar.destroy', $cuenta->id) }}" method="POST"
                                        onsubmit="return confirm('¿Seguro que deseas eliminar esta cuenta?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="px-3 py-1 bg-red-600 hover:bg-red-700 text-white text-xs rounded-lg shadow">
                                            Eliminar
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-6 text-center text-gray-500 dark:text-gray-400">
                                No hay cuentas por cobrar registradas.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
