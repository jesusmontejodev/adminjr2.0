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
<!-- SCRIPT PARA FUNCIONALIDAD MÓVIL -->
<script>
document.addEventListener("DOMContentLoaded", function () {
    const menuBtn = document.getElementById('menuBtn');
    const mobileMenu = document.getElementById('mobileMenu');
    const navBar = document.getElementById('navBar');

    // Toggle menú móvil
    menuBtn.addEventListener('click', function (e) {
        e.stopPropagation();
        mobileMenu.classList.toggle('hidden');
    });

    // Cerrar menú al hacer click fuera
    document.addEventListener('click', function(event) {
        if (!mobileMenu.contains(event.target) && !menuBtn.contains(event.target)) {
            mobileMenu.classList.add('hidden');
        }
    });

    // Cerrar menú al hacer click en enlaces
    const mobileLinks = mobileMenu.querySelectorAll('a');
    mobileLinks.forEach(link => {
        link.addEventListener('click', function() {
            mobileMenu.classList.add('hidden');
        });
    });

    // Efecto scroll sutil
    window.addEventListener('scroll', function () {
        if (window.scrollY > 50) {
            navBar.classList.add('bg-white/95', 'shadow-[0_8px_30px_rgb(0,0,0,0.1)]');
            navBar.classList.remove('bg-white/95', 'shadow-[0_8px_30px_rgb(0,0,0,0.05)]');
        } else {
            navBar.classList.remove('bg-white/95', 'shadow-[0_8px_30px_rgb(0,0,0,0.1)]');
            navBar.classList.add('bg-white/95', 'shadow-[0_8px_30px_rgb(0,0,0,0.05)]');
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
    px-6 py-3
    bg-white/95
    backdrop-blur-md
    border border-gray-200/80
    shadow-[0_8px_30px_rgb(0,0,0,0.05)]
    transition-all duration-300
    relative">

    <!-- LOGO Avaspace -->
    <a href="/" class="flex items-center gap-2.5 group">
        <div class="relative">
            <img src="{{ asset('avaspace.svg') }}"
                alt="Avaspace"
                class="h-9 sm:h-10 relative z-11">
        </div>
    </a>

    <!-- MENU DESKTOP -->
    <div class="hidden md:flex items-center absolute left-1/2 -translate-x-1/2 gap-8">
        <a href="{{ route('nosotros') }}" class="text-sm font-medium text-gray-600 hover:text-red-600 transition-colors px-1">Contacto</a>
        <a href="#funciones" class="text-sm font-medium text-gray-600 hover:text-red-600 transition-colors px-1">Funciones</a>
        <a href="#precios" class="text-sm font-medium text-gray-600 hover:text-red-600 transition-colors px-1">Precios</a>
</div>

    <!-- BOTONES DESKTOP --->
    <div class="hidden md:flex items-center gap-2">
<!-- Botón Iniciar sesión -->
<a href="{{ route('login') }}"
   class="px-5 py-2 bg-transparent border border-gray-800 hover:bg-gray-900 text-gray-800 hover:text-white text-sm font-medium rounded-full
          transition-all duration-200">
    Iniciar sesión
</a>
        <!-- Botón Crear cuenta-->
        <a href="{{ route('register') }}"
           class="px-5 py-2 bg-gradient-to-r from-red-600 to-red-500 hover:from-red-700 hover:to-red-600 text-white text-sm font-semibold rounded-full
                  shadow-md shadow-red-200 hover:shadow-lg hover:shadow-red-300
                  transition-all duration-200 hover:scale-105
                  flex items-center gap-1.5">
            <span>Crear cuenta</span>
        </a>
    </div>

    <!-- BOTÓN HAMBURGUESA MÓVIL -->
    <button id="menuBtn" class="md:hidden flex items-center justify-center w-10 h-10 rounded-full bg-white border border-gray-200 hover:border-red-300 text-gray-600 hover:text-red-600 hover:bg-red-50 transition-all shadow-sm">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
        </svg>
    </button>

    <!-- MENU MÓVIL-->
    <div id="mobileMenu" class="
        absolute top-full right-4 mt-4
        hidden
        w-72
        bg-white/95
        backdrop-blur-md
        border border-gray-200
        rounded-2xl
        shadow-2xl
        p-5
        space-y-3
        text-gray-700
    ">
        <!-- Header del menú móvil -->
        <div class="flex items-center gap-3 pb-4 border-b border-gray-100">
            <img src="{{ asset('avaspace.svg') }}" alt="Avaspace" class="h-10 w-auto">
            <div>
                <div class="text-base font-semibold text-gray-900">Avaspace</div>
                <div class="text-xs text-gray-500">Admin JR</div>
            </div>
        </div>
        
        <!-- Opciones del menú -->
        <a href="{{ route('nosotros') }}" class="block px-4 py-3 text-gray-700 hover:text-red-600 hover:bg-red-50 rounded-xl transition-all font-medium">Contacto</a>
        <a href="#funciones" class="block px-4 py-3 text-gray-700 hover:text-red-600 hover:bg-red-50 rounded-xl transition-all font-medium">Funciones</a>
        <a href="#precios" class="block px-4 py-3 text-gray-700 hover:text-red-600 hover:bg-red-50 rounded-xl transition-all font-medium">Precios</a>
        
        <!-- BOTONES MÓVIL-->
        <div class="pt-4 mt-2 border-t border-gray-100 space-y-3">
            <!-- Botón Iniciar sesión-->
            <a href="{{ route('login') }}" 
                class="flex items-center justify-center w-full px-5 py-3 bg-white border border-gray-300 hover:border-red-300 text-gray-700 hover:text-red-600 text-sm font-medium rounded-xl shadow-sm hover:shadow transition-all">
                Iniciar sesión
            </a>
            
            <!-- Botón Crear cuenta-->
            <a href="{{ route('register') }}" 
               class="flex items-center justify-center w-full px-5 py-3 bg-gradient-to-r from-red-600 to-red-500 hover:from-red-700 hover:to-red-600 text-white text-sm font-semibold rounded-xl shadow-md shadow-red-200 hover:shadow-lg transition-all gap-2">
                <span>Crear cuenta gratis</span>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                </svg>
            </a>
        </div>
    </div>

</nav>
</header>
<!-- HERO SECTION - 100% RESPONSIVE (MISMO DISEÑO) -->
<section class="relative pt-24 sm:pt-32 md:pt-36 lg:pt-44 pb-20 sm:pb-24 md:pb-28 lg:pb-36 flex flex-col items-center text-center overflow-hidden px-4 sm:px-6">

    <!-- Badge minimalista - responsive -->
    <div class="mb-6 sm:mb-7 md:mb-8 inline-flex items-center gap-2 sm:gap-3 px-4 sm:px-5 md:px-6 py-2 sm:py-2.5 md:py-3 
                bg-white border-2 border-gray-900 rounded-full 
                shadow-[2px_2px_0_0_#000000] sm:shadow-[3px_3px_0_0_#000000]
                hover:border-red-600 hover:shadow-[3px_3px_0_0_#dc2626] sm:hover:shadow-[4px_4px_0_0_#dc2626]
                transition-all duration-300
                group">

        <div class="w-5 h-5 sm:w-6 sm:h-6 flex items-center justify-center">
            <img src="{{ asset('avaspace.svg') }}" alt="Avaspace" class="h-5 sm:h-6">
        </div>

        <span class="text-xs sm:text-sm font-bold text-gray-900 tracking-wide whitespace-nowrap sm:whitespace-normal">
            Tu asistente administrativo inteligente
        </span>
        
        <span class="w-1 sm:w-1.5 h-1 sm:h-1.5 bg-red-600 rounded-full animate-pulse"></span>
    </div>

    <!-- Título limpio - responsive -->
    <h1 class="text-3xl sm:text-4xl md:text-5xl lg:text-6xl xl:text-7xl
                font-light tracking-tight
                leading-[1.1] sm:leading-[1.08]
                max-w-4xl mx-auto text-gray-900
                px-2">
        
        Si sabes enviar un
        <span class="text-red-600 font-normal">WhatsApp</span>,<br class="hidden sm:block">
        
        puedes dominar tus finanzas<br class="hidden sm:block">
        
        como un
        <span class="text-red-600 font-normal">experto</span>.
    </h1>

    <!-- Subrayado sutil - responsive -->
    <div class="mt-3 sm:mt-4 w-16 sm:w-20 md:w-24 h-[2px] bg-gradient-to-r from-transparent via-red-400 to-transparent"></div>

    <!-- Descripción elegante - responsive -->
    <p class="mt-6 sm:mt-7 md:mt-8 text-sm sm:text-base md:text-lg lg:text-xl text-gray-600
                max-w-2xl mx-auto
                leading-relaxed
                px-4 sm:px-6">
        
        Olvídate de planillas y procesos complicados.
        
        <span class="text-red-600 font-medium">Admin JR</span>
        organiza, categoriza y actualiza
        tu panel financiero al instante.
        
        <span class="text-gray-900 font-medium">Simple</span>,
        <span class="text-gray-900 font-medium">rápido</span>
        y
        <span class="text-gray-900 font-medium">sin esfuerzo</span>.
    </p>

    <!-- IMAGEN - responsive con tooltips que se ocultan en móvil -->
    <div class="mt-10 sm:mt-12 md:mt-14 flex justify-center w-full max-w-5xl px-4">
        <div class="relative w-full max-w-[280px] xs:max-w-xs sm:max-w-sm md:max-w-md group mx-auto">

            <!-- Glow oscuro - responsive -->
            <div class="absolute inset-0 rounded-2xl sm:rounded-3xl
                        bg-black/40
                        blur-2xl sm:blur-3xl
                        opacity-30
                        group-hover:opacity-50
                        transition-opacity duration-500">
            </div>

            <!-- Imagen - responsive -->
            <img src="{{ asset('images/mockup1.png') }}"
                alt="Mockup Admin JR"
                class="relative w-full h-auto object-contain rounded-2xl sm:rounded-3xl
                       transform group-hover:scale-[1.01] transition-transform duration-300">

            <!-- Tooltips - visibles solo en pantallas grandes -->
            <div class="hidden lg:block">
                <!-- Tooltip izquierdo -->
                <div class="absolute top-20 -left-20
                            bg-red-600/90 border border-red-500/60
                            text-white text-sm px-4 py-2 rounded-lg
                            shadow-[4px_4px_0_0_#000000]
                            backdrop-blur-sm
                            tooltip-auto tooltip-delay-1
                            before:absolute before:top-1/2 before:-right-2 before:w-2 before:h-2
                            before:bg-red-600/90 before:border-r before:border-t before:border-red-500/60
                            before:rotate-45 before:-translate-y-1/2">
                    Categorizado automáticamente
                </div>

                <!-- Tooltip derecho -->
                <div class="absolute top-40 -right-20
                            bg-red-600/90 border border-red-500/60
                            text-white text-sm px-4 py-2 rounded-lg
                            shadow-[4px_4px_0_0_#000000]
                            backdrop-blur-sm
                            tooltip-auto tooltip-delay-2
                            before:absolute before:top-1/2 before:-left-2 before:w-2 before:h-2
                            before:bg-red-600/90 before:border-l before:border-b before:border-red-500/60
                            before:rotate-45 before:-translate-y-1/2">
                    Procesado en segundos
                </div>

                <!-- Tooltip inferior -->
                <div class="absolute bottom-32 -right-12
                            bg-red-600/90 border border-red-500/60
                            text-white text-sm px-4 py-2 rounded-lg
                            shadow-[4px_4px_0_0_#000000]
                            backdrop-blur-sm
                            tooltip-auto tooltip-delay-3
                            before:absolute before:top-full before:left-6 before:w-2 before:h-2
                            before:bg-red-600/90 before:border-l before:border-t before:border-red-500/60
                            before:rotate-45 before:-translate-y-[5px]">
                    Registro de tus finanzas
                </div>
            </div>
            
            <!-- Versión mini de tooltips para móvil (opcional, comentado por si quieres activarlo)
            <div class="lg:hidden absolute inset-x-0 -bottom-8 flex justify-center gap-2">
                <span class="text-[10px] bg-red-600/80 text-white px-2 py-1 rounded-full">Categorizado</span>
                <span class="text-[10px] bg-red-600/80 text-white px-2 py-1 rounded-full">Segundos</span>
                <span class="text-[10px] bg-red-600/80 text-white px-2 py-1 rounded-full">Registro</span>
            </div>
            -->
        </div>
    </div>

    <!-- CTA con efecto de brillo - responsive -->
    <div class="mt-10 sm:mt-12 md:mt-14">
        <a href="{{ route('register') }}"
           class="relative inline-flex items-center gap-2 sm:gap-3 px-6 sm:px-7 md:px-8 py-3 sm:py-3.5 md:py-4
                  bg-gradient-to-r from-red-600 to-red-500 hover:from-red-700 hover:to-red-600
                  text-white font-medium text-sm sm:text-base md:text-lg
                  rounded-full
                  transition-all duration-500
                  shadow-[3px_3px_0_0_#000000] sm:shadow-[4px_4px_0_0_#000000] hover:shadow-[4px_4px_0_0_#000000] sm:hover:shadow-[6px_6px_0_0_#000000]
                  hover:scale-105
                  overflow-hidden
                  group">
            
            <!-- Efecto de brillo -->
            <span class="absolute inset-0 bg-white/30 translate-x-[-100%] group-hover:translate-x-[100%] transition-transform duration-700"></span>
            
            <!-- Texto e icono -->
            <span class="relative z-10">Comenzar ahora</span>
            <svg class="w-4 h-4 sm:w-5 sm:h-5 relative z-10 transition-transform duration-300 group-hover:translate-x-1" 
                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
            </svg>
        </a>
    </div>

    <!-- Elementos decorativos sutiles - responsive -->
    <div class="absolute top-1/2 left-0 w-48 sm:w-64 md:w-96 h-48 sm:h-64 md:h-96 bg-gradient-to-r from-red-500/10 to-transparent rounded-full blur-2xl md:blur-3xl -z-10"></div>
    <div class="absolute bottom-1/2 right-0 w-48 sm:w-64 md:w-96 h-48 sm:h-64 md:h-96 bg-gradient-to-l from-red-500/10 to-transparent rounded-full blur-2xl md:blur-3xl -z-10"></div>
    
    <!-- Líneas decorativas abstractas - se ocultan en móvil -->
    <div class="hidden sm:block absolute top-20 left-10 w-px h-40 bg-gradient-to-b from-transparent via-red-500/20 to-transparent opacity-30"></div>
    <div class="hidden sm:block absolute bottom-20 right-10 w-px h-40 bg-gradient-to-t from-transparent via-red-500/20 to-transparent opacity-30"></div>
</section>

<!-- SECCIÓN VIDEO - 100% RESPONSIVE (MISMO DISEÑO) -->
<section class="relative mt-16 sm:mt-20 md:mt-24 flex flex-col items-center overflow-hidden px-4 sm:px-6">

    <!-- Elementos decorativos de fondo - responsive -->
    <div class="absolute inset-0 pointer-events-none">
        <div class="absolute top-0 left-1/4 w-48 sm:w-64 md:w-96 h-48 sm:h-64 md:h-96 bg-red-500/5 rounded-full blur-2xl md:blur-3xl"></div>
        <div class="absolute bottom-0 right-1/4 w-48 sm:w-64 md:w-96 h-48 sm:h-64 md:h-96 bg-amber-500/5 rounded-full blur-2xl md:blur-3xl"></div>
    </div>

    <!-- Badge superior - responsive -->
    <div class="inline-flex items-center gap-1.5 sm:gap-2 px-3 sm:px-4 md:px-5 py-1.5 sm:py-2 bg-white border-2 border-gray-900 rounded-full mb-6 sm:mb-7 md:mb-8 shadow-[2px_2px_0_0_#000000] sm:shadow-[3px_3px_0_0_#000000] z-10">
        <span class="w-1.5 sm:w-2 h-1.5 sm:h-2 bg-red-600 rounded-full animate-pulse"></span>
        <span class="text-[10px] sm:text-xs font-bold text-gray-900 uppercase tracking-wider">VIDEO DEMOSTRATIVO</span>
    </div>

    <!-- Contenedor de video con diseño mejorado - responsive -->
    <div class="relative w-full max-w-5xl group px-2 sm:px-0">
        
        <!-- Glows decorativos - responsive (menos intensos en móvil) -->
        <div class="absolute -inset-2 sm:-inset-3 md:-inset-4 rounded-2xl sm:rounded-3xl bg-gradient-to-r from-red-600/20 via-amber-500/10 to-transparent blur-xl md:blur-2xl opacity-0 group-hover:opacity-40 md:group-hover:opacity-60 transition-opacity duration-700"></div>
        <div class="absolute -inset-1 sm:-inset-2 rounded-2xl sm:rounded-3xl bg-black/10 blur-lg md:blur-xl opacity-0 group-hover:opacity-30 md:group-hover:opacity-40 transition-opacity duration-700"></div>
        
        <!-- Marco decorativo - responsive -->
        <div class="absolute -inset-0.5 sm:-inset-1 rounded-xl sm:rounded-2xl bg-gradient-to-r from-red-600 to-amber-500 opacity-0 group-hover:opacity-20 md:group-hover:opacity-30 blur transition-all duration-500"></div>

        <!-- Contenedor del video - responsive -->
        <div class="relative rounded-xl sm:rounded-2xl overflow-hidden
                    border-2 border-gray-900
                    bg-white
                    shadow-[4px_4px_0_0_#000000] sm:shadow-[6px_6px_0_0_#000000] md:shadow-[8px_8px_0_0_#000000]
                    group-hover:shadow-[6px_6px_0_0_#dc2626] sm:group-hover:shadow-[8px_8px_0_0_#dc2626] md:group-hover:shadow-[12px_12px_0_0_#dc2626]
                    transition-all duration-500
                    transform group-hover:scale-[1.01]">

            <!-- Barra superior estilo ventana - responsive -->
            <div class="flex items-center gap-1.5 sm:gap-2 px-3 sm:px-4 py-2 sm:py-3 bg-gray-100 border-b-2 border-gray-900">
                <span class="w-2 sm:w-3 h-2 sm:h-3 bg-red-500 rounded-full"></span>
                <span class="w-2 sm:w-3 h-2 sm:h-3 bg-yellow-400 rounded-full"></span>
                <span class="w-2 sm:w-3 h-2 sm:h-3 bg-green-500 rounded-full"></span>
                <span class="text-[10px] sm:text-xs font-medium text-gray-600 ml-1 sm:ml-2">Admin JR - Demo</span>
            </div>

            <!-- Video - 100% responsive -->
            <div class="aspect-video bg-black">
                <iframe class="w-full h-full"
                        src="https://www.youtube.com/embed/qeDBw6sXNTw"
                        title="Admin JR Demo Video"
                        frameborder="0"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                        allowfullscreen>
                </iframe>
            </div>
        </div>
    </div>

    <!-- TEXTO DEBAJO DEL VIDEO - responsive -->
    <div class="mt-8 sm:mt-9 md:mt-10 max-w-3xl text-center relative z-10 px-4 sm:px-6">
        
        <!-- Texto con estilo mejorado - responsive -->
        <p class="text-sm sm:text-base md:text-lg lg:text-xl text-gray-700 leading-relaxed border-l-2 border-red-200 pl-3 sm:pl-4 md:pl-6 italic">
            "Mira cómo puedes registrar tus gastos en segundos usando solo WhatsApp
            y llevar el control de tus finanzas sin planillas ni complicaciones."
        </p>
        <br class="hidden sm:block">
        
        <!-- Línea decorativa superior - responsive -->
        <div class="w-16 sm:w-20 md:w-24 h-0.5 sm:h-1 bg-gradient-to-r from-red-600 to-amber-500 rounded-full mx-auto mb-5 sm:mb-6 shadow-[1px_1px_0_0_#000000]"></div>
        
        <!-- Botón - responsive -->
        <div class="mt-8 sm:mt-9 md:mt-10 relative z-10">
            <a href="{{ route('register') }}"
               class="relative inline-flex items-center gap-2 sm:gap-3 px-6 sm:px-7 md:px-8 py-3 sm:py-3.5 md:py-4
                      bg-gradient-to-r from-red-600 to-red-500 hover:from-red-700 hover:to-red-600
                      text-white font-medium text-sm sm:text-base md:text-lg
                      rounded-full
                      transition-all duration-500
                      shadow-[3px_3px_0_0_#000000] sm:shadow-[4px_4px_0_0_#000000] hover:shadow-[4px_4px_0_0_#000000] sm:hover:shadow-[6px_6px_0_0_#000000]
                      hover:scale-105
                      overflow-hidden
                      group">
                
                <!-- Efecto de brillo - responsive -->
                <span class="absolute inset-0 bg-white/30 w-[200%] h-full -translate-x-[150%] group-hover:translate-x-[150%] transition-transform duration-700 skew-x-12"></span>
                
                <!-- Texto del botón -->
                <span class="relative z-10">Crear cuenta</span>
                
                <!-- Icono flecha - responsive -->
                <svg class="w-4 h-4 sm:w-5 sm:h-5 relative z-10 transition-transform duration-300 group-hover:translate-x-1" 
                     fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                </svg>
            </a>
        </div>
    </div>
</section>

<!-- TERCERA SECCIÓN - 100% RESPONSIVE (MISMO DISEÑO) -->
<section class="relative pt-20 sm:pt-24 md:pt-28 lg:pt-32 pb-12 sm:pb-14 md:pb-16 flex flex-col items-center text-center overflow-hidden px-4 sm:px-6">

    <!-- Elementos decorativos de fondo - responsive -->
    <div class="absolute inset-0 pointer-events-none">
        <div class="absolute top-0 left-1/4 w-48 sm:w-64 md:w-96 h-48 sm:h-64 md:h-96 bg-red-500/5 rounded-full blur-2xl md:blur-3xl"></div>
        <div class="absolute bottom-0 right-1/4 w-48 sm:w-64 md:w-96 h-48 sm:h-64 md:h-96 bg-amber-500/5 rounded-full blur-2xl md:blur-3xl"></div>
    </div>

    <div class="relative z-10 max-w-5xl mx-auto px-4 sm:px-6">

        <!-- Badge superior - responsive -->
        <div class="inline-flex items-center gap-1.5 sm:gap-2 px-3 sm:px-4 md:px-5 py-1.5 sm:py-2 bg-white border-2 border-gray-900 rounded-full mb-6 sm:mb-7 md:mb-8 shadow-[2px_2px_0_0_#000000] sm:shadow-[3px_3px_0_0_#000000]">
            <span class="w-1.5 sm:w-2 h-1.5 sm:h-2 bg-red-600 rounded-full animate-pulse"></span>
            <span class="text-[10px] sm:text-xs font-bold text-gray-900 uppercase tracking-wider">PARA EMPRENDEDORES</span>
        </div>

        <!-- Titular - responsive -->
        <h1 class="text-3xl sm:text-4xl md:text-5xl lg:text-6xl xl:text-7xl 
                   font-light tracking-tight 
                   leading-[1.1] sm:leading-[1.08] 
                   max-w-4xl mx-auto text-gray-900
                   relative
                   px-2">

            Para el emprendedor que quiere hacer <br class="hidden sm:block">

            <span class="text-red-600 font-bold relative">
                crecer
            </span><br class="hidden sm:block">

            su negocio,
            no su papeleo.

        </h1>

        <!-- Línea decorativa con gradiente y sombra - responsive -->
        <div class="mt-4 sm:mt-5 md:mt-6 w-16 sm:w-20 md:w-24 h-0.5 sm:h-1 bg-gradient-to-r from-red-600 to-amber-500 rounded-full mx-auto shadow-[1px_1px_0_0_#000000]"></div>

        <!-- Subtítulo - responsive -->
        <p class="mt-6 sm:mt-7 md:mt-8 text-sm sm:text-base md:text-lg lg:text-xl text-gray-700 
                  max-w-3xl mx-auto leading-relaxed
                  border-l-2 border-red-200 pl-3 sm:pl-4 md:pl-6 italic
                  px-2">

            "Descubre la fortuna que se esconde en tu flujo de caja.
            Reporta ventas y gastos por 
            <span class="font-bold text-red-600">WhatsApp</span>
            y deja que 
            <span class="font-bold text-red-600">Admin JR</span>
            genere tus resúmenes financieros
            mientras tú te enfocas en crecer."

        </p>
   
        <!-- SECCIÓN IMAGEN - responsive -->
        <div class="mt-10 sm:mt-11 md:mt-12 flex justify-center relative z-10">

            <!-- Elementos decorativos de fondo - responsive -->
            <div class="absolute inset-0 pointer-events-none">
                <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[400px] sm:w-[600px] md:w-[800px] h-[400px] sm:h-[600px] md:h-[800px] bg-gradient-to-r from-red-500/5 to-amber-500/5 rounded-full blur-2xl md:blur-3xl"></div>
            </div>

            <!-- Contenedor de imagen - responsive -->
            <div class="relative w-full max-w-[280px] xs:max-w-xs sm:max-w-sm md:max-w-md group">

                <!-- Glow principal más elegante - responsive -->
                <div class="absolute inset-0 rounded-2xl sm:rounded-3xl 
                            bg-gradient-to-r from-red-600/30 via-red-500/20 to-transparent
                            blur-2xl md:blur-3xl
                            opacity-40 sm:opacity-50
                            group-hover:opacity-60 sm:group-hover:opacity-70
                            transition-opacity duration-700">
                </div>
                
                <!-- Segundo glow para profundidad - responsive -->
                <div class="absolute inset-0 rounded-2xl sm:rounded-3xl 
                            bg-black/10
                            blur-xl md:blur-2xl
                            opacity-30 sm:opacity-40
                            group-hover:opacity-40 sm:group-hover:opacity-50
                            transition-opacity duration-700">
                </div>

                <!-- Marco decorativo - responsive -->
                <div class="absolute -inset-1 sm:-inset-2 rounded-2xl sm:rounded-3xl bg-gradient-to-r from-red-600 to-amber-500 opacity-0 group-hover:opacity-20 sm:group-hover:opacity-30 blur-lg md:blur-xl transition-all duration-500"></div>

                <!-- Contenedor de imagen - responsive -->
                <div class="relative rounded-xl sm:rounded-2xl overflow-hidden
                            border-2 border-gray-900
                            bg-white
                            shadow-[4px_4px_0_0_#000000] sm:shadow-[6px_6px_0_0_#000000] md:shadow-[8px_8px_0_0_#000000]
                            group-hover:shadow-[6px_6px_0_0_#dc2626] sm:group-hover:shadow-[8px_8px_0_0_#dc2626] md:group-hover:shadow-[12px_12px_0_0_#dc2626]
                            transition-all duration-500
                            transform group-hover:scale-[1.01] sm:group-hover:scale-[1.02]">

                    <!-- Imagen - responsive -->
                    <img src="{{ asset('images/mockupgif.gif') }}"
                         alt="Mockup Admin JR"
                         class="relative w-full h-auto object-contain z-10">

                </div>
            </div>
        </div>
    </div>

    <!-- Elementos decorativos sutiles - se ocultan en móvil -->
    <div class="hidden sm:block absolute top-20 left-10 w-px h-40 bg-gradient-to-b from-transparent via-red-500/20 to-transparent opacity-30"></div>
    <div class="hidden sm:block absolute bottom-20 right-10 w-px h-40 bg-gradient-to-t from-transparent via-red-500/20 to-transparent opacity-30"></div>
</section>

<!-- MAIN - 100% RESPONSIVE (solo input mejorado en móvil) -->
<main class="max-w-7xl mx-auto px-6 pt-24 pb-24 relative">

<!-- HERO SECTION CHAT -->
<section class="relative mt-32 flex flex-col items-center text-center overflow-hidden px-6">

    <!-- Elementos decorativos -->
    <div class="absolute top-1/4 left-1/2 -translate-x-1/2 -z-10 w-[600px] h-[600px] bg-gradient-to-r from-red-600/10 via-red-500/5 to-transparent blur-[160px] rounded-full"></div>
    <div class="absolute bottom-1/4 right-1/4 -z-10 w-[400px] h-[400px] bg-amber-500/10 blur-[120px] rounded-full"></div>
    
    <!-- Líneas decorativas abstractas -->
    <div class="absolute top-20 left-10 w-px h-40 bg-gradient-to-b from-transparent via-red-500/20 to-transparent opacity-30"></div>
    <div class="absolute bottom-20 right-10 w-px h-40 bg-gradient-to-t from-transparent via-red-500/20 to-transparent opacity-30"></div>

    <div class="relative z-10 max-w-4xl mx-auto">

        <!-- Badge superior -->
        <div class="inline-flex items-center gap-2 px-5 py-2 bg-white border-2 border-gray-900 rounded-full mb-8 shadow-[3px_3px_0_0_#000000]">
            <span class="w-2 h-2 bg-red-600 rounded-full animate-pulse"></span>
            <span class="text-xs font-bold text-gray-900 uppercase tracking-wider">PRUÉBALO AHORA</span>
        </div>

        <!-- TITULO -->
        <h2 class="text-4xl md:text-5xl lg:text-6xl font-light leading-[1.1] tracking-tight mb-6 text-gray-900">
            Si sabes enviar un 
            <span class="text-red-600 font-bold relative">
                mensaje
            </span>,
            ya sabes dominar tus 
            <span class="text-red-600 font-bold relative">
                finanzas
            </span>.
        </h2>

        <!-- Línea decorativa con gradiente -->
        <div class="w-24 h-1 bg-gradient-to-r from-red-600 to-amber-500 rounded-full mx-auto mb-6 shadow-[1px_1px_0_0_#000000]"></div>

        <!-- SUBTITULO -->
        <p class="text-lg md:text-xl text-gray-700 leading-relaxed max-w-2xl mx-auto border-l-2 border-red-200 pl-6 italic">
            "Compruébalo por ti mismo ahora. 
            Solo presiona 'Enviar' y mira cómo la IA procesa tu mensaje."
        </p>

        <br>

    </div>
    
    <!-- PANEL CHAT -->
    <div class="w-full max-w-xl chat-demo-container rounded-xl overflow-hidden">
        <!-- CHAT -->
        <div id="chatBox" class="p-4 space-y-3 text-left h-80 overflow-y-auto flex flex-col bg-white/30 backdrop-blur-sm">
            <div class="message-bot">
                💬 Hola, soy AdminJr. Prueba con este mensaje 👇
            </div>
        </div>
    </div>

    <!-- INPUT CON MENSAJE NATURAL PRECARGADO - MEJORADO SÓLO PARA MÓVIL -->
    <div class="mt-6 w-full max-w-xl flex flex-col sm:flex-row gap-2 sm:gap-2 px-4 sm:px-0">
        <input id="userInput"
            type="text"
            value="Hola, gaste 300 pesos en ropa y lo pague con tarjeta"
            class="w-full sm:flex-1 bg-white border border-gray-300
                   rounded-full px-5 py-4 sm:py-3 outline-none text-base sm:text-base text-gray-800
                   focus:border-red-500 focus:ring-1 focus:ring-red-200 transition
                   placeholder:text-sm">

        <button onclick="sendMessage()" id="sendButton"
            class="w-full sm:w-auto px-6 py-4 sm:py-3 bg-red-600 hover:bg-red-700
                   text-white rounded-full text-base sm:text-base font-medium
                   transition duration-300 shadow-md hover:shadow-lg
                   cursor-pointer active:bg-red-800">
            Enviar
        </button>
    </div>
</section>

<script src="/js/chat-demo.js"></script>
<!-- SECCIÓN 4 - 100% RESPONSIVE (WEB Y MÓVIL) -->
<section class="relative mt-16 sm:mt-20 md:mt-24 lg:mt-32 grid grid-cols-1 md:grid-cols-2 gap-8 sm:gap-10 md:gap-12 lg:gap-16 items-center px-4 sm:px-6 max-w-6xl mx-auto overflow-hidden">

    <!-- Elementos decorativos de fondo - responsive -->
    <div class="absolute inset-0 pointer-events-none">
        <div class="absolute top-0 left-1/4 w-48 sm:w-64 md:w-96 h-48 sm:h-64 md:h-96 bg-red-500/5 rounded-full blur-2xl md:blur-3xl"></div>
        <div class="absolute bottom-0 right-1/4 w-48 sm:w-64 md:w-96 h-48 sm:h-64 md:h-96 bg-amber-500/5 rounded-full blur-2xl md:blur-3xl"></div>
    </div>

    <!-- TEXTO - responsive -->
    <div class="space-y-6 sm:space-y-7 md:space-y-8 relative z-10 order-2 md:order-1">

        <!-- Badge superior - responsive -->
        <div class="inline-flex items-center gap-1.5 sm:gap-2 px-3 sm:px-4 py-1 sm:py-1.5 bg-white border-2 border-gray-900 rounded-full shadow-[2px_2px_0_0_#000000]">
            <span class="w-1.5 sm:w-2 h-1.5 sm:h-2 bg-red-600 rounded-full animate-pulse"></span>
            <span class="text-[10px] sm:text-xs font-bold text-gray-900 uppercase tracking-wider">TRANQUILIDAD FINANCIERA</span>
        </div>

        <!-- Título - responsive -->
        <h2 class="text-3xl sm:text-4xl md:text-5xl lg:text-6xl xl:text-7xl font-light leading-[1.1] sm:leading-[1.05] tracking-tight text-gray-900">
            Despídete de la 
            <span class="text-red-600 font-bold relative block sm:inline">
                ansiedad financiera
            </span>
            para siempre.
        </h2>

        <!-- Línea decorativa con gradiente y sombra - responsive -->
        <div class="w-16 sm:w-20 md:w-24 h-0.5 sm:h-1 bg-gradient-to-r from-red-600 to-amber-500 rounded-full shadow-[1px_1px_0_0_#000000]"></div>

        <!-- Subtítulo - responsive -->
        <p class="text-sm sm:text-base md:text-lg lg:text-xl text-gray-700 leading-relaxed max-w-xl border-l-2 border-red-200 pl-3 sm:pl-4 md:pl-6 italic">
            "La claridad es poder. Al ver tu dinero organizado en 
            <span class="font-bold text-gray-900">tiempo real</span>,
            recuperas el control y la tranquilidad que necesitas
            para hacer crecer tu 
            <span class="font-bold text-red-600">negocio</span> 
            o tu ahorro personal."
        </p>
        
        <!-- Lista de beneficios - responsive -->
        <ul class="space-y-2 pt-2 sm:pt-3 md:pt-4">
            <li class="flex items-center gap-2 text-gray-600">
                <span class="w-1.5 h-1.5 bg-red-600 rounded-full flex-shrink-0"></span>
                <span class="text-xs sm:text-sm">Control total de tus finanzas</span>
            </li>
            <li class="flex items-center gap-2 text-gray-600">
                <span class="w-1.5 h-1.5 bg-red-600 rounded-full flex-shrink-0"></span>
                <span class="text-xs sm:text-sm">Toma decisiones informadas</span>
            </li>
        </ul>
    </div>

    <!-- IMAGEN - responsive -->
    <div class="flex justify-center relative z-10 order-1 md:order-2 mb-6 md:mb-0">
        <div class="relative w-full max-w-[280px] xs:max-w-xs sm:max-w-sm md:max-w-md lg:max-w-sm group">

            <!-- Glows decorativos - responsive -->
            <div class="absolute inset-0 rounded-xl sm:rounded-2xl 
                        bg-gradient-to-r from-red-600/20 via-red-500/10 to-transparent
                        blur-2xl md:blur-3xl opacity-30 sm:opacity-40 group-hover:opacity-50 sm:group-hover:opacity-60 transition-opacity duration-700">
            </div>
            
            <div class="absolute inset-0 rounded-xl sm:rounded-2xl 
                        bg-black/10
                        blur-xl md:blur-2xl opacity-20 sm:opacity-30 group-hover:opacity-30 sm:group-hover:opacity-40 transition-opacity duration-700">
            </div>

            <!-- Marco decorativo - responsive -->
            <div class="absolute -inset-1 rounded-xl sm:rounded-2xl bg-gradient-to-r from-red-600 to-amber-500 opacity-0 group-hover:opacity-20 sm:group-hover:opacity-30 blur-lg md:blur-xl transition-all duration-500"></div>

            <!-- Contenedor imagen con bordes y sombras - responsive -->
            <div class="relative rounded-xl sm:rounded-2xl overflow-hidden
                        border-2 border-gray-900
                        bg-white
                        shadow-[4px_4px_0_0_#000000] sm:shadow-[6px_6px_0_0_#000000] md:shadow-[8px_8px_0_0_#000000]
                        group-hover:shadow-[6px_6px_0_0_#dc2626] sm:group-hover:shadow-[8px_8px_0_0_#dc2626] md:group-hover:shadow-[12px_12px_0_0_#dc2626]
                        transition-all duration-500
                        transform group-hover:scale-[1.01] sm:group-hover:scale-[1.02]">

                <img src="{{ asset('images/mockup3.png') }}"
                     alt="Mockup Admin JR"
                     class="w-full h-auto object-contain relative z-10">

            </div>
        </div>
    </div>
    
    <!-- Líneas decorativas laterales - se ocultan en móvil/tablet -->
    <div class="absolute left-10 top-1/2 -translate-y-1/2 w-px h-40 bg-gradient-to-b from-transparent via-red-500/20 to-transparent opacity-30 hidden xl:block"></div>
    <div class="absolute right-10 top-1/2 -translate-y-1/2 w-px h-40 bg-gradient-to-b from-transparent via-red-500/20 to-transparent opacity-30 hidden xl:block"></div>
</section>
<!-- SECCIÓN FUNCIONES - 100% RESPONSIVE -->
<section id="funciones" class="relative mt-20 sm:mt-24 md:mt-28 lg:mt-32 xl:mt-40 overflow-hidden px-4 sm:px-6">
    
    <!-- Elementos decorativos de fondo - responsive -->
    <div class="absolute inset-0 pointer-events-none">
        <div class="absolute top-0 left-1/4 w-48 sm:w-64 md:w-96 h-48 sm:h-64 md:h-96 bg-red-500/5 rounded-full blur-2xl md:blur-3xl"></div>
        <div class="absolute bottom-0 right-1/4 w-48 sm:w-64 md:w-96 h-48 sm:h-64 md:h-96 bg-amber-500/5 rounded-full blur-2xl md:blur-3xl"></div>
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[400px] sm:w-[500px] md:w-[600px] lg:w-[800px] h-[400px] sm:h-[500px] md:h-[600px] lg:h-[800px] bg-gradient-to-r from-red-500/3 to-amber-500/3 rounded-full blur-2xl md:blur-3xl"></div>
    </div>

    <div class="relative z-10 max-w-6xl mx-auto">

        <!-- TITULO con badge superior - responsive -->
        <div class="text-center mb-10 sm:mb-12 md:mb-14 lg:mb-16">
            <!-- Badge superior - responsive -->
            <div class="inline-flex items-center gap-1.5 sm:gap-2 px-3 sm:px-4 md:px-5 py-1.5 sm:py-2 bg-white border-2 border-gray-900 rounded-full mb-4 sm:mb-5 md:mb-6 shadow-[2px_2px_0_0_#000000] sm:shadow-[3px_3px_0_0_#000000]">
                <span class="w-1.5 sm:w-2 h-1.5 sm:h-2 bg-red-600 rounded-full animate-pulse"></span>
                <span class="text-[10px] sm:text-xs font-bold text-gray-900 uppercase tracking-wider">FUNCIONES</span>
            </div>
    
            <h1 class="text-3xl sm:text-4xl md:text-5xl lg:text-6xl font-light leading-[1.1] tracking-tight mb-4 sm:mb-5 md:mb-6 text-gray-900 px-4">
                Control total de tu negocio,
                <span class="text-red-600 font-bold block sm:inline">desde WhatsApp</span>
            </h1>
            
            <!-- Subrayado con gradiente - responsive -->
            <div class="w-16 sm:w-20 md:w-24 h-0.5 sm:h-1 bg-gradient-to-r from-red-600 to-amber-500 rounded-full mx-auto mb-4 sm:mb-5 md:mb-6 shadow-[1px_1px_0_0_#000000]"></div>

            <p class="text-gray-600 max-w-2xl mx-auto text-sm sm:text-base md:text-lg leading-relaxed border-l-2 border-red-200 pl-3 sm:pl-4 md:pl-6 italic px-4">
                "Admin JR convierte cada mensaje en información organizada,
                reportes automáticos y decisiones más inteligentes."
            </p>
        </div>

        <!-- CAROUSEL 3D - RESPONSIVE (el CSS maneja los tamaños) -->
        <div class="relative w-full flex justify-center items-center py-4 sm:py-6 md:py-8 overflow-visible">
            
            <div id="carousel" class="carousel-3d">

                <!-- CARD 1 - Registro en 3 segundos (los estilos están en CSS) -->
                <div class="card-3d 
                    rounded-3xl 
                    border-2 border-gray-900
                    bg-white
                    p-6 sm:p-8 md:p-10 
                    text-center 
                    transition-all duration-500 
                    hover:border-red-600
                    hover:shadow-[8px_8px_0_0_#dc2626]
                    shadow-[4px_4px_0_0_#000000]
                    relative
                    overflow-hidden
                    group">

                    <!-- Elemento decorativo superior - responsive -->
                    <div class="absolute top-0 right-0 w-16 sm:w-20 md:w-24 h-16 sm:h-20 md:h-24 bg-gradient-to-br from-red-500/10 to-amber-500/10 rounded-bl-full"></div>
                    
                    <!-- Icono - responsive -->
                    <div class="flex justify-center mb-4 sm:mb-6 md:mb-8 relative z-10">
                        <div class="w-12 sm:w-14 md:w-16 h-12 sm:h-14 md:h-16 flex items-center justify-center 
                                    rounded-xl sm:rounded-2xl 
                                    bg-gradient-to-br from-red-600 to-red-500
                                    border-2 border-gray-900
                                    shadow-[3px_3px_0_0_#000000]
                                    group-hover:shadow-[5px_5px_0_0_#000000]
                                    transition-all duration-300">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 24 24"
                                fill="currentColor"
                                class="w-6 sm:w-7 md:w-8 h-6 sm:h-7 md:h-8 text-white">
                                <path d="M12 2C6.48 2 2 6.02 2 11.5S6.48 21 12 21s10-4.02 10-9.5S17.52 2 12 2zm1 15.93V19h-2v-1.07c-1.72-.2-3-1.39-3-3.01h2c0 .83.67 1.5 1.5 1.5S13 15.75 13 15s-.67-1.5-1.5-1.5c-1.93 0-3.5-1.57-3.5-3.5 0-1.62 1.28-2.81 3-3.01V5h2v1.07c1.72.2 3 1.39 3 3.01h-2c0-.83-.67-1.5-1.5-1.5S11 8.25 11 9s.67 1.5 1.5 1.5c1.93 0 3.5 1.57 3.5 3.5 0 1.62-1.28 2.81-3 3.01z"/>
                            </svg>
                        </div>
                    </div>

                    <h3 class="text-xl sm:text-2xl font-bold text-gray-900 mb-2 sm:mb-3 md:mb-4 tracking-wide flex flex-wrap items-center justify-center gap-1 sm:gap-2">
                        Registro en <span class="text-red-600 bg-red-50 px-2 py-0.5 rounded-lg border border-red-200 shadow-[1px_1px_0_0_#000000] text-sm sm:text-base md:text-xl">3 segundos</span>
                    </h3>

                    <p class="text-gray-600 leading-relaxed text-xs sm:text-sm md:text-base">
                        Escribe tu venta o gasto y Admin JR lo convierte
                        en datos organizados automáticamente.
                    </p>
                    
                    <!-- Feature tag - responsive -->
                    <div class="mt-4 sm:mt-5 md:mt-6 inline-flex items-center gap-1 px-3 sm:px-4 py-1 sm:py-1.5 bg-gray-900 rounded-full border border-gray-700 shadow-[2px_2px_0_0_#dc2626]">
                        <span class="w-1 sm:w-1.5 h-1 sm:h-1.5 bg-red-500 rounded-full animate-pulse"></span>
                        <span class="text-[10px] sm:text-xs text-white font-medium">Automático</span>
                    </div>
                </div>

                <!-- CARD 2 - Recordatorios inteligentes -->
                <div class="card-3d 
                            rounded-3xl 
                            border-2 border-gray-900
                            bg-white
                            p-6 sm:p-8 md:p-10 
                            text-center 
                            transition-all duration-500 
                            hover:border-red-600
                            hover:shadow-[8px_8px_0_0_#dc2626]
                            shadow-[4px_4px_0_0_#000000]
                            relative
                            overflow-hidden
                            group">

                    <div class="absolute top-0 right-0 w-16 sm:w-20 md:w-24 h-16 sm:h-20 md:h-24 bg-gradient-to-br from-red-500/10 to-amber-500/10 rounded-bl-full"></div>
                    
                    <div class="flex justify-center mb-4 sm:mb-6 md:mb-8 relative z-10">
                        <div class="w-12 sm:w-14 md:w-16 h-12 sm:h-14 md:h-16 flex items-center justify-center 
                                    rounded-xl sm:rounded-2xl 
                                    bg-gradient-to-br from-red-600 to-red-500
                                    border-2 border-gray-900
                                    shadow-[3px_3px_0_0_#000000]
                                    group-hover:shadow-[5px_5px_0_0_#000000]
                                    transition-all duration-300">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 24 24"
                                fill="currentColor"
                                class="w-6 sm:w-7 md:w-8 h-6 sm:h-7 md:h-8 text-white">
                                <path d="M12 22c1.1 0 2-.9 2-2h-4c0 1.1.9 2 2 2zm6-6v-5c0-3.07-1.63-5.64-4.5-6.32V4c0-.83-.67-1.5-1.5-1.5S10.5 3.17 10.5 4v.68C7.63 5.36 6 7.92 6 11v5l-2 2v1h16v-1l-2-2z"/>
                            </svg>
                        </div>
                    </div>

                    <h3 class="text-xl sm:text-2xl font-bold text-gray-900 mb-2 sm:mb-3 md:mb-4 tracking-wide flex flex-wrap items-center justify-center gap-1 sm:gap-2">
                        Recordatorios <span class="text-red-600 bg-red-50 px-2 py-0.5 rounded-lg border border-red-200 shadow-[1px_1px_0_0_#000000] text-sm sm:text-base md:text-xl">inteligentes</span>
                    </h3>

                    <p class="text-gray-600 leading-relaxed text-xs sm:text-sm md:text-base">
                        Si olvidas registrar algo, tu asistente te avisa.
                        Siempre atento, siempre disponible.
                    </p>
                    
                    <div class="mt-4 sm:mt-5 md:mt-6 inline-flex items-center gap-1 px-3 sm:px-4 py-1 sm:py-1.5 bg-gray-900 rounded-full border border-gray-700 shadow-[2px_2px_0_0_#dc2626]">
                        <span class="w-1 sm:w-1.5 h-1 sm:h-1.5 bg-red-500 rounded-full animate-pulse"></span>
                        <span class="text-[10px] sm:text-xs text-white font-medium">Proactivo</span>
                    </div>
                </div>

                <!-- CARD 3 - Resumen 24/7 -->
                <div class="card-3d 
                            rounded-3xl 
                            border-2 border-gray-900
                            bg-white
                            p-6 sm:p-8 md:p-10 
                            text-center 
                            transition-all duration-500 
                            hover:border-red-600
                            hover:shadow-[8px_8px_0_0_#dc2626]
                            shadow-[4px_4px_0_0_#000000]
                            relative
                            overflow-hidden
                            group">

                    <div class="absolute top-0 right-0 w-16 sm:w-20 md:w-24 h-16 sm:h-20 md:h-24 bg-gradient-to-br from-red-500/10 to-amber-500/10 rounded-bl-full"></div>
                    
                    <div class="flex justify-center mb-4 sm:mb-6 md:mb-8 relative z-10">
                        <div class="w-12 sm:w-14 md:w-16 h-12 sm:h-14 md:h-16 flex items-center justify-center 
                                    rounded-xl sm:rounded-2xl 
                                    bg-gradient-to-br from-red-600 to-red-500
                                    border-2 border-gray-900
                                    shadow-[3px_3px_0_0_#000000]
                                    group-hover:shadow-[5px_5px_0_0_#000000]
                                    transition-all duration-300">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 24 24"
                                fill="currentColor"
                                class="w-6 sm:w-7 md:w-8 h-6 sm:h-7 md:h-8 text-white">
                                <path d="M4 9h3v11H4V9zm6-5h3v16h-3V4zm6 8h3v8h-3v-8z"/>
                            </svg>
                        </div>
                    </div>

                    <h3 class="text-xl sm:text-2xl font-bold text-gray-900 mb-2 sm:mb-3 md:mb-4 tracking-wide flex flex-wrap items-center justify-center gap-1 sm:gap-2">
                        Resumen <span class="text-red-600 bg-red-50 px-2 py-0.5 rounded-lg border border-red-200 shadow-[1px_1px_0_0_#000000] text-sm sm:text-base md:text-xl">24/7</span>
                    </h3>

                    <p class="text-gray-600 leading-relaxed text-xs sm:text-sm md:text-base">
                        Pregunta cómo va tu negocio y recibe reportes claros,
                        gráficos dinámicos y control total.
                    </p>
                </div>

            </div>
        </div>
        
        <!-- Indicadores de posición con estilo premium - responsive -->
        <div class="flex justify-center gap-2 sm:gap-3 mt-6 sm:mt-7 md:mt-8">
            <span class="w-6 sm:w-7 md:w-8 h-1.5 sm:h-2 bg-gray-900 rounded-full shadow-[1px_1px_0_0_#dc2626]"></span>
            <span class="w-1.5 sm:w-2 h-1.5 sm:h-2 bg-gray-300 rounded-full"></span>
            <span class="w-1.5 sm:w-2 h-1.5 sm:h-2 bg-gray-300 rounded-full"></span>
        </div>
    </div>
</section>
<!-- PREGUNTAS FRECUENTES - 100% RESPONSIVE -->
<section class="relative mt-16 sm:mt-20 md:mt-24 lg:mt-28 xl:mt-32 px-4 sm:px-6 overflow-hidden">

    <!-- Elementos decorativos de fondo - responsive -->
    <div class="absolute inset-0 pointer-events-none">
        <div class="absolute top-0 left-1/4 w-48 sm:w-64 md:w-96 h-48 sm:h-64 md:h-96 bg-red-500/5 rounded-full blur-2xl md:blur-3xl"></div>
        <div class="absolute bottom-0 right-1/4 w-48 sm:w-64 md:w-96 h-48 sm:h-64 md:h-96 bg-amber-500/5 rounded-full blur-2xl md:blur-3xl"></div>
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[400px] sm:w-[500px] md:w-[600px] lg:w-[800px] h-[400px] sm:h-[500px] md:h-[600px] lg:h-[800px] bg-gradient-to-r from-red-500/3 to-amber-500/3 rounded-full blur-2xl md:blur-3xl"></div>
    </div>

    <div class="max-w-4xl mx-auto relative z-10">

        <!-- TITULO CENTRADO con badge superior - responsive -->
        <div class="text-center mb-8 sm:mb-10 md:mb-12">
            <!-- Badge superior - responsive -->
            <div class="inline-flex items-center gap-1.5 sm:gap-2 px-3 sm:px-4 md:px-5 py-1.5 sm:py-2 bg-white border-2 border-gray-900 rounded-full mb-4 sm:mb-5 md:mb-6 shadow-[2px_2px_0_0_#000000] sm:shadow-[3px_3px_0_0_#000000]">
                <span class="w-1.5 sm:w-2 h-1.5 sm:h-2 bg-red-600 rounded-full animate-pulse"></span>
                <span class="text-[10px] sm:text-xs font-bold text-gray-900 uppercase tracking-wider">SOPORTE</span>
            </div>
            
            <h2 class="text-3xl sm:text-4xl md:text-5xl lg:text-6xl font-light leading-[1.1] tracking-tight mb-4 sm:mb-5 md:mb-6 text-gray-900 px-4">
                Preguntas <span class="text-red-600 font-bold relative">frecuentes</span>
            </h2>
            
            <!-- Línea decorativa con gradiente - responsive -->
            <div class="w-16 sm:w-20 md:w-24 h-0.5 sm:h-1 bg-gradient-to-r from-red-600 to-amber-500 rounded-full mx-auto shadow-[1px_1px_0_0_#000000]"></div>
        </div>

        <div class="space-y-3 sm:space-y-4 px-2 sm:px-0">

            <!-- ITEM 01 - responsive -->
            <div class="faq-item rounded-xl sm:rounded-2xl border border-gray-300 bg-white hover:border-red-500/50 hover:shadow-lg transition-all duration-300">
                <button onclick="toggleFaq(this)"
                        class="w-full flex justify-between items-center px-4 sm:px-5 md:px-6 py-4 sm:py-5 md:py-6 text-left group">

                    <div class="flex items-center gap-2 sm:gap-3 md:gap-4">
                        <span class="flex items-center justify-center w-6 sm:w-7 md:w-8 h-6 sm:h-7 md:h-8 rounded-full bg-black text-white text-xs sm:text-sm font-semibold group-hover:bg-red-600 transition-colors duration-300">01</span>
                        <span class="text-gray-900 text-sm sm:text-base md:text-lg font-medium group-hover:text-red-600 transition-colors duration-300">
                            ¿Qué es Admin JR?
                        </span>
                    </div>

                    <span class="faq-icon text-2xl sm:text-3xl text-black group-hover:text-red-600 transition-all duration-300">+</span>

                </button>

                <div class="faq-content hidden px-4 sm:px-5 md:px-6 pb-4 sm:pb-5 md:pb-6 text-gray-600 text-xs sm:text-sm md:text-base leading-relaxed border-t border-gray-100 mt-2 pt-3 sm:pt-4">
                    Admin JR es un asistente administrativo digital que funciona desde WhatsApp
                    y te ayuda a llevar el control de tus ingresos y gastos de forma simple y ordenada.
                </div>
            </div>

            <!-- ITEM 02 - responsive -->
            <div class="faq-item rounded-xl sm:rounded-2xl border border-gray-300 bg-white hover:border-red-500/50 hover:shadow-lg transition-all duration-300">
                <button onclick="toggleFaq(this)"
                        class="w-full flex justify-between items-center px-4 sm:px-5 md:px-6 py-4 sm:py-5 md:py-6 text-left group">

                    <div class="flex items-center gap-2 sm:gap-3 md:gap-4">
                        <span class="flex items-center justify-center w-6 sm:w-7 md:w-8 h-6 sm:h-7 md:h-8 rounded-full bg-black text-white text-xs sm:text-sm font-semibold group-hover:bg-red-600 transition-colors duration-300">02</span>
                        <span class="text-gray-900 text-sm sm:text-base md:text-lg font-medium group-hover:text-red-600 transition-colors duration-300">
                            ¿Necesito descargar una app?
                        </span>
                    </div>

                    <span class="faq-icon text-2xl sm:text-3xl text-black group-hover:text-red-600 transition-all duration-300">+</span>

                </button>

                <div class="faq-content hidden px-4 sm:px-5 md:px-6 pb-4 sm:pb-5 md:pb-6 text-gray-600 text-xs sm:text-sm md:text-base leading-relaxed border-t border-gray-100 mt-2 pt-3 sm:pt-4">
                    No, Admin JR funciona directamente en WhatsApp,
                    sin descargas ni plataformas complicadas.
                </div>
            </div>

            <!-- ITEM 03 - responsive -->
            <div class="faq-item rounded-xl sm:rounded-2xl border border-gray-300 bg-white hover:border-red-500/50 hover:shadow-lg transition-all duration-300">
                <button onclick="toggleFaq(this)"
                        class="w-full flex justify-between items-center px-4 sm:px-5 md:px-6 py-4 sm:py-5 md:py-6 text-left group">

                    <div class="flex items-center gap-2 sm:gap-3 md:gap-4">
                        <span class="flex items-center justify-center w-6 sm:w-7 md:w-8 h-6 sm:h-7 md:h-8 rounded-full bg-black text-white text-xs sm:text-sm font-semibold group-hover:bg-red-600 transition-colors duration-300">03</span>
                        <span class="text-gray-900 text-sm sm:text-base md:text-lg font-medium group-hover:text-red-600 transition-colors duration-300">
                            ¿Para quién es Admin JR?
                        </span>
                    </div>

                    <span class="faq-icon text-2xl sm:text-3xl text-black group-hover:text-red-600 transition-all duration-300">+</span>

                </button>

                <div class="faq-content hidden px-4 sm:px-5 md:px-6 pb-4 sm:pb-5 md:pb-6 text-gray-600 text-xs sm:text-sm md:text-base leading-relaxed border-t border-gray-100 mt-2 pt-3 sm:pt-4">
                    Para emprendedores, pequeños negocios y freelancers que:
                    <ul class="list-disc pl-4 sm:pl-5 mt-1 sm:mt-2 space-y-0.5 sm:space-y-1">
                        <li>Llevan su administración solos</li>
                        <li>No tienen tiempo para Excel</li>
                        <li>Quieren claridad real de su dinero</li>
                    </ul>
                </div>
            </div>

            <!-- ITEM 04 - responsive -->
            <div class="faq-item rounded-xl sm:rounded-2xl border border-gray-300 bg-white hover:border-red-500/50 hover:shadow-lg transition-all duration-300">
                <button onclick="toggleFaq(this)"
                        class="w-full flex justify-between items-center px-4 sm:px-5 md:px-6 py-4 sm:py-5 md:py-6 text-left group">

                    <div class="flex items-center gap-2 sm:gap-3 md:gap-4">
                        <span class="flex items-center justify-center w-6 sm:w-7 md:w-8 h-6 sm:h-7 md:h-8 rounded-full bg-black text-white text-xs sm:text-sm font-semibold group-hover:bg-red-600 transition-colors duration-300">04</span>
                        <span class="text-gray-900 text-sm sm:text-base md:text-lg font-medium group-hover:text-red-600 transition-colors duration-300">
                            ¿Qué problemas me ayuda a resolver?
                        </span>
                    </div>

                    <span class="faq-icon text-2xl sm:text-3xl text-black group-hover:text-red-600 transition-all duration-300">+</span>

                </button>

                <div class="faq-content hidden px-4 sm:px-5 md:px-6 pb-4 sm:pb-5 md:pb-6 text-gray-600 text-xs sm:text-sm md:text-base leading-relaxed border-t border-gray-100 mt-2 pt-3 sm:pt-4">
                    <ul class="list-disc pl-4 sm:pl-5 space-y-0.5 sm:space-y-1">
                        <li>No saber cuánto ganas realmente</li>
                        <li>Desorden financiero</li>
                        <li>Gastos que se pierden</li>
                        <li>Falta de control del dinero</li>
                    </ul>
                    <p class="mt-1 sm:mt-2">
                        Admin JR te ayuda a ordenar sin complicarte.
                    </p>
                </div>
            </div>

            <!-- ITEM 05 - responsive -->
            <div class="faq-item rounded-xl sm:rounded-2xl border border-gray-300 bg-white hover:border-red-500/50 hover:shadow-lg transition-all duration-300">
                <button onclick="toggleFaq(this)"
                        class="w-full flex justify-between items-center px-4 sm:px-5 md:px-6 py-4 sm:py-5 md:py-6 text-left group">

                    <div class="flex items-center gap-2 sm:gap-3 md:gap-4">
                        <span class="flex items-center justify-center w-6 sm:w-7 md:w-8 h-6 sm:h-7 md:h-8 rounded-full bg-black text-white text-xs sm:text-sm font-semibold group-hover:bg-red-600 transition-colors duration-300">05</span>
                        <span class="text-gray-900 text-sm sm:text-base md:text-lg font-medium group-hover:text-red-600 transition-colors duration-300">
                            ¿Necesito saber de contabilidad?
                        </span>
                    </div>

                    <span class="faq-icon text-2xl sm:text-3xl text-black group-hover:text-red-600 transition-all duration-300">+</span>

                </button>

                <div class="faq-content hidden px-4 sm:px-5 md:px-6 pb-4 sm:pb-5 md:pb-6 text-gray-600 text-xs sm:text-sm md:text-base leading-relaxed border-t border-gray-100 mt-2 pt-3 sm:pt-4">
                    No, Admin JR está diseñado para personas sin conocimientos contables.
                    Solo registras movimientos de dinero de forma sencilla.
                </div>
            </div>

            <!-- ITEM 06 - responsive -->
            <div class="faq-item rounded-xl sm:rounded-2xl border border-gray-300 bg-white hover:border-red-500/50 hover:shadow-lg transition-all duration-300">
                <button onclick="toggleFaq(this)"
                        class="w-full flex justify-between items-center px-4 sm:px-5 md:px-6 py-4 sm:py-5 md:py-6 text-left group">

                    <div class="flex items-center gap-2 sm:gap-3 md:gap-4">
                        <span class="flex items-center justify-center w-6 sm:w-7 md:w-8 h-6 sm:h-7 md:h-8 rounded-full bg-black text-white text-xs sm:text-sm font-semibold group-hover:bg-red-600 transition-colors duration-300">06</span>
                        <span class="text-gray-900 text-sm sm:text-base md:text-lg font-medium group-hover:text-red-600 transition-colors duration-300">
                            ¿Admin JR reemplaza a un contador?
                        </span>
                    </div>

                    <span class="faq-icon text-2xl sm:text-3xl text-black group-hover:text-red-600 transition-all duration-300">+</span>

                </button>

                <div class="faq-content hidden px-4 sm:px-5 md:px-6 pb-4 sm:pb-5 md:pb-6 text-gray-600 text-xs sm:text-sm md:text-base leading-relaxed border-t border-gray-100 mt-2 pt-3 sm:pt-4">
                    No, Admin JR no sustituye a un contador,
                    pero sí te permite tener tu información organizada y lista cuando la necesites.
                </div>
            </div>

            <!-- ITEM 07 - responsive -->
            <div class="faq-item rounded-xl sm:rounded-2xl border border-gray-300 bg-white hover:border-red-500/50 hover:shadow-lg transition-all duration-300">
                <button onclick="toggleFaq(this)"
                        class="w-full flex justify-between items-center px-4 sm:px-5 md:px-6 py-4 sm:py-5 md:py-6 text-left group">

                    <div class="flex items-center gap-2 sm:gap-3 md:gap-4">
                        <span class="flex items-center justify-center w-6 sm:w-7 md:w-8 h-6 sm:h-7 md:h-8 rounded-full bg-black text-white text-xs sm:text-sm font-semibold group-hover:bg-red-600 transition-colors duration-300">07</span>
                        <span class="text-gray-900 text-sm sm:text-base md:text-lg font-medium group-hover:text-red-600 transition-colors duration-300">
                            ¿Mi información está segura?
                        </span>
                    </div>

                    <span class="faq-icon text-2xl sm:text-3xl text-black group-hover:text-red-600 transition-all duration-300">+</span>

                </button>

                <div class="faq-content hidden px-4 sm:px-5 md:px-6 pb-4 sm:pb-5 md:pb-6 text-gray-600 text-xs sm:text-sm md:text-base leading-relaxed border-t border-gray-100 mt-2 pt-3 sm:pt-4">
                    Sí, tu información es privada y confidencial.
                    Solo tú tienes acceso a tus datos.
                </div>
            </div>

            <!-- ITEM 08 - responsive -->
            <div class="faq-item rounded-xl sm:rounded-2xl border border-gray-300 bg-white hover:border-red-500/50 hover:shadow-lg transition-all duration-300">
                <button onclick="toggleFaq(this)"
                        class="w-full flex justify-between items-center px-4 sm:px-5 md:px-6 py-4 sm:py-5 md:py-6 text-left group">

                    <div class="flex items-center gap-2 sm:gap-3 md:gap-4">
                        <span class="flex items-center justify-center w-6 sm:w-7 md:w-8 h-6 sm:h-7 md:h-8 rounded-full bg-black text-white text-xs sm:text-sm font-semibold group-hover:bg-red-600 transition-colors duration-300">08</span>
                        <span class="text-gray-900 text-sm sm:text-base md:text-lg font-medium group-hover:text-red-600 transition-colors duration-300">
                            ¿Cuánto cuesta Admin JR?
                        </span>
                    </div>

                    <span class="faq-icon text-2xl sm:text-3xl text-black group-hover:text-red-600 transition-all duration-300">+</span>

                </button>

                <div class="faq-content hidden px-4 sm:px-5 md:px-6 pb-4 sm:pb-5 md:pb-6 text-gray-600 text-xs sm:text-sm md:text-base leading-relaxed border-t border-gray-100 mt-2 pt-3 sm:pt-4">
                    El costo es de <strong class="text-red-600">$129 MXN al mes</strong>.
                    Sin contratos largos ni compromisos forzosos.
                </div>
            </div>

            <!-- ITEM 09 - responsive -->
            <div class="faq-item rounded-xl sm:rounded-2xl border border-gray-300 bg-white hover:border-red-500/50 hover:shadow-lg transition-all duration-300">
                <button onclick="toggleFaq(this)"
                        class="w-full flex justify-between items-center px-4 sm:px-5 md:px-6 py-4 sm:py-5 md:py-6 text-left group">

                    <div class="flex items-center gap-2 sm:gap-3 md:gap-4">
                        <span class="flex items-center justify-center w-6 sm:w-7 md:w-8 h-6 sm:h-7 md:h-8 rounded-full bg-black text-white text-xs sm:text-sm font-semibold group-hover:bg-red-600 transition-colors duration-300">09</span>
                        <span class="text-gray-900 text-sm sm:text-base md:text-lg font-medium group-hover:text-red-600 transition-colors duration-300">
                            ¿Puedo ver cómo funciona antes de pagar?
                        </span>
                    </div>

                    <span class="faq-icon text-2xl sm:text-3xl text-black group-hover:text-red-600 transition-all duration-300">+</span>

                </button>

                <div class="faq-content hidden px-4 sm:px-5 md:px-6 pb-4 sm:pb-5 md:pb-6 text-gray-600 text-xs sm:text-sm md:text-base leading-relaxed border-t border-gray-100 mt-2 pt-3 sm:pt-4">
                    Sí, puedes crear una cuenta demo y conocer Admin JR antes
                    de tomar cualquier decisión.
                </div>
            </div>

        </div>

    </div>

</section>
<!-- PLAN ÚNICO - 100% RESPONSIVE (TODOS LOS DISPOSITIVOS) -->
<section id="precios" class="relative mt-16 sm:mt-20 md:mt-24 lg:mt-28 xl:mt-32 px-4 sm:px-6">

    <div class="max-w-4xl mx-auto">

        <div class="relative rounded-xl sm:rounded-2xl 
            border-2 border-gray-900
            bg-white
            shadow-[0_20px_40px_-20px_rgba(0,0,0,0.3)] sm:shadow-[0_25px_60px_-20px_rgba(0,0,0,0.3)]
            p-6 sm:p-7 md:p-8 lg:p-10 overflow-hidden">

            <!-- Elementos decorativos - responsive -->
            <div class="absolute -top-16 sm:-top-20 md:-top-24 -right-16 sm:-right-20 md:-right-24 w-32 sm:w-40 md:w-48 lg:w-64 h-32 sm:h-40 md:h-48 lg:h-64 bg-red-500/10 rounded-full blur-2xl md:blur-3xl"></div>
            <div class="absolute -bottom-16 sm:-bottom-20 md:-bottom-24 -left-16 sm:-left-20 md:-left-24 w-32 sm:w-40 md:w-48 lg:w-64 h-32 sm:h-40 md:h-48 lg:h-64 bg-amber-500/10 rounded-full blur-2xl md:blur-3xl"></div>
            
            <!-- Líneas diagonales decorativas (se mantienen) -->
            <div class="absolute inset-0 opacity-5" style="background-image: repeating-linear-gradient(45deg, #000 0px, #000 2px, transparent 2px, transparent 10px);"></div>
            
            <!-- Línea divisoria vertical - visible solo en desktop -->
            <div class="absolute left-1/2 top-10 bottom-10 w-0.5 bg-gradient-to-b from-transparent via-red-400 to-transparent hidden md:block"></div>

            <!-- Badge superior - responsive -->
            <div class="absolute top-3 sm:top-4 left-1/2 -translate-x-1/2 z-10">
                <span class="bg-gray-900 text-white text-[10px] sm:text-xs px-4 sm:px-5 md:px-6 py-1.5 sm:py-2 rounded-full font-semibold tracking-wider shadow-xl inline-flex items-center gap-1.5 sm:gap-2 border border-gray-700">
                    <span class="w-1.5 sm:w-2 h-1.5 sm:h-2 bg-red-500 rounded-full animate-pulse"></span>
                    PLAN EXCLUSIVO
                </span>
            </div>

            <!-- Grid responsive: 1 columna en móvil, 2 en desktop -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 sm:gap-7 md:gap-8 items-start md:items-center relative z-10 mt-12 sm:mt-14 md:mt-16 lg:mt-20">

                <!-- LADO IZQUIERDO - responsive -->
                <div class="space-y-4 sm:space-y-5 px-2 sm:px-0">
                    <div class="relative">
                        <span class="text-[10px] sm:text-xs font-bold text-gray-400 uppercase tracking-[0.2em]">Suscripción</span>
                        <h3 class="text-2xl sm:text-3xl font-light text-gray-900 mt-1 flex flex-wrap items-center gap-2">
                            Plan <span class="font-bold text-red-600 bg-red-50 px-2 sm:px-2.5 py-0.5 rounded-lg inline-block text-xl sm:text-2xl md:text-3xl">Básico</span>
                        </h3>
                        <div class="w-12 sm:w-14 md:w-16 h-0.5 sm:h-1 bg-gradient-to-r from-red-600 to-amber-500 rounded-full mt-2 sm:mt-3"></div>
                    </div>

                    <p class="text-gray-600 text-xs sm:text-sm leading-relaxed border-l-2 border-red-200 pl-3 sm:pl-4 italic">
                        "Todo lo que necesitas para administrar tu negocio desde WhatsApp
                        con reportes claros y automatizados."
                    </p>

                    <!-- Lista con iconos - responsive -->
                    <ul class="space-y-3 sm:space-y-4 pt-2 sm:pt-3">
                        <li class="flex items-center gap-2 sm:gap-3 text-gray-700 group">
                            <div class="w-5 sm:w-6 h-5 sm:h-6 rounded-lg bg-gradient-to-br from-red-500 to-red-600 flex items-center justify-center flex-shrink-0 shadow-md shadow-red-500/30 group-hover:scale-110 transition-transform">
                                <svg class="w-3 sm:w-3.5 h-3 sm:h-3.5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <span class="text-sm sm:text-base"><span class="font-bold text-gray-900">Hasta 3</span> números WhatsApp</span>
                        </li>

                        <li class="flex items-center gap-2 sm:gap-3 text-gray-700 group">
                            <div class="w-5 sm:w-6 h-5 sm:h-6 rounded-lg bg-gradient-to-br from-red-500 to-red-600 flex items-center justify-center flex-shrink-0 shadow-md shadow-red-500/30 group-hover:scale-110 transition-transform">
                                <svg class="w-3 sm:w-3.5 h-3 sm:h-3.5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <span class="text-sm sm:text-base"><span class="font-bold text-gray-900">5 cuentas</span> conectadas</span>
                        </li>

                        <li class="flex items-center gap-2 sm:gap-3 text-gray-700 group">
                            <div class="w-5 sm:w-6 h-5 sm:h-6 rounded-lg bg-gradient-to-br from-red-500 to-red-600 flex items-center justify-center flex-shrink-0 shadow-md shadow-red-500/30 group-hover:scale-110 transition-transform">
                                <svg class="w-3 sm:w-3.5 h-3 sm:h-3.5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <span class="text-sm sm:text-base"><span class="font-bold text-gray-900">Reportes</span> inteligentes</span>
                        </li>

                        <li class="flex items-center gap-2 sm:gap-3 text-gray-700 group">
                            <div class="w-5 sm:w-6 h-5 sm:h-6 rounded-lg bg-gradient-to-br from-red-500 to-red-600 flex items-center justify-center flex-shrink-0 shadow-md shadow-red-500/30 group-hover:scale-110 transition-transform">
                                <svg class="w-3 sm:w-3.5 h-3 sm:h-3.5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <span class="text-sm sm:text-base"><span class="font-bold text-gray-900">Soporte</span> prioritario</span>
                        </li>
                    </ul>
                </div>

                <!-- LADO DERECHO - Precio y CTA responsive -->
                <div class="text-center md:text-left space-y-5 sm:space-y-6 px-2 sm:px-0">
                    <!-- Precio destacado -->
                    <div class="relative">
                        <!-- Fondo decorativo -->
                        <div class="absolute inset-0 bg-gradient-to-r from-red-500/5 to-amber-500/5 rounded-xl sm:rounded-2xl -m-1"></div>
                        
                        <div class="relative bg-white p-5 sm:p-6 md:p-7 rounded-xl border-2 border-gray-900 shadow-[3px_3px_0_0_#dc2626] sm:shadow-[4px_4px_0_0_#dc2626]">
                            <span class="text-[10px] sm:text-xs font-bold text-gray-500 uppercase tracking-wider bg-gray-100 px-2 sm:px-3 py-0.5 sm:py-1 rounded-full inline-block mb-2 sm:mb-3">Oferta especial</span>
                            
                            <div class="flex items-center justify-center md:justify-start gap-1 sm:gap-2 flex-wrap">
                                <span class="text-4xl sm:text-5xl md:text-6xl font-black text-gray-900">$129</span>
                                <span class="text-gray-500 text-base sm:text-lg mb-1 sm:mb-2">/mes</span>
                            </div>
                            
                            <div class="mt-3 sm:mt-4 space-y-1.5 sm:space-y-2">
                                <p class="text-[10px] sm:text-xs text-gray-600 flex items-center justify-center md:justify-start gap-1.5 sm:gap-2">
                                    <svg class="w-3 sm:w-4 h-3 sm:h-4 text-green-600 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                    </svg>
                                    <span>Sin permanencia · Cancela cuando quieras</span>
                                </p>
                                <p class="text-[10px] sm:text-xs text-gray-500 flex items-center justify-center md:justify-start gap-1.5 sm:gap-2">
                                    <svg class="w-3 sm:w-4 h-3 sm:h-4 text-red-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M4 4a2 2 0 00-2 2v1h16V6a2 2 0 00-2-2H4z"/>
                                        <path fill-rule="evenodd" d="M18 9H2v5a2 2 0 002 2h12a2 2 0 002-2V9zM4 13a1 1 0 011-1h1a1 1 0 110 2H5a1 1 0 01-1-1zm5-1a1 1 0 100 2h1a1 1 0 100-2H9z"/>
                                    </svg>
                                    <span>Pago seguro · Facturación mensual</span>
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Botón CTA - responsive -->
                    <a href="{{ route('register') }}"
                        class="group relative inline-flex items-center justify-center w-full md:w-auto px-6 sm:px-8 md:px-10 py-3 sm:py-3.5 md:py-4 
                               bg-gradient-to-r from-red-600 to-red-500 hover:from-red-700 hover:to-red-600
                               text-white font-bold text-sm sm:text-base
                               rounded-xl
                               transition-all duration-300
                               shadow-[0_8px_16px_-8px_rgba(220,38,38,0.6)] sm:shadow-[0_10px_20px_-8px_rgba(220,38,38,0.6)]
                               hover:shadow-[0_12px_20px_-8px_rgba(220,38,38,0.8)] sm:hover:shadow-[0_15px_25px_-8px_rgba(220,38,38,0.8)]
                               hover:scale-105
                               gap-2 sm:gap-3
                               border border-red-400
                               overflow-hidden">
                        <!-- Efecto de brillo -->
                        <span class="absolute inset-0 bg-white/20 translate-x-[-100%] group-hover:translate-x-[100%] transition-transform duration-1000"></span>
                        
                        <span class="relative z-10">Comenzar ahora</span>
                        <svg class="w-3 sm:w-4 h-3 sm:h-4 relative z-10 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                        </svg>
                    </a>
                </div>

            </div>
            
            <!-- Badge de garantía - responsive -->
            <div class="mt-6 sm:mt-7 md:mt-8 flex justify-center">
                <div class="inline-flex items-center gap-2 sm:gap-3 px-3 sm:px-4 md:px-5 py-1.5 sm:py-2 bg-gray-50 rounded-full border border-gray-200">
                    <span class="flex gap-0.5 sm:gap-1">
                        <span class="w-0.5 sm:w-1 h-0.5 sm:h-1 bg-red-600 rounded-full"></span>
                        <span class="w-0.5 sm:w-1 h-0.5 sm:h-1 bg-red-600 rounded-full"></span>
                        <span class="w-0.5 sm:w-1 h-0.5 sm:h-1 bg-red-600 rounded-full"></span>
                    </span>
                    <span class="text-[10px] sm:text-xs text-gray-600">+500 empresarios confían en nosotros</span>
                </div>
            </div>

        </div>

    </div>

</section>
<!-- CTA FINAL - 100% RESPONSIVE (TODOS LOS DISPOSITIVOS) -->
<section class="relative mt-16 sm:mt-20 md:mt-24 lg:mt-28 xl:mt-32 grid grid-cols-1 md:grid-cols-2 gap-8 sm:gap-10 md:gap-12 lg:gap-16 items-center px-4 sm:px-6 max-w-6xl mx-auto">

    <!-- IMAGEN con diseño mejorado - responsive -->
    <div class="flex justify-center order-2 md:order-1">
        <div class="relative w-full max-w-[240px] xs:max-w-[280px] sm:max-w-sm md:max-w-md lg:max-w-sm group">

            <!-- Glow más elegante - responsive -->
            <div class="absolute inset-0 rounded-xl sm:rounded-2xl 
                        bg-gradient-to-r from-red-600/20 via-red-500/10 to-transparent
                        blur-2xl md:blur-3xl opacity-30 sm:opacity-40 group-hover:opacity-50 sm:group-hover:opacity-60 transition-opacity duration-700">
            </div>
            
            <!-- Segundo glow para profundidad - responsive -->
            <div class="absolute inset-0 rounded-xl sm:rounded-2xl 
                        bg-black/10
                        blur-xl md:blur-2xl opacity-20 sm:opacity-30 group-hover:opacity-30 sm:group-hover:opacity-40 transition-opacity duration-700">
            </div>

            <!-- Marco decorativo - responsive -->
            <div class="absolute -inset-1 rounded-xl sm:rounded-2xl bg-gradient-to-r from-red-600 to-amber-500 opacity-0 group-hover:opacity-20 sm:group-hover:opacity-30 blur-lg md:blur-xl transition-all duration-500"></div>

            <!-- Imagen con bordes y sombras - responsive -->
            <div class="relative rounded-xl sm:rounded-2xl overflow-hidden
                        border-2 border-gray-900
                        bg-white
                        shadow-[4px_4px_0_0_#000000] sm:shadow-[6px_6px_0_0_#000000] md:shadow-[8px_8px_0_0_#000000]
                        group-hover:shadow-[6px_6px_0_0_#dc2626] sm:group-hover:shadow-[8px_8px_0_0_#dc2626] md:group-hover:shadow-[12px_12px_0_0_#dc2626]
                        transition-all duration-500
                        transform group-hover:scale-[1.01] sm:group-hover:scale-[1.02]">

                <img src="{{ asset('images/mockup10.png') }}"
                     alt="Admin JR app"
                     class="w-full h-auto object-contain relative z-10">

            </div>
        </div>
    </div>

    <!-- TEXTO con diseño mejorado - responsive -->
    <div class="relative space-y-5 sm:space-y-6 md:space-y-7 lg:space-y-8 order-1 md:order-2 px-2 sm:px-0">

        <!-- Badge superior - responsive -->
        <div class="inline-flex items-center gap-1.5 sm:gap-2 px-3 sm:px-4 py-1 sm:py-1.5 bg-white border-2 border-gray-900 rounded-full shadow-[2px_2px_0_0_#000000]">
            <span class="w-1.5 sm:w-2 h-1.5 sm:h-2 bg-red-600 rounded-full animate-pulse"></span>
            <span class="text-[10px] sm:text-xs font-bold text-gray-900 uppercase tracking-wider">ÚLTIMA OPORTUNIDAD</span>
        </div>

        <!-- Título - responsive -->
        <h3 class="text-3xl sm:text-4xl md:text-5xl lg:text-6xl font-light leading-[1.1] sm:leading-[1.05] tracking-tight text-gray-900">
            Activa tu 
           <span class="text-red-600 font-bold block sm:inline">asistente financiero</span>
        </h3>

        <!-- Línea decorativa - responsive -->
        <div class="w-16 sm:w-20 md:w-24 h-0.5 sm:h-1 bg-gradient-to-r from-red-600 to-amber-500 rounded-full shadow-[1px_1px_0_0_#000000]"></div>

        <!-- Descripción - responsive -->
        <p class="text-sm sm:text-base md:text-lg lg:text-xl text-gray-700 leading-relaxed max-w-xl border-l-2 border-red-200 pl-3 sm:pl-4 md:pl-6 italic">
            "Conecta tu número de WhatsApp y permite que 
            <span class="font-bold text-red-600">Admin JR</span>
            registre automáticamente los gastos de tu negocio,
            generando reportes y manteniendo tu control financiero
            siempre actualizado."
        </p>

        <!-- Botón con efecto de brillo - responsive -->
        <a href="{{ route('register') }}"
           class="relative inline-flex items-center justify-center w-full sm:w-auto px-6 sm:px-8 md:px-10 py-3 sm:py-3.5 md:py-4 
                  bg-gradient-to-r from-red-600 to-red-500 hover:from-red-700 hover:to-red-600
                  text-white font-bold text-base sm:text-lg
                  rounded-xl
                  transition-all duration-500
                  shadow-[3px_3px_0_0_#000000] sm:shadow-[4px_4px_0_0_#000000] hover:shadow-[4px_4px_0_0_#000000] sm:hover:shadow-[6px_6px_0_0_#000000]
                  hover:scale-105
                  overflow-hidden group
                  border border-red-400
                  gap-2 sm:gap-3">
            
            <!-- Efecto de brillo -->
            <span class="absolute inset-0 bg-white/30 translate-x-[-100%] group-hover:translate-x-[100%] transition-transform duration-700"></span>
            
            <!-- Texto del botón -->
            <span class="relative z-10">Crear cuenta gratis</span>
            
            <!-- Icono flecha - responsive -->
            <svg class="w-4 sm:w-5 h-4 sm:h-5 relative z-10 transition-transform duration-300 group-hover:translate-x-1" 
                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
            </svg>
        </a>
        
        <!-- Texto de confianza - responsive -->
        <p class="text-[10px] sm:text-xs text-gray-400 flex items-center gap-1 justify-center sm:justify-start">
            <span class="w-0.5 sm:w-1 h-0.5 sm:h-1 bg-gray-400 rounded-full"></span>
            Sin compromiso · Pago seguro · Facturación mensual
        </p>
    </div>

</section>
</main>
<!-- FOOTER - 100% RESPONSIVE (TODOS LOS DISPOSITIVOS) -->
<footer class="bg-zinc-950 text-gray-200 border-t border-zinc-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-10 md:py-12 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-6 sm:gap-8 items-start">

        <!-- Columna principal - ocupa 2 columnas en desktop, 1 en móvil -->
<div class="sm:col-span-2 space-y-2 sm:space-y-3 text-center sm:text-left">
    <div class="flex items-center gap-2 sm:gap-3 justify-center sm:justify-start">
        <img src="{{ asset('avaspace.svg') }}" alt="Avaspace" class="h-8 sm:h-9 md:h-10">
        <!-- Texto ajustado: más pequeño en móvil, igual en desktop -->
        <h2 class="text-base xs:text-lg sm:text-xl font-semibold text-white leading-tight">
            Controla tus gastos
        </h2>
    </div>
    <p class="text-xs sm:text-sm text-gray-400 max-w-sm mx-auto sm:mx-0">
        Convierte tus números en decisiones inteligentes para hacer crecer tu negocio.
    </p>
</div>  
        <!-- Columnas de enlaces - responsive grid -->
        <div class="space-y-2 text-center sm:text-left">
            <h3 class="text-sm sm:text-base font-semibold text-white">Avisos</h3>
            <ul class="space-y-1 text-xs sm:text-sm text-gray-400">
                <li><a href="{{ route('aviso-de-privacidad') }}" class="hover:text-red-400 transition inline-block py-1">Aviso de privacidad</a></li>
                <li><a href="{{ route('terminos') }}" class="hover:text-red-400 transition inline-block py-1">Términos y condiciones</a></li>
            </ul>
        </div>

        <div class="space-y-2 text-center sm:text-left">
            <h3 class="text-sm sm:text-base font-semibold text-white">Equipo</h3>
            <ul class="space-y-1 text-xs sm:text-sm text-gray-400">
                <li><a href="{{ route('nosotros') }}" class="hover:text-red-400 transition inline-block py-1">Nosotros</a></li>
            </ul>
        </div>

        <div class="space-y-2 text-center sm:text-left">
            <h3 class="text-sm sm:text-base font-semibold text-white">Social</h3>
            <ul class="space-y-1 text-xs sm:text-sm text-gray-400">
                <li><a href="https://www.facebook.com/avaspace.io" class="hover:text-red-400 transition inline-block py-1" target="_blank">Facebook</a></li>
                <li><a href="https://www.instagram.com/avaspace.io/" class="hover:text-red-400 transition inline-block py-1" target="_blank">Instagram</a></li>
                <li><a href="https://www.youtube.com/@avaspace" class="hover:text-red-400 transition inline-block py-1" target="_blank">YouTube</a></li>
            </ul>
        </div>
    </div>

    <!-- Copyright - responsive -->
    <div class="border-t border-zinc-800 py-3 sm:py-4 text-center text-[10px] sm:text-xs text-gray-500 px-4">
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
/* =========================
   TOOLTIPS
========================= */
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
   CAROUSEL 3D - SOLO PARA #funciones
   (No afecta a otras secciones)
========================= */
#funciones .carousel-3d {
    position: relative;
    width: 100%;
    max-width: 1000px;
    height: 420px;
    transform-style: preserve-3d;
    perspective: 1600px;
    display: flex;
    justify-content: center;
    align-items: center;
    margin: 0 auto;
}

/* =========================
   CARD BASE - SOLO PARA #funciones
========================= */
#funciones .card-3d {
    position: absolute;
    left: 50%;
    top: 50%;
    width: 320px;
    height: 380px;
    padding: 2.5rem 2rem;
    text-align: center;
    background: #ffffff;
    border-radius: 2rem;
    border: 2px solid #000000;
    transform-style: preserve-3d;
    transform-origin: center center;
    translate: -50% -50%;
    transition: transform 0.8s cubic-bezier(0.2, 0.8, 0.3, 1), opacity 0.6s ease, box-shadow 0.3s ease;
    box-shadow: 4px 4px 0 0 #000000;
}

/* =========================
   CARD ACTIVA - SOLO PARA #funciones
========================= */
#funciones .card-3d.active {
    box-shadow: 8px 8px 0 0 #dc2626;
    border-color: #dc2626;
}

/* =========================
   HOVER EFFECT - SOLO PARA #funciones
========================= */
#funciones .card-3d:hover {
    border-color: #dc2626;
    box-shadow: 8px 8px 0 0 #dc2626;
}

/* =========================
   TEXTOS DENTRO DE CARDS - SOLO PARA #funciones
   (CORREGIDO - Recuadros rojos simétricos)
========================= */
#funciones .card-3d h3 {
    color: #111827;
    font-weight: 700;
    margin-bottom: 1rem;
    font-size: 1.5rem;
    line-height: 1.4;
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    align-items: center;
    gap: 0.5rem;
}

#funciones .card-3d h3 span {
    color: #dc2626;
    background-color: #fef2f2;
    padding: 0.25rem 0.75rem;
    border-radius: 0.5rem;
    border: 1px solid #fecaca;
    box-shadow: 1px 1px 0 0 #000000;
    display: inline-block;
    font-size: 1.5rem;
    line-height: 1.4;
    white-space: nowrap;
    font-weight: 700;
}

#funciones .card-3d p {
    color: #4b5563;
    line-height: 1.6;
    margin-bottom: 1rem;
}

/* =========================
   ICONOS DENTRO DE CARDS - SOLO PARA #funciones
========================= */
#funciones .card-3d .flex.justify-center.mb-8 div {
    width: 64px;
    height: 64px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 1rem;
    background: linear-gradient(135deg, #dc2626, #b91c1c);
    border: 2px solid #000000;
    box-shadow: 3px 3px 0 0 #000000;
    margin: 0 auto 2rem auto;
    transition: all 0.3s ease;
}

#funciones .card-3d:hover .flex.justify-center.mb-8 div {
    box-shadow: 5px 5px 0 0 #000000;
}

#funciones .card-3d .flex.justify-center.mb-8 svg {
    width: 32px;
    height: 32px;
    color: #ffffff;
}

/* =========================
   FEATURE TAGS DENTRO DE CARDS - SOLO PARA #funciones
========================= */
#funciones .card-3d .mt-6.inline-flex {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.5rem 1.25rem;
    background: #111827;
    border-radius: 9999px;
    border: 1px solid #374151;
    box-shadow: 2px 2px 0 0 #dc2626;
}

#funciones .card-3d .mt-6.inline-flex span.w-1\\.5 {
    width: 0.375rem;
    height: 0.375rem;
    background: #dc2626;
    border-radius: 50%;
    animation: pulse 2s infinite;
}

#funciones .card-3d .mt-6.inline-flex span.text-xs {
    color: #ffffff;
    font-size: 0.75rem;
    font-weight: 600;
    letter-spacing: 0.02em;
}

/* =========================
   ELEMENTO DECORATIVO ESQUINA
========================= */
#funciones .card-3d .absolute.top-0.right-0 {
    position: absolute;
    top: 0;
    right: 0;
    width: 6rem;
    height: 6rem;
    background: linear-gradient(135deg, rgba(220,38,38,0.1), rgba(245,158,11,0.1));
    border-bottom-left-radius: 1rem;
    pointer-events: none;
}

/* =========================
   ANIMACIONES
========================= */
@keyframes pulse {
    0%, 100% { opacity: 1; transform: scale(1); }
    50% { opacity: 0.6; transform: scale(1.2); }
}

/* =========================
   RESPONSIVE - SOLO PARA #funciones
========================= */
@media (max-width: 768px) {
    #funciones .carousel-3d {
        height: 380px;
    }
    
    #funciones .card-3d {
        width: 280px;
        height: 340px;
        padding: 2rem 1.5rem;
    }
    
    #funciones .card-3d h3 {
        font-size: 1.3rem;
        gap: 0.3rem;
    }
    
    #funciones .card-3d h3 span {
        font-size: 1.3rem;
        padding: 0.2rem 0.6rem;
    }
}
/* =========================
   SCROLL SUAVE (GLOBAL)
========================= */
html {
    scroll-behavior: smooth;
}

/* =========================
   DISEÑO CHAT BOT (GLOBAL)
========================= */
.chat-demo-container {
    background: linear-gradient(145deg, #1e1e1e 0%, #252525 100%);
    border: 1px solid #333333;
    box-shadow: 0 20px 35px -10px rgba(0,0,0,0.4);
    border-radius: 24px;
    padding: 4px;
}

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

.expense-card {
    background: #2d2d2d;
    border: 1px solid #404040;
    border-radius: 14px;
    padding: 14px 16px;
    margin-top: 12px;
    font-size: 0.95rem;
    color: #f0f0f0;
    box-shadow: 0 4px 12px rgba(0,0,0,0.3);
    position: relative;
    margin-left: 8px;
}

.expense-card strong {
    color: #ffffff;
    font-weight: 700;
}

.expense-card div {
    padding: 5px 0;
    border-bottom: 1px dashed #505050;
    color: #e5e5e5;
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

#chatBox {
    display: flex;
    flex-direction: column;
    gap: 16px;
    padding: 16px;
    background: rgba(0,0,0,0.2);
    border-radius: 20px;
    min-height: 320px;
}

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

.message-bot:first-child {
    background: linear-gradient(135deg, #2a2a2a 0%, #1a1a1a 100%);
    border-left: 4px solid #dc2626;
}

.message-bot:hover, .message-user:hover {
    filter: brightness(1.1);
    transition: all 0.2s ease;
}
/* =========================
    BREAKPOINTS UNIVERSALES - CUBREN TODOS LOS DISPOSITIVOS
   ========================= */

/* Móviles muy pequeños (iPhone SE, Android mini 320px-375px) */
@media (max-width: 375px) { 
    html { font-size: 14px; }
    .container { padding-left: 0.75rem; padding-right: 0.75rem; }
    h1 { font-size: 2rem !important; }
    h2 { font-size: 1.75rem !important; }
    .text-lg { font-size: 0.95rem !important; }
    .text-xl { font-size: 1rem !important; }
    .badge, .px-5.py-2 { padding: 0.4rem 0.8rem !important; }
    .gap-16 { gap: 2rem !important; }
}

/* Móviles normales (iPhone 12/13/14, Samsung S20/S21 - 376px-480px) */
@media (min-width: 376px) and (max-width: 480px) { 
    html { font-size: 15px; }
    .container { padding-left: 1rem; padding-right: 1rem; }
    h1 { font-size: 2.2rem !important; }
    h2 { font-size: 2rem !important; }
    .text-lg { font-size: 1rem !important; }
    .text-xl { font-size: 1.1rem !important; }
}

/* Móviles grandes (iPhone Plus/Pro Max, Samsung Ultra - 481px-640px) */
@media (min-width: 481px) and (max-width: 640px) { 
    html { font-size: 16px; }
    .container { padding-left: 1.25rem; padding-right: 1.25rem; }
    h1 { font-size: 2.5rem !important; }
    h2 { font-size: 2.2rem !important; }
}

/* Tablets pequeñas Y PLGABLES PLEGADOS (Z Fold plegado, iPad mini, Surface Duo - 641px-800px) */
@media (min-width: 641px) and (max-width: 800px) { 
    .container { max-width: 95% !important; }
    .grid-cols-1.md\:grid-cols-2 { 
        grid-template-columns: repeat(2, 1fr) !important; 
        gap: 1.5rem !important;
    }
    h1 { font-size: 2.8rem !important; }
    h2 { font-size: 2.5rem !important; }
    .text-4xl { font-size: 2.8rem !important; }
    .text-5xl { font-size: 3.2rem !important; }
}

/* Tablets normales (iPad Air, Samsung Tab - 801px-1024px) */
@media (min-width: 801px) and (max-width: 1024px) { 
    .container { max-width: 90% !important; }
    .grid.md\:grid-cols-2 { grid-template-columns: repeat(2, 1fr) !important; }
    .grid-cols-3 { grid-template-columns: repeat(2, 1fr) !important; }
    h1 { font-size: 3.2rem !important; }
    h2 { font-size: 2.8rem !important; }
}

/* Tablets grandes y desktop pequeño (1025px-1280px) */
@media (min-width: 1025px) and (max-width: 1280px) { 
    .container { max-width: 85% !important; }
    h1 { font-size: 3.5rem !important; }
    h2 { font-size: 3rem !important; }
    .text-6xl { font-size: 3.8rem !important; }
    .text-7xl { font-size: 4.5rem !important; }
}

/* Desktop normal (1281px-1440px) */
@media (min-width: 1281px) and (max-width: 1440px) { 
    .container { max-width: 1280px !important; }
    h1 { font-size: 4rem !important; }
    .text-6xl { font-size: 4rem !important; }
    .text-7xl { font-size: 5rem !important; }
}

/* Desktop grande y PLGABLES DESPLEGADOS (Z Fold desplegado - 1441px-1600px) */
@media (min-width: 1441px) and (max-width: 1600px) { 
    .container { max-width: 1400px !important; }
    .grid-cols-4 { grid-template-columns: repeat(4, 1fr) !important; }
    .text-7xl { font-size: 5.5rem !important; }
}

/* Pantallas ultra-wide (1601px+) */
@media (min-width: 1601px) { 
    .container { max-width: 1536px !important; }
    .text-7xl { font-size: 6rem !important; }
}
</style>