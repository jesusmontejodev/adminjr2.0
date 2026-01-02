<x-app-layout>
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <h1 class="text-2xl font-semibold text-gray-900 mb-6">
            {{ isset($categoria) ? 'Editar Categoría' : 'Crear Categoría' }}
        </h1>

        @if ($errors->any())
            <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ isset($categoria) ? route('categorias.update', $categoria) : route('categorias.store') }}" method="POST" class="bg-white shadow rounded-lg p-6">
            @csrf
            @if(isset($categoria))
                @method('PUT')
            @endif

            <div class="mb-4">
                <label for="nombre" class="block text-sm font-medium text-gray-700">Nombre *</label>
                <input type="text" name="nombre" id="nombre"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                    value="{{ old('nombre', $categoria->nombre ?? '') }}" required>
                @error('nombre')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="descripcion" class="block text-sm font-medium text-gray-700">Descripción</label>
                <textarea name="descripcion" id="descripcion"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                        rows="3">{{ old('descripcion', $categoria->descripcion ?? '') }}</textarea>
                @error('descripcion')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex space-x-2">
                <button type="submit"
                        class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-md shadow">
                    {{ isset($categoria) ? 'Actualizar' : 'Guardar' }}
                </button>
                <a href="{{ route('categorias.index') }}"
                    class="px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white rounded-md shadow">
                    Cancelar
                </a>
            </div>
        </form>
    </div>
</x-app-layout>
