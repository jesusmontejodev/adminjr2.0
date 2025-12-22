{{-- resources/views/transaccionesinternas/index.blade.php --}}
<x-app-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        <h1 class="text-2xl font-bold text-white mb-6">Transacciones Internas (Entre Cuentas)</h1>

        {{-- Mensajes de éxito --}}
        @if (session('success'))
            <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-800 rounded">
                {{ session('success') }}
            </div>
        @endif

        {{-- Botón crear --}}
        <div class="mb-4">
            <a href="{{ route('transaccionesinternas.create') }}"
                class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg shadow">
                + Nueva Transferencia
            </a>
        </div>

        {{-- Tabla --}}
        <div class="bg-white shadow rounded-lg overflow-hidden">
            <table class="min-w-full table-auto">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-4 py-2 text-left text-sm font-semibold text-gray-600">Fecha</th>
                        <th class="px-4 py-2 text-left text-sm font-semibold text-gray-600">Cuenta Origen</th>
                        <th class="px-4 py-2 text-left text-sm font-semibold text-gray-600">Cuenta Destino</th>
                        <th class="px-4 py-2 text-left text-sm font-semibold text-gray-600">Monto</th>
                        <th class="px-4 py-2 text-left text-sm font-semibold text-gray-600">Descripción</th>
                        <th class="px-4 py-2 text-center text-sm font-semibold text-gray-600">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($transaccionesinternas as $transaccion)
                        <tr class="border-b">
                            <td class="px-4 py-2 text-sm text-gray-700">
                                {{ $transaccion->created_at->format('d/m/Y H:i') }}
                            </td>
                            <td class="px-4 py-2 text-sm text-gray-700">
                                {{ $transaccion->cuentaOrigen->nombre }}
                            </td>
                            <td class="px-4 py-2 text-sm text-gray-700">
                                {{ $transaccion->cuentaDestino->nombre }}
                            </td>
                            <td class="px-4 py-2 text-sm font-semibold text-gray-800">
                                ${{ number_format($transaccion->monto, 2) }}
                            </td>
                            <td class="px-4 py-2 text-sm text-gray-600">
                                {{ $transaccion->descripcion ?? '-' }}
                            </td>
                            <td class="px-4 py-2 text-center space-x-2">
                                <a href="{{ route('transaccionesinternas.edit', $transaccion->id) }}"
                                    class="px-3 py-1 bg-yellow-500 hover:bg-yellow-600 text-white text-sm rounded">
                                    Editar
                                </a>
                                <form action="{{ route('transaccionesinternas.destroy', $transaccion->id) }}"
                                    method="POST"
                                    class="inline-block"
                                    onsubmit="return confirm('¿Seguro que deseas eliminar esta transacción interna?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="px-3 py-1 bg-red-600 hover:bg-red-700 text-white text-sm rounded">
                                        Eliminar
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-4 text-center text-gray-500">
                                No hay transacciones internas registradas.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>
</x-app-layout>
