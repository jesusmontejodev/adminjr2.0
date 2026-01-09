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
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-8">
                    <!-- Encabezado -->
                    <div class="flex items-center justify-between mb-8 pb-6 border-b border-gray-200">
                        <div class="flex items-center">
                            <div class="text-4xl mr-4">
                                {{ $numero->bandera }}
                            </div>
                            <div>
                                <h1 class="text-2xl font-bold text-gray-900">
                                    {{ $numero->etiqueta ?: 'Sin etiqueta' }}
                                </h1>
                                @if($numero->es_principal)
                                <span class="inline-flex items-center px-3 py-1 mt-2 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                    <i class="fas fa-star mr-1.5"></i> Número Principal
                                </span>
                                @endif
                            </div>
                        </div>

                        <!-- Acciones rápidas -->
                        <div class="flex space-x-3">
                            <a href="{{ $numero->enlace_whatsapp }}"
                               target="_blank"
                               class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                <i class="fab fa-whatsapp mr-2"></i> Abrir WhatsApp
                            </a>

                            <a href="{{ route('numeros-whatsapp.edit', $numero->id) }}"
                               class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                <i class="fas fa-edit mr-2"></i> Editar
                            </a>
                        </div>
                    </div>

                    <!-- Información del número -->
                    <div class="space-y-8">
                        <!-- Sección principal -->
                        <div>
                            <h3 class="text-lg font-medium text-gray-900 mb-4">
                                <i class="fas fa-info-circle text-green-500 mr-2"></i>Información Principal
                            </h3>
                            <div class="bg-gray-50 rounded-lg p-6">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <p class="text-sm font-medium text-gray-500">Formato WhatsApp</p>
                                        <div class="mt-2 flex items-center">
                                            <span class="font-mono text-lg bg-white p-2 rounded border border-gray-200">
                                                {{ $numero->numero_whatsapp }}
                                            </span>
                                            <button onclick="copiarTexto('{{ $numero->numero_whatsapp }}', 'whatsapp')"
                                                    class="ml-3 inline-flex items-center p-2 border border-gray-300 rounded-md text-gray-500 hover:text-gray-700 hover:bg-gray-50">
                                                <i class="far fa-copy"></i>
                                            </button>
                                        </div>
                                        <p class="mt-1 text-xs text-gray-500">Para usar en enlaces de WhatsApp</p>
                                    </div>

                                    <div>
                                        <p class="text-sm font-medium text-gray-500">Formato Internacional</p>
                                        <div class="mt-2 flex items-center">
                                            <span class="font-mono text-lg bg-white p-2 rounded border border-gray-200">
                                                {{ $numero->numero_formateado }}
                                            </span>
                                            <button onclick="copiarTexto('{{ $numero->numero_internacional }}', 'internacional')"
                                                    class="ml-3 inline-flex items-center p-2 border border-gray-300 rounded-md text-gray-500 hover:text-gray-700 hover:bg-gray-50">
                                                <i class="far fa-copy"></i>
                                            </button>
                                        </div>
                                        <p class="mt-1 text-xs text-gray-500">Formato estándar internacional</p>
                                    </div>

                                    <div>
                                        <p class="text-sm font-medium text-gray-500">País</p>
                                        <div class="mt-2 flex items-center">
                                            <span class="text-2xl mr-2">{{ $numero->bandera }}</span>
                                            <span class="text-lg text-gray-900">
                                                {{ $numero->nombre_pais }}
                                            </span>
                                        </div>
                                        <p class="mt-1 text-xs text-gray-500">{{ $numero->codigo_pais }}</p>
                                    </div>

                                    <div>
                                        <p class="text-sm font-medium text-gray-500">Número Local</p>
                                        <p class="mt-2 font-mono text-lg text-gray-900">
                                            {{ $numero->numero_local }}
                                        </p>
                                        <p class="mt-1 text-xs text-gray-500">Sin código de país</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Enlaces rápidos -->
                        <div>
                            <h3 class="text-lg font-medium text-gray-900 mb-4">
                                <i class="fas fa-link text-blue-500 mr-2"></i>Enlaces Rápidos
                            </h3>
                            <div class="bg-gray-50 rounded-lg p-6">
                                <div class="space-y-3">
                                    <div>
                                        <p class="text-sm font-medium text-gray-500">Enlace WhatsApp Directo</p>
                                        <div class="mt-2 flex items-center">
                                            <a href="{{ $numero->enlace_whatsapp }}"
                                               target="_blank"
                                               class="text-green-600 hover:text-green-800 break-all">
                                                {{ $numero->enlace_whatsapp }}
                                            </a>
                                            <button onclick="copiarTexto('{{ $numero->enlace_whatsapp }}', 'enlace')"
                                                    class="ml-3 inline-flex items-center p-2 border border-gray-300 rounded-md text-gray-500 hover:text-gray-700 hover:bg-gray-50">
                                                <i class="far fa-copy"></i>
                                            </button>
                                        </div>
                                    </div>

                                    <div>
                                        <p class="text-sm font-medium text-gray-500">Texto para mensaje</p>
                                        <div class="mt-2">
                                            <input type="text"
                                                   id="mensaje-whatsapp"
                                                   value="https://wa.me/{{ $numero->numero_whatsapp }}?text=Hola"
                                                   class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm"
                                                   readonly>
                                            <button onclick="copiarTexto(document.getElementById('mensaje-whatsapp').value, 'mensaje')"
                                                    class="mt-2 inline-flex items-center px-3 py-1 border border-gray-300 rounded-md text-sm text-gray-600 hover:bg-gray-50">
                                                <i class="far fa-copy mr-1"></i> Copiar enlace con mensaje
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Metadatos -->
                        <div>
                            <h3 class="text-lg font-medium text-gray-900 mb-4">
                                <i class="fas fa-database text-purple-500 mr-2"></i>Metadatos
                            </h3>
                            <div class="bg-gray-50 rounded-lg p-6">
                                <dl class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500">Estado</dt>
                                        <dd class="mt-1">
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $numero->es_principal ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                                @if($numero->es_principal)
                                                <i class="fas fa-check-circle mr-1.5"></i> Número principal
                                                @else
                                                <i class="fas fa-mobile-alt mr-1.5"></i> Número secundario
                                                @endif
                                            </span>
                                        </dd>
                                    </div>

                                    <div>
                                        <dt class="text-sm font-medium text-gray-500">Etiqueta</dt>
                                        <dd class="mt-1 text-lg text-gray-900">
                                            {{ $numero->etiqueta ?: 'Sin etiqueta' }}
                                        </dd>
                                    </div>

                                    <div>
                                        <dt class="text-sm font-medium text-gray-500">Fecha de Creación</dt>
                                        <dd class="mt-1 text-lg text-gray-900">
                                            {{ $numero->created_at->format('d/m/Y H:i:s') }}
                                        </dd>
                                    </div>

                                    <div>
                                        <dt class="text-sm font-medium text-gray-500">Última Actualización</dt>
                                        <dd class="mt-1 text-lg text-gray-900">
                                            {{ $numero->updated_at->format('d/m/Y H:i:s') }}
                                        </dd>
                                    </div>
                                </dl>
                            </div>
                        </div>
                    </div>

                    <!-- Acciones peligrosas -->
                    <div class="mt-10 pt-8 border-t border-gray-200">
                        <div class="flex justify-between items-center">
                            <div>
                                <p class="text-sm text-gray-500">
                                    @if($numero->es_principal)
                                    <i class="fas fa-exclamation-triangle text-yellow-500 mr-1"></i>
                                    Este es tu número principal. Si lo eliminas, deberás marcar otro como principal.
                                    @endif
                                </p>
                            </div>
                            <div class="flex space-x-3">
                                @if(!$numero->es_principal)
                                <form action="{{ route('numeros-whatsapp.marcar-principal', $numero->id) }}"
                                      method="POST">
                                    @csrf
                                    <button type="submit"
                                            class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-yellow-600 hover:bg-yellow-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500">
                                        <i class="fas fa-star mr-2"></i> Marcar Principal
                                    </button>
                                </form>
                                @endif

                                <form action="{{ route('numeros-whatsapp.destroy', $numero->id) }}"
                                      method="POST"
                                      onsubmit="return confirm('¿Estás seguro de eliminar este número? Esta acción no se puede deshacer.')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                        <i class="fas fa-trash mr-2"></i> Eliminar Número
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
    function copiarTexto(texto, tipo) {
        navigator.clipboard.writeText(texto).then(function() {
            // Mostrar notificación
            const notification = document.createElement('div');
            notification.className = 'fixed top-4 right-4 bg-green-500 text-white px-4 py-2 rounded-lg shadow-lg z-50';
            notification.innerHTML = `
                <div class="flex items-center">
                    <i class="fas fa-check-circle mr-2"></i>
                    <span>${tipo.charAt(0).toUpperCase() + tipo.slice(1)} copiado</span>
                </div>
            `;
            document.body.appendChild(notification);

            // Remover notificación después de 3 segundos
            setTimeout(() => {
                notification.remove();
            }, 3000);
        }).catch(function(err) {
            console.error('Error al copiar: ', err);
            alert('Error al copiar el texto');
        });
    }
    </script>
    @endpush
</x-app-layout>
