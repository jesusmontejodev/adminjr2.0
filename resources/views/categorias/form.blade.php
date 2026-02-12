<x-app-layout>
    <div class="form-create">   
    <div class="relative z-10 max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-10 text-white">

        <!-- HEADER -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-6 mb-10">
            <div>
                <h1 class="flex items-center gap-3 text-xl font-bold">
                    <span class="icon-circle">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10">
                            {{ isset($categoria) ? 'edit' : 'category' }}
                        </svg>
                    </span>
                    {{ isset($categoria) ? 'Editar Categoría' : 'Nueva Categoría' }}
                </h1>

                <p class="mt-2 text-sm text-red-300">
                    {{ isset($categoria)
                        ? 'Modifica la información de la categoría'
                        : 'Crea una categoría para organizar tus movimientos' }}
                </p>
            </div>

            <a href="{{ route('categorias.index') }}">
             <button type="submit" class="btn-primary">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M15 18l-6-6 6-6"/>
            </svg>
            Volver
            </button>   
        </a>
        </div>

        <!-- ERRORES -->
        @if ($errors->any())
            <div class="alert-error mb-6">
                <strong>Corrige los errores:</strong>
                <ul class="list-disc pl-5 mt-2 text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- CARD -->
        <div class="card">
            <form
                action="{{ isset($categoria)
                    ? route('categorias.update', $categoria)
                    : route('categorias.store') }}"
                method="POST"
                class="p-6"
            >
                @csrf
                @isset($categoria)
                    @method('PUT')
                @endisset

                <!-- NOMBRE -->
                <div class="mb-8">
                    <label class="label">Nombre *</label>
                    <input
                        type="text"
                        name="nombre"
                        value="{{ old('nombre', $categoria->nombre ?? '') }}"
                        class="input"
                        placeholder="Ej: Comidas, Transporte..."
                        required
                        autofocus
                    >
                </div>

                <!-- FOOTER -->
                <div class="flex flex-col sm:flex-row sm:justify-between gap-4 pt-6 border-t border-white/10">
                    <p class="text-xs text-gray-400">
                        Los campos marcados con * son obligatorios
                    </p>

                    <div class="flex gap-3">
                        <a href="{{ route('categorias.index') }}" class="btn-cancel">
                            Cancelar
                        </a>
                        <button type="submit" class="btn-primary">
                            {{ isset($categoria) ? 'Actualizar' : 'Crear categoría' }}
                        </button>
                    </div>
                </div>
            </form>
        </div>

    </div>
    </div>
</x-app-layout>