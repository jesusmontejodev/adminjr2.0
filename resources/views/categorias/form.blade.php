<x-app-layout>
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-8 text-black">
        <h1 class="text-2xl font-semibold text-gray-900 mb-6">
            {{ isset($categoria) ? 'Editar Categoría' : 'Crear Categoría' }}
        </h1>

        {{-- Mensajes de validación --}}
        @if ($errors->any())
            <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Formulario --}}
        <form action="{{ isset($categoria) ? route('categorias.update', $categoria->id) : route('categorias.store') }}"
            method="POST" class="bg-white shadow rounded-lg p-6">
            @csrf
            @if(isset($categoria))
                @method('PUT')
            @endif

            <div class="mb-4">
                <label for="nombre" class="block text-sm font-medium text-gray-700">Nombre</label>
                <input type="text" name="nombre" id="nombre"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                    value="{{ old('nombre', $categoria->nombre ?? '') }}" required>
            </div>

            <div class="flex space-x-2">
                <button type="submit"
                        class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-md shadow">
                    {{ isset($categoria) ? 'Actualizar' : 'Guardar' }}
                </button>
                <a href="{{ route('categorias.index') }}"
                    ss="px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white rounded-md shadow">
                    Cancelar
                </a>
            </div>
        </form>
    </div>
</x-app-layout>
