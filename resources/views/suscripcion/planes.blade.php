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
                                {{ auth()->user()->getInfoSuscripcion()['plan'] }}
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

            <!-- Switch Anual/Mensual -->
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

            <!-- Grid de Planes -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">

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
                                    $10<span class="text-gray-400 text-lg">/mes</span>
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
                                @if(auth()->user()->tieneSuscripcionActiva() &&
                                   auth()->user()->getPlanActual() === config('services.stripe.price_basico'))
                                    <button class="w-full py-3 bg-gradient-to-r from-green-600 to-emerald-700 text-white font-semibold rounded-lg text-sm">
                                        <i class="fas fa-check mr-2"></i>Plan Actual
                                    </button>
                                @else
                                    <button onclick="subscribe('{{ config('services.stripe.price_basico') }}', 'basico')"
                                            class="w-full py-3 bg-gray-800 hover:bg-gray-700 text-white font-semibold rounded-lg border border-gray-700 transition text-sm">
                                        {{ auth()->user()->tieneSuscripcionActiva() ? 'Cambiar a este plan' : 'Comenzar Prueba' }}
                                    </button>
                                @endif
                            @else
                                <a href="{{ route('register') }}?plan=basico"
                                   class="block w-full py-3 bg-gray-800 hover:bg-gray-700 text-white font-semibold rounded-lg border border-gray-700 transition text-sm text-center">
                                    Registrarse Gratis
                                </a>
                            @endauth
                        </div>
                    </div>
                </div>

                <!-- Plan Pro (Destacado) -->
                <div class="relative group transform md:scale-105 z-10">
                    <div class="absolute -inset-0.5 bg-gradient-to-r from-red-600 to-pink-600 rounded-2xl blur opacity-30 group-hover:opacity-40 transition duration-1000"></div>
                    <div class="relative bg-gray-900/90 backdrop-blur-sm border border-red-800/50 rounded-2xl p-6">
                        <div class="absolute -top-3 left-1/2 transform -translate-x-1/2">
                            <span class="px-4 py-1 bg-gradient-to-r from-red-600 to-pink-600 text-white text-xs font-bold rounded-full shadow-lg">
                                RECOMENDADO
                            </span>
                        </div>

                        <div class="mb-6">
                            <div class="flex justify-between items-start mb-4">
                                <div>
                                    <h3 class="text-xl font-bold text-white">Pro</h3>
                                    <p class="text-gray-400 text-sm mt-1">Para crecer</p>
                                </div>
                                <span class="px-3 py-1 bg-red-900/30 text-red-300 text-xs rounded-full">Popular</span>
                            </div>

                            <div class="mb-6">
                                <div class="text-4xl font-bold text-white mb-1">
                                    $20<span class="text-gray-400 text-lg">/mes</span>
                                </div>
                                <p class="text-gray-400 text-sm">Todo lo que necesitas</p>
                            </div>

                            <ul class="space-y-3 mb-8">
                                <li class="flex items-start">
                                    <i class="fas fa-check text-green-500 mt-1 mr-3 text-sm"></i>
                                    <span class="text-gray-300">Hasta 10 números WhatsApp</span>
                                </li>
                                <li class="flex items-start">
                                    <i class="fas fa-check text-green-500 mt-1 mr-3 text-sm"></i>
                                    <span class="text-gray-300">20 cuentas</span>
                                </li>
                                <li class="flex items-start">
                                    <i class="fas fa-check text-green-500 mt-1 mr-3 text-sm"></i>
                                    <span class="text-gray-300">Reportes avanzados</span>
                                </li>
                                <li class="flex items-start">
                                    <i class="fas fa-check text-green-500 mt-1 mr-3 text-sm"></i>
                                    <span class="text-gray-300">Análisis de tendencias</span>
                                </li>
                                <li class="flex items-start">
                                    <i class="fas fa-check text-green-500 mt-1 mr-3 text-sm"></i>
                                    <span class="text-gray-300">API Access limitado</span>
                                </li>
                                <li class="flex items-start">
                                    <i class="fas fa-check text-green-500 mt-1 mr-3 text-sm"></i>
                                    <span class="text-gray-300">Soporte prioritario</span>
                                </li>
                            </ul>
                        </div>

                        <div>
                            @auth
                                @if(auth()->user()->tieneSuscripcionActiva() &&
                                   auth()->user()->getPlanActual() === config('services.stripe.price_pro'))
                                    <button class="w-full py-3 bg-gradient-to-r from-green-600 to-emerald-700 text-white font-semibold rounded-lg text-sm">
                                        <i class="fas fa-crown mr-2"></i>Plan Actual
                                    </button>
                                @else
                                    <button onclick="subscribe('{{ config('services.stripe.price_pro') }}', 'pro')"
                                            class="w-full py-3 bg-gradient-to-r from-red-600 to-pink-600 hover:from-red-500 hover:to-pink-500 text-white font-semibold rounded-lg shadow-lg shadow-red-900/30 transition text-sm">
                                        <i class="fas fa-bolt mr-2"></i>
                                        {{ auth()->user()->tieneSuscripcionActiva() ? 'Actualizar a Pro' : 'Probar Gratis' }}
                                    </button>
                                @endif
                            @else
                                <a href="{{ route('register') }}?plan=pro"
                                   class="block w-full py-3 bg-gradient-to-r from-red-600 to-pink-600 hover:from-red-500 hover:to-pink-500 text-white font-semibold rounded-lg shadow-lg shadow-red-900/30 transition text-sm text-center">
                                    <i class="fas fa-bolt mr-2"></i>
                                    Comenzar Prueba
                                </a>
                            @endauth
                        </div>
                    </div>
                </div>

                <!-- Plan Empresa -->
                <div class="relative group">
                    <div class="absolute -inset-0.5 bg-gradient-to-r from-purple-600 to-purple-800 rounded-2xl blur opacity-20 group-hover:opacity-30 transition duration-1000"></div>
                    <div class="relative bg-gray-900/80 backdrop-blur-sm border border-purple-800/30 rounded-2xl p-6">
                        <div class="mb-6">
                            <div class="flex justify-between items-start mb-4">
                                <div>
                                    <h3 class="text-xl font-bold text-white">Empresa</h3>
                                    <p class="text-gray-400 text-sm mt-1">Para equipos</p>
                                </div>
                                <span class="px-3 py-1 bg-purple-900/30 text-purple-300 text-xs rounded-full">Premium</span>
                            </div>

                            <div class="mb-6">
                                <div class="text-4xl font-bold text-white mb-1">
                                    $50<span class="text-gray-400 text-lg">/mes</span>
                                </div>
                                <p class="text-gray-400 text-sm">Potencia empresarial</p>
                            </div>

                            <ul class="space-y-3 mb-8">
                                <li class="flex items-start">
                                    <i class="fas fa-check text-green-500 mt-1 mr-3 text-sm"></i>
                                    <span class="text-gray-300">WhatsApp ilimitado</span>
                                </li>
                                <li class="flex items-start">
                                    <i class="fas fa-check text-green-500 mt-1 mr-3 text-sm"></i>
                                    <span class="text-gray-300">Cuentas ilimitadas</span>
                                </li>
                                <li class="flex items-start">
                                    <i class="fas fa-check text-green-500 mt-1 mr-3 text-sm"></i>
                                    <span class="text-gray-300">Dashboard personalizado</span>
                                </li>
                                <li class="flex items-start">
                                    <i class="fas fa-check text-green-500 mt-1 mr-3 text-sm"></i>
                                    <span class="text-gray-300">API Access completo</span>
                                </li>
                                <li class="flex items-start">
                                    <i class="fas fa-check text-green-500 mt-1 mr-3 text-sm"></i>
                                    <span class="text-gray-300">Soporte 24/7 dedicado</span>
                                </li>
                                <li class="flex items-start">
                                    <i class="fas fa-check text-green-500 mt-1 mr-3 text-sm"></i>
                                    <span class="text-gray-300">Entrenamiento personalizado</span>
                                </li>
                            </ul>
                        </div>

                        <div>
                            @auth
                                <button onclick="subscribe('{{ config('services.stripe.price_empresa') }}', 'empresa')"
                                        class="w-full py-3 bg-gradient-to-r from-purple-800 to-purple-900 hover:from-purple-700 hover:to-purple-800 text-white font-semibold rounded-lg border border-purple-700 transition text-sm">
                                    <i class="fas fa-building mr-2"></i>
                                    {{ auth()->user()->tieneSuscripcionActiva() ? 'Actualizar' : 'Contactar Ventas' }}
                                </button>
                            @else
                                <a href="{{ route('register') }}?plan=empresa"
                                   class="block w-full py-3 bg-gradient-to-r from-purple-800 to-purple-900 hover:from-purple-700 hover:to-purple-800 text-white font-semibold rounded-lg border border-purple-700 transition text-sm text-center">
                                    <i class="fas fa-building mr-2"></i>
                                    Contactar Ventas
                                </a>
                            @endauth
                        </div>
                    </div>
                </div>
            </div>

            <!-- Comparación -->
            <div class="bg-gray-900/50 rounded-xl p-6 mb-10 border border-gray-800">
                <h3 class="text-xl font-bold text-white mb-6 text-center">Comparación de Características</h3>

                <div class="overflow-x-auto">
                    <table class="w-full min-w-max">
                        <thead>
                            <tr class="border-b border-gray-800">
                                <th class="text-left py-3 text-gray-400 font-medium text-sm">Característica</th>
                                <th class="text-center py-3 px-2">
                                    <div class="font-bold text-gray-300 text-sm">Básico</div>
                                    <div class="text-xs text-gray-500">$10/mes</div>
                                </th>
                                <th class="text-center py-3 px-2">
                                    <div class="font-bold text-red-400 text-sm">Pro</div>
                                    <div class="text-xs text-gray-500">$20/mes</div>
                                </th>
                                <th class="text-center py-3 px-2">
                                    <div class="font-bold text-purple-400 text-sm">Empresa</div>
                                    <div class="text-xs text-gray-500">$50/mes</div>
                                </th>
                            </tr>
                        </thead>
                        <tbody class="text-sm">
                            <tr class="border-b border-gray-800/50">
                                <td class="py-3 text-gray-300">Números WhatsApp</td>
                                <td class="text-center py-3">3</td>
                                <td class="text-center py-3 text-red-400 font-semibold">10</td>
                                <td class="text-center py-3 text-purple-400 font-semibold">Ilimitados</td>
                            </tr>
                            <tr class="border-b border-gray-800/50">
                                <td class="py-3 text-gray-300">Cuentas</td>
                                <td class="text-center py-3">5</td>
                                <td class="text-center py-3 text-red-400 font-semibold">20</td>
                                <td class="text-center py-3 text-purple-400 font-semibold">Ilimitadas</td>
                            </tr>
                            <tr class="border-b border-gray-800/50">
                                <td class="py-3 text-gray-300">Reportes Avanzados</td>
                                <td class="text-center py-3"><i class="fas fa-times text-red-500"></i></td>
                                <td class="text-center py-3"><i class="fas fa-check text-green-500"></i></td>
                                <td class="text-center py-3"><i class="fas fa-check text-green-500"></i></td>
                            </tr>
                            <tr class="border-b border-gray-800/50">
                                <td class="py-3 text-gray-300">API Access</td>
                                <td class="text-center py-3"><i class="fas fa-times text-red-500"></i></td>
                                <td class="text-center py-3 text-yellow-400 text-xs">Limitado</td>
                                <td class="text-center py-3"><i class="fas fa-check text-green-500"></i></td>
                            </tr>
                            <tr>
                                <td class="py-3 text-gray-300">Soporte</td>
                                <td class="text-center py-3 text-xs">Email</td>
                                <td class="text-center py-3 text-red-400 text-xs">Prioritario</td>
                                <td class="text-center py-3 text-purple-400 text-xs">24/7 Dedicado</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- FAQ -->
            <div class="mb-8">
                <h3 class="text-xl font-bold text-white mb-6 text-center">Preguntas Frecuentes</h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 max-w-4xl mx-auto">
                    @php
                        $faqs = [
                            [
                                'q' => '¿Puedo cambiar de plan después?',
                                'a' => 'Sí, puedes cambiar de plan en cualquier momento. La diferencia se prorrateará automáticamente.'
                            ],
                            [
                                'q' => '¿Hay período de prueba?',
                                'a' => '¡Sí! Todos los planes incluyen 14 días de prueba gratuita. Sin tarjeta de crédito requerida.'
                            ],
                            [
                                'q' => '¿Puedo cancelar cuando quiera?',
                                'a' => 'Sí, puedes cancelar cuando quieras. No hay contratos a largo plazo ni penalizaciones.'
                            ],
                            [
                                'q' => '¿Qué métodos de pago aceptan?',
                                'a' => 'Aceptamos todas las tarjetas principales (Visa, Mastercard, Amex) vía Stripe.'
                            ],
                            [
                                'q' => '¿Mis datos están seguros?',
                                'a' => 'Sí, usamos encriptación de grado bancario y cumplimos con los más altos estándares de seguridad.'
                            ],
                            [
                                'q' => '¿Ofrecen descuentos anuales?',
                                'a' => 'Sí, al pagar anualmente recibes 2 meses gratis (20% de descuento).'
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
                    ¿Tienes más preguntas? <a href="mailto:soporte@tudominio.com" class="text-red-400 hover:text-red-300">Contáctanos</a>
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
                    <p class="text-gray-400 text-sm mt-1" id="modal-plan-title"></p>
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
                            <p class="text-xl font-bold text-white" id="modal-total">$0.00</p>
                        </div>
                        <div class="text-right">
                            <p class="text-gray-400 text-xs">Próximo pago</p>
                            <p class="text-sm font-semibold text-white" id="modal-next-payment">En 14 días</p>
                        </div>
                    </div>

                    <button id="submit-payment"
                            onclick="confirmPayment()"
                            class="w-full py-3 bg-gradient-to-r from-red-600 to-pink-600 hover:from-red-500 hover:to-pink-500 text-white font-semibold rounded-lg transition flex items-center justify-center text-sm">
                        <span id="payment-text">Completar Suscripción</span>
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
    <script>
        // Configuración Stripe
        const stripe = Stripe('{{ config("services.stripe.key") }}');
        const elements = stripe.elements();
        let cardElement;

        let selectedPlan = null;
        let selectedPlanName = null;
        let isLoading = false;
        let isAnnual = false;

        // Precios de los planes
        const planPrices = {
            '{{ config("services.stripe.price_basico") }}': {
                name: 'Básico',
                monthly: 10,
                annual: 96, // $8/mes
                monthlyText: '$10/mes',
                annualText: '$96/año'
            },
            '{{ config("services.stripe.price_pro") }}': {
                name: 'Pro',
                monthly: 20,
                annual: 192, // $16/mes
                monthlyText: '$20/mes',
                annualText: '$192/año'
            },
            '{{ config("services.stripe.price_empresa") }}': {
                name: 'Empresa',
                monthly: 50,
                annual: 480, // $40/mes
                monthlyText: '$50/mes',
                annualText: '$480/año'
            }
        };

        // Toggle billing
        function toggleBilling(period) {
            const monthlyBtn = document.getElementById('toggle-mensual');
            const annualBtn = document.getElementById('toggle-anual');

            if (period === 'mensual') {
                isAnnual = false;
                monthlyBtn.classList.add('bg-red-900/30', 'text-white');
                monthlyBtn.classList.remove('text-gray-400');
                annualBtn.classList.remove('bg-red-900/30', 'text-white');
                annualBtn.classList.add('text-gray-400');

                // Actualizar precios en UI
                document.querySelectorAll('.plan-price').forEach(el => {
                    const planId = el.dataset.plan;
                    if (planPrices[planId]) {
                        el.innerHTML = `$${planPrices[planId].monthly}<span class="text-gray-400 text-lg">/mes</span>`;
                    }
                });
            } else {
                isAnnual = true;
                annualBtn.classList.add('bg-red-900/30', 'text-white');
                annualBtn.classList.remove('text-gray-400');
                monthlyBtn.classList.remove('bg-red-900/30', 'text-white');
                monthlyBtn.classList.add('text-gray-400');

                // Actualizar precios en UI
                document.querySelectorAll('.plan-price').forEach(el => {
                    const planId = el.dataset.plan;
                    if (planPrices[planId]) {
                        el.innerHTML = `$${planPrices[planId].annual}<span class="text-gray-400 text-lg">/año</span>`;
                    }
                });
            }
        }

        // Función para suscribirse
        function subscribe(planId, planName) {
            selectedPlan = planId;
            selectedPlanName = planName;

            const plan = planPrices[planId];
            const price = isAnnual ? plan.annual : plan.monthly;
            const period = isAnnual ? 'año' : 'mes';

            // Actualizar modal con información del plan
            document.getElementById('modal-plan-title').textContent =
                `Plan ${plan.name} - $${price}/${period}`;

            document.getElementById('modal-total').textContent = '$0.00';
            document.getElementById('modal-next-payment').textContent = isAnnual ? 'En 1 año' : 'En 1 mes';

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
            }

            selectedPlan = null;
            selectedPlanName = null;
            isLoading = false;

            // Restaurar botón
            const submitBtn = document.getElementById('submit-payment');
            const paymentText = document.getElementById('payment-text');
            const paymentSpinner = document.getElementById('payment-spinner');

            submitBtn.disabled = false;
            paymentText.classList.remove('hidden');
            paymentSpinner.classList.add('hidden');
        }

        // Mostrar toast
        function showToast(message, type = 'success') {
            const toast = document.createElement('div');
            toast.className = `fixed top-4 right-4 z-50 px-4 py-3 rounded-lg border ${
                type === 'success' ? 'bg-green-900/90 border-green-700' :
                type === 'error' ? 'bg-red-900/90 border-red-700' :
                'bg-blue-900/90 border-blue-700'
            } backdrop-blur-sm`;
            toast.innerHTML = `
                <div class="flex items-center">
                    <i class="fas fa-${type === 'success' ? 'check-circle' : 'exclamation-circle'} mr-3 ${
                        type === 'success' ? 'text-green-400' : 'text-red-400'
                    }"></i>
                    <span class="text-white text-sm">${message}</span>
                </div>
            `;

            document.body.appendChild(toast);

            setTimeout(() => {
                toast.remove();
            }, 3000);
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

            try {
                const response = await fetch('{{ route("suscripcion.crear") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        payment_method: paymentMethod.id,
                        plan: selectedPlan,
                        plan_name: selectedPlanName,
                        billing_period: isAnnual ? 'annual' : 'monthly'
                    })
                });

                const data = await response.json();

                if (data.success) {
                    showToast('¡Suscripción creada exitosamente!', 'success');

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
                        showToast('¡Pago confirmado!', 'success');

                        setTimeout(() => {
                            window.location.href = '{{ route("dashboard") }}';
                        }, 1500);
                    }

                } else {
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

        // Inicializar
        document.addEventListener('DOMContentLoaded', function() {
            toggleBilling('mensual');
        });
    </script>
    @endpush

</x-app-layout>
