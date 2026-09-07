<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Límite de números de WhatsApp
        </h2>
    </x-slot>

    <div class="max-w-3xl mx-auto p-6 sm:p-10">
        <p class="text-sm text-gray-600 dark:text-gray-400 mb-6">
            Busca un usuario para ver su límite actual (según su plan) y, si hace falta, asignarle uno propio.
            Deja el campo vacío para volver a usar el límite del plan.
        </p>

        @if (session('success'))
            <div class="mb-6 p-4 bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-300 rounded-lg border border-green-200 dark:border-green-800/40">
                {{ session('success') }}
            </div>
        @endif

        <form method="GET" action="{{ route('admin.whatsapp-limites.index') }}" class="flex gap-3 mb-8">
            <x-text-input
                type="text"
                name="q"
                value="{{ $busqueda }}"
                placeholder="Buscar por nombre o correo..."
                class="flex-1"
            />
            <x-primary-button>Buscar</x-primary-button>
        </form>

        @if ($busqueda !== '' && $usuarios->isEmpty())
            <p class="text-sm text-gray-500 dark:text-gray-400">No se encontraron usuarios para "{{ $busqueda }}".</p>
        @endif

        <div class="space-y-3">
            @foreach ($usuarios as $usuario)
                <div class="bg-white dark:bg-white/5 border border-gray-200 dark:border-white/10 rounded-xl p-4">
                    <div class="flex items-center justify-between gap-4 flex-wrap">
                        <div>
                            <p class="font-semibold text-gray-900 dark:text-gray-100">{{ $usuario->name }}</p>
                            <p class="text-sm text-gray-500 dark:text-gray-400">{{ $usuario->email }}</p>
                            <p class="text-xs text-gray-400 dark:text-gray-500 mt-1">
                                Usa {{ $usuario->numeros_whats_app_count }} de {{ $usuario->getLimiteWhatsApp() }} números permitidos
                                @if($usuario->limite_whatsapp_override !== null)
                                    <span class="text-red-600 dark:text-red-400 font-medium">&middot; override activo</span>
                                @endif
                            </p>
                        </div>

                        <form method="POST" action="{{ route('admin.whatsapp-limites.update', $usuario) }}" class="flex items-end gap-2">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="q" value="{{ $busqueda }}">
                            <div>
                                <x-input-label for="limite-{{ $usuario->id }}" value="Límite propio" class="text-xs" />
                                <x-text-input
                                    id="limite-{{ $usuario->id }}"
                                    type="number"
                                    min="0"
                                    max="100"
                                    name="limite_whatsapp_override"
                                    value="{{ old('limite_whatsapp_override', $usuario->limite_whatsapp_override) }}"
                                    placeholder="Plan"
                                    class="w-24"
                                />
                            </div>
                            <x-primary-button>Guardar</x-primary-button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</x-app-layout>
