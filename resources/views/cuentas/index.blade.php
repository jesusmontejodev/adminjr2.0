<x-app-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-semibold text-white">Cuentas</h1>
            <a href="{{ route('cuentas.create') }}" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-md shadow">
                Crear Cuenta
            </a>
        </div>

        @if(session('success'))
            <div class="mb-4 px-4 py-3 bg-green-100 border border-green-400 text-green-700 rounded">
                {{ session('success') }}
            </div>
        @endif

        <div class="overflow-x-auto bg-white shadow rounded-lg">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nombre</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Saldo Actual</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Descripción</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($cuentas as $cuenta)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-gray-900">{{ $cuenta->nombre }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-gray-900">${{ number_format($cuenta->saldo_actual, 2) }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-gray-900">{{ $cuenta->descripcion }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex space-x-2">
                                <a href="{{ route('cuentas.edit', $cuenta) }}" class="px-3 py-1 bg-yellow-400 hover:bg-yellow-500 text-black rounded-md text-sm">Editar</a>
                                <form action="{{ route('cuentas.destroy', $cuenta) }}" method="POST" onsubmit="return confirm('¿Deseas eliminar esta cuenta?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="px-3 py-1 bg-red-500 hover:bg-red-600 text-black rounded-md text-sm divide-solid">Eliminar</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
