<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Admin Jr | Avaspace</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined"
      rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-gradient-to-br from-black via-[#0f1115] to-[#1a1d23] text-white overflow-x-hidden">

<!-- HEADER -->
<header class="max-w-7xl mx-auto px-6 py-6">
    <div class="flex justify-between items-center rounded-full px-6 sm:px-8 py-4 
                bg-white/10 backdrop-blur-md border border-white/10 shadow-lg gap-2 sm:gap-0">

        <!-- LOGO + NOMBRE -->
        <div class="flex items-center gap-3 shrink-0">
            <img src="{{ asset('avaspace.svg') }}" alt="Avaspace" class="h-10">
            <span class="text-white font-bold text-lg tracking-wide">
                Avaspace
            </span>
        </div>

        <!-- ACCIONES -->
        <div class="flex gap-3 sm:gap-4">
            <a href="{{ route('login') }}"
               class="min-w-[120px] sm:min-w-0
                      text-center whitespace-nowrap
                      px-5 py-2 rounded-full border border-white/40 text-sm 
                      hover:bg-white hover:text-black transition font-medium">
                Iniciar sesión
            </a>

            <a href="{{ route('register') }}"
               class="min-w-[120px] sm:min-w-0
                      text-center whitespace-nowrap
                      px-5 py-2 rounded-full border border-red-900 bg-red-600 text-white text-sm
                      hover:bg-white hover:text-black transition font-medium">
                Crear cuenta
            </a>
        </div>

    </div>
</header>

<!-- VIDEO -->
    <section class="relative mt-24 flex justify-center">
        <div class="absolute inset-0 flex justify-center">
            <div class="w-[80%] h-[80%] bg-red-600/20 blur-3xl rounded-full"></div>
        </div>

        <div class="relative w-full max-w-5xl rounded-2xl overflow-hidden bg-white/10 backdrop-blur-xl border border-white/10 shadow-2xl">
            <div class="flex items-center gap-2 px-4 py-3 bg-black/40">
                <span class="w-3 h-3 bg-red-500 rounded-full"></span>
                <span class="w-3 h-3 bg-yellow-400 rounded-full"></span>
                <span class="w-3 h-3 bg-green-500 rounded-full"></span>
            </div>

            <div class="aspect-video">
                <iframe class="w-full h-full"
                        src="https://www.youtube.com/embed/mjW6kuUwr6c"
                        allowfullscreen>
                </iframe>
            </div>
        </div>
    </section>

<!-- MAIN -->
<main class="max-w-7xl mx-auto px-6 pt-24 pb-24 relative">

<!-- HERO -->
<section class="max-w-7xl mx-auto px-6 pt-24 pb-32 relative overflow-hidden">

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">

        <!-- TEXTO -->
         
        <div class="space-y-8 text-center lg:text-left">
           <!-- glow decorativo -->
        <div class="absolute inset-0 -z-10 flex justify-center items-center">
            <div class="w-[60%] h-[60%] bg-red-600/20 blur-3xl rounded-full"></div>
        </div>

            <h2 class="text-3xl md:text-4xl font-medium text-white leading-tight">
                
                Controla tus
                <span class="text-red-500 font-bold">finanzas</span>
                o las de
                <span class="text-red-500 font-bold">tu negocio</span>
                con un mensaje de
                <span class="text-red-500 font-bold">WhatsApp</span>
            </h2>

            <p class="text-lg md:text-xl text-white/70 max-w-xl mx-auto lg:mx-0 leading-relaxed">
                Reporta tus
                <span class="text-red-500 font-medium">ventas y gastos</span>
                por <span class="text-red-500 font-medium">WhatsApp</span>
                y recibe
                <span class="text-white font-medium">resúmenes automáticos</span>
                de tu dinero al instante.
            </p>

        </div>

        <!-- MOCKUP -->
<div class="flex justify-center relative font-montserrat">

    <!-- GLOW -->
    <div class="absolute -z-10 w-[460px] h-[460px] bg-red-600/15 blur-[160px] rounded-full"></div>

    <!-- FRAME -->
    <div class="relative bg-white/5 backdrop-blur-xl
                border border-white/10 rounded-3xl p-8 shadow-2xl">

        <!-- PHONE -->
        <div class="w-[310px] rounded-[2.6rem]
                    bg-[#111827] border border-white/10 overflow-hidden">

            <!-- TOP BAR -->
            <div class="px-5 py-4 flex items-center gap-3
                        bg-gradient-to-r from-[#075E54] to-[#0b6e63]">

                <div class="w-9 h-9 rounded-full bg-white flex items-center justify-center">
                    <img src="{{ asset('avaspace.svg') }}" alt="Admin JR" class="w-5 h-5">
                </div>

                <div class="flex-1">
                    <p class="text-sm font-semibold text-white tracking-wide">
                        Admin JR 🤖
                    </p>
                    <p class="text-[11px] text-white/70">
                        Asistente financiero 📊
                    </p>
                </div>
            </div>

            <!-- CHAT -->
            <div class="bg-[#F4F5F7] px-5 py-6 space-y-5 text-[13px] text-left">

                <!-- USER -->
                <div class="flex justify-end">
                    <div class="bg-white px-4 py-3 rounded-2xl
                                max-w-[80%] shadow text-black leading-relaxed">
                        💸 Venta del día $2,500<br>
                        💳 pago con tarjeta
                    </div>
                </div>

                <!-- ADMIN JR -->
                <div class="flex justify-start">
                    <div class="bg-[#e8f5ef] px-4 py-3 rounded-2xl
                                max-w-[80%] shadow text-black space-y-2">

                        <p class="font-semibold">
                            ✅ Movimiento registrado
                        </p>

                        <div class="text-xs space-y-1">
                            <p>📥 Ingreso: <b>$2,500</b></p>
                            <p>💳 Método: Tarjeta</p>
                            <p>📈 Utilidad del día: <b>$1,700</b></p>
                        </div>
                    </div>
                </div>

                <!-- RESUMEN -->
                <div class="flex justify-start">
                    <div class="bg-white px-4 py-3 rounded-2xl
                                max-w-[80%] shadow text-black text-xs leading-relaxed">

                        <b>📊 Resumen rápido</b><br>
                        Hoy llevas un balance positivo ✅<br>
                        ¿Deseas ver el reporte semanal? 📅
                    </div>
                </div>

            </div>
        </div>
    </div>

</div>
</section>

    

   <!-- INFO -->
<section class="mt-32 grid md:grid-cols-2 gap-16 items-center">

    <!-- TEXTO -->
    <div class="relative space-y-6">

        <!-- glow decorativo -->
        <div class="absolute inset-0 -z-10 flex justify-center items-center">
            <div class="w-[60%] h-[60%] bg-red-600/20 blur-3xl rounded-full"></div>
        </div>

        <h3 class="text-3xl font-extrabold text-white leading-tight">
            Tu asistente administrativo
            <span class="text-red-600">vive en tu WhatsApp</span>
        </h3>

        <p class="text-white/70 text-lg leading-relaxed">
            <span class="text-white font-medium">
                La mejor herramienta de automatización
            </span>
            para controlar tu negocio en segundos.
            <br><br>
            No necesitas abrir plataformas complicadas para saber cuánto dinero tienes.
            Solo envía un texto y
            <span class="text-white font-medium">Admin JR</span>
            se encarga del resto: centraliza
            <span class="text-white font-medium">ingresos</span>,
            <span class="text-white font-medium">egresos</span> y
            <span class="text-white font-medium">recordatorios</span>
            de forma
            <span class="text-red-500 font-medium">simple</span>,
            <span class="text-red-500 font-medium">rápida</span> y
            <span class="text-red-500 font-medium">sin errores</span>.
            <br><br>
            Reporta y consulta tu
            <span class="text-white font-medium">utilidad</span>
            sin salir de tu chat favorito.
        </p>

    </div>

    <!-- MOCKUP GRÁFICA / RESUMEN -->
<div class="flex justify-center relative font-montserrat">

    <!-- glow -->
    <div class="absolute -z-10 w-[420px] h-[420px] bg-red-600/20 blur-[150px] rounded-full"></div>

    <!-- card -->
    <div class="relative w-full max-w-md
                bg-white/10 backdrop-blur-xl
                border border-white/10 rounded-3xl
                p-6 shadow-2xl space-y-6">

        <!-- header -->
        <div>
            <p class="text-sm text-white/60">
                Resumen del día
            </p>
            <h4 class="text-2xl font-extrabold text-white">
                $1,950 <span class="text-red-500">MXN</span>
            </h4>
            <p class="text-xs text-white/60">
                Utilidad neta
            </p>
        </div>

        <!-- gráfica -->
        <div class="space-y-3">
            <div>
                <div class="flex justify-between text-xs text-white/70 mb-1">
                    <span>Ingresos</span>
                    <span>$3,200</span>
                </div>
                <div class="w-full h-2 rounded-full bg-white/10">
                    <div class="h-2 rounded-full bg-green-500 w-[85%]"></div>
                </div>
            </div>

            <div>
                <div class="flex justify-between text-xs text-white/70 mb-1">
                    <span>Egresos</span>
                    <span>$1,250</span>
                </div>
                <div class="w-full h-2 rounded-full bg-white/10">
                    <div class="h-2 rounded-full bg-red-500 w-[40%]"></div>
                </div>
            </div>
        </div>

        <!-- footer -->
        <div class="bg-black/30 rounded-xl p-4 text-xs text-white/70 leading-relaxed">
            Balance actualizado automáticamente a partir de tus mensajes.
        </div>
    </div>
</div>
</section>

  <!-- FEATURES -->
<section class="mt-32">
    <h3 class="text-3xl font-extrabold text-center mb-16 text-white">
        Todo el poder de Admin JR, <span class="text-red-600">a un mensaje de distancia</span>
    </h3>

    <div class="grid md:grid-cols-3 gap-12">

        <!-- CARD 1 -->
        <div class="relative bg-white/10 p-8 rounded-2xl border border-white/10 space-y-6 overflow-hidden">

            <!-- glow -->
            <div class="absolute inset-0 -z-10 flex justify-center items-center">
                <div class="w-[70%] h-[70%] bg-red-600/20 blur-3xl rounded-full"></div>
            </div>

            <!-- ICONO -->
            <span class="material-symbols-outlined text-red-600 text-5xl">
                paid
            </span>

            <h4 class="text-xl font-semibold text-white">
                Registro en <span class="text-red-500">3 segundos</span>
                vía 
                <span class="text-red-500">WhatsApp</span>
            </h4>

            <p class="text-white/70 leading-relaxed">
                Tu nuevo registro contable es un mensaje de texto. Olvida abrir la computadora o pelear con hojas de Excel. 
                Reporta una venta o un gasto mientras sucede, directamente en tu chat. Admin JR procesa la información al instante 
                para que tu flujo de efectivo esté siempre al día.
            </p>
        </div>

        <!-- CARD 2 -->
        <div class="relative bg-white/10 p-8 rounded-2xl border border-white/10 space-y-6 overflow-hidden">

            <!-- glow -->
            <div class="absolute inset-0 -z-10 flex justify-center items-center">
                <div class="w-[70%] h-[70%] bg-red-600/20 blur-3xl rounded-full"></div>
            </div>

            <!-- ICONO -->
            <span class="material-symbols-outlined text-red-600 text-5xl">
                notifications_active
            </span>

            <h4 class="text-xl font-semibold text-white">
                Recordatorios <span class="text-red-500">inteligentes</span>
            </h4>

            <p class="text-white/70 leading-relaxed">
                
                Tu asistente te avisa qué falta por reportar o cobrar. Recibe recordatorios automáticos por WhatsApp sobre pagos 
                de clientes o facturas por vencer. Evita fugas de dinero y mantén tus cuentas claras sin tener que revisar agendas
                o correos traspapelados.
            </p>
        </div>

        <!-- CARD 3 -->
        <div class="relative bg-white/10 p-8 rounded-2xl border border-white/10 space-y-6 overflow-hidden">

            <!-- glow -->
            <div class="absolute inset-0 -z-10 flex justify-center items-center">
                <div class="w-[70%] h-[70%] bg-red-600/20 blur-3xl rounded-full"></div>
            </div>

            <!-- ICONO -->
            <span class="material-symbols-outlined text-red-600 text-5xl">
                bar_chart
            </span>

            <h4 class="text-xl font-semibold text-white">
                El resumen de tu   <span class="text-red-500">administración 24/7</span>
            </h4>

            <p class="text-white/70 leading-relaxed">
                No más dudas sobre cuánto estás ganando. Recibe resúmenes de utilidad y gráficos dinámicos
                que te dicen exactamente cómo va tu negocio hoy. Obtén respuestas inmediatas por WhatsApp o 
                profundiza en tu dashboard: información clara para tomar decisiones rápidas.
            </p>
        </div>

    </div>
</section>


    <!---preguntas frecuentes--->
    <section class="mt-32 max-w-3xl mx-auto">
    <h2 class="text-4xl font-extrabold text-center mb-12 text-white">
        Preguntas <span class="text-red-600">frecuentes</span>
    </h2>

    <div class="space-y-4">

        <!-- ITEM -->
        <div class="border border-white/10 rounded-xl overflow-hidden">
            <button onclick="toggleFaq(this)"
                class="w-full flex justify-between items-center p-6 text-left text-white font-semibold bg-white/10">
                ¿Qué es Admin JR?
                <span class="text-red-600 text-xl">+</span>
            </button>
            <div class="hidden px-6 pb-6 text-white/70">
                Admin JR es un asistente administrativo digital que funciona desde WhatsApp
                y te ayuda a llevar el control de tus ingresos y gastos de forma simple y ordenada.
            </div>
        </div>

        <div class="border border-white/10 rounded-xl overflow-hidden">
            <button onclick="toggleFaq(this)"
                class="w-full flex justify-between items-center p-6 text-left text-white font-semibold bg-white/10">
                ¿Necesito descargar una app?
                <span class="text-red-600 text-xl">+</span>
            </button>
            <div class="hidden px-6 pb-6 text-white/70">
                No. Admin JR funciona directamente en WhatsApp, sin descargas ni plataformas complicadas.
                <br><em> Mientras menos apps, más control.</em>
            </div>
        </div>

        <div class="border border-white/10 rounded-xl overflow-hidden">
            <button onclick="toggleFaq(this)"
                class="w-full flex justify-between items-center p-6 text-left text-white font-semibold bg-white/10">
                ¿Para quién es Admin JR?
                <span class="text-red-600 text-xl">+</span>
            </button>
            <div class="hidden px-6 pb-6 text-white/70">
                Para emprendedores, pequeños negocios y freelancers que:
                <ul class="list-disc pl-5 mt-2 space-y-1">
                    <li>Llevan su administración solos</li>
                    <li>No tienen tiempo para Excel</li>
                    <li>Quieren claridad real de su dinero</li>
                </ul>
            </div>
        </div>

        <div class="border border-white/10 rounded-xl overflow-hidden">
            <button onclick="toggleFaq(this)"
                class="w-full flex justify-between items-center p-6 text-left text-white font-semibold bg-white/10">
                ¿Qué problemas me ayuda a resolver?
                <span class="text-red-600 text-xl">+</span>
            </button>
            <div class="hidden px-6 pb-6 text-white/70">
                <ul class="list-disc pl-5 space-y-1">
                    <li>No saber cuánto ganas realmente</li>
                    <li>Desorden financiero</li>
                    <li>Gastos que “se pierden”</li>
                    <li>Falta de control del dinero</li>
                </ul>
                <p class="mt-2">Admin JR te ayuda a ordenar sin complicarte.</p>
            </div>
        </div>

        <div class="border border-white/10 rounded-xl overflow-hidden">
            <button onclick="toggleFaq(this)"
                class="w-full flex justify-between items-center p-6 text-left text-white font-semibold bg-white/10">
                ¿Necesito saber de contabilidad?
                <span class="text-red-600 text-xl">+</span>
            </button>
            <div class="hidden px-6 pb-6 text-white/70">
                No. Admin JR está diseñado para personas sin conocimientos contables.
                Solo registras movimientos de dinero de forma sencilla.
            </div>
        </div>

        <div class="border border-white/10 rounded-xl overflow-hidden">
            <button onclick="toggleFaq(this)"
                class="w-full flex justify-between items-center p-6 text-left text-white font-semibold bg-white/10">
                ¿Admin JR reemplaza a un contador?
                <span class="text-red-600 text-xl">+</span>
            </button>
            <div class="hidden px-6 pb-6 text-white/70">
                No. Admin JR no sustituye a un contador, pero sí te permite tener tu información
                organizada y lista cuando la necesites.
            </div>
        </div>

        <div class="border border-white/10 rounded-xl overflow-hidden">
            <button onclick="toggleFaq(this)"
                class="w-full flex justify-between items-center p-6 text-left text-white font-semibold bg-white/10">
                ¿Mi información está segura?
                <span class="text-red-600 text-xl">+</span>
            </button>
            <div class="hidden px-6 pb-6 text-white/70">
                Sí. Tu información es privada y confidencial. Solo tú tienes acceso a tus datos.
            </div>
        </div>

        <div class="border border-white/10 rounded-xl overflow-hidden">
            <button onclick="toggleFaq(this)"
                class="w-full flex justify-between items-center p-6 text-left text-white font-semibold bg-white/10">
                ¿Cuánto cuesta Admin JR?
                <span class="text-red-600 text-xl">+</span>
            </button>
            <div class="hidden px-6 pb-6 text-white/70">
                El costo es de <strong>$459 MXN al mes</strong>, mucho menos que contratar
                a un asistente administrativo tradicional.
                <br><em> Sin contratos largos ni compromisos forzosos.</em>
            </div>
        </div>

        <div class="border border-white/10 rounded-xl overflow-hidden">
            <button onclick="toggleFaq(this)"
                class="w-full flex justify-between items-center p-6 text-left text-white font-semibold bg-white/10">
                ¿Puedo ver cómo funciona antes de pagar?
                <span class="text-red-600 text-xl">+</span>
            </button>
            <div class="hidden px-6 pb-6 text-white/70">
                Sí. Puedes crear una cuenta demo y conocer Admin JR antes de tomar cualquier decisión.
            </div>
        </div>

    </div>

    <!-- CTA -->
    <div class="mt-12 text-center">
        <p class="text-white text-lg mb-2">
            Empieza a tener control de tu dinero sin complicarte.
        </p>
        <p class="text-white/70 mb-6">
            Agenda una demo gratuita y conoce cómo funciona Admin JR.
        </p>
        <a href="#"
           class="inline-block bg-red-600 hover:bg-red-700 transition
                  text-white font-semibold px-8 py-3 rounded-xl">
            Crea una cuenta
        </a>
    </div>
</section>

<script>
function toggleFaq(button) {
    const content = button.nextElementSibling;
    const icon = button.querySelector('span');

    content.classList.toggle('hidden');
    icon.textContent = content.classList.contains('hidden') ? '+' : '−';
}
</script>

    <!-- CTA -->
<section class="mt-32 flex justify-center">
    <div class="relative w-full max-w-4xl bg-white/10 p-10 rounded-2xl border border-white/10 text-center overflow-hidden">

        <!-- glow -->
        <div class="absolute inset-0 -z-10 flex justify-center items-center">
            <div class="w-[60%] h-[60%] bg-red-600/20 blur-3xl rounded-full"></div>
        </div>

        <h3 class="text-3xl font-extrabold text-white mb-4">
            Activa tu
            <span class="text-red-600">asistente financiero</span>
        </h3>

        <p class="text-white/70 mb-8 max-w-2xl mx-auto leading-relaxed">
            <!---Deja atrás el
            <span class="text-white font-medium">Excel</span>
            y las
            <span class="text-white font-medium">notas de papel</span>.
            <br>--->
            Configura tu cuenta en segundos y comienza a recibir
            <span class="text-red-600 font-medium">reportes automáticos</span>
            que te permiten
            <span class="text-white font-medium">controlar tu administración</span>
            desde hoy mismo.
        </p>

        <a href="{{ route('register') }}"
           class="inline-block px-12 py-4 rounded-full bg-red-600 hover:bg-red-700 transition font-semibold text-white shadow-lg shadow-red-600/30">
            Crear cuenta
        </a>
    </div>
</section>


</main>

<!-- FOOTER (SIN CAMBIOS) -->
<footer class="bg-white text-black border-t border-gray-200">
    <div class="max-w-7xl mx-auto px-6 py-12 grid grid-cols-1 md:grid-cols-5 gap-8 items-start">

        <div class="md:col-span-2 space-y-3">
            <div class="flex items-center gap-3">
                <img src="{{ asset('avaspace.svg') }}" alt="Avaspace" class="h-10">
                <h2 class="text-xl font-semibold">Controla tus gastos</h2>
            </div>
            <p class="text-sm text-gray-600 max-w-sm">
                Convierte tus números en decisiones inteligentes para hacer crecer tu negocio.
            </p>
        </div>

        <div class="space-y-2 text-sm">
            <h3 class="font-semibold">Avisos</h3>
            <ul class="space-y-1 text-gray-600">
                <li><a href="{{ route('aviso-de-privacidad') }}">Aviso de privacidad</a></li>
                <li><a href="{{ route('terminos') }}">Términos y condiciones</a></li>
            </ul>
        </div>

        <div class="space-y-2 text-sm">
            <h3 class="font-semibold">Equipo</h3>
            <ul class="space-y-1 text-gray-600">
                <li><a href="{{ route('nosotros') }}">Nosotros</a></li>
            </ul>
        </div>

        <div class="space-y-2 text-sm">
            <h3 class="font-semibold">Social</h3>
            <ul class="space-y-1 text-gray-600">
                <li><a href="https://www.facebook.com/avaspace.io">Facebook</a></li>
                <li><a href="https://www.instagram.com/avaspace.io/">Instagram</a></li>
                <li><a href="https://www.youtube.com/@avaspace">YouTube</a></li>
            </ul>
        </div>
    </div>

    <div class="border-t border-gray-200 py-4 text-center text-xs text-gray-500">
        © {{ date('Y') }} Avaspace. Todos los derechos reservados.
    </div>
</footer>

</body>
</html>