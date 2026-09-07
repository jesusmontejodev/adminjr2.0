<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Agregar Número de WhatsApp') }}
        </h2>
    </x-slot>

    <div class="whatsapp-view relative z-10 p-6 sm:p-10">

        <!-- HEADER -->
        <div class="wa-topbar">
            <div class="wa-title-row">
                <span class="wa-title-icon">
                    <svg fill="currentColor" viewBox="0 0 16 16">
                        <path d="M13.601 2.326A7.854 7.854 0 0 0 7.994 0C3.627 0 .068 3.558.064 7.926c0 1.399.366 2.76 1.057 3.965L0 16l4.204-1.102a7.933 7.933 0 0 0 3.79.965h.004c4.368 0 7.926-3.558 7.93-7.93A7.898 7.898 0 0 0 13.6 2.326z"/>
                    </svg>
                </span>
                <div>
                    <h1>Agregar número de WhatsApp</h1>
                    <div class="wa-title-sub">Conecta un número para automatizar tu atención por WhatsApp</div>
                </div>
            </div>

            <a href="{{ route('numeros-whatsapp.index') }}" class="wa-btn-secondary">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 18l-6-6 6-6"/>
                </svg>
                Volver
            </a>
        </div>

        <!-- MENSAJES -->
        @if (session('error'))
            <div class="wa-alert wa-alert--error">{{ session('error') }}</div>
        @endif

        <!-- FORMULARIO -->
        <div class="wa-form-panel">
            <form action="{{ route('numeros-whatsapp.store') }}" method="POST">
                @csrf

                {{-- País --}}
                <div class="wa-field">
                    <label for="pais" class="wa-label">País *</label>
                    <select name="pais" id="pais" class="wa-select" required>
                        <option value="">Selecciona un país</option>
                        @foreach($paises as $codigo => $nombre)
                            <option value="{{ $codigo }}" {{ old('pais') == $codigo ? 'selected' : '' }}>
                                {{ $nombre }} ({{ $codigo }})
                            </option>
                        @endforeach
                    </select>
                    @error('pais') <p class="wa-input-error">{{ $message }}</p> @enderror
                </div>

                {{-- Número --}}
                <div class="wa-field">
                    <label for="numero_local" class="wa-label">
                        Número de teléfono *
                        <span id="codigo-pais-hint" class="wa-label-hint"></span>
                    </label>

                    <div class="wa-input-prefix-wrap">
                        <span id="codigo-pais-display" class="wa-input-prefix">+</span>
                        <input type="tel" name="numero_local" id="numero_local" class="wa-input"
                            placeholder="5512345678"
                            value="{{ old('numero_local') }}"
                            required>
                    </div>

                    <p class="wa-input-note">Ingresa solo el número local (sin código de país)</p>
                    @error('numero_local') <p class="wa-input-error">{{ $message }}</p> @enderror
                </div>

                {{-- Etiqueta --}}
                <div class="wa-field">
                    <label for="etiqueta" class="wa-label">
                        Etiqueta
                        <span class="wa-label-hint">(opcional)</span>
                    </label>
                    <input type="text" name="etiqueta" id="etiqueta" class="wa-input"
                        placeholder="Ej: Personal, Trabajo, Marketing..."
                        value="{{ old('etiqueta') }}">
                </div>

                <div class="wa-form-foot">
                    <a href="{{ route('numeros-whatsapp.index') }}" class="wa-btn-secondary">Cancelar</a>
                    <button type="submit" class="wa-btn-new">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        Conectar número
                    </button>
                </div>
            </form>
        </div>

        <!-- INFO -->
        <div class="wa-info-panel">
            <h4>Requisitos importantes</h4>
            <ul>
                <li>
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    El número debe estar registrado en WhatsApp Business API
                </li>
                <li>
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    Asegúrate de tener los permisos necesarios
                </li>
                <li>
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    Solo puedes tener un número marcado como principal
                </li>
            </ul>
        </div>

    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const paisSelect = document.getElementById('pais');
            const codigoDisplay = document.getElementById('codigo-pais-display');
            const codigoHint = document.getElementById('codigo-pais-hint');
            const numeroInput = document.getElementById('numero_local');

            const codigosPais = {
                'MX': '+52','US': '+1','CA': '+1','ES': '+34','AR': '+54','CO': '+57','PE': '+51',
                'CL': '+56','BR': '+55','EC': '+593','VE': '+58','UY': '+598','PY': '+595',
                'BO': '+591','GT': '+502','SV': '+503','HN': '+504','NI': '+505','CR': '+506',
                'PA': '+507','DO': '+1','PR': '+1','CU': '+53','FR': '+33','DE': '+49',
                'IT': '+39','GB': '+44','PT': '+351','CH': '+41','NL': '+31','BE': '+32'
            };

            function actualizarCodigoPais() {
                const codigo = paisSelect.value;
                if (codigo && codigosPais[codigo]) {
                    codigoDisplay.textContent = codigosPais[codigo];
                    codigoHint.textContent = `Código: ${codigosPais[codigo]}`;
                    numeroInput.style.paddingLeft = (codigosPais[codigo].length * 8 + 30) + 'px';
                } else {
                    codigoDisplay.textContent = '+';
                    codigoHint.textContent = '';
                    numeroInput.style.paddingLeft = '';
                }
            }

            function formatPhoneNumber(value) {
                let numbers = value.replace(/\D/g, '');

                if (paisSelect.value === 'MX' && numbers.length > 10) {
                    numbers = numbers.substring(0, 10);
                }

                return numbers;
            }

            paisSelect.addEventListener('change', actualizarCodigoPais);
            numeroInput.addEventListener('input', e => {
                e.target.value = formatPhoneNumber(e.target.value);
            });

            actualizarCodigoPais();
        });
    </script>
</x-app-layout>
