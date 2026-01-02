<x-app-layout>
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Encabezado -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Crear Nueva Cuenta</h1>
                    <p class="mt-2 text-sm text-gray-600">
                        Agrega una nueva cuenta para gestionar tus finanzas
                    </p>
                </div>
                <div>
                    <a href="{{ route('cuentas.index') }}"
                        class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        Volver a Cuentas
                    </a>
                </div>
            </div>
        </div>

        <!-- Mensajes de éxito/error -->
        @if (session('success'))
            <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-lg">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
                    </div>
                </div>
            </div>
        @endif

        @if (session('error'))
            <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-red-800">{{ session('error') }}</p>
                    </div>
                </div>
            </div>
        @endif

        <!-- Errores de validación -->
        @if ($errors->any())
            <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-red-800">
                            Por favor, corrige los siguientes errores:
                        </h3>
                        <div class="mt-2 text-sm text-red-700">
                            <ul class="list-disc pl-5 space-y-1">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <!-- Formulario -->
        <div class="bg-white shadow overflow-hidden sm:rounded-lg">
            <form action="{{ route('cuentas.store') }}" method="POST" class="p-6">
                @csrf

                <!-- Nombre de la cuenta -->
                <div class="mb-6">
                    <label for="nombre" class="block text-sm font-medium text-gray-700 mb-2">
                        Nombre de la cuenta *
                    </label>
                    <input type="text"
                            name="nombre"
                            id="nombre"
                            value="{{ old('nombre') }}"
                            class="text-gray-700 block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-150 ease-in-out @error('nombre') border-red-300 @enderror"
                            placeholder="Ej: Cuenta Corriente, Ahorros, Efectivo..."
                            required
                            autofocus>
                    @error('nombre')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-xs text-gray-500">Nombre único para identificar tu cuenta</p>
                </div>

                <!-- Saldo inicial -->
                <div class="mb-6">
                    <label for="saldo_inicial" class="block text-sm font-medium text-gray-700 mb-2">
                        Saldo inicial *
                    </label>
                    <div class="relative rounded-md shadow-sm">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <span class="text-gray-500 sm:text-sm">$</span>
                        </div>
                        <input type="number"
                                name="saldo_inicial"
                                id="saldo_inicial"
                                value="{{ old('saldo_inicial', 0) }}"
                                step="0.01"
                                min="0"
                                class="block w-full pl-10 pr-4 py-3 border border-gray-300 text-gray-700  rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-150 ease-in-out @error('saldo_inicial') border-red-300 @enderror"
                                placeholder="0.00"
                                required>
                    </div>
                    @error('saldo_inicial')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-xs text-gray-500">Saldo actual de la cuenta al momento de creación</p>
                </div>

                <!-- Descripción -->
                <div class="mb-8">
                    <label for="descripcion" class="block text-sm font-medium text-gray-700 mb-2">
                        Descripción
                    </label>
                    <textarea name="descripcion"
                            id="descripcion"
                            rows="4"
                            class="text-gray-700 block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-150 ease-in-out @error('descripcion') border-red-300 @enderror"
                            placeholder="Agrega una descripción opcional de la cuenta...">{{ old('descripcion') }}</textarea>
                    @error('descripcion')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-xs text-gray-500">Máximo 500 caracteres</p>
                </div>

                <!-- Botones de acción -->
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between pt-6 border-t border-gray-200">
                    <div class="mb-4 sm:mb-0">
                        <p class="text-sm text-gray-500">
                            Los campos marcados con * son obligatorios
                        </p>
                    </div>
                    <div class="flex space-x-3">
                        <a href="{{ route('cuentas.index') }}"
                            class="inline-flex items-center justify-center px-5 py-3 border border-gray-300 text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition duration-150 ease-in-out">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                            Cancelar
                        </a>
                        <button type="submit"
                                class="inline-flex items-center justify-center px-5 py-3 border border-transparent text-sm font-medium rounded-lg text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-150 ease-in-out shadow-sm">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                            Crear Cuenta
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Información adicional -->
        <div class="mt-8 bg-blue-50 border border-blue-200 rounded-lg p-6">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-blue-400" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-medium text-blue-800">¿Para qué sirven las cuentas?</h3>
                    <div class="mt-2 text-sm text-blue-700">
                        <ul class="list-disc pl-5 space-y-1">
                            <li>Organizar tus diferentes fuentes de dinero</li>
                            <li>Seguir el saldo de cada cuenta por separado</li>
                            <li>Clasificar tus transacciones según la cuenta utilizada</li>
                            <li>Generar reportes específicos por cuenta</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Auto-completar nombre con tipos sugeridos
            document.querySelectorAll('.tipo-sugerido').forEach(button => {
                button.addEventListener('click', function() {
                    document.getElementById('nombre').value = this.dataset.nombre;
                    document.getElementById('nombre').focus();
                });
            });

            // Formatear saldo mientras se escribe
            const saldoInput = document.getElementById('saldo_inicial');
            if (saldoInput) {
                saldoInput.addEventListener('blur', function() {
                    let value = parseFloat(this.value);
                    if (!isNaN(value)) {
                        this.value = value.toFixed(2);
                    }
                });
            }

            // Validación en tiempo real
            const nombreInput = document.getElementById('nombre');
            if (nombreInput) {
                nombreInput.addEventListener('input', function() {
                    if (this.value.length > 100) {
                        this.value = this.value.substring(0, 100);
                    }
                });
            }

            // Confirmar envío del formulario
            const form = document.querySelector('form');
            if (form) {
                form.addEventListener('submit', function(e) {
                    // Validación adicional del saldo
                    const saldo = parseFloat(saldoInput.value);
                    if (isNaN(saldo) || saldo < 0) {
                        e.preventDefault();
                        alert('Por favor, ingresa un saldo válido (mayor o igual a 0)');
                        saldoInput.focus();
                    }
                });
            }
        });
    </script>
    @endpush
</x-app-layout>
