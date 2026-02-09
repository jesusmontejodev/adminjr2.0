<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-semibold text-2xl text-white leading-tight">
                    {{ __('Planes de Suscripción') }}
                </h2>
                <p class="text-gray-400 mt-1">Elige el plan perfecto para tu negocio</p>
            </div>

            @auth
                @if(auth()->user()->tieneSuscripcionActiva())
                    <div class="flex items-center space-x-3">
                        <div class="px-3 py-1.5 bg-gradient-to-r from-green-900/30 to-emerald-900/30 border border-green-700/30 rounded-lg">
                            <span class="text-green-400 text-sm font-semibold">
                                <i class="fas fa-crown mr-1.5"></i>
                                {{ auth()->user()->getPlanActualNombre() ?? 'Plan Básico' }}
                            </span>
                        </div>
                        <a href="{{ route('dashboard') }}"
                           class="px-4 py-2 bg-gray-800 hover:bg-gray-700 rounded-lg transition text-sm">
                            <i class="fas fa-tachometer-alt mr-1.5"></i>Dashboard
                        </a>
                    </div>
                @endif
            @endauth
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Mensaje destacado -->
            <div class="mb-10 text-center">
                <div class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-red-900/20 to-pink-900/20 border border-red-800/30 rounded-full mb-4">
                    <span class="text-red-400 text-sm font-medium">
                        <i class="fas fa-gift mr-2"></i>
                        Prueba 14 días gratis - Sin tarjeta requerida
                    </span>
                </div>
                <h1 class="text-3xl md:text-4xl font-bold text-white mb-3">
                    Potencia tu <span class="bg-gradient-to-r from-red-500 to-pink-600 bg-clip-text text-transparent">negocio</span>
                </h1>
                <p class="text-gray-400 text-lg max-w-2xl mx-auto">
                    Desde emprendedores hasta grandes empresas, tenemos un plan diseñado para cada necesidad.
                </p>
            </div>

            <!-- Switch Anual/Mensual (Opcional - puedes quitar si solo es mensual) -->
            <div class="flex justify-center mb-10">
                <div class="bg-gray-900/50 rounded-xl p-1 inline-flex border border-gray-800">
                    <button id="toggle-mensual"
                            class="px-5 py-2.5 rounded-lg font-medium text-sm transition-all bg-red-900/30 text-white"
                            onclick="toggleBilling('mensual')">
                        <i class="fas fa-calendar-day mr-2"></i>Pago Mensual
                    </button>
                    <button id="toggle-anual"
                            class="px-5 py-2.5 rounded-lg font-medium text-sm transition-all text-gray-400 hover:text-white"
                            onclick="toggleBilling('anual')">
                        <i class="fas fa-calendar-alt mr-2"></i>Pago Anual
                        <span class="text-green-400 text-xs ml-1 bg-green-900/30 px-2 py-0.5 rounded">-20%</span>
                    </button>
                </div>
            </div>

            <!-- Grid de Planes (SOLO BÁSICO) -->
            <div class="flex justify-center mb-12">
                <div class="w-full max-w-md">
                    <!-- Plan Básico -->
                    <div class="relative group">
                        <div class="absolute -inset-0.5 bg-gradient-to-r from-gray-600 to-gray-800 rounded-2xl blur opacity-20 group-hover:opacity-30 transition duration-1000"></div>
                        <div class="relative bg-gray-900/80 backdrop-blur-sm border border-gray-800 rounded-2xl p-6">
                            <div class="mb-6">
                                <div class="flex justify-between items-start mb-4">
                                    <div>
                                        <h3 class="text-xl font-bold text-white">Básico</h3>
                                        <p class="text-gray-400 text-sm mt-1">Para empezar</p>
                                    </div>
                                    <span class="px-3 py-1 bg-gray-800 text-gray-300 text-xs rounded-full">Popular</span>
                                </div>

                                <div class="mb-6">
                                    <div class="text-4xl font-bold text-white mb-1">
                                        $459<span class="text-gray-400 text-lg">/mes</span>
                                    </div>
                                    <p class="text-gray-400 text-sm">Facturación mensual</p>
                                </div>

                                <ul class="space-y-3 mb-8">
                                    <li class="flex items-start">
                                        <i class="fas fa-check text-green-500 mt-1 mr-3 text-sm"></i>
                                        <span class="text-gray-300">Hasta 3 números WhatsApp</span>
                                    </li>
                                    <li class="flex items-start">
                                        <i class="fas fa-check text-green-500 mt-1 mr-3 text-sm"></i>
                                        <span class="text-gray-300">5 cuentas conectadas</span>
                                    </li>
                                    <li class="flex items-start">
                                        <i class="fas fa-check text-green-500 mt-1 mr-3 text-sm"></i>
                                        <span class="text-gray-300">Reportes básicos</span>
                                    </li>
                                    <li class="flex items-start">
                                        <i class="fas fa-check text-green-500 mt-1 mr-3 text-sm"></i>
                                        <span class="text-gray-300">Soporte por email</span>
                                    </li>
                                    <li class="flex items-start text-gray-500">
                                        <i class="fas fa-times mt-1 mr-3 text-sm"></i>
                                        <span>Reportes avanzados</span>
                                    </li>
                                    <li class="flex items-start text-gray-500">
                                        <i class="fas fa-times mt-1 mr-3 text-sm"></i>
                                        <span>API Access</span>
                                    </li>
                                </ul>
                            </div>

                            <div>
                                @auth
                                    @if(auth()->user()->tieneSuscripcionActiva())
                                        @if(auth()->user()->getPlanActualId() === config('services.stripe.price_basico'))
                                            <button class="w-full py-3 bg-gradient-to-r from-green-600 to-emerald-700 text-white font-semibold rounded-lg text-sm">
                                                <i class="fas fa-check mr-2"></i>Plan Actual
                                            </button>
                                        @else
                                            <div class="text-center p-3 bg-yellow-900/20 border border-yellow-800/30 rounded-lg mb-3">
                                                <p class="text-yellow-400 text-sm">
                                                    Ya tienes una suscripción activa
                                                </p>
                                            </div>
                                        @endif
                                    @else
                                        <button onclick="subscribe()"
                                                class="w-full py-3 bg-red-600 hover:bg-red-700 text-white font-semibold rounded-lg border border-red-700 transition text-sm">
                                            Comenzar Prueba Gratis
                                        </button>
                                    @endif
                                @else
                                    <a href="{{ route('register') }}"
                                       class="block w-full py-3 bg-red-600 hover:bg-red-700 text-white font-semibold rounded-lg border border-red-700 transition text-sm text-center">
                                        Registrarse Gratis
                                    </a>
                                @endauth
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- COMPARACIÓN -->
        <!---- <div class="bg-gray-900/50 rounded-xl p-6 mb-10 border border-gray-800">
                <h3 class="text-xl font-bold text-white mb-6 text-center">¿Qué incluye el Plan Básico?</h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <h4 class="text-lg font-semibold text-white mb-3">✅ Incluido</h4>
                        <ul class="space-y-2">
                            <li class="flex items-center">
                                <i class="fas fa-check text-green-500 mr-3"></i>
                                <span class="text-gray-300">3 números de WhatsApp</span>
                            </li>
                            <li class="flex items-center">
                                <i class="fas fa-check text-green-500 mr-3"></i>
                                <span class="text-gray-300">5 cuentas bancarias</span>
                            </li>
                            <li class="flex items-center">
                                <i class="fas fa-check text-green-500 mr-3"></i>
                                <span class="text-gray-300">Reportes básicos diarios</span>
                            </li>
                            <li class="flex items-center">
                                <i class="fas fa-check text-green-500 mr-3"></i>
                                <span class="text-gray-300">Soporte por email prioritario</span>
                            </li>
                        </ul>
                    </div>

                    <div>
                        <h4 class="text-lg font-semibold text-white mb-3">📈 Para más necesidades</h4>
                        <p class="text-gray-400 text-sm mb-3">
                            Si necesitas más capacidades, contáctanos para planes personalizados.
                        </p>
                        <a href="mailto:ventas@avaspace.io"
                           class="inline-flex items-center px-4 py-2 bg-gray-800 hover:bg-gray-700 rounded-lg transition">
                            <i class="fas fa-envelope mr-2"></i>
                            Contactar Ventas
                        </a>
                    </div>
                </div>
            </div>---->

            <!-- FAQ -->
            <div class="mb-8">
                <h3 class="text-xl font-bold text-white mb-6 text-center">Preguntas Frecuentes</h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 max-w-4xl mx-auto">
                    @php
                        $faqs = [
                            [
                                'q' => '¿Hay período de prueba?',
                                'a' => '¡Sí! Incluye 14 días de prueba gratuita. Sin tarjeta de crédito requerida.'
                            ],
                            [
                                'q' => '¿Puedo cancelar cuando quiera?',
                                'a' => 'Sí, puedes cancelar cuando quieras. No hay contratos a largo plazo.'
                            ],
                            [
                                'q' => '¿Qué métodos de pago aceptan?',
                                'a' => 'Aceptamos todas las tarjetas principales (Visa, Mastercard, Amex) vía Stripe.'
                            ],
                            [
                                'q' => '¿Mis datos están seguros?',
                                'a' => 'Sí, usamos encriptación de grado bancario y cumplimos con los más altos estándares de seguridad.'
                            ]
                        ];
                    @endphp

                    @foreach($faqs as $faq)
                        <div class="bg-gray-900/30 rounded-lg p-4 border border-gray-800">
                            <h4 class="font-semibold text-white mb-2">{{ $faq['q'] }}</h4>
                            <p class="text-gray-400 text-sm">{{ $faq['a'] }}</p>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- CTA Final -->
            <div class="text-center">
                <p class="text-gray-400 mb-6">
                    ¿Tienes más preguntas? <a href="mailto:soporte@avaspace.io" class="text-red-400 hover:text-red-300">Contáctanos</a>
                </p>
                <p class="text-sm text-gray-500">
                    <i class="fas fa-lock mr-1"></i>
                    Todos los pagos son procesados de forma segura por Stripe.
                </p>
            </div>

        </div>
    </div>

    <!-- Modal de Pago -->
    <div id="paymentModal" class="fixed inset-0 z-50 hidden">
        <div class="absolute inset-0 bg-black/70 backdrop-blur-sm"></div>

        <div class="absolute inset-0 flex items-center justify-center p-4">
            <div class="bg-gray-900 rounded-xl border border-gray-800 shadow-2xl w-full max-w-md">

                <!-- Header -->
                <div class="p-6 border-b border-gray-800">
                    <div class="flex justify-between items-center">
                        <h3 class="text-lg font-bold text-white">Completar Suscripción</h3>
                        <button onclick="closePaymentModal()" class="text-gray-400 hover:text-white">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                    <p class="text-gray-400 text-sm mt-1">Plan Básico - $459/mes</p>
                </div>

                <!-- Body -->
                <div class="p-6">
                    <div class="mb-4">
                        <label class="block text-gray-300 text-sm font-medium mb-2">
                            Información de tarjeta
                        </label>
                        <div id="card-element" class="p-3 bg-gray-800/50 border border-gray-700 rounded-lg">
                            <!-- Stripe Card Element -->
                        </div>
                        <div id="card-errors" class="text-red-400 text-xs mt-2"></div>
                    </div>

                    <div class="flex items-center mb-4">
                        <input type="checkbox" id="save-card" checked class="w-4 h-4 text-red-600 bg-gray-800 border-gray-700 rounded">
                        <label for="save-card" class="ml-2 text-gray-300 text-sm">Guardar tarjeta para pagos futuros</label>
                    </div>

                    <div class="text-xs text-gray-500">
                        <i class="fas fa-shield-alt mr-1"></i>
                        Pagos seguros procesados por Stripe. Nunca almacenamos tu información de tarjeta.
                    </div>
                </div>

                <!-- Footer -->
                <div class="p-6 border-t border-gray-800">
                    <div class="flex justify-between items-center mb-4">
                        <div>
                            <p class="text-gray-400 text-xs">Total a pagar hoy</p>
                            <p class="text-xl font-bold text-white">$0.00</p>
                        </div>
                        <div class="text-right">
                            <p class="text-gray-400 text-xs">Próximo pago</p>
                            <p class="text-sm font-semibold text-white">En 14 días</p>
                        </div>
                    </div>

                    <button id="submit-payment"
                            onclick="confirmPayment()"
                            class="w-full py-3 bg-gradient-to-r from-red-600 to-pink-600 hover:from-red-500 hover:to-pink-500 text-white font-semibold rounded-lg transition flex items-center justify-center text-sm">
                        <span id="payment-text">Comenzar Prueba Gratis</span>
                        <span id="payment-spinner" class="hidden ml-2">
                            <i class="fas fa-spinner fa-spin"></i>
                        </span>
                    </button>

                    <p class="text-center text-gray-500 text-xs mt-3">
                        Al suscribirte, aceptas nuestros <a href="#" class="text-red-400">Términos</a>
                    </p>
                </div>
            </div>
        </div>
    </div>

@push('scripts')
<script src="https://js.stripe.com/v3/"></script>
<script>
    // Configuración Stripe
    const stripe = Stripe('{{ config("services.stripe.key") }}');
    const elements = stripe.elements();
    let cardElement;
    let isLoading = false;

    // Función para suscribirse
    function subscribe() {
        // Inicializar elemento de tarjeta
        if (!cardElement) {
            cardElement = elements.create('card', {
                style: {
                    base: {
                        color: '#ffffff',
                        fontFamily: '"Figtree", sans-serif',
                        fontSize: '16px',
                        '::placeholder': {
                            color: '#6b7280'
                        }
                    }
                },
                hidePostalCode: true
            });
        }

        // Montar elemento de tarjeta
        cardElement.mount('#card-element');

        // Mostrar modal
        document.getElementById('paymentModal').classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

    // Cerrar modal
    function closePaymentModal() {
        if (isLoading) return;

        document.getElementById('paymentModal').classList.add('hidden');
        document.body.style.overflow = 'auto';

        // Limpiar errores
        document.getElementById('card-errors').textContent = '';

        if (cardElement) {
            cardElement.unmount();
            cardElement = null;
        }

        isLoading = false;

        // Restaurar botón
        const submitBtn = document.getElementById('submit-payment');
        const paymentText = document.getElementById('payment-text');
        const paymentSpinner = document.getElementById('payment-spinner');

        submitBtn.disabled = false;
        paymentText.classList.remove('hidden');
        paymentSpinner.classList.add('hidden');
    }

    // Confirmar pago
    async function confirmPayment() {
        if (isLoading) return;

        const submitBtn = document.getElementById('submit-payment');
        const paymentText = document.getElementById('payment-text');
        const paymentSpinner = document.getElementById('payment-spinner');

        // Mostrar loading
        isLoading = true;
        submitBtn.disabled = true;
        paymentText.classList.add('hidden');
        paymentSpinner.classList.remove('hidden');

        try {
            // Crear método de pago
            const { paymentMethod, error } = await stripe.createPaymentMethod({
                type: 'card',
                card: cardElement,
                billing_details: {
                    email: '{{ auth()->user()->email ?? "" }}',
                    name: '{{ auth()->user()->name ?? "" }}'
                }
            });

            if (error) {
                document.getElementById('card-errors').textContent = error.message;

                isLoading = false;
                submitBtn.disabled = false;
                paymentText.classList.remove('hidden');
                paymentSpinner.classList.add('hidden');
                return;
            }

            // Enviar al servidor usando el endpoint simplificado
            const response = await fetch('{{ route("suscripcion.suscribirse-basico") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    payment_method: paymentMethod.id
                })
            });

            const data = await response.json();

            if (data.success) {
                // Éxito
                alert(data.message);

                // Redirigir después de 1.5 segundos
                setTimeout(() => {
                    window.location.href = '{{ route("dashboard") }}';
                }, 1500);

            } else if (data.requires_action) {
                // 3D Secure
                const { error: confirmError } = await stripe.confirmCardPayment(
                    data.payment_intent_client_secret
                );

                if (confirmError) {
                    document.getElementById('card-errors').textContent = confirmError.message;

                    isLoading = false;
                    submitBtn.disabled = false;
                    paymentText.classList.remove('hidden');
                    paymentSpinner.classList.add('hidden');
                } else {
                    alert('¡Pago confirmado!');

                    setTimeout(() => {
                        window.location.href = '{{ route("dashboard") }}';
                    }, 1500);
                }

            } else {
                // Error del servidor
                document.getElementById('card-errors').textContent = data.message;

                isLoading = false;
                submitBtn.disabled = false;
                paymentText.classList.remove('hidden');
                paymentSpinner.classList.add('hidden');
            }

        } catch (error) {
            console.error('Error:', error);
            document.getElementById('card-errors').textContent = 'Error de conexión. Intenta nuevamente.';

            isLoading = false;
            submitBtn.disabled = false;
            paymentText.classList.remove('hidden');
            paymentSpinner.classList.add('hidden');
        }
    }

    // Cerrar modal con Escape
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') closePaymentModal();
    });

    // Toggle billing (opcional)
    function toggleBilling(period) {
        const monthlyBtn = document.getElementById('toggle-mensual');
        const annualBtn = document.getElementById('toggle-anual');

        if (period === 'mensual') {
            monthlyBtn.classList.add('bg-red-900/30', 'text-white');
            monthlyBtn.classList.remove('text-gray-400');
            annualBtn.classList.remove('bg-red-900/30', 'text-white');
            annualBtn.classList.add('text-gray-400');
        } else {
            annualBtn.classList.add('bg-red-900/30', 'text-white');
            annualBtn.classList.remove('text-gray-400');
            monthlyBtn.classList.remove('bg-red-900/30', 'text-white');
            monthlyBtn.classList.add('text-gray-400');
        }
    }

    // Inicializar
    document.addEventListener('DOMContentLoaded', function() {
        toggleBilling('mensual');
    });

    // Validar entrada de tarjeta en tiempo real
    if (cardElement) {
        cardElement.on('change', function(event) {
            const displayError = document.getElementById('card-errors');
            if (event.error) {
                displayError.textContent = event.error.message;
            } else {
                displayError.textContent = '';
            }
        });
    }
</script>
@endpush
</x-app-layout>
