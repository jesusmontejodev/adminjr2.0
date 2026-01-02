<x-app-layout>
    <!-- Contenedor principal con ancho máximo de 1440px y centrado -->
    <div class="max-w-[1440px] mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Encabezado con flex-col en móviles -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
            <h1 class="text-2xl sm:text-3xl font-bold text-white" id="cuentas">💰 Mis Cuentas</h1>
            <a href="{{ route('cuentas.create') }}"
                class="px-4 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg sm:rounded-xl shadow-md transition-colors duration-200 text-center">
                + Nueva Cuenta
            </a>
        </div>

        <!-- Mensaje de éxito -->
        @if(session('success'))
            <div class="mb-6 p-4 bg-green-100 border-l-4 border-green-500 text-green-700 rounded-lg shadow-sm">
                ✅ {{ session('success') }}
            </div>
        @endif

        <!-- Tarjeta de saldo total -->
        <div class="mb-8">
            <div class="bg-gradient-to-r from-green-500 to-green-600 rounded-xl p-6 text-white shadow-lg max-w-md">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm opacity-90">Saldo Total</p>
                        <p class="text-3xl font-bold">
                            ${{ number_format($cuentas->sum('saldo_actual'), 2) }}
                        </p>
                    </div>
                    <div class="text-4xl">💰</div>
                </div>
            </div>
        </div>

        <!-- Contenedor de tabla responsive -->
        <div class="bg-white shadow-lg rounded-xl overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-base border-collapse">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 font-semibold text-gray-700 text-left">ID</th>
                            <th class="px-4 py-3 font-semibold text-gray-700 text-left">Nombre</th>
                            <th class="px-4 py-3 font-semibold text-gray-700 text-left">Saldo Actual</th>
                            <th class="px-4 py-3 font-semibold text-gray-700 text-left">Descripción</th>
                            <th class="px-4 py-3 font-semibold text-gray-700 text-right">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($cuentas as $cuenta)
                            <tr class="hover:bg-gray-50 transition-colors duration-150">
                                <td class="px-4 py-3 text-gray-900">{{ $cuenta->id }}</td>
                                <td class="px-4 py-3 text-gray-900 font-medium">
                                    <div class="flex items-center">
                                        <span class="mr-2">💰</span>
                                        {{ $cuenta->nombre }}
                                    </div>
                                </td>
                                <td class="px-4 py-3">
                                    <span class="font-semibold {{ $cuenta->saldo_actual >= 0 ? 'text-green-600' : 'text-red-600' }}">
                                        ${{ number_format($cuenta->saldo_actual, 2) }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-gray-600">
                                    @if($cuenta->descripcion)
                                        {{ Str::limit($cuenta->descripcion, 50) }}
                                    @else
                                        <span class="text-gray-400">Sin descripción</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-right space-x-1 sm:space-x-2">
                                    <a href="{{ route('cuentas.edit', $cuenta) }}"
                                        class="inline-block px-3 py-1.5 bg-yellow-500 hover:bg-yellow-600 text-gray-800 text-sm rounded shadow transition-colors duration-200">
                                        ✏️ Editar
                                    </a>

                                    <form action="{{ route('cuentas.destroy', $cuenta) }}" method="POST"
                                        class="inline-block"
                                        onsubmit="return confirm('¿Seguro que deseas eliminar esta cuenta?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="inline-block px-3 py-1.5 bg-red-600 hover:bg-red-700 text-white text-sm rounded shadow transition-colors duration-200">
                                            🗑️ Eliminar
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-4 py-6 text-center text-gray-500">
                                    No hay cuentas registradas.
                                    <a href="{{ route('cuentas.create') }}" class="text-blue-600 hover:text-blue-800 ml-2">
                                        Crear mi primera cuenta
                                    </a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</x-app-layout>
