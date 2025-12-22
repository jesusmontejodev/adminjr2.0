<x-app-layout>
    <!-- Contenedor principal con ancho máximo de 1440px y centrado -->
    <div class="max-w-[1440px] mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Encabezado con flex-col en móviles -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
            <h1 class="text-2xl sm:text-3xl font-bold text-white" id="caregoria">📂 Categorías</h1>
            <a href="{{ route('categorias.create') }}"
                class="px-4 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg sm:rounded-xl shadow-md transition-colors duration-200 text-center">
                + Nueva Categoría
            </a>
        </div>

        <!-- Mensaje de éxito -->
        @if(session('success'))
            <div class="mb-6 p-4 bg-green-100 border-l-4 border-green-500 text-green-700 rounded-lg shadow-sm">
                ✅ {{ session('success') }}
            </div>
        @endif

        <!-- Contenedor de tabla responsive -->
        <div class="bg-white shadow-lg rounded-xl overflow-hidden">
            <div class="overflow-x-auto">  <!-- Permite scroll horizontal en móviles -->
                <table class="w-full text-base border-collapse">  <!-- Usamos text-base para mejor legibilidad -->
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 font-semibold text-gray-700 text-left">ID</th>
                            <th class="px-4 py-3 font-semibold text-gray-700 text-left">Nombre</th>
                            <th class="px-4 py-3 font-semibold text-gray-700 text-right">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($categorias as $categoria)
                            <tr class="hover:bg-gray-50 transition-colors duration-150">
                                <td class="px-4 py-3 text-gray-900">{{ $categoria->id }}</td>
                                <td class="px-4 py-3 text-gray-900">{{ $categoria->nombre }}</td>
                                <td class="px-4 py-3 text-right space-x-1 sm:space-x-2">
                                    <a href="{{ route('categorias.edit', $categoria->id) }}"
                                        class="inline-block px-3 py-1.5 bg-yellow-500 hover:bg-yellow-600 text-gray text-sm rounded shadow transition-colors duration-200">
                                        ✏️ Editar
                                    </a>

                                    <form action="{{ route('categorias.destroy', $categoria->id) }}" method="POST"
                                        class="inline-block"
                                        onsubmit="return confirm('¿Seguro que deseas eliminar esta categoría?')">
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
                                <td colspan="4" class="px-4 py-6 text-center text-gray-500">
                                    No hay categorías registradas.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</x-app-layout>

