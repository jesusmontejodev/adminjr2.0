<x-app-layout>
    <div class="max-w-6xl mx-auto px-6 py-10">
        <h1 class="text-3xl font-bold text-gray-900 dark:text-gray-100 mb-8">Ventas</h1>

        {{-- Mensaje de éxito --}}
        @if(session('success'))
            <div class="mb-6 rounded-lg bg-green-100 dark:bg-green-800 text-green-800 dark:text-green-200 px-4 py-3 shadow">
                {{ session('success') }}
            </div>
        @endif

        {{-- Botón nuevo pago --}}
        <div class="mb-6">
            <a href="{{ route('comisiones.create') }}"
                class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-lg shadow transition">
                ➕ Nueva venta
            </a>
        </div>

        {{-- Tabla --}}
        <div class="overflow-x-auto bg-white dark:bg-gray-800 rounded-lg shadow">
            <table class="w-full text-sm text-left">
                <thead class="bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 uppercase text-xs">
                    <tr>
                        <th class="px-4 py-3">Nombre del asesor</th>
                        <th class="px-4 py-3">Lote</th>
                        <th class="px-4 py-3">Nombre del proyecto</th>
                        <th class="px-4 py-3">Modelo</th>
                        <th class="px-4 py-3">Cliente</th>
                        <th class="px-4 py-3 text-center">Precio</th>
                        <th class="px-4 py-3 text-center">Apartado</th>
                        <th class="px-4 py-3 text-center">Enganche</th>
                        <th class="px-4 py-3 text-center">Contrato</th>
                        <th class="px-4 py-3">Observaciones</th>
                        <th class="px-4 py-3 text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($comisiones as $comision)
                        <tr class="border-b dark:border-gray-700">
                            <td class="px-4 py-3 dark:text-gray-300 text-gray-700">{{ $comision->nombre }}</td>
                            <td class="px-4 py-3 dark:text-gray-300">{{ $comision->lote }}</td>
                            <td class="px-4 py-3 dark:text-gray-300">{{ $comision->nombre_proyecto }}</td>
                            <td class="px-4 py-3 dark:text-gray-300">{{ $comision->modelo }}</td>
                            <td class="px-4 py-3 dark:text-gray-300">{{ $comision->cliente }}</td>
                            <td class="px-4 py-3 dark:text-gray-300 text-center">${{ number_format($comision->precio, 2) }}</td>
                            <td class="px-4 py-3 dark:text-gray-300 text-center">{{ $comision->apartado }}</td>
                            <td class="px-4 py-3 dark:text-gray-300 text-center">{{ $comision->enganche }}</td>
                            <td class="px-4 py-3 dark:text-gray-300 text-center">{{ $comision->contrato }}</td>
                            <td class="px-4 py-3 dark:text-gray-300">{{ $comision->observaciones }}</td>
                            <td class="px-4 py-3 dark:text-gray-300 text-center">
                                <div class="flex justify-center gap-2">
                                    {{-- Botón Editar --}}
                                    <a href="{{ route('comisiones.edit', $comision->id) }}"
                                        class="px-3 py-1 bg-yellow-500 hover:bg-yellow-600 text-white text-xs rounded-lg shadow">
                                        Editar
                                    </a>
                                    @if (!$comision->concretado)
                                    <a href="{{ route('comisiones.concretar', $comision->id) }}"
                                        class="px-3 py-1 bg-yellow-500 hover:bg-blue-500 text-white text-xs rounded-lg shadow">
                                        Concretar
                                    </a>
                                    @endif
                                    {{-- Botón Eliminar --}}
                                    <form action="{{ route('comisiones.destroy', $comision->id) }}" method="POST"
                                        onsubmit="return confirm('¿Seguro que deseas eliminar este registro?')">
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
                            <td colspan="11" class="px-4 py-6 text-center text-gray-500 dark:text-gray-400">
                                No hay registros de pagos pendientes.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
