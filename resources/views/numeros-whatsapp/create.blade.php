<x-app-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        {{-- Header --}}
        <div class="mb-8">
            <div class="flex items-center gap-3 mb-2">
                <a href="{{ route('numeros-whatsapp.index') }}"
                   class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300 transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                </a>
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Agregar Número de WhatsApp</h1>
            </div>
            <p class="text-gray-600 dark:text-gray-400">Conecta un nuevo número de WhatsApp Business</p>
        </div>

        <div class="max-w-2xl mx-auto">
            {{-- Card del formulario --}}
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-100 dark:border-gray-700 overflow-hidden">
                {{-- Card header --}}
                <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-700 bg-gradient-to-r from-gray-50 to-white dark:from-gray-900/50 dark:to-gray-800/50">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-gradient-to-r from-green-100 to-emerald-100 dark:from-green-900/30 dark:to-emerald-900/30 rounded-xl flex items-center justify-center">
                            <svg class="w-5 h-5 text-green-600 dark:text-green-400" fill="currentColor" viewBox="0 0 16 16">
                                <path d="M13.601 2.326A7.854 7.854 0 0 0 7.994 0C3.627 0 .068 3.558.064 7.926c0 1.399.366 2.76 1.057 3.965L0 16l4.204-1.102a7.933 7.933 0 0 0 3.79.965h.004c4.368 0 7.926-3.558 7.93-7.93A7.898 7.898 0 0 0 13.6 2.326z"/>
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-lg font-semibold text-gray-800 dark:text-white">Información del número</h2>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Completa los datos para conectar el número</p>
                        </div>
                    </div>
                </div>

                {{-- Form --}}
                <form action="{{ route('numeros-whatsapp.store') }}" method="POST" class="p-6">
                    @csrf

                    {{-- País --}}
                    <div class="mb-6">
                        <label for="pais" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            País
                            <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <select name="pais" id="pais"
                                class="w-full px-4 py-3 pl-12 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:text-white transition appearance-none bg-white dark:bg-gray-700"
                                required>
                                <option value="">Selecciona un país</option>
                                @foreach($paises as $codigo => $nombre)
                                    <option value="{{ $codigo }}"
                                            data-codigo="{{ $codigo }}"
                                            {{ old('pais') == $codigo ? 'selected' : '' }}>
                                        {{ $nombre }} ({{ $codigo }})
                                    </option>
                                @endforeach
                            </select>
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                </svg>
                            </div>
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                <svg class="w-5 h-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                        </div>
                        @error('pais')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Número de teléfono --}}
                    <div class="mb-6">
                        <label for="numero_local" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Número de teléfono
                            <span class="text-red-500">*</span>
                            <span class="text-sm font-normal text-gray-500 dark:text-gray-400 ml-2" id="codigo-pais-hint"></span>
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <span id="codigo-pais-display" class="text-gray-500 dark:text-gray-400 font-medium">+</span>
                            </div>
                            <input type="tel"
                                name="numero_local"
                                id="numero_local"
                                class="pl-16 w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:text-white transition"
                                placeholder="5512345678"
                                value="{{ old('numero_local') }}"
                                required
                                aria-describedby="numero-hint">
                        </div>
                        <div id="numero-hint" class="mt-2 flex items-center text-sm text-gray-500 dark:text-gray-400">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            Ingresa solo el número local (sin código de país)
                        </div>
                        @error('numero_local')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Etiqueta --}}
                    <div class="mb-6">
                        <label for="etiqueta" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Etiqueta
                            <span class="text-sm font-normal text-gray-500 dark:text-gray-400 ml-2">(opcional)</span>
                        </label>
                        <div class="relative">
                            <input type="text"
                                name="etiqueta"
                                id="etiqueta"
                                class="w-full px-4 py-3 pl-12 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:text-white transition"
                                placeholder="Ej: Personal, Trabajo, Familiar, Marketing..."
                                value="{{ old('etiqueta') }}">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                                </svg>
                            </div>
                        </div>
                        <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                            Ayuda a identificar el propósito de este número
                        </p>
                    </div>

                    {{-- Número principal --}}
                    {{-- <div class="mb-8">
                        <div class="relative flex items-start">
                            <div class="flex items-center h-5">
                                <input type="checkbox"
                                    name="es_principal"
                                    id="es_principal"
                                    class="w-4 h-4 text-green-600 border-gray-300 rounded focus:ring-green-500 dark:border-gray-600 dark:bg-gray-700 dark:checked:bg-green-500"
                                    {{ old('es_principal') ? 'checked' : '' }}>
                            </div>
                            <div class="ml-3">
                                <label for="es_principal" class="font-medium text-gray-700 dark:text-gray-300">
                                    Marcar como número principal
                                </label>
                                <p class="text-sm text-gray-500 dark:text-gray-400">
                                    Este número será usado como predeterminado para envíos masivos
                                </p>
                            </div>
                        </div>
                    </div> --}}

                    {{-- Botones --}}
                    <div class="flex flex-col sm:flex-row gap-3 pt-6 border-t border-gray-100 dark:border-gray-700">
                        <a href="{{ route('numeros-whatsapp.index') }}"
                           class="inline-flex justify-center items-center px-6 py-3 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                            Cancelar
                        </a>
                        <button type="submit"
                                class="inline-flex justify-center items-center px-6 py-3 bg-gradient-to-r from-green-600 to-emerald-700 hover:from-green-700 hover:to-emerald-800 text-white rounded-lg shadow-lg transition-all duration-200 hover:shadow-xl hover:-translate-y-0.5 flex-1">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            Conectar número
                        </button>
                    </div>
                </form>
            </div>

            {{-- Información adicional --}}
            <div class="mt-6 bg-blue-50 dark:bg-blue-900/20 border border-blue-100 dark:border-blue-800 rounded-2xl p-6">
                <div class="flex items-start gap-3">
                    <div class="flex-shrink-0">
                        <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div>
                        <h4 class="font-semibold text-blue-900 dark:text-blue-300 mb-2">Requisitos importantes</h4>
                        <ul class="space-y-2 text-sm text-blue-800 dark:text-blue-400">
                            <li class="flex items-start">
                                <svg class="w-4 h-4 mr-2 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                El número debe estar registrado en WhatsApp Business API
                            </li>
                            <li class="flex items-start">
                                <svg class="w-4 h-4 mr-2 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                Asegúrate de tener los permisos necesarios
                            </li>
                            <li class="flex items-start">
                                <svg class="w-4 h-4 mr-2 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                Solo puedes tener un número marcado como principal
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const paisSelect = document.getElementById('pais');
            const codigoDisplay = document.getElementById('codigo-pais-display');
            const codigoHint = document.getElementById('codigo-pais-hint');
            const numeroInput = document.getElementById('numero_local');

            // Códigos de país ampliados
            const codigosPais = {
                'MX': '+52', 'US': '+1', 'CA': '+1', 'ES': '+34',
                'AR': '+54', 'CO': '+57', 'PE': '+51', 'CL': '+56',
                'BR': '+55', 'EC': '+593', 'VE': '+58', 'UY': '+598',
                'PY': '+595', 'BO': '+591', 'GT': '+502', 'SV': '+503',
                'HN': '+504', 'NI': '+505', 'CR': '+506', 'PA': '+507',
                'DO': '+1', 'PR': '+1', 'CU': '+53', 'FR': '+33',
                'DE': '+49', 'IT': '+39', 'GB': '+44', 'PT': '+351',
                'CH': '+41', 'NL': '+31', 'BE': '+32', 'SE': '+46',
                'NO': '+47', 'DK': '+45', 'FI': '+358', 'PL': '+48',
                'CZ': '+420', 'HU': '+36', 'RO': '+40', 'BG': '+359',
                'GR': '+30', 'TR': '+90', 'RU': '+7', 'UA': '+380',
                'IL': '+972', 'SA': '+966', 'AE': '+971', 'QA': '+974',
                'KW': '+965', 'BH': '+973', 'OM': '+968', 'JO': '+962',
                'LB': '+961', 'SY': '+963', 'IQ': '+964', 'IR': '+98',
                'AF': '+93', 'PK': '+92', 'IN': '+91', 'BD': '+880',
                'LK': '+94', 'NP': '+977', 'MM': '+95', 'TH': '+66',
                'VN': '+84', 'KH': '+855', 'LA': '+856', 'MY': '+60',
                'SG': '+65', 'ID': '+62', 'PH': '+63', 'JP': '+81',
                'KR': '+82', 'CN': '+86', 'TW': '+886', 'HK': '+852',
                'MO': '+853', 'AU': '+61', 'NZ': '+64', 'FJ': '+679',
                'PG': '+675', 'SB': '+677', 'VU': '+678', 'NC': '+687',
                'PF': '+689', 'WF': '+681', 'CK': '+682', 'NU': '+683',
                'TK': '+690', 'TO': '+676', 'WS': '+685', 'KI': '+686',
                'TV': '+688', 'FM': '+691', 'MH': '+692', 'NR': '+674',
                'PW': '+680', 'MP': '+670', 'GU': '+1', 'AS': '+1',
                'VI': '+1', 'PR': '+1', 'BM': '+1', 'BS': '+1',
                'BB': '+1', 'AG': '+1', 'DM': '+1', 'GD': '+1',
                'KN': '+1', 'LC': '+1', 'VC': '+1', 'TT': '+1',
                'JM': '+1', 'KY': '+1', 'TC': '+1', 'AI': '+1',
                'VG': '+1', 'MS': '+1', 'SX': '+1', 'CW': '+599',
                'AW': '+297', 'BQ': '+599', 'SR': '+597', 'GF': '+594',
                'GP': '+590', 'MQ': '+596', 'YT': '+262', 'RE': '+262',
                'BL': '+590', 'MF': '+590', 'PM': '+508', 'WF': '+681',
                'NC': '+687', 'PF': '+689', 'TK': '+690', 'NU': '+683',
                'CK': '+682', 'WS': '+685', 'TO': '+676', 'TV': '+688',
                'VU': '+678', 'FJ': '+679', 'PG': '+675', 'SB': '+677',
                'KI': '+686', 'MH': '+692', 'FM': '+691', 'NR': '+674',
                'PW': '+680', 'MP': '+670'
            };

            function actualizarCodigoPais() {
                const codigo = paisSelect.value;
                if (codigo && codigosPais[codigo]) {
                    codigoDisplay.textContent = codigosPais[codigo];
                    codigoHint.textContent = `Código: ${codigosPais[codigo]}`;
                    numeroInput.style.paddingLeft = '4rem';
                } else {
                    codigoDisplay.textContent = '+';
                    codigoHint.textContent = '';
                    numeroInput.style.paddingLeft = '3rem';
                }
            }

            function formatPhoneNumber(value) {
                // Eliminar todo excepto números
                let numbers = value.replace(/\D/g, '');

                // Aplicar formato basado en el país seleccionado
                const codigo = paisSelect.value;

                if (codigo === 'MX') {
                    // Formato México: 10 dígitos
                    if (numbers.length > 10) numbers = numbers.substring(0, 10);
                    if (numbers.length > 3) {
                        numbers = numbers.replace(/(\d{3})(\d{3})(\d{4})/, '$1 $2 $3');
                    }
                } else if (codigo === 'US' || codigo === 'CA') {
                    // Formato US/Canada: 10 dígitos
                    if (numbers.length > 10) numbers = numbers.substring(0, 10);
                    if (numbers.length > 3) {
                        numbers = numbers.replace(/(\d{3})(\d{3})(\d{4})/, '($1) $2-$3');
                    }
                } else if (codigo === 'ES') {
                    // Formato España: 9 dígitos
                    if (numbers.length > 9) numbers = numbers.substring(0, 9);
                    if (numbers.length > 3) {
                        numbers = numbers.replace(/(\d{3})(\d{3})(\d{3})/, '$1 $2 $3');
                    }
                }

                return numbers;
            }

            paisSelect.addEventListener('change', actualizarCodigoPais);

            numeroInput.addEventListener('input', function(e) {
                let value = e.target.value;
                e.target.value = formatPhoneNumber(value);
            });

            // Inicializar
            actualizarCodigoPais();
            if (numeroInput.value) {
                numeroInput.value = formatPhoneNumber(numeroInput.value);
            }
        });
    </script>

    <style>
        select {
            background-position: right 1rem center;
            background-repeat: no-repeat;
            background-size: 1rem;
            padding-right: 2.5rem;
        }

        input[type="checkbox"]:checked {
            background-image: url("data:image/svg+xml,%3csvg viewBox='0 0 16 16' fill='white' xmlns='http://www.w3.org/2000/svg'%3e%3cpath d='M12.207 4.793a1 1 0 010 1.414l-5 5a1 1 0 01-1.414 0l-2-2a1 1 0 011.414-1.414L6.5 9.086l4.293-4.293a1 1 0 011.414 0z'/%3e%3c/svg%3e");
        }

        .hover-lift:hover {
            transform: translateY(-2px);
            transition: transform 0.2s ease-in-out;
        }
    </style>
</x-app-layout>
