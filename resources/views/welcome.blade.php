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

<script>
function detectCategory(text) {
    const lower = text.toLowerCase();

    if (lower.includes("comida") || lower.includes("taco") || lower.includes("pizza") || lower.includes("hamburguesa")) {
        return "Alimentación";
    }
    if (lower.includes("uber") || lower.includes("taxi") || lower.includes("bus") || lower.includes("camión")) {
        return "Transporte";
    }
    if (lower.includes("renta") || lower.includes("casa") || lower.includes("luz") || lower.includes("agua")) {
        return "Hogar";
    }
    if (lower.includes("netflix") || lower.includes("spotify") || lower.includes("internet")) {
        return "Servicios";
    }
    if (lower.includes("doctor") || lower.includes("farmacia") || lower.includes("medicina")) {
        return "Salud";
    }
    if (lower.includes("ropa") || lower.includes("zapatos")) {
        return "Ropa";
    }

    return "Otros";
}

function detectPaymentMethod(text) {
    const lower = text.toLowerCase();

    if (lower.includes("tarjeta") || lower.includes("credito") || lower.includes("crédito") || lower.includes("debito") || lower.includes("débito")) {
        return "Tarjeta";
    }
    if (lower.includes("transferencia") || lower.includes("spei")) {
        return "Transferencia";
    }
    if (lower.includes("efectivo") || lower.includes("cash")) {
        return "Efectivo";
    }

    return "Efectivo";
}

function cleanDescription(text) {
    return text
        .replace(/\d+/g, "") // quitar números
        .replace(/tarjeta|credito|crédito|debito|débito|efectivo|transferencia|spei|cash/gi, "")
        .trim();
}

function sendMessage() {
    const input = document.getElementById("userInput");
    const chatBox = document.getElementById("chatBox");

    const text = input.value.trim();
    if (!text) return;

    // Mensaje usuario
    const userMsg = document.createElement("div");
    userMsg.className = "bg-red-700 text-white p-2 rounded-full w-fit ml-auto text-sm";
    userMsg.innerText = text;
    chatBox.appendChild(userMsg);

    input.value = "";

    setTimeout(() => {
        const botMsg = document.createElement("div");
        botMsg.className = "bg-black/40 p-3 rounded-xl text-white space-y-1";

        const amountMatch = text.match(/\d+/);
        const amount = amountMatch ? amountMatch[0] : "0";

        const category = detectCategory(text);
        const paymentMethod = detectPaymentMethod(text);

        const description = cleanDescription(text) || "Gasto";

        const today = new Date().toLocaleDateString("es-MX");

        botMsg.innerHTML = `
            ✅ <b>¡Listo! Gasto registrado</b><br>
            💰 Valor: $${amount} MXN<br>
            📅 Fecha: ${today}<br>
            🏷 Categoría: ${category}<br>
            📝 Descripción: ${description}<br>
            💳 Método de pago: ${paymentMethod}
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
<div class="hidden md:flex items-center text-sm text-white/80
        absolute left-1/2 -translate-x-1/2
        gap-10">

    <a href="{{ route('nosotros') }}" class="hover:text-white transition">Contacto</a>
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
            <a href="{{ route('nosotros') }}" class="block hover:text-red-500">Contacto</a>
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

    <!-- Glow armónico centrado -->
<div class="absolute inset-0 -z-20 flex justify-center items-center pointer-events-none">
    <div class="w-[900px] h-[900px] rounded-full 
                bg-gradient-to-br from-red-600/40 via-red-500/25 to-transparent 
                blur-[160px]">
    </div>
</div>

    <!-- Badge -->
    <div class="mb-8 px-6 py-2.5 rounded-full
                bg-white/5 border border-white/10
                backdrop-blur-xl text-sm text-white/80
                flex items-center gap-3 shadow-lg shadow-red-600/10">

        <div class="w-6 h-6 flex items-center justify-center">
            <img src="{{ asset('avaspace.svg') }}" alt="Avaspace" class="h-7">
        </div>

        <span class="tracking-wide">
            Tu asistente administrativo inteligente
        </span>
    </div>

    <!-- Título -->
   <h1 class="text-4xl md:text-6xl xl:text-7xl 
           font-light tracking-tight 
           leading-[1.08] 
           max-w-4xl mx-auto">
    Si sabes enviar un 
    <span class="text-red-500">WhatsApp</span>,<br>
    puedes dominar tus finanzas<br>
    como un <span class="text-red-500 relative">
        experto.
</h1>
    <!-- Subrayado decorativo -->
    <div class="mt-4 w-24 h-[3px] bg-gradient-to-r from-transparent via-red-500 to-transparent"></div>

    <!-- Descripción -->
<p class="mt-8 text-lg md:text-xl text-white/70 
            max-w-2xl mx-auto 
            leading-relaxed">
    Olvídate de planillas y procesos complicados.
    <span class="text-red-500 font-medium">Admin JR</span> 
    organiza, categoriza y actualiza 
    tu panel financiero al instante.
    <span class="text-white font-medium">Simple</span>
    , 
    <span class="text-white font-medium"> rápido</span>
    y 
    <span class="text-white font-medium"> sin esfuerzo.</span> 
</p>
<!-- IMAGEN -->
<div class="mt-12 flex justify-center">
<div class="relative w-full max-w-sm group">

    <!-- Glow -->
    <div class="absolute inset-0 rounded-2xl 
                bg-gradient-to-r from-red-500 via-pink-500 to-purple-500
                blur-2xl opacity-40"></div>

    <!-- Imagen -->
    <img src="{{ asset('images/mockup1.png') }}"
            alt="Mockup Admin JR"
            class="relative w-full h-auto object-contain rounded-2xl">

    <!-- Tooltip 1 -->
    <div class="absolute top-20 -left-20
                opacity-0 translate-x-4
                group-hover:opacity-100 group-hover:translate-x-0
                transition duration-500 ease-out
                bg-white/10 backdrop-blur-xl
                border border-white/20
                text-white text-sm px-4 py-2 rounded-xl
                shadow-[0_0_20px_rgba(255,0,0,0.4)]">
        <span class="block"> Categorizado automáticamente</span>
        <span class="absolute top-1/2 -right-2 w-3 h-3 
                    bg-white/10 border-r border-t border-white/20
                    rotate-45"></span>
    </div>

    <!-- Tooltip 2 -->
    <div class="absolute top-40 -right-20
                opacity-0 -translate-x-4
                group-hover:opacity-100 group-hover:translate-x-0
                transition duration-500 delay-150 ease-out
                bg-white/10 backdrop-blur-xl
                border border-white/20
                text-white text-sm px-4 py-2 rounded-xl
                shadow-[0_0_20px_rgba(236,72,153,0.4)]">
        Procesado en segundos
        <span class="absolute top-1/2 -left-2 w-3 h-3 
                    bg-white/10 border-l border-b border-white/20
                    rotate-45"></span>
        </div>

    <!-- Tooltip 3 -->
    <div class="absolute bottom-32 -right-12
                opacity-0 -translate-y-4
                group-hover:opacity-100 group-hover:translate-y-0
                transition duration-500 delay-300 ease-out
                bg-white/10 backdrop-blur-xl
                border border-white/20
                text-white text-sm px-4 py-2 rounded-xl
                shadow-[0_0_20px_rgba(147,51,234,0.4)]">
                Registro de tus finanzas
        <span class="absolute top-full left-6 w-3 h-3 
                    bg-white/10 border-l border-t border-white/20
                    rotate-45"></span>
        </div>

</div>
</div>
<!-- Botón CTA -->
<div class="mt-10">
    <a href="{{ route('register') }}"
       class="inline-flex items-center gap-3 px-8 py-4
              bg-red-600 hover:bg-red-500
              text-white font-medium text-lg
              rounded-full
              transition duration-300
              shadow-lg shadow-red-600/30
              hover:shadow-red-500/50
              hover:scale-105">
        Comenzar ahora
    </a>
</div>
</section>
<section class="relative pt-32 pb-16 flex flex-col items-center text-center">

    <!-- Glow -->
    <div class="absolute inset-0 -z-10 flex justify-center items-center">
        <div class="w-[70%] h-[70%] bg-red-500/20 blur-3xl rounded-full"></div>
    </div>

     <!-- Titular -->
    <h1 class="text-4xl md:text-6xl xl:text-7xl 
               font-light tracking-tight 
               leading-[1.08] 
               max-w-4xl mx-auto">
        Para el emprendedor<br>
        <span class="text-red-500">sobrecargado</span><br>
        que odia la contabilidad manual
    </h1>

    <!-- Línea decorativa -->
    <div class="mt-6 w-20 h-[3px] bg-gradient-to-r from-transparent via-red-500 to-transparent"></div>

    <!-- Subtítulo -->
    <p class="mt-8 text-lg md:text-xl text-white/70 
              max-w-2xl mx-auto leading-relaxed">
        Descubre la fortuna que se esconde en tu flujo de caja.
        Reporta ventas y gastos por 
        <span class="text-red-500 font-medium">WhatsApp</span>
        y deja que 
        <span class="text-red-500 font-medium">Admin JR</span>
        genere tus resúmenes financieros
        mientras tú te enfocas en crecer.
    </p>
    <div class="mt-12 flex justify-center">

   <!-- Imagen con glow elegante -->
    <div class="mt-16 relative w-full max-w-md">

        <!-- Glow detrás de la imagen -->
        <div class="absolute inset-0 rounded-2xl 
                    bg-gradient-to-r from-red-500 via-pink-500 to-purple-500
                    blur-2xl opacity-70">
        </div>

        <!-- Imagen -->
        <img src="{{ asset('images/mockupgif.gif') }}"
             alt="Mockup Admin JR"
             class="relative w-full h-auto object-contain rounded-2xl">
    </div>


</div>
</div>
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

    <div class="mt-10">
    <a href="{{ route('register') }}"
       class="inline-flex items-center gap-3 px-8 py-4
              bg-red-600 hover:bg-red-500
              text-white font-medium text-lg
              rounded-full
              transition duration-300
              shadow-lg shadow-red-600/30
              hover:shadow-red-500/50
              hover:scale-105">
        Crear cuenta
    </a>
</div>

</section>

<!-- MAIN -->
<main class="max-w-7xl mx-auto px-6 pt-24 pb-24 relative">

<!-- HERO -->
    <section class="relative mt-32 flex flex-col items-center text-center">
        <!-- Glow secundario -->
        <div class="absolute top-1/4 -z-10 w-[420px] h-[420px] bg-red-700/20 blur-[160px] rounded-full"></div>

        <div class="max-w-3xl mx-auto text-center">

    <!-- TITULO -->
    <h2 class="text-4xl md:text-5xl lg:text-6xl font-light leading-[1.1] tracking-tight mb-6">
        Si sabes enviar un 
        <span class="text-red-500">mensaje</span>,
        ya sabes dominar tus 
        <span class="text-red-500">finanzas.</span>
    </h2>

    <!-- SUBTITULO -->
    <p class="text-lg md:text-xl text-white/70 leading-relaxed max-w-2xl mx-auto">
        Compruébalo por ti mismo ahora. 
        Escribe cualquier gasto abajo y deja que la 
       IA 
        haga el trabajo por ti.
    </p>
<br>
</div>
        <!-- PANEL -->
        <div class="w-full max-w-xl border border-white/10 rounded-xl">

            <!-- CHAT -->
            <div id="chatBox"
                class="bg-white/5 backdrop-blur-xl rounded-xl p-4 space-y-3 text-left">

                <div class="bg-black/40 p-3 rounded-lg text-sm border border-white/10">
                    💬 Hola, soy AdminJr, tu asistente administrativo por WhatsApp.
                </div>

            </div>
        </div>

        <!-- INPUT -->
        <div class="mt-6 w-full max-w-xl flex gap-2">

            <input id="userInput"
                type="text"
                placeholder="Escribe tu gasto aquí..."
                class="flex-1 bg-transparent border border-white/15
                        rounded-full px-5 py-3 outline-none text-white
                        focus:border-white/30 transition">

            <button onclick="sendMessage()"
                    class="border border-white/15 hover:border-white/30 transition
                        text-white px-6 rounded-full">
                ➤
            </button>
        </div>

    </section>

<script src="/js/chat-demo.js"></script>
<!-- SECCIÓN 4 -->
<section class="mt-32 grid md:grid-cols-2 gap-16 items-center px-6 max-w-6xl mx-auto">

    <!-- TEXTO -->
    <div class="relative space-y-8">

        <!-- Glow decorativo -->
        <div class="absolute inset-0 -z-10 flex justify-center items-center">
            <div class="w-[60%] h-[60%] bg-red-700/20 blur-3xl rounded-full"></div>
        </div>

        <!-- Título -->
        <h2 class="text-4xl md:text-6xl xl:text-7xl font-light leading-[1.05] tracking-tight text-white">
            Despídete de la 
            <span class="text-red-500">ansiedad financiera</span>
            para siempre.
        </h2>

        <!-- Línea decorativa -->
        <div class="w-24 h-[3px] bg-gradient-to-r from-transparent via-red-500 to-transparent"></div>

        <!-- Subtítulo -->
        <p class="text-lg md:text-xl text-white/70 max-w-xl leading-relaxed">
            La claridad es poder. Al ver tu dinero organizado en 
            <span class="text-white font-medium">tiempo real</span>,
            recuperas el control y la tranquilidad que necesitas
            para hacer crecer tu 
            <span class="text-red-500 font-medium">negocio</span> 
            o tu ahorro personal.
        </p>

    </div>


    <!-- IMAGEN -->
    <div class="flex justify-center">
        <div class="relative w-full max-w-sm">

            <!-- Glow de fondo -->
            <div class="absolute inset-0 rounded-2xl 
                        bg-gradient-to-r from-red-500 via-pink-500 to-purple-500
                        blur-2xl opacity-60">
            </div>

            <!-- Contenedor imagen -->
            <div class="relative rounded-2xl overflow-hidden
                        border border-white/10
                        bg-white/5 backdrop-blur-xl shadow-2xl">

                <img src="{{ asset('images/mockup3.png') }}"
                     alt="Mockup Admin JR"
                     class="w-full h-auto object-contain rounded-2xl">

            </div>

        </div>
    </div>

</section>
<section id="funciones" class="mt-40 relative overflow-hidden px-6">

    <div class="relative z-10 max-w-6xl mx-auto">

        <!-- TITULO -->
        <div class="text-center mb-20">
            <h3 class="text-3xl md:text-5xl font-light text-white mb-6 tracking-tight">
                Control total de tu negocio,
                <span class="text-red-600 font-normal">desde WhatsApp</span>
            </h3>

            <p class="text-white/60 max-w-2xl mx-auto text-lg leading-relaxed">
                Admin JR convierte cada mensaje en información organizada,
                reportes automáticos y decisiones más inteligentes.
            </p>
        </div>

        <!-- CAROUSEL -->
        <div class="relative w-full flex justify-center items-center">
            <div id="carousel" class="carousel-3d">

                <!-- CARD 1 -->
                <div class="card-3d 
            rounded-2xl 
            border border-white/15 
            bg-[#1a1a1a] 
            p-10 
            text-center 
            transition duration-300 
            hover:border-red-500/40">

                    <div class="flex justify-center mb-8">
                        <div class="w-14 h-14 flex items-center justify-center 
                                    rounded-xl 
                                    bg-red-600/10 
                                    border border-red-500/20
                                    transition duration-300
                                    group-hover:bg-red-600/20">

                            <svg xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 24 24"
                                fill="currentColor"
                                class="w-7 h-7 text-red-600">
                                <path d="M12 2C6.48 2 2 6.02 2 11.5S6.48 21 12 21s10-4.02 10-9.5S17.52 2 12 2zm1 15.93V19h-2v-1.07c-1.72-.2-3-1.39-3-3.01h2c0 .83.67 1.5 1.5 1.5S13 15.75 13 15s-.67-1.5-1.5-1.5c-1.93 0-3.5-1.57-3.5-3.5 0-1.62 1.28-2.81 3-3.01V5h2v1.07c1.72.2 3 1.39 3 3.01h-2c0-.83-.67-1.5-1.5-1.5S11 8.25 11 9s.67 1.5 1.5 1.5c1.93 0 3.5 1.57 3.5 3.5 0 1.62-1.28 2.81-3 3.01z"/>
                            </svg>
                        </div>
                    </div>

                    <h4 class="text-xl font-semibold text-white mb-4 tracking-wide">
                        Registro en <span class="text-red-500">3 segundos</span>
                    </h4>

                    <p class="text-white/60 leading-relaxed">
                        Escribe tu venta o gasto y Admin JR lo convierte
                        en datos organizados automáticamente.
                    </p>
                </div>


                <!-- CARD 2 -->
                <div class="card-3d group 
                            rounded-2xl 
                            border border-white/10 
                            bg-[#0f0f0f] 
                            p-10 
                            text-center 
                            transition duration-300 
                            hover:border-red-500/40 
                            hover:-translate-y-2">

                    <div class="flex justify-center mb-8">
                        <div class="w-14 h-14 flex items-center justify-center 
                                    rounded-xl 
                                    bg-red-600/10 
                                    border border-red-500/20
                                    transition duration-300
                                    group-hover:bg-red-600/20">

                            <svg xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 24 24"
                                fill="currentColor"
                                class="w-7 h-7 text-red-600">
                                <path d="M12 22c1.1 0 2-.9 2-2h-4c0 
                                         1.1.9 2 2 2zm6-6v-5c0-3.07-1.63-5.64-4.5-6.32V4
                                         c0-.83-.67-1.5-1.5-1.5S10.5 3.17 10.5 4v.68
                                         C7.63 5.36 6 7.92 6 11v5l-2 2v1h16v-1l-2-2z"/>
                            </svg>
                        </div>
                    </div>

                    <h4 class="text-xl font-semibold text-white mb-4 tracking-wide">
                        Recordatorios <span class="text-red-500">inteligentes</span>
                    </h4>

                    <p class="text-white/60 leading-relaxed">
                        Si olvidas registrar algo, tu asistente te avisa.
                        Siempre atento, siempre disponible.
                    </p>
                </div>


                <!-- CARD 3 -->
                <div class="card-3d group 
                            rounded-2xl 
                            border border-white/10 
                            bg-[#0f0f0f] 
                            p-10 
                            text-center 
                            transition duration-300 
                            hover:border-red-500/40 
                            hover:-translate-y-2">

                    <div class="flex justify-center mb-8">
                        <div class="w-14 h-14 flex items-center justify-center 
                                    rounded-xl 
                                    bg-red-600/10 
                                    border border-red-500/20
                                    transition duration-300
                                    group-hover:bg-red-600/20">

                            <svg xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 24 24"
                                fill="currentColor"
                                class="w-7 h-7 text-red-600">
                                <path d="M4 9h3v11H4V9zm6-5h3v16h-3V4zm6 8h3v8h-3v-8z"/>
                            </svg>
                        </div>
                    </div>

                    <h4 class="text-xl font-semibold text-white mb-4 tracking-wide">
                        Resumen <span class="text-red-500">24/7</span>
                    </h4>

                    <p class="text-white/60 leading-relaxed">
                        Pregunta cómo va tu negocio y recibe reportes claros,
                        gráficos dinámicos y control total.
                    </p>
                </div>

            </div>
        </div>

    </div>
</section>

    <!-- BOTONES -->
    <!---<div class="flex justify-center gap-4 mt-10">
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
    </div>--->
<!-- PREGUNTAS FRECUENTES -->
<section class="mt-32 px-6">

    <div class="max-w-4xl mx-auto">

        <h2 class="text-4xl font-normal text-center mb-16 text-white">
            Preguntas <span class="text-red-600">frecuentes</span>
        </h2>

        <div class="space-y-5">

            <!-- ITEM 01 -->
            <div class="faq-item rounded-2xl border border-white/10 bg-[#111111] transition duration-300 hover:border-red-500/40">
                <button onclick="toggleFaq(this)"
                        class="w-full flex justify-between items-center px-6 py-6 text-left">
                    <div class="flex items-center gap-4">
                        <span class="text-red-600 font-semibold text-sm">01</span>
                        <span class="text-white text-lg font-medium">
                            ¿Qué es Admin JR?
                        </span>
                    </div>
                    <span class="faq-icon text-red-600 text-xl transition-transform duration-300">+</span>
                </button>
                <div class="faq-content hidden px-6 pb-6 text-white/60 leading-relaxed">
                    Admin JR es un asistente administrativo digital que funciona desde WhatsApp
                    y te ayuda a llevar el control de tus ingresos y gastos de forma simple y ordenada.
                </div>
            </div>

            <!-- ITEM 02 -->
            <div class="faq-item rounded-2xl border border-white/10 bg-[#111111] transition duration-300 hover:border-red-500/40">
                <button onclick="toggleFaq(this)"
                        class="w-full flex justify-between items-center px-6 py-6 text-left">
                    <div class="flex items-center gap-4">
                        <span class="text-red-600 font-semibold text-sm">02</span>
                        <span class="text-white text-lg font-medium">
                            ¿Necesito descargar una app?
                        </span>
                    </div>
                    <span class="faq-icon text-red-600 text-xl transition-transform duration-300">+</span>
                </button>
                <div class="faq-content hidden px-6 pb-6 text-white/60 leading-relaxed">
                    No. Admin JR funciona directamente en WhatsApp,
                    sin descargas ni plataformas complicadas.
                </div>
            </div>

            <!-- ITEM 03 -->
            <div class="faq-item rounded-2xl border border-white/10 bg-[#111111] transition duration-300 hover:border-red-500/40">
                <button onclick="toggleFaq(this)"
                        class="w-full flex justify-between items-center px-6 py-6 text-left">
                    <div class="flex items-center gap-4">
                        <span class="text-red-600 font-semibold text-sm">03</span>
                        <span class="text-white text-lg font-medium">
                            ¿Para quién es Admin JR?
                        </span>
                    </div>
                    <span class="faq-icon text-red-600 text-xl transition-transform duration-300">+</span>
                </button>
                <div class="faq-content hidden px-6 pb-6 text-white/60 leading-relaxed">
                    Para emprendedores, pequeños negocios y freelancers que:
                    <ul class="list-disc pl-5 mt-2 space-y-1">
                        <li>Llevan su administración solos</li>
                        <li>No tienen tiempo para Excel</li>
                        <li>Quieren claridad real de su dinero</li>
                    </ul>
                </div>
            </div>

            <!-- ITEM 04 -->
            <div class="faq-item rounded-2xl border border-white/10 bg-[#111111] transition duration-300 hover:border-red-500/40">
                <button onclick="toggleFaq(this)"
                        class="w-full flex justify-between items-center px-6 py-6 text-left">
                    <div class="flex items-center gap-4">
                        <span class="text-red-600 font-semibold text-sm">04</span>
                        <span class="text-white text-lg font-medium">
                            ¿Qué problemas me ayuda a resolver?
                        </span>
                    </div>
                    <span class="faq-icon text-red-600 text-xl transition-transform duration-300">+</span>
                </button>
                <div class="faq-content hidden px-6 pb-6 text-white/60 leading-relaxed">
                    <ul class="list-disc pl-5 space-y-1">
                        <li>No saber cuánto ganas realmente</li>
                        <li>Desorden financiero</li>
                        <li>Gastos que se pierden</li>
                        <li>Falta de control del dinero</li>
                    </ul>
                    <p class="mt-2">Admin JR te ayuda a ordenar sin complicarte.</p>
                </div>
            </div>

            <!-- ITEM 05 -->
            <div class="faq-item rounded-2xl border border-white/10 bg-[#111111] transition duration-300 hover:border-red-500/40">
                <button onclick="toggleFaq(this)"
                        class="w-full flex justify-between items-center px-6 py-6 text-left">
                    <div class="flex items-center gap-4">
                        <span class="text-red-600 font-semibold text-sm">05</span>
                        <span class="text-white text-lg font-medium">
                            ¿Necesito saber de contabilidad?
                        </span>
                    </div>
                    <span class="faq-icon text-red-600 text-xl transition-transform duration-300">+</span>
                </button>
                <div class="faq-content hidden px-6 pb-6 text-white/60 leading-relaxed">
                    No. Admin JR está diseñado para personas sin conocimientos contables.
                    Solo registras movimientos de dinero de forma sencilla.
                </div>
            </div>

            <!-- ITEM 06 -->
            <div class="faq-item rounded-2xl border border-white/10 bg-[#111111] transition duration-300 hover:border-red-500/40">
                <button onclick="toggleFaq(this)"
                        class="w-full flex justify-between items-center px-6 py-6 text-left">
                    <div class="flex items-center gap-4">
                        <span class="text-red-600 font-semibold text-sm">06</span>
                        <span class="text-white text-lg font-medium">
                            ¿Admin JR reemplaza a un contador?
                        </span>
                    </div>
                    <span class="faq-icon text-red-600 text-xl transition-transform duration-300">+</span>
                </button>
                <div class="faq-content hidden px-6 pb-6 text-white/60 leading-relaxed">
                    No. Admin JR no sustituye a un contador, pero sí te permite
                    tener tu información organizada y lista cuando la necesites.
                </div>
            </div>

            <!-- ITEM 07 -->
            <div class="faq-item rounded-2xl border border-white/10 bg-[#111111] transition duration-300 hover:border-red-500/40">
                <button onclick="toggleFaq(this)"
                        class="w-full flex justify-between items-center px-6 py-6 text-left">
                    <div class="flex items-center gap-4">
                        <span class="text-red-600 font-semibold text-sm">07</span>
                        <span class="text-white text-lg font-medium">
                            ¿Mi información está segura?
                        </span>
                    </div>
                    <span class="faq-icon text-red-600 text-xl transition-transform duration-300">+</span>
                </button>
                <div class="faq-content hidden px-6 pb-6 text-white/60 leading-relaxed">
                    Sí. Tu información es privada y confidencial.
                    Solo tú tienes acceso a tus datos.
                </div>
            </div>

            <!-- ITEM 08 -->
            <div class="faq-item rounded-2xl border border-white/10 bg-[#111111] transition duration-300 hover:border-red-500/40">
                <button onclick="toggleFaq(this)"
                        class="w-full flex justify-between items-center px-6 py-6 text-left">
                    <div class="flex items-center gap-4">
                        <span class="text-red-600 font-semibold text-sm">08</span>
                        <span class="text-white text-lg font-medium">
                            ¿Cuánto cuesta Admin JR?
                        </span>
                    </div>
                    <span class="faq-icon text-red-600 text-xl transition-transform duration-300">+</span>
                </button>
                <div class="faq-content hidden px-6 pb-6 text-white/60 leading-relaxed">
                    El costo es de <strong>$459 MXN al mes</strong>.
                    Sin contratos largos ni compromisos forzosos.
                </div>
            </div>

            <!-- ITEM 09 -->
            <div class="faq-item rounded-2xl border border-white/10 bg-[#111111] transition duration-300 hover:border-red-500/40">
                <button onclick="toggleFaq(this)"
                        class="w-full flex justify-between items-center px-6 py-6 text-left">
                    <div class="flex items-center gap-4">
                        <span class="text-red-600 font-semibold text-sm">09</span>
                        <span class="text-white text-lg font-medium">
                            ¿Puedo ver cómo funciona antes de pagar?
                        </span>
                    </div>
                    <span class="faq-icon text-red-600 text-xl transition-transform duration-300">+</span>
                </button>
                <div class="faq-content hidden px-6 pb-6 text-white/60 leading-relaxed">
                    Sí. Puedes crear una cuenta demo y conocer Admin JR antes
                    de tomar cualquier decisión.
                </div>
            </div>

        </div>

    </div>

</section>

<!-- PLAN ÚNICO -->
<section id="precios" class="mt-32 px-6">

    <div class="max-w-4xl mx-auto">

        <div class="relative rounded-3xl 
                    border border-red-500/30
                    bg-gradient-to-br from-[#0f0f0f] via-[#141414] to-[#1a0b0b]
                    backdrop-blur-xl
                    p-12 overflow-hidden">

            <!-- Glow decorativo -->
            <div class="absolute -top-20 -left-20 w-72 h-72 bg-red-600/20 blur-3xl rounded-full"></div>
            <div class="absolute -bottom-20 -right-20 w-72 h-72 bg-red-500/10 blur-3xl rounded-full"></div>

            <!-- Badge superior -->
            <div class="absolute top-4 left-1/2 -translate-x-1/2 z-10">
                <span class="bg-red-600/90 text-white text-xs 
                             px-5 py-1.5 rounded-full 
                             font-semibold tracking-wide 
                             shadow-lg">
                    PLAN DISPONIBLE
                </span>
            </div>

            <div class="grid md:grid-cols-2 gap-12 items-center">

                <!-- LADO IZQUIERDO -->
                <div>
                    <h3 class="text-3xl font-medium text-white mb-4">
                        Plan Básico
                    </h3>

                    <p class="text-white/60 mb-8 leading-relaxed">
                        Todo lo que necesitas para administrar tu negocio desde WhatsApp
                        con reportes claros y automatizados.
                    </p>

                    <ul class="space-y-4 text-white/80">
                        <li class="flex items-center gap-3">
                            <span class="w-2 h-2 bg-red-500 rounded-full"></span>
                            Hasta 3 números WhatsApp
                        </li>

                        <li class="flex items-center gap-3">
                            <span class="w-2 h-2 bg-red-500 rounded-full"></span>
                            5 cuentas conectadas
                        </li>

                        <li class="flex items-center gap-3">
                            <span class="w-2 h-2 bg-red-500 rounded-full"></span>
                            Reportes inteligentes
                        </li>

                        <li class="flex items-center gap-3">
                            <span class="w-2 h-2 bg-red-500 rounded-full"></span>
                            Soporte por email
                        </li>
                    </ul>
                </div>

                <!-- LADO DERECHO -->
                <div class="text-center md:text-right">

                    <div class="mb-6">
                        <span class="text-6xl font-light text-white">
                            $459
                        </span>
                        <span class="text-white/60 text-lg">
                            / mes
                        </span>
                    </div>

                    <a href="{{ route('register') }}"
                        class="inline-block px-10 py-4 rounded-xl
                               bg-red-600 hover:bg-red-700
                               text-white font-semibold
                               transition duration-300
                               hover:shadow-lg hover:shadow-red-600/20">
                        Comenzar ahora
                    </a>

                </div>

            </div>

        </div>

    </div>

</section>
<!-- CTA FINAL -->
<section class="mt-32 grid md:grid-cols-2 gap-16 items-center px-6 max-w-6xl mx-auto">

    <!-- IMAGEN -->
    <div class="flex justify-center">
        <div class="relative w-full max-w-sm">

            <!-- Glow -->
            <div class="absolute inset-0 rounded-2xl 
                        bg-gradient-to-r from-red-500 via-pink-500 to-purple-500
                        blur-2xl opacity-60">
            </div>

            <!-- Imagen -->
            <div class="relative rounded-2xl overflow-hidden
                        border border-white/10
                        bg-white/5 backdrop-blur-xl shadow-2xl">

                <img src="{{ asset('images/mockup10.png') }}"
                     alt="Admin JR app"
                     class="w-full h-auto object-contain">

            </div>

        </div>
    </div>


    <!-- TEXTO -->
    <div class="relative space-y-8">

        <!-- Glow decorativo -->
        <div class="absolute inset-0 -z-10 flex justify-center items-center">
            <div class="w-[60%] h-[60%] bg-red-700/20 blur-3xl rounded-full"></div>
        </div>

        <!-- Título estilo hero -->
        <h3 class="text-4xl md:text-6xl font-light leading-[1.05] tracking-tight text-white">
            Activa tu 
            <span class="text-red-500">asistente financiero</span>
        </h3>

        <!-- Línea decorativa -->
        <div class="w-24 h-[3px] bg-gradient-to-r from-transparent via-red-500 to-transparent"></div>

        <!-- Descripción -->
        <p class="text-lg md:text-xl text-white/70 leading-relaxed max-w-xl">
            Conecta tu número de WhatsApp y permite que 
            <span class="text-red-500 font-medium">Admin JR</span>
            registre automáticamente los gastos de tu negocio,
            generando reportes y manteniendo tu control financiero
            siempre actualizado.
        </p>

        <!-- Botón -->
        <a href="{{ route('register') }}"
           class="inline-block mt-6 px-10 py-4 rounded-xl
                  bg-red-600 hover:bg-red-700
                  text-white font-semibold
                  transition duration-300
                  hover:shadow-lg hover:shadow-red-600/20">

            Crear cuenta
        </a>

    </div>

</section>
</main>
<!-- FOOTER-->
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
<!--script para las preguntas frecuentes-->
<script>
function toggleFaq(button) {
    const item = button.closest('.faq-item');
    const content = item.querySelector('.faq-content');
    const icon = item.querySelector('.faq-icon');

    const isOpen = !content.classList.contains('hidden');

    // Cerrar todos primero
    document.querySelectorAll('.faq-content').forEach(el => {
        el.classList.add('hidden');
    });

    document.querySelectorAll('.faq-icon').forEach(el => {
        el.textContent = '+';
        el.classList.remove('rotate-45');
    });

    // Si estaba cerrado, lo abrimos
    if (!isOpen) {
        content.classList.remove('hidden');
        icon.textContent = '−';
    }
}
</script>
<!--para que el carrusel se mueva automa--->
<script>
const cards = document.querySelectorAll(".card-3d");
let current = 0;
let autoSlide;
let isPaused = false;

function updateCarousel() {
    cards.forEach((card, index) => {
        card.classList.remove("active");

        const offset = index - current;

        if (offset === 0) {
            card.style.transform = "translateX(0) translateZ(200px) scale(1)";
            card.style.opacity = "1";
            card.style.zIndex = "3";
            card.classList.add("active");
        } 
        else if (offset === -1 || offset === cards.length - 1) {
            card.style.transform = "translateX(-260px) translateZ(0) scale(0.8)";
            card.style.opacity = "0.5";
            card.style.zIndex = "2";
        } 
        else if (offset === 1 || offset === -(cards.length - 1)) {
            card.style.transform = "translateX(260px) translateZ(0) scale(0.8)";
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

/* 🔥 Auto movimiento lento */
function startAutoSlide() {
    autoSlide = setInterval(() => {
        if (!isPaused) {
            nextCard();
        }
    }, 4500); // 4.5 segundos (tiempo para leer)
}

/* 🛑 Pausar si hacen click en cualquier card */
cards.forEach((card) => {
    card.addEventListener("click", () => {
        isPaused = true;
        clearInterval(autoSlide);
    });
});

updateCarousel();
startAutoSlide();
</script>
<style>
.carousel-3d {
    position: relative;
    width: 100%;
    max-width: 950px;
    height: 380px;
    transform-style: preserve-3d;
    perspective: 1400px;
    display: flex;
    justify-content: center;
    align-items: center;
}

/* CARD BASE */
.card-3d {
    position: absolute;
    left: 50%;
    top: 50%;
    width: 300px;
    height: 340px;
    padding: 2rem;
    text-align: center;

    background: linear-gradient(145deg, #1c1c1c, #111111);
    border-radius: 1.8rem;

    /* 🔴 BORDE ROJO FIJO */
    border: 1.5px solid rgba(239, 68, 68, 0.7);

    transform-style: preserve-3d;
    transform-origin: center center;
    translate: -50% -50%;

    transition: transform 0.8s cubic-bezier(.25,.8,.25,1),
                opacity 0.8s ease;

    /* 🔥 Glow rojo permanente */
    box-shadow:
        0 20px 40px rgba(0,0,0,0.6),
        0 0 40px rgba(239,68,68,0.25);
}

/* CARD ACTIVA (solo más profundidad, NO cambia borde por hover) */
.card-3d.active {
    box-shadow:
        0 25px 60px rgba(0,0,0,0.8),
        0 0 70px rgba(239,68,68,0.35);
}

html {
    scroll-behavior: smooth;
}

/*DISEÑO DEL CHAT BOT */
/* burbuja usuario estilo WhatsApp */
.user-bubble{
    background:#dc2626;
    color:white;
    padding:10px 14px;
    border-radius:18px 18px 4px 18px;
    max-width:70%;
    margin-left:auto;
    font-size:14px;
}

/* burbuja bot */
.bot-bubble{
    background:#1f1f1f;
    border:1px solid rgba(255,255,255,0.08);
    color:white;
    padding:12px 14px;
    border-radius:18px 18px 18px 4px;
    max-width:75%;
    font-size:14px;
}

/* tarjeta interna del gasto */
.expense-card{
    background:#111;
    border-radius:12px;
    padding:10px;
    margin-top:6px;
    border:1px solid rgba(255,255,255,0.06);
    font-size:13px;
}

/* puntos escribiendo */
.typing{
    display:flex;
    gap:4px;
    padding:10px 14px;
    background:#1f1f1f;
    border-radius:18px 18px 18px 4px;
    width:fit-content;
}

.typing span{
    width:6px;
    height:6px;
    background:#9ca3af;
    border-radius:50%;
    animation:blink 1.4s infinite;
}

.typing span:nth-child(2){
    animation-delay:.2s;
}

.typing span:nth-child(3){
    animation-delay:.4s;
}

@keyframes blink{
    0%,80%,100%{opacity:.2;}
    40%{opacity:1;}
}
</style>