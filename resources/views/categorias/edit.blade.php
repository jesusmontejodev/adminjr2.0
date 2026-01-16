<x-app-layout>
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        <!-- HEADER -->
        <h1 class="flex items-center gap-2 text-2xl font-semibold text-gray-900 mb-6">
            @if(isset($categoria))
                <!-- edit -->
                <svg class="w-6 h-6 text-blue-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M4 20h4l10-10-4-4L4 16v4zM14 6l4 4"
                          stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                Editar Categoría
            @else
                <!-- category -->
                <svg class="w-6 h-6 text-green-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M4 4h6v6H4zM14 4h6v6h-6zM4 14h6v6H4zM14 14h6v6h-6z"/>
                </svg>
                Crear Categoría
            @endif
        </h1>

        {{-- ERRORES --}}
        @if ($errors->any())
            <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- FORM -->
        <form
            action="{{ isset($categoria) ? route('categorias.update', $categoria->id) : route('categorias.store') }}"
            method="POST"
            class="bg-white shadow rounded-lg p-6 space-y-4"
        >
            @csrf
            @if(isset($categoria))
                @method('PUT')
            @endif

            <!-- NOMBRE -->
            <div>
                <label for="nombre" class="block text-sm font-medium text-gray-700">
                    Nombre
                </label>
                <div class="mt-1 relative">
                    <input
                        type="text"
                        name="nombre"
                        id="nombre"
                        class="block w-full pl-10 border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                        value="{{ old('nombre', $categoria->nombre ?? '') }}"
                        required
                    >
                    <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400"
                         viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M4 4h16v4H4zM4 10h16v10H4z"/>
                    </svg>
                </div>
            </div>

            <!-- DESCRIPCIÓN -->
            <div>
                <label for="descripcion" class="block text-sm font-medium text-gray-700">
                    Descripción
                </label>
                <div class="mt-1 relative">
                    <textarea
                        name="descripcion"
                        id="descripcion"
                        rows="3"
                        class="block w-full pl-10 border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                    >{{ old('descripcion', $categoria->descripcion ?? '') }}</textarea>

                    <svg class="absolute left-3 top-3 w-5 h-5 text-gray-400"
                         viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M4 4h16M4 10h16M4 16h10"/>
                    </svg>
                </div>
            </div>

            <!-- BOTONES -->
            <div class="flex gap-2 pt-4">
                <button type="submit"
                        class="inline-flex items-center gap-2 px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-md shadow">
                    @if(isset($categoria))
                        <!-- save -->
                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M5 3h14l2 2v16H3V3h2zM7 3v6h10V3"
                                  stroke-linejoin="round"/>
                        </svg>
                        Actualizar
                    @else
                        <!-- add -->
                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M12 5v14M5 12h14" stroke-linecap="round"/>
                        </svg>
                        Guardar
                    @endif
                </button>

                <a href="{{ route('categorias.index') }}"
                   class="inline-flex items-center gap-2 px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white rounded-md shadow">
                    <!-- back -->
                    <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M15 18l-6-6 6-6" stroke-linecap="round"/>
                    </svg>
                    Cancelar
                </a>
            </div>
        </form>

    </div>
</x-app-layout>