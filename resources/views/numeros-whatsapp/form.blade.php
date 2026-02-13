<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="edit-whatsapp-title text-xl leading-tight">
                    Editar Número
                </h2>
                <p class="edit-whatsapp-subtitle mt-1">
                    Actualiza la información del número de WhatsApp
                </p>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="edit-whatsapp-card">

                <form action="{{ route('numeros-whatsapp.update', $numero->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="edit-section grid grid-cols-1 md:grid-cols-2 gap-6">

                        <!-- Número local -->
                        <div>
                            <label class="edit-label">Número local</label>
                            <input
                                type="text"
                                name="numero_local"
                                value="{{ old('numero_local', $numero->numero_local) }}"
                                class="edit-input"
                                placeholder="Ej: 9991234567"
                                required
                            >
                            @error('numero_local')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- País -->
                        <div>
                            <label class="edit-label">País</label>
                            <select name="pais"
                                    id="pais"
                                    class="edit-select w-full"
                                    required>
                                <option value="">Selecciona un país</option>
                                @foreach($paises as $codigo => $nombre)
                                    <option value="{{ $codigo }}"
                                        {{ old('pais', $numero->pais) == $codigo ? 'selected' : '' }}>
                                        {{ $nombre }} ({{ $codigo }})
                                    </option>
                                @endforeach
                            </select>
                            @error('pais')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Etiqueta -->
                        <div class="md:col-span-2">
                            <label class="edit-label">Etiqueta</label>
                            <input
                                type="text"
                                name="etiqueta"
                                value="{{ old('etiqueta', $numero->etiqueta) }}"
                                class="edit-input"
                                placeholder="Ej: Ventas"
                            >
                            @error('etiqueta')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                    </div>

                    <div class="flex justify-end gap-4 mt-8 edit-section">
                        <a href="{{ route('numeros-whatsapp.index', $numero->id) }}" class="btn-cancel">
                            cancelar
                        </a>

                        <button type="submit" class="btn-save">
                            Guardar cambios
                        </button>
                    </div>

                </form>

            </div>
        </div>
    </div>
</x-app-layout>