@php
    // Verificar si $numero existe
    if (!isset($numero) || is_null($numero)) {
        // Redirigir o mostrar mensaje de error
        header('Location: ' . route('numeros-whatsapp.index'));
        exit();
    }
@endphp

<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    <i class="fab fa-whatsapp text-green-500 mr-2"></i>Detalles del Número
                </h2>
                <p class="text-sm text-gray-600 mt-1">Información completa del número de WhatsApp</p>
            </div>
            <x-secondary-button>
                <a href="{{ route('numeros-whatsapp.index') }}" class="flex items-center">
                    <i class="fas fa-arrow-left mr-2"></i> Volver
                </a>
            </x-secondary-button>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            @if(!$numero)
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-12 text-center">
                        <div class="mx-auto flex items-center justify-center h-24 w-24 rounded-full bg-red-100">
                            <i class="fas fa-exclamation-triangle text-red-600 text-3xl"></i>
                        </div>
                        <h3 class="mt-6 text-xl font-medium text-gray-900">Número no encontrado</h3>
                        <p class="mt-2 text-sm text-gray-500">
                            El número que estás buscando no existe o ha sido eliminado.
                        </p>
                        <div class="mt-6">
                            <a href="{{ route('numeros-whatsapp.index') }}"
                               class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700">
                                <i class="fas fa-arrow-left mr-2"></i> Volver a la lista
                            </a>
                        </div>
                    </div>
                </div>
            @else
            <!-- Todo el contenido de la vista show aquí -->
            @endif
        </div>
    </div>
</x-app-layout>
