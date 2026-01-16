<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="flex items-center gap-2 font-semibold text-xl text-gray-800 leading-tight">
                    <!-- WhatsApp -->
                    <svg class="w-6 h-6 text-green-500" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M12.04 2C6.58 2 2.1 6.48 2.1 11.94c0 1.98.52 3.9 1.5 5.58L2 22l4.63-1.53a9.9 9.9 0 005.4 1.57c5.46 0 9.94-4.48 9.94-9.94C21.98 6.48 17.5 2 12.04 2z"/>
                    </svg>
                    Detalles del Número
                </h2>
                <p class="text-sm text-gray-600 mt-1">
                    Información completa del número de WhatsApp
                </p>
            </div>

            <x-secondary-button>
                <a href="{{ route('numeros-whatsapp.index') }}" class="flex items-center gap-2">
                    <!-- Back -->
                    <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M15 18l-6-6 6-6"/>
                    </svg>
                    Volver
                </a>
            </x-secondary-button>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm rounded-lg">
                <div class="p-8">

                    <!-- HEADER -->
                    <div class="flex justify-between items-center mb-8 pb-6 border-b">
                        <div class="flex items-center gap-4">
                            <div class="text-4xl">{{ $numero->bandera }}</div>
                            <div>
                                <h1 class="text-2xl font-bold text-gray-900">
                                    {{ $numero->etiqueta ?: 'Sin etiqueta' }}
                                </h1>

                                @if($numero->es_principal)
                                    <span class="inline-flex items-center gap-1 mt-2 px-3 py-1 rounded-full text-sm bg-green-100 text-green-800">
                                        <!-- Star -->
                                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor">
                                            <path d="M12 17.3l6.18 3.7-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/>
                                        </svg>
                                        Número Principal
                                    </span>
                                @endif
                            </div>
                        </div>

                        <!-- ACCIONES -->
                        <div class="flex gap-3">
                            <a href="{{ $numero->enlace_whatsapp }}" target="_blank"
                               class="inline-flex items-center gap-2 px-4 py-2 text-white bg-green-600 rounded-md hover:bg-green-700">
                                <svg class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M12.04 2C6.58 2 2.1 6.48 2.1 11.94c0 1.98.52 3.9 1.5 5.58L2 22l4.63-1.53a9.9 9.9 0 005.4 1.57c5.46 0 9.94-4.48 9.94-9.94C21.98 6.48 17.5 2 12.04 2z"/>
                                </svg>
                                Abrir WhatsApp
                            </a>

                            <a href="{{ route('numeros-whatsapp.edit', $numero->id) }}"
                               class="inline-flex items-center gap-2 px-4 py-2 border rounded-md hover:bg-gray-50">
                                <!-- Edit -->
                                <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M12 20h9"/>
                                    <path d="M16.5 3.5a2.1 2.1 0 013 3L7 19l-4 1 1-4z"/>
                                </svg>
                                Editar
                            </a>
                        </div>
                    </div>

                    <!-- INFO -->
                    <div class="space-y-8">

                        <!-- INFO PRINCIPAL -->
                        <div>
                            <h3 class="flex items-center gap-2 text-lg font-medium mb-4">
                                <svg class="w-5 h-5 text-green-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <circle cx="12" cy="12" r="10"/>
                                    <path d="M12 16v-4M12 8h.01"/>
                                </svg>
                                Información Principal
                            </h3>

                            <div class="bg-gray-50 p-6 rounded-lg grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <p class="text-sm text-gray-500">Formato WhatsApp</p>
                                    <div class="flex items-center gap-3 mt-2">
                                        <span class="font-mono bg-white p-2 border rounded">
                                            {{ $numero->numero_whatsapp }}
                                        </span>
                                        <button onclick="copiarTexto('{{ $numero->numero_whatsapp }}','whatsapp')">
                                            📋
                                        </button>
                                    </div>
                                </div>

                                <div>
                                    <p class="text-sm text-gray-500">Formato Internacional</p>
                                    <div class="flex items-center gap-3 mt-2">
                                        <span class="font-mono bg-white p-2 border rounded">
                                            {{ $numero->numero_formateado }}
                                        </span>
                                        <button onclick="copiarTexto('{{ $numero->numero_internacional }}','internacional')">
                                            📋
                                        </button>
                                    </div>
                                </div>

                                <div>
                                    <p class="text-sm text-gray-500">País</p>
                                    <p class="mt-2 text-lg">
                                        {{ $numero->bandera }} {{ $numero->nombre_pais }}
                                    </p>
                                </div>

                                <div>
                                    <p class="text-sm text-gray-500">Número Local</p>
                                    <p class="mt-2 font-mono text-lg">
                                        {{ $numero->numero_local }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- METADATOS -->
                        <div>
                            <h3 class="flex items-center gap-2 text-lg font-medium mb-4">
                                <svg class="w-5 h-5 text-purple-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <ellipse cx="12" cy="5" rx="9" ry="3"/>
                                    <path d="M3 5v14c0 1.66 4.03 3 9 3s9-1.34 9-3V5"/>
                                </svg>
                                Metadatos
                            </h3>

                            <div class="bg-gray-50 p-6 rounded-lg grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <p class="text-sm text-gray-500">Estado</p>
                                    <p class="mt-1">
                                        {{ $numero->es_principal ? 'Número principal' : 'Número secundario' }}
                                    </p>
                                </div>

                                <div>
                                    <p class="text-sm text-gray-500">Creado</p>
                                    <p>{{ $numero->created_at->format('d/m/Y H:i') }}</p>
                                </div>

                                <div>
                                    <p class="text-sm text-gray-500">Actualizado</p>
                                    <p>{{ $numero->updated_at->format('d/m/Y H:i') }}</p>
                                </div>
                            </div>
                        </div>

                    </div>

                    <!-- ELIMINAR -->
                    <div class="mt-10 pt-6 border-t flex justify-end">
                        <form action="{{ route('numeros-whatsapp.destroy', $numero->id) }}"
                              method="POST"
                              onsubmit="return confirm('¿Eliminar este número?')">
                            @csrf
                            @method('DELETE')
                            <button class="inline-flex items-center gap-2 px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">
                                <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M3 6h18M8 6v14M16 6v14M5 6l1 14h12l1-14"/>
                                </svg>
                                Eliminar
                            </button>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        function copiarTexto(texto, tipo){
            navigator.clipboard.writeText(texto);
            alert(tipo + ' copiado');
        }
    </script>
    @endpush
</x-app-layout>