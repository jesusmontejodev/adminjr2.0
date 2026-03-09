<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Admin Jr | Avaspace</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined"
      rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

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
// Enfocar el botón al cargar la página
document.addEventListener("DOMContentLoaded", function() {
    const sendButton = document.getElementById('sendButton');
    if (sendButton) {
        sendButton.focus();
    }
    
    // Permitir enviar con Enter
    const userInput = document.getElementById('userInput');
    userInput.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            sendMessage();
        }
    });
});

function detectCategory(text) {
    const lower = text.toLowerCase();

    if (lower.includes("comida") || lower.includes("taco") || lower.includes("pizza") || lower.includes("hamburguesa") || lower.includes("restaurant")) {
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
    if (lower.includes("ropa") || lower.includes("zapatos") || lower.includes("vestido") || lower.includes("camisa")) {
        return "Ropa";
    }

    return "Otros";
}

function detectPaymentMethod(text) {
    const lower = text.toLowerCase();

    if (lower.includes("tarjeta") || lower.includes("credito") || lower.includes("crédito") || lower.includes("debito") || lower.includes("débito") || lower.includes("tc")) {
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
    const lower = text.toLowerCase();
    
    // Detectar frases completas primero
    if (lower.includes("comida china")) return "comida china";
    if (lower.includes("pizza")) return "pizza";
    if (lower.includes("hamburguesa")) return "hamburguesa";
    if (lower.includes("taco")) return "tacos";
    
    // Detectar categorías
    if (lower.includes("ropa")) return "ropa";
    if (lower.includes("zapatos")) return "zapatos";
    if (lower.includes("uber")) return "uber";
    if (lower.includes("taxi")) return "taxi";
    if (lower.includes("netflix")) return "netflix";
    if (lower.includes("spotify")) return "spotify";
    if (lower.includes("internet")) return "internet";
    if (lower.includes("luz")) return "luz";
    if (lower.includes("agua")) return "agua";
    if (lower.includes("gasolina")) return "gasolina";
    if (lower.includes("farmacia")) return "farmacia";
    if (lower.includes("doctor")) return "doctor";
    
    // Si no encuentra nada, hace la limpieza normal y agarra la última palabra relevante
    let palabras = text.split(' ');
    for (let i = palabras.length - 1; i >= 0; i--) {
        let palabra = palabras[i].toLowerCase();
        // Ignorar números y palabras comunes
        if (!palabra.match(/\d+/) && 
            !['hola', 'gaste', 'pague', 'con', 'por', 'de', 'en', 'el', 'la', 'los', 'las', 'un', 'una', 'y', 'mi', 'mis', 'tarjeta', 'efectivo'].includes(palabra)) {
            return palabras[i];
        }
    }
    
    return "Gasto";
}

function sendMessage() {
    const input = document.getElementById("userInput");
    const chatBox = document.getElementById("chatBox");

    const text = input.value.trim();
    if (!text) return;

    // Mensaje usuario
    const userMsg = document.createElement("div");
    userMsg.className = "message-user";
    userMsg.innerText = text;
    chatBox.appendChild(userMsg);

    // Mantener el input con el mensaje precargado (opcional)
    // input.value = "Hola, gaste 300 pesos en ropa y lo pague con tarjeta";

    // Mostrar indicador de "escribiendo..."
    const typingIndicator = document.createElement("div");
    typingIndicator.className = "typing";
    typingIndicator.innerHTML = "<span></span><span></span><span></span>";
    chatBox.appendChild(typingIndicator);
    chatBox.scrollTop = chatBox.scrollHeight;

    setTimeout(() => {
        // Quitar indicador de escritura
        chatBox.removeChild(typingIndicator);

        const botMsg = document.createElement("div");
        botMsg.className = "message-bot";

        const amountMatch = text.match(/\d+/);
        const amount = amountMatch ? amountMatch[0] : "0";

        const category = detectCategory(text);
        const paymentMethod = detectPaymentMethod(text);

        const description = cleanDescription(text) || "Gasto";

        const today = new Date().toLocaleDateString("es-MX");

        botMsg.innerHTML = `
            <strong style="color: #ffffff;">✅ ¡Listo! Gasto registrado</strong>
            <div class="expense-card">
                <div>💰 <strong>Monto:</strong> $${amount} MXN</div>
                <div>📅 <strong>Fecha:</strong> ${today}</div>
                <div>🏷 <strong>Categoría:</strong> ${category}</div>
                <div>📝 <strong>Descripción:</strong> ${description}</div>
                <div>💳 <strong>Método:</strong> ${paymentMethod}</div>
            </div>
        `;

        chatBox.appendChild(botMsg);
        chatBox.scrollTop = chatBox.scrollHeight;

    }, 1500);
}
</script>


<body class="min-h-screen bg-gradient-to-br from-gray-100 via-gray-50 to-gray-200 text-gray-800 overflow-x-hidden">
<!-- HEADER -->
<header id="mainHeader" class="fixed top-0 left-0 w-full z-50 flex justify-center pt-4 px-3 transition-all duration-300">
<nav id="navBar" class="
    flex items-center justify-between
    w-full max-w-5xl
    rounded-full
    px-6 py-4
    bg-white/40
    backdrop-blur-xl
    border border-gray-200/60
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
    <div class="hidden md:flex items-center text-sm text-gray-700
        absolute left-1/2 -translate-x-1/2
        gap-10">

        <a href="{{ route('nosotros') }}" class="hover:text-red-600 transition">Contacto</a>
        <a href="#funciones" class="hover:text-red-600 transition">Funciones</a>
        <a href="#precios" class="hover:text-red-600 transition">Precios</a>
        <a href="{{ route('login') }}" class="hover:text-red-600 transition">Iniciar sesión</a>
        <a href="{{ route('register') }}" class="hover:text-red-600 transition">Crear cuenta</a>
    </div>

    <!-- BOTÓN HAMBURGUESA -->
    <button id="menuBtn" class="md:hidden text-gray-700 ml-2">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none"
            viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M4 6h16M4 12h16M4 18h16" />
        </svg>
    </button>

    <!-- MENU MÓVIL -->
    <div id="mobileMenu" class="
        absolute top-full right-4 mt-4
        hidden
        w-52
        bg-white/80
        backdrop-blur-xl
        border border-gray-200
        rounded-2xl
        shadow-2xl
        p-4
        space-y-3
        text-gray-700
    ">
        <a href="{{ route('nosotros') }}" class="block hover:text-red-600">Contacto</a>
        <a href="#funciones" class="block hover:text-red-600">Funciones</a>
        <a href="#precios" class="block hover:text-red-600">Precios</a>

        <hr class="border-gray-200">

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

   <!-- Badge minimalista -->
<div class="mb-8 px-6 py-2.5 rounded-full
            bg-black/85 border border-gray-800
            text-sm text-white
            flex items-center gap-3
            shadow-sm
            hover:border-red-500 hover:shadow-md hover:shadow-red-500/20
            transition-all duration-300
            group">

    <div class="w-6 h-6 flex items-center justify-center">
        <img src="{{ asset('avaspace.svg') }}" alt="Avaspace" class="h-6">
    </div>

    <span class="tracking-wide">
        Tu asistente administrativo inteligente
    </span>

</div>

    <!-- Título limpio -->
    <h1 class="text-4xl md:text-6xl xl:text-7xl
                font-light tracking-tight
                leading-[1.08]
                max-w-4xl mx-auto text-gray-900">
        
        Si sabes enviar un
        <span class="text-red-600 font-normal">WhatsApp</span>,<br>
        
        puedes dominar tus finanzas<br>
        
        como un
        <span class="text-red-600 font-normal">experto</span>.
    </h1>

    <!-- Subrayado sutil -->
    <div class="mt-4 w-24 h-[2px] bg-gradient-to-r from-transparent via-red-400 to-transparent"></div>

    <!-- Descripción elegante -->
    <p class="mt-8 text-lg md:text-xl text-gray-600
                max-w-2xl mx-auto
                leading-relaxed">
        
        Olvídate de planillas y procesos complicados.
        
        <span class="text-red-600 font-medium">Admin JR</span>
        organiza, categoriza y actualiza
        tu panel financiero al instante.
        
        <span class="text-gray-900 font-medium">Simple</span>,
        <span class="text-gray-900 font-medium">rápido</span>
        y
        <span class="text-gray-900 font-medium">sin esfuerzo</span>.
    </p>

  <!-- IMAGEN con diseño limpio -->
<div class="mt-14 flex justify-center w-full max-w-5xl px-4">
    <div class="relative w-full max-w-sm group mx-auto">

        <!-- Glow oscuro -->
        <div class="absolute inset-0 rounded-3xl
                    bg-black/40
                    blur-3xl
                    opacity-30
                    group-hover:opacity-50
                    transition-opacity duration-500">
        </div>

            
            <!-- Imagen -->
            <img src="{{ asset('images/mockup1.png') }}"
                alt="Mockup Admin JR"
                class="relative w-full h-auto object-contain rounded-3xl
                       transform group-hover:scale-[1.01] transition-transform duration-300">

            <!-- Tooltip 1 -->
<div class="absolute top-20 -left-20
            bg-red-600/85 border border-red-500/60
            text-white text-sm px-4 py-2 rounded-lg
            shadow-lg shadow-red-900/20
            backdrop-blur-sm
            tooltip-auto tooltip-delay-1
            before:absolute before:top-1/2 before:-right-2 before:w-2 before:h-2
            before:bg-red-600/85 before:border-r before:border-t before:border-red-500/60
            before:rotate-45 before:-translate-y-1/2">
    Categorizado automáticamente
</div>


<!-- Tooltip 2 -->
<div class="absolute top-40 -right-20
            bg-red-600/85 border border-red-500/60
            text-white text-sm px-4 py-2 rounded-lg
            shadow-lg shadow-red-900/20
            backdrop-blur-sm
            tooltip-auto tooltip-delay-2
            before:absolute before:top-1/2 before:-left-2 before:w-2 before:h-2
            before:bg-red-600/85 before:border-l before:border-b before:border-red-500/60
            before:rotate-45 before:-translate-y-1/2">
    Procesado en segundos
</div>


<!-- Tooltip 3 -->
<div class="absolute bottom-32 -right-12
            bg-red-600/85 border border-red-500/60
            text-white text-sm px-4 py-2 rounded-lg
            shadow-lg shadow-red-900/20
            backdrop-blur-sm
            tooltip-auto tooltip-delay-3
            before:absolute before:top-full before:left-6 before:w-2 before:h-2
            before:bg-red-600/85 before:border-l before:border-t before:border-red-500/60
            before:rotate-45 before:-translate-y-[5px]">
    Registro de tus finanzas
</div>
        </div>
    </div>

    <!-- CTA elegante -->
    <div class="mt-14">
        <a href="{{ route('register') }}"
           class="inline-flex items-center gap-3 px-8 py-4
                  bg-red-600 hover:bg-red-700
                  text-white font-medium text-lg
                  rounded-full
                  transition-all duration-300
                  shadow-md shadow-red-200
                  hover:shadow-lg hover:shadow-red-300
                  hover:scale-105
                  group">
            
            Comenzar ahora
            
            <!-- Icono sutil -->
            <svg class="w-5 h-5 transition-transform duration-300 group-hover:translate-x-1" 
                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
            </svg>
        </a>
    </div>

    <!-- Elementos decorativos muy sutiles -->
    <div class="absolute top-1/2 left-0 w-96 h-96 bg-red-50 rounded-full blur-3xl -z-10 opacity-30"></div>
    <div class="absolute bottom-1/2 right-0 w-96 h-96 bg-red-50 rounded-full blur-3xl -z-10 opacity-30"></div>
</section>
<!---segunda sección-->
<section class="relative pt-32 pb-16 flex flex-col items-center text-center overflow-hidden">

     <!-- Titular -->
    <h1 class="text-4xl md:text-6xl xl:text-7xl 
               font-light tracking-tight 
               leading-[1.08] 
               max-w-4xl mx-auto text-black">

        Para el emprendedor que quiere hacer <br>

        <span class="text-red-500">crecer</span><br>

        su negocio,
        no su papeleo.

    </h1>

    <!-- Línea decorativa -->
    <div class="mt-6 w-20 h-[3px] bg-gradient-to-r from-transparent via-red-500 to-transparent"></div>

    <!-- Subtítulo -->
    <p class="mt-8 text-lg md:text-xl text-black 
              max-w-2xl mx-auto leading-relaxed">

        Descubre la fortuna que se esconde en tu flujo de caja.
        Reporta ventas y gastos por 
        <span class="text-red-500 font-medium">WhatsApp</span>
        y deja que 
        <span class="text-red-500 font-medium">Admin JR</span>
        genere tus resúmenes financieros
        mientras tú te enfocas en crecer.

    </p>

    <!----<div class="mt-12 flex justify-center">--->

        <!-- Imagen con glow elegante -->
        <!---<div class="mt-16 relative w-full max-w-md">-->

            <!-- Glow detrás de la imagen -->
            <!---<div class="absolute inset-0 rounded-3xl 
                        bg-gradient-to-r from-red-500/40 via-pink-500/30 to-purple-500/30
                        blur-3xl opacity-60">
            </div>--->

            <!-- Imagen -->
            <!----<img src="{{ asset('images/mockupgif.gif') }}"
                 alt="Mockup Admin JR"
                 class="relative w-full h-auto object-contain rounded-2xl">---->

        <!---</div>--->

    <!---</div>--->

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
    <p class="mt-6 text-black text-center max-w-3xl text-lg">
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

    <!-- Glow suave -->
    <div class="absolute top-1/4 -z-10 w-[420px] h-[420px] bg-red-500/20 blur-[160px] rounded-full"></div>

    <div class="max-w-3xl mx-auto text-center">

        <!-- TITULO -->
        <h2 class="text-4xl md:text-5xl lg:text-6xl font-light leading-[1.1] tracking-tight mb-6 text-gray-900">
            Si sabes enviar un 
            <span class="text-red-600">mensaje</span>,
            ya sabes dominar tus 
            <span class="text-red-600">finanzas.</span>
        </h2>

        <!-- SUBTITULO -->
        <p class="text-lg md:text-xl text-gray-600 leading-relaxed max-w-2xl mx-auto">
            Compruébalo por ti mismo ahora. 
            Solo presiona "Enviar" y mira cómo la IA procesa tu mensaje.
        </p>

        <br>

    </div>

    <!-- PANEL - CHAT MEJORADO -->
    <div class="w-full max-w-xl chat-demo-container rounded-xl overflow-hidden">
        <!-- CHAT -->
        <div id="chatBox" class="p-4 space-y-3 text-left h-80 overflow-y-auto flex flex-col bg-white/30 backdrop-blur-sm">
            <div class="message-bot">
                💬 Hola, soy AdminJr. Prueba con este mensaje 👇
            </div>
        </div>
    </div>

    <!-- INPUT CON MENSAJE NATURAL PRECARGADO -->
    <div class="mt-6 w-full max-w-xl flex gap-2">
        <input id="userInput"
            type="text"
            value="Hola, gaste 300 pesos en ropa y lo pague con tarjeta"
            class="flex-1 bg-white border border-gray-300
                   rounded-full px-5 py-3 outline-none text-gray-800
                   focus:border-red-500 focus:ring-1 focus:ring-red-200 transition">

        <button onclick="sendMessage()" id="sendButton"
            class="px-6 py-3 bg-red-600 hover:bg-red-700
                   text-white rounded-full font-medium
                   transition duration-300 shadow-md hover:shadow-lg
                   cursor-pointer">
            Enviar
        </button>
    </div>

    <!-- Pequeño texto de ayuda -->
    <p class="text-xs text-gray-400 mt-3">Haz clic en "Enviar" y verás cómo extrae: 300, ropa, tarjeta</p>

</section>

<script src="/js/chat-demo.js"></script>
<!-- SECCIÓN 4 -->
<section class="mt-32 grid md:grid-cols-2 gap-16 items-center px-6 max-w-6xl mx-auto">

    <!-- TEXTO -->
    <div class="space-y-8">

        <!-- Título -->
        <h2 class="text-4xl md:text-6xl xl:text-7xl font-light leading-[1.05] tracking-tight text-gray-900">
            Despídete de la 
            <span class="text-red-600">ansiedad financiera</span>
            para siempre.
        </h2>

        <!-- Línea decorativa -->
        <div class="w-24 h-[3px] bg-gradient-to-r from-transparent via-red-500 to-transparent"></div>

        <!-- Subtítulo -->
        <p class="text-lg md:text-xl text-gray-600 max-w-xl leading-relaxed">
            La claridad es poder. Al ver tu dinero organizado en 
            <span class="text-gray-900 font-medium">tiempo real</span>,
            recuperas el control y la tranquilidad que necesitas
            para hacer crecer tu 
            <span class="text-red-600 font-medium">negocio</span> 
            o tu ahorro personal.
        </p>

    </div>

    <!-- IMAGEN -->
    <div class="flex justify-center">
        <div class="relative w-full max-w-sm">

            <!-- Contenedor imagen -->
            <div class="rounded-2xl overflow-hidden
                        border border-gray-200
                        bg-white shadow-lg">

                <img src="{{ asset('images/mockup3.png') }}"
                     alt="Mockup Admin JR"
                     class="w-full h-auto object-contain">

            </div>

        </div>
    </div>

</section>
<section id="funciones" class="mt-40 relative overflow-hidden px-6">

    <div class="relative z-10 max-w-6xl mx-auto">

        <!-- TITULO -->
        <div class="text-center mb-20">
            <h3 class="text-3xl md:text-5xl font-light text-gray-900 mb-6 tracking-tight">
                Control total de tu negocio,
                <span class="text-red-600 font-normal">desde WhatsApp</span>
            </h3>

            <p class="text-gray-600 max-w-2xl mx-auto text-lg leading-relaxed">
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
                    border border-gray-200
                    bg-white
                    p-10 
                    text-center 
                    transition duration-300 
                    hover:border-red-500/40">

                    <div class="flex justify-center mb-8">
                        <div class="w-14 h-14 flex items-center justify-center 
                                    rounded-xl 
                                    bg-red-600/10 
                                    border border-red-200">

                            <svg xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 24 24"
                                fill="currentColor"
                                class="w-7 h-7 text-red-600">
                                <path d="M12 2C6.48 2 2 6.02 2 11.5S6.48 21 12 21s10-4.02 10-9.5S17.52 2 12 2zm1 15.93V19h-2v-1.07c-1.72-.2-3-1.39-3-3.01h2c0 .83.67 1.5 1.5 1.5S13 15.75 13 15s-.67-1.5-1.5-1.5c-1.93 0-3.5-1.57-3.5-3.5 0-1.62 1.28-2.81 3-3.01V5h2v1.07c1.72.2 3 1.39 3 3.01h-2c0-.83-.67-1.5-1.5-1.5S11 8.25 11 9s.67 1.5 1.5 1.5c1.93 0 3.5 1.57 3.5 3.5 0 1.62-1.28 2.81-3 3.01z"/>
                            </svg>
                        </div>
                    </div>

                    <h4 class="text-xl font-semibold text-gray-900 mb-4 tracking-wide">
                        Registro en <span class="text-red-600">3 segundos</span>
                    </h4>

                    <p class="text-gray-600 leading-relaxed">
                        Escribe tu venta o gasto y Admin JR lo convierte
                        en datos organizados automáticamente.
                    </p>
                </div>


                <!-- CARD 2 -->
                <div class="card-3d group 
                            rounded-2xl 
                            border border-gray-200
                            bg-white
                            p-10 
                            text-center 
                            transition duration-300 
                            hover:border-red-500/40 
                            hover:-translate-y-2">

                    <div class="flex justify-center mb-8">
                        <div class="w-14 h-14 flex items-center justify-center 
                                    rounded-xl 
                                    bg-red-600/10 
                                    border border-red-200">

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

                    <h4 class="text-xl font-semibold text-gray-900 mb-4 tracking-wide">
                        Recordatorios <span class="text-red-600">inteligentes</span>
                    </h4>

                    <p class="text-gray-600 leading-relaxed">
                        Si olvidas registrar algo, tu asistente te avisa.
                        Siempre atento, siempre disponible.
                    </p>
                </div>


                <!-- CARD 3 -->
                <div class="card-3d group 
                            rounded-2xl 
                            border border-gray-200
                            bg-white
                            p-10 
                            text-center 
                            transition duration-300 
                            hover:border-red-500/40 
                            hover:-translate-y-2">

                    <div class="flex justify-center mb-8">
                        <div class="w-14 h-14 flex items-center justify-center 
                                    rounded-xl 
                                    bg-red-600/10 
                                    border border-red-200">

                            <svg xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 24 24"
                                fill="currentColor"
                                class="w-7 h-7 text-red-600">
                                <path d="M4 9h3v11H4V9zm6-5h3v16h-3V4zm6 8h3v8h-3v-8z"/>
                            </svg>
                        </div>
                    </div>

                    <h4 class="text-xl font-semibold text-gray-900 mb-4 tracking-wide">
                        Resumen <span class="text-red-600">24/7</span>
                    </h4>

                    <p class="text-gray-600 leading-relaxed">
                        Pregunta cómo va tu negocio y recibe reportes claros,
                        gráficos dinámicos y control total.
                    </p>
                </div>

            </div>
        </div>

    </div>
</section>

<!-- PREGUNTAS FRECUENTES -->
<section class="mt-32 px-6">

    <div class="max-w-4xl mx-auto">

        <!-- TITULO -->
        <h2 class="text-4xl font-normal text-center mb-16 text-gray-900">
            Preguntas <span class="text-red-600">frecuentes</span>
        </h2>

        <div class="space-y-5">

            <!-- ITEM 01 -->
            <div class="faq-item rounded-2xl border border-gray-200 bg-white transition duration-300 hover:border-red-500/40 hover:shadow-md">
                <button onclick="toggleFaq(this)"
                        class="w-full flex justify-between items-center px-6 py-6 text-left">

                    <div class="flex items-center gap-4">
                        <span class="text-red-600 font-semibold text-sm">01</span>
                        <span class="text-gray-900 text-lg font-medium">
                            ¿Qué es Admin JR?
                        </span>
                    </div>

                    <span class="faq-icon text-red-600 text-xl transition-transform duration-300">+</span>

                </button>

                <div class="faq-content hidden px-6 pb-6 text-gray-600 leading-relaxed">
                    Admin JR es un asistente administrativo digital que funciona desde WhatsApp
                    y te ayuda a llevar el control de tus ingresos y gastos de forma simple y ordenada.
                </div>
            </div>


            <!-- ITEM 02 -->
            <div class="faq-item rounded-2xl border border-gray-200 bg-white transition duration-300 hover:border-red-500/40 hover:shadow-md">
                <button onclick="toggleFaq(this)"
                        class="w-full flex justify-between items-center px-6 py-6 text-left">

                    <div class="flex items-center gap-4">
                        <span class="text-red-600 font-semibold text-sm">02</span>
                        <span class="text-gray-900 text-lg font-medium">
                            ¿Necesito descargar una app?
                        </span>
                    </div>

                    <span class="faq-icon text-red-600 text-xl transition-transform duration-300">+</span>

                </button>

                <div class="faq-content hidden px-6 pb-6 text-gray-600 leading-relaxed">
                    No, Admin JR funciona directamente en WhatsApp,
                    sin descargas ni plataformas complicadas.
                </div>
            </div>


            <!-- ITEM 03 -->
            <div class="faq-item rounded-2xl border border-gray-200 bg-white transition duration-300 hover:border-red-500/40 hover:shadow-md">
                <button onclick="toggleFaq(this)"
                        class="w-full flex justify-between items-center px-6 py-6 text-left">

                    <div class="flex items-center gap-4">
                        <span class="text-red-600 font-semibold text-sm">03</span>
                        <span class="text-gray-900 text-lg font-medium">
                            ¿Para quién es Admin JR?
                        </span>
                    </div>

                    <span class="faq-icon text-red-600 text-xl transition-transform duration-300">+</span>

                </button>

                <div class="faq-content hidden px-6 pb-6 text-gray-600 leading-relaxed">
                    Para emprendedores, pequeños negocios y freelancers que:
                    <ul class="list-disc pl-5 mt-2 space-y-1">
                        <li>Llevan su administración solos</li>
                        <li>No tienen tiempo para Excel</li>
                        <li>Quieren claridad real de su dinero</li>
                    </ul>
                </div>
            </div>


            <!-- ITEM 04 -->
            <div class="faq-item rounded-2xl border border-gray-200 bg-white transition duration-300 hover:border-red-500/40 hover:shadow-md">
                <button onclick="toggleFaq(this)"
                        class="w-full flex justify-between items-center px-6 py-6 text-left">

                    <div class="flex items-center gap-4">
                        <span class="text-red-600 font-semibold text-sm">04</span>
                        <span class="text-gray-900 text-lg font-medium">
                            ¿Qué problemas me ayuda a resolver?
                        </span>
                    </div>

                    <span class="faq-icon text-red-600 text-xl transition-transform duration-300">+</span>

                </button>

                <div class="faq-content hidden px-6 pb-6 text-gray-600 leading-relaxed">
                    <ul class="list-disc pl-5 space-y-1">
                        <li>No saber cuánto ganas realmente</li>
                        <li>Desorden financiero</li>
                        <li>Gastos que se pierden</li>
                        <li>Falta de control del dinero</li>
                    </ul>

                    <p class="mt-2">
                        Admin JR te ayuda a ordenar sin complicarte.
                    </p>
                </div>
            </div>


            <!-- ITEM 05 -->
            <div class="faq-item rounded-2xl border border-gray-200 bg-white transition duration-300 hover:border-red-500/40 hover:shadow-md">
                <button onclick="toggleFaq(this)"
                        class="w-full flex justify-between items-center px-6 py-6 text-left">

                    <div class="flex items-center gap-4">
                        <span class="text-red-600 font-semibold text-sm">05</span>
                        <span class="text-gray-900 text-lg font-medium">
                            ¿Necesito saber de contabilidad?
                        </span>
                    </div>

                    <span class="faq-icon text-red-600 text-xl transition-transform duration-300">+</span>

                </button>

                <div class="faq-content hidden px-6 pb-6 text-gray-600 leading-relaxed">
                    No, Admin JR está diseñado para personas sin conocimientos contables.
                    Solo registras movimientos de dinero de forma sencilla.
                </div>
            </div>


            <!-- ITEM 06 -->
            <div class="faq-item rounded-2xl border border-gray-200 bg-white transition duration-300 hover:border-red-500/40 hover:shadow-md">
                <button onclick="toggleFaq(this)"
                        class="w-full flex justify-between items-center px-6 py-6 text-left">

                    <div class="flex items-center gap-4">
                        <span class="text-red-600 font-semibold text-sm">06</span>
                        <span class="text-gray-900 text-lg font-medium">
                            ¿Admin JR reemplaza a un contador?
                        </span>
                    </div>

                    <span class="faq-icon text-red-600 text-xl transition-transform duration-300">+</span>

                </button>

                <div class="faq-content hidden px-6 pb-6 text-gray-600 leading-relaxed">
                    No, Admin JR no sustituye a un contador,
                    pero sí te permite tener tu información organizada y lista cuando la necesites.
                </div>
            </div>


            <!-- ITEM 07 -->
            <div class="faq-item rounded-2xl border border-gray-200 bg-white transition duration-300 hover:border-red-500/40 hover:shadow-md">
                <button onclick="toggleFaq(this)"
                        class="w-full flex justify-between items-center px-6 py-6 text-left">

                    <div class="flex items-center gap-4">
                        <span class="text-red-600 font-semibold text-sm">07</span>
                        <span class="text-gray-900 text-lg font-medium">
                            ¿Mi información está segura?
                        </span>
                    </div>

                    <span class="faq-icon text-red-600 text-xl transition-transform duration-300">+</span>

                </button>

                <div class="faq-content hidden px-6 pb-6 text-gray-600 leading-relaxed">
                    Sí, tu información es privada y confidencial.
                    Solo tú tienes acceso a tus datos.
                </div>
            </div>


            <!-- ITEM 08 -->
            <div class="faq-item rounded-2xl border border-gray-200 bg-white transition duration-300 hover:border-red-500/40 hover:shadow-md">
                <button onclick="toggleFaq(this)"
                        class="w-full flex justify-between items-center px-6 py-6 text-left">

                    <div class="flex items-center gap-4">
                        <span class="text-red-600 font-semibold text-sm">08</span>
                        <span class="text-gray-900 text-lg font-medium">
                            ¿Cuánto cuesta Admin JR?
                        </span>
                    </div>

                    <span class="faq-icon text-red-600 text-xl transition-transform duration-300">+</span>

                </button>

                <div class="faq-content hidden px-6 pb-6 text-gray-600 leading-relaxed">
                    El costo es de <strong>$129 MXN al mes</strong>.
                    Sin contratos largos ni compromisos forzosos.
                </div>
            </div>


            <!-- ITEM 09 -->
            <div class="faq-item rounded-2xl border border-gray-200 bg-white transition duration-300 hover:border-red-500/40 hover:shadow-md">
                <button onclick="toggleFaq(this)"
                        class="w-full flex justify-between items-center px-6 py-6 text-left">

                    <div class="flex items-center gap-4">
                        <span class="text-red-600 font-semibold text-sm">09</span>
                        <span class="text-gray-900 text-lg font-medium">
                            ¿Puedo ver cómo funciona antes de pagar?
                        </span>
                    </div>

                    <span class="faq-icon text-red-600 text-xl transition-transform duration-300">+</span>

                </button>

                <div class="faq-content hidden px-6 pb-6 text-gray-600 leading-relaxed">
                    Sí, puedes crear una cuenta demo y conocer Admin JR antes
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
            border border-gray-900/30
            bg-white
            shadow-xl
            p-12 overflow-hidden">

            <!-- Glow decorativo -->
            <div class="absolute -top-20 -left-20 w-72 h-72 bg-red-500/20 blur-3xl rounded-full"></div>
            <div class="absolute -bottom-20 -right-20 w-72 h-72 bg-red-400/10 blur-3xl rounded-full"></div>

            <!-- Badge superior -->
            <div class="absolute top-4 left-1/2 -translate-x-1/2 z-10">
                <span class="bg-red-600 text-white text-xs 
                             px-5 py-1.5 rounded-full 
                             font-semibold tracking-wide 
                             shadow-md">
                    PLAN DISPONIBLE
                </span>
            </div>

            <div class="grid md:grid-cols-2 gap-12 items-center">

                <!-- LADO IZQUIERDO -->
                <div>
                    <h3 class="text-3xl font-medium text-gray-900 mb-4">
                        Plan Básico
                    </h3>

                    <p class="text-gray-600 mb-8 leading-relaxed">
                        Todo lo que necesitas para administrar tu negocio desde WhatsApp
                        con reportes claros y automatizados.
                    </p>

                    <ul class="space-y-4 text-gray-700">

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
                        <span class="text-6xl font-light text-gray-900">
                            $129
                        </span>
                        <span class="text-gray-500 text-lg">
                            / mes
                        </span>
                    </div>

                    <a href="{{ route('register') }}"
                        class="inline-block px-10 py-4 rounded-xl
                               bg-red-600 hover:bg-red-700
                               text-white font-semibold
                               transition duration-300
                               hover:shadow-lg hover:shadow-red-500/30">
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
                        blur-2xl opacity-30">
            </div>

            <!-- Imagen -->
            <div class="relative rounded-2xl overflow-hidden
                        border border-gray-200
                        bg-white shadow-xl">

                <img src="{{ asset('images/mockup10.png') }}"
                     alt="Admin JR app"
                     class="w-full h-auto object-contain">

            </div>

        </div>
    </div>


    <!-- TEXTO -->
    <div class="relative space-y-8">

        <!-- Título -->
        <h3 class="text-4xl md:text-6xl font-light leading-[1.05] tracking-tight text-gray-900">
            Activa tu 
            <span class="text-red-600">asistente financiero</span>
        </h3>

        <!-- Línea decorativa -->
        <div class="w-24 h-[3px] bg-gradient-to-r from-transparent via-red-500 to-transparent"></div>

        <!-- Descripción -->
        <p class="text-lg md:text-xl text-gray-600 leading-relaxed max-w-xl">
            Conecta tu número de WhatsApp y permite que 
            <span class="text-red-600 font-medium">Admin JR</span>
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
                  hover:shadow-lg hover:shadow-red-500/30">

            Crear cuenta
        </a>

    </div>

</section>
</main>
<!-- FOOTER-->
<footer class="bg-zinc-950 text-gray-200 border-t border-zinc-800">
    <div class="max-w-7xl mx-auto px-6 py-12 grid grid-cols-1 md:grid-cols-5 gap-8 items-start">

        <div class="md:col-span-2 space-y-3">
            <div class="flex items-center gap-3">
                <img src="{{ asset('avaspace.svg') }}" alt="Avaspace" class="h-10">
                <h2 class="text-xl font-semibold text-white">Controla tus gastos</h2>
            </div>
            <p class="text-sm text-gray-400 max-w-sm">
                Convierte tus números en decisiones inteligentes para hacer crecer tu negocio.
            </p>
        </div>

        <div class="space-y-2 text-sm">
            <h3 class="font-semibold text-white">Avisos</h3>
            <ul class="space-y-1 text-gray-400">
                <li><a href="{{ route('aviso-de-privacidad') }}" class="hover:text-red-400 transition">Aviso de privacidad</a></li>
                <li><a href="{{ route('terminos') }}" class="hover:text-red-400 transition">Términos y condiciones</a></li>
            </ul>
        </div>

        <div class="space-y-2 text-sm">
            <h3 class="font-semibold text-white">Equipo</h3>
            <ul class="space-y-1 text-gray-400">
                <li><a href="{{ route('nosotros') }}" class="hover:text-red-400 transition">Nosotros</a></li>
            </ul>
        </div>

        <div class="space-y-2 text-sm">
            <h3 class="font-semibold text-white">Social</h3>
            <ul class="space-y-1 text-gray-400">
                <li><a href="https://www.facebook.com/avaspace.io" class="hover:text-red-400 transition">Facebook</a></li>
                <li><a href="https://www.instagram.com/avaspace.io/" class="hover:text-red-400 transition">Instagram</a></li>
                <li><a href="https://www.youtube.com/@avaspace" class="hover:text-red-400 transition">YouTube</a></li>
            </ul>
        </div>
    </div>

    <div class="border-t border-zinc-800 py-4 text-center text-xs text-gray-500">
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

/*telefono */
@keyframes tooltipShow {
    0% { opacity: 0; transform: translateY(10px); }
    10% { opacity: 1; transform: translateY(0); }
    70% { opacity: 1; transform: translateY(0); }
    85% { opacity: 0; transform: translateY(10px); }
    100% { opacity: 0; transform: translateY(10px); }
}

.tooltip-auto {
    opacity: 0;
    animation: tooltipShow 8s infinite;
}
/* =========================
   CAROUSEL 3D
========================= */

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

/* =========================
   CARD BASE
========================= */

.card-3d {
    position: absolute;
    left: 50%;
    top: 50%;
    width: 300px;
    height: 340px;
    padding: 2rem;
    text-align: center;

    background: rgba(255,255,255,0.9);
    backdrop-filter: blur(10px);

    border-radius: 1.8rem;

    /* NUEVO BORDE */
    border: 1px solid #000;

    transform-style: preserve-3d;
    transform-origin: center center;
    translate: -50% -50%;

    transition: 
        transform 0.8s cubic-bezier(.25,.8,.25,1),
        opacity 0.8s ease;

    box-shadow:
        0 20px 40px rgba(0,0,0,0.08);
}

/* =========================
   CARD ACTIVA
========================= */

.card-3d.active {
    box-shadow:
        0 30px 60px rgba(0,0,0,0.15);
}

/* =========================
   SCROLL SUAVE
========================= */

html {
    scroll-behavior: smooth;
}

/* =========================
   DISEÑO CHAT BOT - VERSIÓN DARK ELEGANT
   Paleta: Negro mate, Rojo vibrante, Blanco suave
========================= */

/* Contenedor principal del chat */
.chat-demo-container {
    background: linear-gradient(145deg, #1e1e1e 0%, #252525 100%);
    border: 1px solid #333333;
    box-shadow: 0 20px 35px -10px rgba(0,0,0,0.4);
    border-radius: 24px;
    padding: 4px;
}

/* Burbuja del BOT (AdminJr) */
.message-bot {
    background: linear-gradient(135deg, #2a2a2a 0%, #222222 100%);
    border: 1px solid #3a3a3a;
    color: #f0f0f0;
    border-radius: 20px 20px 20px 5px;
    padding: 14px 18px;
    max-width: 85%;
    align-self: flex-start;
    font-size: 0.95rem;
    box-shadow: 0 4px 10px rgba(0,0,0,0.3);
    position: relative;
}

/* Burbuja del USUARIO */
.message-user {
    background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%);
    color: #ffffff;
    border-radius: 20px 20px 5px 20px;
    padding: 14px 18px;
    max-width: 85%;
    align-self: flex-end;
    font-size: 0.95rem;
    font-weight: 500;
    box-shadow: 0 4px 15px rgba(220, 38, 38, 0.3);
    position: relative;
}

/* Tarjeta de gasto (la que muestra los detalles) */
/* Tarjeta de gasto - VERSIÓN OSCURA PERO LEGIBLE */
.expense-card {
    background: #2d2d2d;  /* Fondo gris oscuro */
    border: 1px solid #404040;
    border-radius: 14px;
    padding: 14px 16px;
    margin-top: 12px;
    font-size: 0.95rem;
    color: #f0f0f0;  /* Texto blanco suave */
    box-shadow: 0 4px 12px rgba(0,0,0,0.3);
    position: relative;
}

.expense-card strong {
    color: #ffffff;  /* Negritas en blanco puro */
    font-weight: 700;
}

.expense-card div {
    padding: 5px 0;
    border-bottom: 1px dashed #505050;
    color: #e5e5e5;  /* Texto claro */
}

.expense-card div:last-child {
    border-bottom: none;
}

.expense-card::before {
    content: '';
    position: absolute;
    left: 0;
    top: 10%;
    height: 80%;
    width: 4px;
    background: #dc2626;
    border-radius: 0 4px 4px 0;
}

/* Ajuste para que el pseudo-elemento no rompa el layout */
.expense-card {
    position: relative;
    margin-left: 8px;
}

/* Indicador de "escribiendo..." */
.typing {
    display: flex;
    gap: 6px;
    padding: 14px 20px;
    background: #2a2a2a;
    border: 1px solid #3a3a3a;
    border-radius: 20px 20px 20px 5px;
    width: fit-content;
    align-self: flex-start;
    box-shadow: 0 4px 10px rgba(0,0,0,0.2);
}

.typing span {
    width: 10px;
    height: 10px;
    background-color: #dc2626;
    border-radius: 50%;
    animation: pulse 1.5s infinite ease-in-out;
}

.typing span:nth-child(1) { animation-delay: 0s; background-color: #dc2626; }
.typing span:nth-child(2) { animation-delay: 0.2s; background-color: #ef4444; }
.typing span:nth-child(3) { animation-delay: 0.4s; background-color: #f87171; }

@keyframes pulse {
    0%, 60%, 100% { transform: scale(1); opacity: 0.5; }
    30% { transform: scale(1.4); opacity: 1; }
}

/* Contenedor de mensajes */
#chatBox {
    display: flex;
    flex-direction: column;
    gap: 16px;
    padding: 16px;
    background: rgba(0,0,0,0.2);
    border-radius: 20px;
    min-height: 320px;
}

/* Scrollbar personalizada */
#chatBox::-webkit-scrollbar {
    width: 6px;
}

#chatBox::-webkit-scrollbar-track {
    background: #2a2a2a;
    border-radius: 10px;
}

#chatBox::-webkit-scrollbar-thumb {
    background: #dc2626;
    border-radius: 10px;
}

#chatBox::-webkit-scrollbar-thumb:hover {
    background: #ef4444;
}

/* INPUT - Caja de texto */
#userInput {
    background: #2a2a2a;
    color: #ffffff;
    border: 2px solid #333333;
    border-radius: 30px;
    padding: 14px 22px;
    font-size: 1rem;
    transition: all 0.3s ease;
}

#userInput:focus {
    border-color: #dc2626;
    outline: none;
    box-shadow: 0 0 0 3px rgba(220, 38, 38, 0.2);
    background: #222222;
}

#userInput::placeholder {
    color: #6b7280;
    font-style: italic;
}

/* Botón de enviar */
button[onclick="sendMessage()"] {
    background: #dc2626;
    color: white;
    border: none;
    border-radius: 30px;
    padding: 14px 28px;
    font-weight: 600;
    letter-spacing: 0.5px;
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(220, 38, 38, 0.3);
}

button[onclick="sendMessage()"]:hover {
    background: #b91c1c;
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(220, 38, 38, 0.4);
}

button[onclick="sendMessage()"]:active {
    transform: translateY(0);
}

/* Mensaje de bienvenida especial */
.message-bot:first-child {
    background: linear-gradient(135deg, #2a2a2a 0%, #1a1a1a 100%);
    border-left: 4px solid #dc2626;
}

/* Efecto de brillo en mensajes al pasar el mouse */
.message-bot:hover, .message-user:hover {
    filter: brightness(1.1);
    transition: all 0.2s ease;
}
</style>