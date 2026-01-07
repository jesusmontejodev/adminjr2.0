<x-app-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        {{-- Header mejorado --}}
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
            <div>
                <div class="flex items-center gap-3 mb-2">
                    <h1 class="text-3xl font-bold text-gray-900 dark:text-white">WhatsApp Business</h1>
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-gradient-to-r from-green-100 to-emerald-100 dark:from-green-900/30 dark:to-emerald-900/30 text-green-800 dark:text-green-400 border border-green-200 dark:border-green-800">
                        Business API
                    </span>
                </div>
                <p class="text-gray-600 dark:text-gray-400 mt-1">Gestiona y configura tus números de WhatsApp Business conectados</p>
            </div>

            <div class="flex items-center space-x-3">
                <a href="{{ route('numeros-whatsapp.create') }}"
                    class="inline-flex items-center px-5 py-3 bg-gradient-to-r from-green-600 to-emerald-700 hover:from-green-700 hover:to-emerald-800 text-white rounded-lg shadow-lg transition-all duration-200 hover:shadow-xl hover:-translate-y-0.5">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Nuevo Número
                </a>
            </div>
        </div>

        {{-- Mensaje de éxito --}}
        @if (session('success'))
            <div class="mb-6 p-4 bg-gradient-to-r from-green-500 to-emerald-600 text-white rounded-xl shadow-lg flex items-center">
                <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                <div>
                    <p class="font-semibold">¡Operación exitosa!</p>
                    <p class="text-sm opacity-90">{{ session('success') }}</p>
                </div>
            </div>
        @endif

        {{-- Estadísticas principales --}}
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-gradient-to-r from-green-500 to-emerald-600 rounded-2xl p-6 text-white shadow-lg">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm opacity-90 mb-1">Números Totales</p>
                        <p class="text-2xl font-bold">{{ $numeros->count() }}</p>
                    </div>
                    <div class="text-3xl">
                        <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 16 16">
                            <path d="M13.601 2.326A7.854 7.854 0 0 0 7.994 0C3.627 0 .068 3.558.064 7.926c0 1.399.366 2.76 1.057 3.965L0 16l4.204-1.102a7.933 7.933 0 0 0 3.79.965h.004c4.368 0 7.926-3.558 7.93-7.93A7.898 7.898 0 0 0 13.6 2.326z"/>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-gradient-to-r from-blue-500 to-indigo-600 rounded-2xl p-6 text-white shadow-lg">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm opacity-90 mb-1">Activos</p>
                        <p class="text-2xl font-bold">{{ $numeros->where('activo', true)->count() }}</p>
                    </div>
                    <div class="text-3xl">✅</div>
                </div>
            </div>

            <div class="bg-gradient-to-r from-purple-500 to-pink-600 rounded-2xl p-6 text-white shadow-lg">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm opacity-90 mb-1">Principales</p>
                        <p class="text-2xl font-bold">{{ $numeros->where('es_principal', true)->count() }}</p>
                    </div>
                    <div class="text-3xl">⭐</div>
                </div>
            </div>

            <div class="bg-gradient-to-r from-orange-500 to-amber-600 rounded-2xl p-6 text-white shadow-lg">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm opacity-90 mb-1">Países</p>
                        <p class="text-2xl font-bold">{{ $numeros->pluck('pais')->unique()->count() }}</p>
                    </div>
                    <div class="text-3xl">🌍</div>
                </div>
            </div>
        </div>

        @if($numeros->isEmpty())
            {{-- Estado vacío --}}
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-100 dark:border-gray-700 p-12 text-center">
                <div class="max-w-md mx-auto">
                    <div class="w-24 h-24 mx-auto mb-6 text-gray-400 dark:text-gray-500">
                        <svg fill="currentColor" viewBox="0 0 16 16">
                            <path d="M13.5 0a.5.5 0 0 0 0 1V15a1 1 0 0 0 1 1h2v-2h-2V0h-1zm.5 3h2a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1h-2a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1z"/>
                            <path d="M9.828 3h2.972a.5.5 0 0 1 .5.5v12a.5.5 0 0 1-.5.5H9.828a.5.5 0 0 1-.5-.5v-12a.5.5 0 0 1 .5-.5zM2.5 0h2A1.5 1.5 0 0 1 6 1.5v13A1.5 1.5 0 0 1 4.5 16h-2A1.5 1.5 0 0 1 1 14.5v-13A1.5 1.5 0 0 1 2.5 0zm0 1a.5.5 0 0 0-.5.5v13a.5.5 0 0 0 .5.5h2a.5.5 0 0 0 .5-.5v-13a.5.5 0 0 0-.5-.5h-2z"/>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-3">Sin números configurados</h3>
                    <p class="text-gray-600 dark:text-gray-400 mb-8">
                        Conecta tu primer número de WhatsApp Business para comenzar a enviar mensajes
                    </p>
                    <a href="{{ route('numeros-whatsapp.create') }}"
                       class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-green-600 to-emerald-700 hover:from-green-700 hover:to-emerald-800 text-white rounded-lg shadow-lg transition-all duration-200 hover:shadow-xl hover:-translate-y-0.5">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        Conectar primer número
                    </a>
                </div>
            </div>
        @else
            {{-- Grid de números --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($numeros as $numero)
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-100 dark:border-gray-700 overflow-hidden hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
                    {{-- Header de la tarjeta --}}
                    <div class="p-6 border-b border-gray-100 dark:border-gray-700">
                        <div class="flex justify-between items-start mb-4">
                            <div class="flex items-center space-x-3">
                                <div class="w-12 h-12 bg-gradient-to-r from-green-100 to-emerald-100 dark:from-green-900/30 dark:to-emerald-900/30 rounded-xl flex items-center justify-center">
                                    <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="currentColor" viewBox="0 0 16 16">
                                        <path d="M13.601 2.326A7.854 7.854 0 0 0 7.994 0C3.627 0 .068 3.558.064 7.926c0 1.399.366 2.76 1.057 3.965L0 16l4.204-1.102a7.933 7.933 0 0 0 3.79.965h.004c4.368 0 7.926-3.558 7.93-7.93A7.898 7.898 0 0 0 13.6 2.326zM7.994 14.521a6.573 6.573 0 0 1-3.356-.92l-.24-.144-2.494.654.666-2.433-.156-.251a6.56 6.56 0 0 1-1.007-3.505c0-3.626 2.957-6.584 6.591-6.584a6.56 6.56 0 0 1 4.66 1.931 6.557 6.557 0 0 1 1.928 4.66c-.004 3.639-2.961 6.592-6.592 6.592zm3.615-4.934c-.197-.099-1.17-.578-1.353-.646-.182-.065-.315-.099-.445.099-.133.197-.513.646-.627.775-.114.133-.232.148-.43.05-.197-.1-.834-.308-1.588-.983-.587-.525-.983-1.175-1.098-1.372-.114-.198-.011-.304.088-.403.087-.088.197-.232.296-.346.1-.114.133-.198.198-.33.065-.134.034-.248-.015-.347-.05-.099-.445-1.076-.612-1.47-.16-.389-.323-.335-.445-.34-.114-.007-.247-.007-.38-.007a.729.729 0 0 0-.529.247c-.182.198-.691.677-.691 1.654 0 .977.71 1.916.81 2.049.098.133 1.394 2.132 3.383 2.992.47.205.84.326 1.129.418.475.152.904.129 1.246.08.38-.058 1.171-.48 1.338-.943.164-.464.164-.86.114-.943-.049-.084-.182-.133-.38-.232z"/>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="font-bold text-gray-900 dark:text-white">{{ $numero->numero_internacional }}</h3>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">ID: {{ substr($numero->id, 0, 8) }}...</p>
                                </div>
                            </div>
                            <div class="dropdown relative">
                                <button class="p-2 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg transition">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 16 16">
                                        <path d="M9.5 13a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0zm0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0zm0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0z"/>
                                    </svg>
                                </button>
                                <div class="dropdown-menu absolute right-0 mt-2 w-48 bg-white dark:bg-gray-800 rounded-lg shadow-lg border border-gray-100 dark:border-gray-700 py-1 z-10 hidden">
                                    <a href="{{ route('numeros-whatsapp.edit', $numero) }}"
                                       class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                                        <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                        Editar
                                    </a>
                                    <button onclick="confirmDelete({{ $numero->id }})"
                                            class="block w-full text-left px-4 py-2 text-sm text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/30">
                                        <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                        Eliminar
                                    </button>
                                </div>
                            </div>
                        </div>

                        {{-- Badges --}}
                        <div class="flex flex-wrap gap-2">
                            @if($numero->es_principal)
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-gradient-to-r from-amber-100 to-yellow-100 dark:from-amber-900/30 dark:to-yellow-900/30 text-amber-800 dark:text-amber-400">
                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 16 16">
                                    <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/>
                                </svg>
                                Principal
                            </span>
                            @endif

                            @if($numero->etiqueta)
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-300">
                                {{ $numero->etiqueta }}
                            </span>
                            @endif
                        </div>
                    </div>

                    {{-- Información del número --}}
                    <div class="p-6">
                        <div class="space-y-4">
                            {{-- Números --}}
                            <div class="grid grid-cols-2 gap-4">
                                <div class="bg-gray-50 dark:bg-gray-900/50 rounded-xl p-4">
                                    <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Número Local</p>
                                    <p class="font-semibold text-gray-900 dark:text-white">{{ $numero->numero_local }}</p>
                                </div>
                                <div class="bg-gray-50 dark:bg-gray-900/50 rounded-xl p-4">
                                    <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">WhatsApp</p>
                                    <p class="font-semibold text-gray-900 dark:text-white">{{ $numero->numero_whatsapp }}</p>
                                </div>
                            </div>

                            {{-- País --}}
                            <div class="flex items-center space-x-3 p-4 bg-gray-50 dark:bg-gray-900/50 rounded-xl">
                                <svg class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="currentColor" viewBox="0 0 16 16">
                                    <path d="M8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10zm0-7a3 3 0 1 1 0-6 3 3 0 0 1 0 6z"/>
                                </svg>
                                <div>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">País</p>
                                    <p class="font-semibold text-gray-900 dark:text-white">{{ $numero->pais }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Footer de la tarjeta --}}
                    <div class="px-6 py-4 bg-gray-50 dark:bg-gray-900/30 border-t border-gray-100 dark:border-gray-700">
                        <div class="flex justify-between items-center">
                            <div class="flex items-center space-x-2">
                                @if($numero->activo)
                                <div class="flex items-center space-x-1 text-green-600 dark:text-green-400">
                                    <div class="w-2 h-2 bg-green-500 rounded-full"></div>
                                    <span class="text-sm font-medium">Activo</span>
                                </div>
                                @else
                                <div class="flex items-center space-x-1 text-gray-500">
                                    <div class="w-2 h-2 bg-gray-400 rounded-full"></div>
                                    <span class="text-sm">Inactivo</span>
                                </div>
                                @endif
                            </div>
                            <div class="text-sm text-gray-500 dark:text-gray-400">
                                Creado {{ $numero->created_at->diffForHumans() }}
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            {{-- Paginación si es necesario --}}
            @if(method_exists($numeros, 'links'))
                <div class="mt-8">
                    {{ $numeros->links() }}
                </div>
            @endif
        @endif
    </div>

    {{-- Modal de confirmación de eliminación --}}
    <div id="confirmModal" class="fixed inset-0 bg-gray-500 bg-opacity-75 dark:bg-opacity-90 flex items-center justify-center p-4 z-50 hidden">
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-2xl max-w-md w-full p-6">
            <div class="text-center mb-6">
                <div class="w-16 h-16 mx-auto mb-4 bg-red-100 dark:bg-red-900/30 rounded-full flex items-center justify-center">
                    <svg class="w-8 h-8 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.86-.833-2.632 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">¿Eliminar número?</h3>
                <p class="text-gray-600 dark:text-gray-400 mb-6">
                    Esta acción no se puede deshacer. El número será eliminado permanentemente.
                </p>
            </div>
            <div class="flex space-x-3">
                <button onclick="closeModal()"
                        class="flex-1 px-4 py-3 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                    Cancelar
                </button>
                <button id="confirmDeleteBtn"
                        class="flex-1 px-4 py-3 bg-gradient-to-r from-red-600 to-pink-700 hover:from-red-700 hover:to-pink-800 text-white rounded-lg shadow transition">
                    Sí, eliminar
                </button>
            </div>
        </div>
    </div>

    <script>
        // Dropdown functionality
        document.addEventListener('click', function(e) {
            if (e.target.closest('.dropdown button')) {
                const dropdown = e.target.closest('.dropdown');
                const menu = dropdown.querySelector('.dropdown-menu');
                menu.classList.toggle('hidden');
            } else {
                document.querySelectorAll('.dropdown-menu').forEach(menu => {
                    menu.classList.add('hidden');
                });
            }
        });

        // Modal functionality
        let formToDelete = null;

        function confirmDelete(numeroId) {
            formToDelete = document.getElementById(`delete-form-${numeroId}`);
            document.getElementById('confirmModal').classList.remove('hidden');
        }

        function closeModal() {
            document.getElementById('confirmModal').classList.add('hidden');
            formToDelete = null;
        }

        document.getElementById('confirmDeleteBtn').addEventListener('click', function() {
            if (formToDelete) {
                formToDelete.submit();
            }
        });

        // Cerrar modal al hacer clic fuera
        document.getElementById('confirmModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeModal();
            }
        });

        // Añadir formularios de eliminación dinámicamente
        document.addEventListener('DOMContentLoaded', function() {
            @foreach($numeros as $numero)
            if (!document.getElementById('delete-form-{{ $numero->id }}')) {
                const form = document.createElement('form');
                form.id = 'delete-form-{{ $numero->id }}';
                form.action = '{{ route('numeros-whatsapp.destroy', $numero) }}';
                form.method = 'POST';
                form.style.display = 'none';
                form.innerHTML = `
                    @csrf
                    @method('DELETE')
                `;
                document.body.appendChild(form);
            }
            @endforeach
        });
    </script>

    <style>
        .dropdown-menu {
            animation: dropdownFade 0.2s ease-out;
        }

        @keyframes dropdownFade {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        #confirmModal {
            animation: modalFade 0.3s ease-out;
        }

        @keyframes modalFade {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }
    </style>
</x-app-layout>
