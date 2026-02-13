<x-app-layout>
    <div class="form-create relative">
    <div class="relative z-10 max-w-lg mx-auto px-4 sm:px-6 lg:px-8 py-10">

        <!-- HEADER -->
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-6 mb-10">
            <span class="icon-circle">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 16 16">
                    <path d="M13.601 2.326A7.854 7.854 0 0 0 7.994 0C3.627 0 .068 3.558.064 7.926c0 1.399.366 2.76 1.057 3.965L0 16l4.204-1.102a7.933 7.933 0 0 0 3.79.965h.004c4.368 0 7.926-3.558 7.93-7.93A7.898 7.898 0 0 0 13.6 2.326z"/>
                </svg>
            </span>
            <h1 class="text-white text-xl font-bold">
                Agregar número de WhatsApp
            </h1>
            <button type="submit" class="btn-primary">
                        <a href="{{ route('numeros-whatsapp.index') }}" class="text-white/60 hover:text-white transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M15 18l-6-6 6-6"/>
            </svg>
            </a>
</button>
        </div>
        <!-- CARD -->
<div class="card max-w-md mx-auto">
    <form action="{{ route('numeros-whatsapp.store') }}"
          method="POST"
          class="space-y-6">
        @csrf

        <div class="space-y-6 p-6">

            {{-- País --}}
            <div class="space-y-2">
                <label for="pais" class="label block">
                    País *
                </label>

                <select name="pais"
                        id="pais"
                        class="input w-full 
                            bg-neutral-900 
                            border border-red-500/60 
                            text-red-300 
                            focus:outline-none 
                            focus:ring-2 
                            focus:ring-red-500/40 
                            focus:border-red-500 
                            rounded-xl"
                        required>
                    <option value="">Selecciona un país</option>
                    @foreach($paises as $codigo => $nombre)
                        <option value="{{ $codigo }}"
                                {{ old('pais') == $codigo ? 'selected' : '' }}>
                            {{ $nombre }} ({{ $codigo }})
                        </option>
                    @endforeach
                </select>

                @error('pais')
                    <p class="error-text">{{ $message }}</p>
                @enderror
            </div>

            {{-- Número --}}
            <div class="space-y-2">
                <label for="numero_local" class="label block">
                    Número de teléfono *
                    <span id="codigo-pais-hint"
                          class="text-xs text-white/50 ml-2"></span>
                </label>

                <div class="relative w-full">
                    <span id="codigo-pais-display"
                          class="absolute left-4 top-1/2 -translate-y-1/2 text-white/60 font-medium pointer-events-none">
                        +
                    </span>

                    <input type="tel"
                           name="numero_local"
                           id="numero_local"
                           class="input w-full pl-14"
                           placeholder="5512345678"
                           value="{{ old('numero_local') }}"
                           required>
                </div>

                <p class="text-xs text-white/50">
                    Ingresa solo el número local (sin código de país)
                </p>

                @error('numero_local')
                    <p class="error-text">{{ $message }}</p>
                @enderror
            </div>

            {{-- Etiqueta --}}
            <div class="space-y-2">
                <label for="etiqueta" class="label block">
                    Etiqueta
                    <span class="text-xs text-white/50">(opcional)</span>
                </label>

                <input type="text"
                       name="etiqueta"
                       id="etiqueta"
                       class="input w-full"
                       placeholder="Ej: Personal, Trabajo, Marketing..."
                       value="{{ old('etiqueta') }}">
            </div>

        </div>

        {{-- FOOTER --}}
        <div class="flex justify-between items-center px-6 py-4 border-t border-white/10">
            <a href="{{ route('numeros-whatsapp.index') }}"
               class="btn-cancel">
                Cancelar
            </a>

            <button type="submit"
                    class="btn-primary">
                Conectar número
            </button>
        </div>

    </form>
</div>
        <!-- INFO -->
        <div class="mt-6 info-box">
            <h4 class="text-red-400 font-semibold mb-2">Requisitos importantes</h4>
            <ul class="text-sm text-gray/70 space-y-2">
                <li>✔ El número debe estar registrado en WhatsApp Business API</li>
                <li>✔ Asegúrate de tener los permisos necesarios</li>
                <li>✔ Solo puedes tener un número marcado como principal</li>
            </ul>
        </div>

    </div>
</div>

    <!-- JS ORIGINAL COMPLETO (SIN CAMBIOS) -->
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
                    numeroInput.style.paddingLeft = '4rem';
                } else {
                    codigoDisplay.textContent = '+';
                    codigoHint.textContent = '';
                    numeroInput.style.paddingLeft = '3rem';
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