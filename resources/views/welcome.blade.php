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
<script>
document.addEventListener("DOMContentLoaded", function () {
    const menuBtn = document.getElementById('menuBtn');
    const mobileMenu = document.getElementById('mobileMenu');
    const navBar = document.getElementById('navBar');

    // Toggle menú móvil
    menuBtn.addEventListener('click', function () {
        mobileMenu.classList.toggle('hidden');
    });

    // Efecto scroll (transparencia)
    window.addEventListener('scroll', function () {
        if (window.scrollY > 50) {
            navBar.classList.add('bg-black/60','backdrop-blur-md','shadow-2xl');
            navBar.classList.remove('bg-white/5','backdrop-blur-sm');
        } else {
            navBar.classList.remove('bg-black/60','backdrop-blur-md','shadow-2xl');
            navBar.classList.add('bg-white/5','backdrop-blur-sm');
        }
    });
});
</script>

<!--CHAT BOT-->
<script>
function sendMessage() {
    const input = document.getElementById("userInput");
    const chatBox = document.getElementById("chatBox");

    const text = input.value.trim();
    if (!text) return;

    // Mensaje del usuario
    const userMsg = document.createElement("div");
    userMsg.className = "bg-green-400 text-black p-2 rounded-full w-fit ml-auto text-sm";
    userMsg.innerText = text;
    chatBox.appendChild(userMsg);

    input.value = "";

    // Simular respuesta con delay
    setTimeout(() => {
        const botMsg = document.createElement("div");
        botMsg.className = "bg-black/40 p-3 rounded-xl text-sm space-y-1";

        // Extraer número (monto)
        const amountMatch = text.match(/\d+/);
        const amount = amountMatch ? amountMatch[0] : "0";

        // Extraer concepto
        const description = text.replace(/\d+/g, "").trim() || "Gasto";

        const today = new Date().toLocaleDateString("es-MX");

        botMsg.innerHTML = `
            ✅ <b>¡Listo! Gasto registrado</b><br>
            💰 Valor: $${amount} MXN<br>
            📅 Fecha: ${today}<br>
            🏷 Categoría: Alimentación<br>
            📝 Descripción: ${description}<br>
            💳 Método de pago: Efectivo
        `;

        chatBox.appendChild(botMsg);

        chatBox.scrollTop = chatBox.scrollHeight;

    }, 800);
}
</script>

<body class="min-h-screen bg-gradient-to-br from-black via-[#0f1115] to-[#1a1d23] text-white overflow-x-hidden">
<!-- HEADER -->
<header id="mainHeader" class="fixed top-0 left-0 w-full z-50 flex justify-center pt-4 px-3 transition-all duration-300">
    <nav id="navBar" class="
        flex items-center justify-between
        w-full max-w-5xl
        rounded-full
        px-6 py-4
        bg-white/5
        backdrop-blur-sm
        border border-white/10
        shadow-lg
        transition-all duration-300
        relative">

        <!-- LOGO -->
        <div class="flex items-center gap-2">
            <img src="{{ asset('avaspace.svg') }}"
                    alt="Avaspace"
                    class="h-7 sm:h-8">
        </div>

        <!-- MENU DESKTOP -->
        <div class="hidden md:flex items-center gap-8 text-sm text-white/80
                absolute left-1/2 -translate-x-1/2">
        <a href="#contacto" class="hover:text-white transition">Contacto</a>
        <a href="#funciones" class="hover:text-white transition">Funciones</a>
        <a href="#precios" class="hover:text-white transition">Precios</a>
        <a href="{{ route('login') }}" class="hover:text-white transition">Iniciar sesión</a>
        <a href="{{ route('register') }}" class="hover:text-white transition">Crear cuenta</a>
    </div>

</div>

            <!-- BOTÓN HAMBURGUESA -->
            <button id="menuBtn" class="md:hidden text-white ml-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>
        </div>

        <!-- MENU MÓVIL -->
        <div id="mobileMenu" class="
            absolute top-full right-4 mt-4
            hidden
            w-52
            bg-black/90
            backdrop-blur-xl
            border border-white/10
            rounded-2xl
            shadow-2xl
            p-4
            space-y-3
            text-white
        ">
            <a href="#contacto" class="block hover:text-red-500">Contacto</a>
            <a href="#funciones" class="block hover:text-red-500">Funciones</a>
            <a href="#precios" class="block hover:text-red-500">Precios</a>

            <hr class="border-white/10">

            <a href="{{ route('login') }}" class="block text-center bg-red-600 hover:bg-red-700 transition
                      text-white font-medium py-2 rounded-xl">
                Iniciar sesión
            </a>

            <a href="{{ route('register') }}"
               class="block text-center bg-red-600 hover:bg-red-700 transition
                      text-white font-medium py-2 rounded-xl">
                Crear cuenta
            </a>
        </div>

    </nav>
</header>
<section class="relative pt-44 pb-36 flex flex-col items-center text-center overflow-hidden">

    <!-- Glow principal -->
    <div class="absolute inset-0 -z-20 flex justify-center items-center">
        <div class="w-[65%] h-[65%] bg-red-700/20 blur-[140px] rounded-full"></div>
    </div>

    <!-- Glow secundario -->
    <div class="absolute top-1/4 -z-10 w-[420px] h-[420px] bg-red-600/20 blur-[160px] rounded-full"></div>

    <!-- Badge -->
    <div class="mb-8 px-6 py-2.5 rounded-full
                bg-white/5 border border-white/10
                backdrop-blur-xl text-sm text-white/80
                flex items-center gap-3 shadow-lg shadow-red-600/10">

        <div class="w-6 h-6 flex items-center justify-center">
            <img src="{{ asset('avaspace.svg') }}" alt="Avaspace" class="h-7">
        </div>

        <span class="tracking-wide">
            Tu asistente financiero inteligente
        </span>
    </div>

    <!-- Título -->
    <h2 class="text-4xl md:text-6xl xl:text-7xl font-semibold leading-[1.05] max-w-5xl">
        Organiza tu dinero sin abrir planillas<br>
        Solo envía un <span class="text-red-500">WhatsApp</span>.
    </h2>

    <!-- Subrayado decorativo -->
    <div class="mt-4 w-24 h-[3px] bg-gradient-to-r from-transparent via-red-500 to-transparent"></div>

    <!-- Descripción -->
    <p class="mt-8 text-lg md:text-xl text-white/70 max-w-2xl leading-relaxed">
        Con un solo mensaje a 
        <span class="text-red-500 font-medium">Admin JR</span>,
        la IA categoriza, suma y actualiza tu
        <span class="text- font-medium">panel financiero</span>
        al instante.
    </p>
    <!-- IMAGEN -->
<div class="mt-12 flex justify-center">
    <div class="relative w-full max-w-sm rounded-2xl backdrop-blur-xl shadow-2xl">
       <img src="{{ asset('images/mockup2.png') }}"
             alt="Mockup Admin JR"
             class="w-full h-auto object-contain">
    </div>
</div>

</section>
<section class="relative pt-32 pb-16 flex flex-col items-center text-center overflow-hidden">

    <!-- Glow -->
    <div class="absolute inset-0 -z-10 flex justify-center items-center">
        <div class="w-[70%] h-[70%] bg-red-500/20 blur-3xl rounded-full"></div>
    </div>

    <!-- Título -->
    <h2 class="text-4xl md:text-6xl font-medium leading-tight max-w-5xl">
       Controla tus
                <span class="text-red-500 font-bold">finanzas</span>
                o las de
                <span class="text-red-500 font-bold">tu negocio</span>
                con un mensaje de
                <span class="text-red-500 font-bold">WhatsApp</span>
    </h2>

    <!-- Subtítulo -->
    <p class="mt-8 text-lg md:text-xl text-white/70 max-w-2xl">
        Reporta tus
                <span class="text-red-500 font-medium">ventas y gastos</span>
                por <span class="text-red-500 font-medium">WhatsApp</span>
                y recibe
                <span class="text-white font-medium">resúmenes automáticos</span>
                de tu dinero al instante.
    </p>
    
</section>
<!-- VIDEO -->
<section class="relative mt-24 flex flex-col items-center">

    <div class="relative w-full max-w-5xl rounded-2xl overflow-hidden bg-white/10 backdrop-blur-xl border border-white/10 shadow-2xl">
        <div class="flex items-center gap-2 px-4 py-3 bg-black/40">
            <span class="w-3 h-3 bg-red-500 rounded-full"></span>
            <span class="w-3 h-3 bg-yellow-400 rounded-full"></span>
            <span class="w-3 h-3 bg-green-500 rounded-full"></span>
        </div>

        <div class="aspect-video">
            <iframe class="w-full h-full"
                    src="https://www.youtube.com/embed/qeDBw6sXNTw"
                    allowfullscreen>
            </iframe>
        </div>
    </div>

    <!-- TEXTO DEBAJO DEL VIDEO -->
    <p class="mt-6 text-white/70 text-center max-w-3xl text-lg">
        Mira cómo puedes registrar tus gastos en segundos usando solo WhatsApp
        y llevar el control de tus finanzas sin planillas ni complicaciones.
    </p>

</section>

<!-- MAIN -->
<main class="max-w-7xl mx-auto px-6 pt-24 pb-24 relative">

<!-- HERO -->
<section class="relative mt-32 flex flex-col items-center text-center">

    <h2 class="text-4xl md:text-5xl font-medium mb-4">
        Compruébalo por <span class="text-red-600">ti mismo ahora.</span>
    </h2>

    <p class="text-white/70 mb-10">
        Escribe un gasto abajo (Ej: "Pizza 200") y mira la magia:
    </p>

    <!-- CHAT -->
    <div id="chatBox"
         class="w-full max-w-xl bg-white/5 backdrop-blur-xl border border-white/10 rounded-2xl p-4 space-y-3 text-left">

        <div class="bg-black/40 p-3 rounded-xl text-sm">
             💬 Hola, soy AdminJr, tu asistente financiero por WhatsApp.
        </div>

    </div>

    <!-- INPUT -->
    <div class="mt-4 w-full max-w-xl flex gap-2">
        <input id="userInput"
               type="text"
               placeholder="Escribe tu gasto aquí..."
               class="flex-1 bg-white/5 border border-white/10 rounded-full px-5 py-3 outline-none text-white">

        <button onclick="sendMessage()"
                class="bg-green-500 hover:bg-green-600 text-black px-6 rounded-full">
            ➤
        </button>
    </div>

</section>

<script src="/js/chat-demo.js"></script>
<!---<section class="max-w-7xl mx-auto px-6 pt-24 pb-32 relative overflow-hidden">

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">--->

        <!-- TEXTO -->
         
        <!---<div class="space-y-8 text-center lg:text-left">-->
           <!-- glow decorativo -->
        <!---<div class="absolute inset-0 -z-10 flex justify-center items-center">
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

        </div>-->

        <!-- MOCKUP -->
<!--<div class="flex justify-center relative font-montserrat">-->

    <!-- GLOW -->
    <!---<div class="absolute -z-10 w-[460px] h-[460px] bg-red-600/15 blur-[160px] rounded-full"></div>-->

    <!-- FRAME -->
    <!--<div class="relative bg-white/5 backdrop-blur-xl
                border border-white/10 rounded-3xl p-8 shadow-2xl">--->

        <!-- PHONE -->
        <!---<div class="w-[310px] rounded-[2.6rem]
                    bg-[#111827] border border-white/10 overflow-hidden">-->

            <!-- TOP BAR -->
            <!----<div class="px-5 py-4 flex items-center gap-3
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
            </div>---->

            <!-- CHAT -->
            <!---<div class="bg-[#F4F5F7] px-5 py-6 space-y-5 text-[13px] text-left">-->

                <!-- USER -->
                <!---<div class="flex justify-end">
                    <div class="bg-white px-4 py-3 rounded-2xl
                                max-w-[80%] shadow text-black leading-relaxed">
                        💸 Venta del día $2,500<br>
                        💳 pago con tarjeta
                    </div>
                </div>-->

                <!-- ADMIN JR -->
                <!---<div class="flex justify-start">
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
                </div>--->

                <!-- RESUMEN -->
                <!---<div class="flex justify-start">
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

</div>----->
</section>

    

<!-- INFO -->
<section class="mt-32 grid md:grid-cols-2 gap-16 items-center">

    <!-- TEXTO -->
    <div class="relative space-y-6">

        <!-- glow decorativo -->
        <div class="absolute inset-0 -z-10 flex justify-center items-center">
            <div class="w-[60%] h-[60%] bg-red-600/20 blur-3xl rounded-full"></div>
        </div>

        <!-- Título -->
        <h2 class="text-4xl md:text-6xl xl:text-7xl font-semibold leading-[1.05] max-w-5xl">
            Organiza tu dinero sin abrir planillas<br>
            Solo envía un <span class="text-red-500">WhatsApp</span>.
        </h2>

        <!-- Subrayado decorativo -->
        <div class="mt-4 w-24 h-[3px] bg-gradient-to-r from-transparent via-red-500 to-transparent"></div>

        <!-- Descripción -->
        <p class="mt-8 text-lg md:text-xl text-white/70 max-w-2xl leading-relaxed">
            Con un solo mensaje a 
            <span class="text-red-500 font-medium">Admin JR</span>,
            la IA categoriza, suma y actualiza tu
            <span class="font-medium">panel financiero</span>
            al instante.
        </p>
    </div>

    <!-- IMAGEN -->
    <div class="flex justify-center md:justify-end">
        <div class="relative w-full max-w-sm rounded-2xl overflow-hidden border border-white/10 bg-white/5 backdrop-blur-xl shadow-2xl">
            <img src="{{ asset('images/mockup3.png') }}"
                 alt="Mockup Admin JR"
                 class="w-full h-auto object-contain">
        </div>
    </div>

</section>

<section class="mt-32 overflow-hidden">
    <h3 class="text-3xl font-extrabold text-center mb-16 text-white">
        Todo el poder de Admin JR, <span class="text-red-600">a un mensaje de distancia</span>
    </h3>

    <div class="relative w-full flex justify-center items-center">
        <div id="carousel" class="carousel-3d">

            <!-- CARD 1 -->
            <div class="card-3d">
                <div class="flex justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg"
        viewBox="0 0 24 24"
        fill="currentColor"
        class="w-12 h-12 text-red-600">
    <path d="M12 2C6.48 2 2 6.02 2 11.5S6.48 21 12 21s10-4.02 10-9.5S17.52 2 12 2zm1 15.93V19h-2v-1.07c-1.72-.2-3-1.39-3-3.01h2c0 .83.67 1.5 1.5 1.5S13 15.75 13 15s-.67-1.5-1.5-1.5c-1.93 0-3.5-1.57-3.5-3.5 0-1.62 1.28-2.81 3-3.01V5h2v1.07c1.72.2 3 1.39 3 3.01h-2c0-.83-.67-1.5-1.5-1.5S11 8.25 11 9s.67 1.5 1.5 1.5c1.93 0 3.5 1.57 3.5 3.5 0 1.62-1.28 2.81-3 3.01z"/>
    </svg>
</div>
                <h4 class="text-xl font-semibold text-white">Registro en <span class="text-red-500">3 segundos</span></h4>
                <p class="text-white/70">Registra ventas y gastos con un simple mensaje de WhatsApp.
                        Sin Excel, sin computadora, sin complicaciones.</p>
            </div>

            <!-- CARD 2 -->
            <div class="card-3d">
                <div class="flex justify-center">
               <svg xmlns="http://www.w3.org/2000/svg"
     viewBox="0 0 24 24"
     fill="currentColor"
     class="w-12 h-12 text-red-600">
  <path d="M12 22c1.1 0 2-.9 2-2h-4c0 
           1.1.9 2 2 2zm6-6v-5c0-3.07-1.63-5.64-4.5-6.32V4
           c0-.83-.67-1.5-1.5-1.5S10.5 3.17 10.5 4v.68
           C7.63 5.36 6 7.92 6 11v5l-2 2v1h16v-1l-2-2z"/>
</svg>
</div>
                <h4 class="text-xl font-semibold text-white">Recordatorios <span class="text-red-500">inteligentes</span></h4>
                <p class="text-white/70">Tu asistente te avisa qué falta por reportar...</p>
            </div>

            <!-- CARD 3 -->
            <div class="card-3d">
                <div class="flex justify-center">
                <svg xmlns="http://www.w3.org/2000/svg"
                    viewBox="0 0 24 24"
                    fill="currentColor"
                    class="w-12 h-12 text-red-600">
                    <path d="M4 9h3v11H4V9zm6-5h3v16h-3V4zm6 8h3v8h-3v-8z"/>
                </svg>
            </div>
                <h4 class="text-xl font-semibold text-white">Resumen <span class="text-red-500">24/7</span></h4>
                <p class="text-white/70">Resúmenes y gráficos dinámicos...</p>
            </div>

        </div>
    </div>

    <!-- BOTONES -->
    <div class="flex justify-center gap-4 mt-8">
    <button onclick="prevCard()"
        class="w-12 h-12 flex items-center justify-center bg-red-600 hover:bg-red-700 transition rounded-full">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-white"
             fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round"
                  d="M15 19l-7-7 7-7" />
        </svg>
    </button>

    <button onclick="nextCard()"
        class="w-12 h-12 flex items-center justify-center bg-red-600 hover:bg-red-700 transition rounded-full">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-white"
             fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round"
                  d="M9 5l7 7-7 7" />
        </svg>
    </button>
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

<!-- PLAN + CTA -->
<div class="mt-12 flex flex-col items-center gap-8">

    <!-- CARD PLAN -->
    <div class="relative w-full max-w-md bg-white/5 backdrop-blur-xl border border-white/10 rounded-2xl p-8 text-center shadow-2xl">

        <!-- glow -->
        <div class="absolute inset-0 -z-10 flex justify-center items-center">
            <div class="w-[70%] h-[70%] bg-red-600/20 blur-3xl rounded-full"></div>
        </div>

        <h3 class="text-2xl font-bold mb-2">
            Plan basico
        </h3>

        <p class="text-red-500 text-4xl font-extrabold mb-1">
            $459 / mes
        </p>
        
         <p class="text-white/70 mb-6">
            Facturas mensuales
        </p>

        <p class="text-white/70 mb-6">
            Todo lo que necesitas para controlar tu dinero por WhatsApp.
        </p>

        <ul class="space-y-3 text-left text-white/80 mb-6">
            <li>✅ Hasta 3 números WhatsApp</li>
            <li>✅ 5 cuentas conectadas</li>
            <li>✅ Reportes básicos</li>
            <li>✅ Soporte por email</li>
        </ul>

        <a href="{{ route('register') }}"
           class="inline-block bg-red-600 hover:bg-red-700 transition
                  text-white font-semibold px-6 py-3 rounded-xl">
            Empieza ahora
        </a>
    </div>

    <!-- CTA -->
    <!--- class="text-center">
        <p class="text-white text-lg mb-2">
            Empieza a tener control de tu dinero sin complicarte.
        </p>
        <p class="text-white/70 mb-6">
            Agenda una demo gratuita y conoce cómo funciona Admin JR.
        </p>
        <a href="{{ route('register') }}"
           class="inline-block bg-red-600 hover:bg-red-700 transition
                  text-white font-semibold px-8 py-3 rounded-xl">
            Crea una cuenta
        </a>--->
    </div>

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
<script>
const cards = document.querySelectorAll(".card-3d");
let current = 0;

function updateCarousel() {
    cards.forEach((card, index) => {
        const offset = index - current;

        if (offset === 0) {
            card.style.transform = "translateX(0) translateZ(200px) scale(1)";
            card.style.opacity = "1";
            card.style.zIndex = "3";
        } 
        else if (offset === -1 || offset === cards.length - 1) {
            card.style.transform = "translateX(-220px) translateZ(0) scale(0.8)";
            card.style.opacity = "0.5";
            card.style.zIndex = "2";
        } 
        else if (offset === 1 || offset === -(cards.length - 1)) {
            card.style.transform = "translateX(220px) translateZ(0) scale(0.8)";
            card.style.opacity = "0.5";
            card.style.zIndex = "2";
        } 
        else {
            card.style.transform = "translateX(0) translateZ(-200px) scale(0.6)";
            card.style.opacity = "0";
            card.style.zIndex = "1";
        }
    });
}

function nextCard() {
    current = (current + 1) % cards.length;
    updateCarousel();
}

function prevCard() {
    current = (current - 1 + cards.length) % cards.length;
    updateCarousel();
}

updateCarousel();
</script>
<style>
    .carousel-3d {
    position: relative;
    width: 100%;
    max-width: 900px;
    height: 350px;
    transform-style: preserve-3d;
    perspective: 1200px;
}

.card-3d {
    position: absolute;
    width: 280px;
    height: 320px;
    background: rgba(255,255,255,0.08);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255,255,255,0.1);
    border-radius: 1.5rem;
    padding: 1.5rem;
    text-align: center;
    transition: transform 0.8s ease, opacity 0.8s ease;
}
.carousel-3d {
    position: relative;
    width: 100%;
    max-width: 900px;
    height: 350px;
    transform-style: preserve-3d;
    perspective: 1200px;

    display: flex;
    justify-content: center;
    align-items: center;
}

.card-3d {
    position: absolute;
    left: 50%;
    top: 50%;
    transform-style: preserve-3d;
    transform-origin: center center;
    translate: -50% -50%;
}
</style>