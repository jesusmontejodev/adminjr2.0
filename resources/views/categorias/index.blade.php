<x-app-layout>
    <!-- Fondo general dark -->
    <div class="bg-gray-900 min-h-screen text-gray-200">
        <div class="max-w-[1440px] mx-auto px-4 sm:px-6 lg:px-8 py-8">

            <!-- Header -->
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
                <div>
                    <h1 class="text-2xl sm:text-3xl font-bold text-white">
                        📂 Categorías
                    </h1>
                    <p class="text-sm text-gray-400 mt-1">
                        Administra y organiza tus categorías
                    </p>
                </div>

                <a href="{{ route('categorias.create') }}"
                    class="inline-flex items-center gap-2 px-4 py-2.5
                    bg-blue-600 hover:bg-blue-500 text-white
                    font-medium rounded-xl shadow transition">
                    ➕ Nueva categoría
                </a>
            </div>

            <!-- Success Message -->
            @if(session('success'))
                <div class="mb-6 p-4
                    bg-green-500/10 text-green-300
                    border border-green-400/30
                    rounded-xl">
                    ✅ {{ session('success') }}
                </div>
            @endif

            <!-- Table -->
            <div class="bg-gray-800 border border-gray-700 rounded-2xl shadow-xl overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead class="bg-gray-900 border-b border-gray-700">
                            <tr>
                                <th class="px-5 py-4 text-left font-semibold text-gray-200">
                                    Nombre
                                </th>

                                <th class="px-5 py-4 text-right font-semibold text-gray-200">
                                    Acciones
                                </th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-gray-700">
                            @forelse($categorias as $categoria)
                                <tr class="hover:bg-gray-700/50 transition">
                                    <!-- Nombre -->
                                    <td class="px-5 py-4 font-medium text-white">
                                        {{ $categoria->nombre }}
                                    </td>

                                    <!-- Descripción -->
                                    {{-- <td class="px-5 py-4">
                                        @if($categoria->descripcion)
                                            <span class="inline-block px-3 py-1 text-xs
                                                bg-blue-500/20 text-blue-300
                                                border border-blue-400/30 rounded-full">
                                                {{ Str::limit($categoria->descripcion, 40) }}
                                            </span>
                                        @else
                                            <span class="inline-block px-3 py-1 text-xs
                                                bg-gray-700 text-gray-300
                                                border border-gray-600 rounded-full">
                                                Sin descripción
                                            </span>
                                        @endif
                                    </td> --}}

                                    <!-- Acciones -->
                                    <td class="px-5 py-4 text-right">
                                        <div class="flex justify-end gap-2">
                                            <a href="{{ route('categorias.edit', $categoria) }}"
                                                class="px-3 py-1.5 text-xs rounded-lg
                                                bg-yellow-500/20 text-yellow-300
                                                border border-yellow-400/40
                                                hover:bg-yellow-500/30 transition">
                                                ✏️ Editar
                                            </a>

                                            <form action="{{ route('categorias.destroy', $categoria) }}"
                                                method="POST"
                                                onsubmit="return confirm('¿Eliminar esta categoría?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="px-3 py-1.5 text-xs rounded-lg
                                                    bg-red-500/20 text-red-300
                                                    border border-red-400/40
                                                    hover:bg-red-500/30 transition">
                                                    🗑️ Eliminar
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="px-6 py-12 text-center">
                                        <p class="text-gray-400 mb-4">
                                            Aún no has creado categorías
                                        </p>
                                        <a href="{{ route('categorias.create') }}"
                                            class="inline-block px-4 py-2
                                            bg-blue-600 hover:bg-blue-500
                                            text-white rounded-lg transition">
                                            Crear mi primera categoría
                                        </a>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Pagination (opcional) -->
            @if(method_exists($categorias, 'links'))
                <div class="mt-6">
                    {{ $categorias->links() }}
                </div>
            @endif

        </div>
    </div>
</x-app-layout>
