<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Nosotros | Avaspace</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0, user-scalable=yes">

    <!-- Fuentes y estilos (mismos que en la landing) -->
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* =========================
           BREAKPOINTS UNIVERSALES (opcional, por si acaso)
        ========================= */
        @media (max-width: 375px) { html { font-size: 14px; } }
        @media (min-width: 376px) and (max-width: 640px) { html { font-size: 15px; } }
        @media (min-width: 641px) { html { font-size: 16px; } }

        /* Scroll suave */
        html { scroll-behavior: smooth; }
    </style>
</head>
<script>
document.addEventListener("DOMContentLoaded", function () {
    // Funcionalidad del menú móvil (copiada de la landing)
    const menuBtn = document.getElementById('menuBtn');
    const mobileMenu = document.getElementById('mobileMenu');
    const navBar = document.getElementById('navBar');

    if (menuBtn && mobileMenu) {
        menuBtn.addEventListener('click', function (e) {
            e.stopPropagation();
            mobileMenu.classList.toggle('hidden');
        });

        document.addEventListener('click', function(event) {
            if (mobileMenu && !mobileMenu.contains(event.target) && !menuBtn.contains(event.target)) {
                mobileMenu.classList.add('hidden');
            }
        });

        const mobileLinks = mobileMenu.querySelectorAll('a');
        mobileLinks.forEach(link => {
            link.addEventListener('click', function() {
                mobileMenu.classList.add('hidden');
            });
        });
    }

    // Efecto scroll sutil en el header (como la landing)
    if (navBar) {
        window.addEventListener('scroll', function () {
            if (window.scrollY > 50) {
                navBar.classList.add('bg-white/95', 'shadow-[0_8px_30px_rgb(0,0,0,0.1)]', 'backdrop-blur-md');
                navBar.classList.remove('bg-white/95', 'shadow-[0_8px_30px_rgb(0,0,0,0.05)]', 'backdrop-blur-sm');
            } else {
                navBar.classList.remove('bg-white/95', 'shadow-[0_8px_30px_rgb(0,0,0,0.1)]', 'backdrop-blur-md');
                navBar.classList.add('bg-white/95', 'shadow-[0_8px_30px_rgb(0,0,0,0.05)]', 'backdrop-blur-sm');
            }
        });
    }
});
</script>

<body class="min-h-screen bg-gradient-to-br from-gray-100 via-gray-50 to-gray-200 text-gray-800 overflow-x-hidden font-['Inter',sans-serif]">

<!-- =========================
     HEADER (IDÉNTICO A LA LANDING)
========================= -->
<header id="mainHeader" class="fixed top-0 left-0 w-full z-50 flex justify-center pt-2 sm:pt-4 px-2 sm:px-3 transition-all duration-300">
<nav id="navBar" class="
    flex items-center justify-between
    w-full max-w-5xl
    rounded-full
    px-3 sm:px-4 md:px-6
    py-2 sm:py-2.5 md:py-3
    bg-white/95
    backdrop-blur-sm
    border border-gray-200/80
    shadow-[0_4px_20px_rgb(0,0,0,0.03)] sm:shadow-[0_8px_30px_rgb(0,0,0,0.05)]
    transition-all duration-300
    relative">

    <!-- LOGO Avaspace -->
    <a href="/" class="flex items-center gap-1.5 sm:gap-2 group">
        <div class="relative">
            <img src="{{ asset('avaspace.svg') }}"
                alt="Avaspace"
                class="h-7 sm:h-8 md:h-9 lg:h-10 relative z-11">
        </div>
        <span class="text-xs font-medium text-gray-700 md:hidden">Admin</span>
    </a>

    <!-- MENU DESKTOP (enlaces de la página nosotros) -->
    <div class="hidden md:flex items-center absolute left-1/2 -translate-x-1/2 gap-8">
        <a href="{{ route('nosotros') }}" class="text-sm font-medium text-red-600 border-b-2 border-red-600 px-1 pb-1">Nosotros</a>
        <a href="#mision" class="text-sm font-medium text-gray-600 hover:text-red-600 transition-colors px-1">Misión</a>
        <a href="#equipo" class="text-sm font-medium text-gray-600 hover:text-red-600 transition-colors px-1">Equipo</a>
        <a href="/#precios" class="text-sm font-medium text-gray-600 hover:text-red-600 transition-colors px-1">Precios</a>
    </div>

    <!-- BOTONES DESKTOP -->
    <div class="hidden md:flex items-center gap-2">
        <a href="{{ route('login') }}"
           class="px-5 py-2 bg-transparent border border-gray-800 hover:bg-gray-900 text-gray-800 hover:text-white text-sm font-medium rounded-full transition-all duration-200">
            Iniciar sesión
        </a>
        <a href="{{ route('register') }}"
           class="px-5 py-2 bg-gradient-to-r from-red-600 to-red-500 hover:from-red-700 hover:to-red-600 text-white text-sm font-semibold rounded-full shadow-md shadow-red-200 hover:shadow-lg hover:shadow-red-300 transition-all duration-200 hover:scale-105 flex items-center gap-1.5">
            <span>Crear cuenta</span>
        </a>
    </div>

    <!-- BOTÓN HAMBURGUESA MÓVIL -->
    <button id="menuBtn" class="md:hidden flex items-center justify-center w-9 h-9 sm:w-10 sm:h-10 rounded-full bg-white border border-gray-200 hover:border-red-300 text-gray-600 hover:text-red-600 hover:bg-red-50 transition-all shadow-sm active:scale-95">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 sm:h-5 sm:w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
        </svg>
    </button>

    <!-- MENU MÓVIL (mejorado, no transparente) -->
    <div id="mobileMenu" class="
        absolute top-full right-2 sm:right-3 md:right-4 
        mt-2 sm:mt-3
        hidden
        w-[calc(100vw-2rem)] sm:w-80
        max-w-[320px] sm:max-w-sm
        bg-white
        border-2 border-gray-300
        rounded-2xl
        shadow-2xl
        p-4 sm:p-5
        space-y-2 sm:space-y-3
        text-gray-700
        z-50
        transition-all duration-200
        origin-top-right
        ring-1 ring-black ring-opacity-5
    ">
        <!-- Header del menú móvil -->
        <div class="flex items-center gap-2 sm:gap-3 pb-3 sm:pb-4 border-b-2 border-gray-200">
            <img src="{{ asset('avaspace.svg') }}" alt="Avaspace" class="h-8 sm:h-10 w-auto">
            <div>
                <div class="text-sm sm:text-base font-bold text-gray-900">Avaspace</div>
                <div class="text-[10px] sm:text-xs font-medium text-gray-600">Admin JR</div>
            </div>
            <button class="ml-auto w-7 h-7 flex items-center justify-center rounded-full bg-gray-100 hover:bg-red-50 text-gray-500 hover:text-red-600 transition-all md:hidden border border-gray-300" onclick="document.getElementById('mobileMenu').classList.add('hidden')">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <!-- Opciones del menú -->
        <a href="{{ route('nosotros') }}" class="block px-3 sm:px-4 py-2.5 sm:py-3 text-sm sm:text-base font-medium text-red-600 bg-red-50 rounded-xl border border-red-200">Nosotros</a>
        <a href="#mision" class="block px-3 sm:px-4 py-2.5 sm:py-3 text-sm sm:text-base font-medium text-gray-800 hover:text-red-600 hover:bg-red-50 rounded-xl transition-all border border-transparent hover:border-red-200">Misión</a>
        <a href="#equipo" class="block px-3 sm:px-4 py-2.5 sm:py-3 text-sm sm:text-base font-medium text-gray-800 hover:text-red-600 hover:bg-red-50 rounded-xl transition-all border border-transparent hover:border-red-200">Equipo</a>
        <a href="/#precios" class="block px-3 sm:px-4 py-2.5 sm:py-3 text-sm sm:text-base font-medium text-gray-800 hover:text-red-600 hover:bg-red-50 rounded-xl transition-all border border-transparent hover:border-red-200">Precios</a>

        <!-- BOTONES MÓVIL -->
        <div class="pt-3 sm:pt-4 mt-2 border-t-2 border-gray-200 space-y-2 sm:space-y-3">
            <a href="{{ route('login') }}" 
               class="flex items-center justify-center w-full px-4 sm:px-5 py-2.5 sm:py-3 bg-white border-2 border-gray-400 hover:border-red-400 text-gray-800 hover:text-red-600 text-xs sm:text-sm font-semibold rounded-xl shadow-sm hover:shadow transition-all active:bg-gray-50">
                Iniciar sesión
            </a>
            <a href="{{ route('register') }}" 
               class="flex items-center justify-center w-full px-4 sm:px-5 py-2.5 sm:py-3 bg-gradient-to-r from-red-600 to-red-500 hover:from-red-700 hover:to-red-600 text-white text-xs sm:text-sm font-bold rounded-xl shadow-md shadow-red-300 hover:shadow-lg transition-all gap-1.5 sm:gap-2 active:scale-[0.98] border border-red-400">
                <span>Crear cuenta gratis</span>
                <svg class="w-3 h-3 sm:w-4 sm:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                </svg>
            </a>
        </div>
    </div>
</nav>
</header>
<!-- FIN HEADER -->

<!-- =========================
     HERO NOSOTROS
========================= -->
<section class="relative pt-32 sm:pt-36 md:pt-40 lg:pt-44 pb-20 sm:pb-24 md:pb-28 lg:pb-32 text-center px-4 sm:px-6 overflow-hidden">

    <!-- Badge decorativo (como en la landing) -->
    <div class="mb-6 sm:mb-7 md:mb-8 inline-flex items-center gap-2 px-4 sm:px-5 py-1.5 sm:py-2 bg-white border-2 border-gray-900 rounded-full shadow-[2px_2px_0_0_#000000] sm:shadow-[3px_3px_0_0_#000000]">
        <span class="w-1.5 sm:w-2 h-1.5 sm:h-2 bg-red-600 rounded-full animate-pulse"></span>
        <span class="text-[10px] sm:text-xs font-bold text-gray-900 uppercase tracking-wider">SOBRE AVASPACE</span>
    </div>

    <!-- Título principal (responsive) -->
    <h1 class="text-3xl xs:text-4xl sm:text-5xl md:text-6xl font-semibold leading-tight max-w-4xl mx-auto text-gray-900 px-2">
        Tecnología para una 
        <span class="text-red-600 block sm:inline">mejor administración financiera</span>
    </h1>

    <!-- Descripción -->
    <p class="text-gray-600 text-sm sm:text-base md:text-lg lg:text-xl mt-5 sm:mt-6 max-w-2xl mx-auto leading-relaxed px-4">
        Admin JR es una plataforma diseñada para ayudar a empresarios, emprendedores y equipos a registrar, organizar y analizar sus gastos de manera simple, rápida e inteligente.
    </p>

    <!-- Elementos decorativos de fondo (sutiles, como la landing) -->
    <div class="absolute top-1/2 left-0 w-48 sm:w-64 md:w-96 h-48 sm:h-64 md:h-96 bg-gradient-to-r from-red-500/10 to-transparent rounded-full blur-2xl md:blur-3xl -z-10"></div>
    <div class="absolute bottom-1/2 right-0 w-48 sm:w-64 md:w-96 h-48 sm:h-64 md:h-96 bg-gradient-to-l from-red-500/10 to-transparent rounded-full blur-2xl md:blur-3xl -z-10"></div>
</section>

<!-- =========================
     MISIÓN
========================= -->
<section id="mision" class="py-20 sm:py-24 md:py-28 px-4 sm:px-6 text-center relative overflow-hidden">

    <!-- Badge (opcional) -->
    <div class="inline-flex items-center gap-2 px-4 py-1.5 bg-white border-2 border-gray-900 rounded-full mb-5 sm:mb-6 shadow-[2px_2px_0_0_#000000]">
        <span class="w-1.5 h-1.5 bg-red-600 rounded-full"></span>
        <span class="text-[10px] font-bold text-gray-900 uppercase tracking-wider">FILOSOFÍA</span>
    </div>

    <h2 class="text-3xl sm:text-4xl md:text-5xl font-semibold mb-4 sm:mb-5 text-gray-900">
        Nuestra misión
    </h2>

    <div class="w-16 sm:w-20 md:w-24 h-0.5 sm:h-1 bg-gradient-to-r from-red-600 to-amber-500 rounded-full mx-auto mb-5 sm:mb-6"></div>

    <p class="text-gray-600 text-sm sm:text-base md:text-lg lg:text-xl max-w-3xl mx-auto leading-relaxed border-l-2 border-red-200 pl-4 sm:pl-6 italic">
        Simplificar la administración financiera para que empresas y emprendedores puedan enfocarse en lo que realmente importa: hacer crecer su negocio.
    </p>
</section>

<!-- =========================
     CARACTERÍSTICAS / VALORES
========================= -->
<section class="py-20 sm:py-24 px-4 sm:px-6">
    <div class="max-w-6xl mx-auto grid grid-cols-1 md:grid-cols-3 gap-6 sm:gap-8">

        <!-- Card 1 -->
        <div class="bg-white border-2 border-gray-900 rounded-2xl sm:rounded-3xl p-6 sm:p-8 shadow-[4px_4px_0_0_#000000] hover:shadow-[6px_6px_0_0_#dc2626] hover:border-red-600 transition-all duration-300 group">
            <div class="w-12 h-12 sm:w-14 sm:h-14 rounded-xl bg-gradient-to-br from-red-600 to-red-500 flex items-center justify-center mb-4 sm:mb-5 border-2 border-gray-900 shadow-[2px_2px_0_0_#000000] group-hover:shadow-[3px_3px_0_0_#000000] transition-all">
                <svg class="w-6 h-6 sm:w-7 sm:h-7 text-white" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M4 4a2 2 0 00-2 2v1h16V6a2 2 0 00-2-2H4z"/>
                    <path fill-rule="evenodd" d="M18 9H2v5a2 2 0 002 2h12a2 2 0 002-2V9zM4 13a1 1 0 011-1h1a1 1 0 110 2H5a1 1 0 01-1-1zm5-1a1 1 0 100 2h1a1 1 0 100-2H9z"/>
                </svg>
            </div>
            <h3 class="text-lg sm:text-xl font-bold text-gray-900 mb-2">Registro de gastos</h3>
            <p class="text-gray-600 text-xs sm:text-sm leading-relaxed">
                Permite registrar gastos fácilmente desde múltiples canales como WhatsApp o plataformas digitales.
            </p>
        </div>

        <!-- Card 2 -->
        <div class="bg-white border-2 border-gray-900 rounded-2xl sm:rounded-3xl p-6 sm:p-8 shadow-[4px_4px_0_0_#000000] hover:shadow-[6px_6px_0_0_#dc2626] hover:border-red-600 transition-all duration-300 group">
            <div class="w-12 h-12 sm:w-14 sm:h-14 rounded-xl bg-gradient-to-br from-red-600 to-red-500 flex items-center justify-center mb-4 sm:mb-5 border-2 border-gray-900 shadow-[2px_2px_0_0_#000000] group-hover:shadow-[3px_3px_0_0_#000000] transition-all">
                <svg class="w-6 h-6 sm:w-7 sm:h-7 text-white" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M5 3a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2V5a2 2 0 00-2-2H5zM5 11a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2v-2a2 2 0 00-2-2H5zM11 5a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V5zM14 11a1 1 0 011 1v1h1a1 1 0 110 2h-1v1a1 1 0 11-2 0v-1h-1a1 1 0 110-2h1v-1a1 1 0 011-1z"/>
                </svg>
            </div>
            <h3 class="text-lg sm:text-xl font-bold text-gray-900 mb-2">Organización automática</h3>
            <p class="text-gray-600 text-xs sm:text-sm leading-relaxed">
                Clasificación inteligente que ayuda a entender en qué se está gastando el dinero.
            </p>
        </div>

        <!-- Card 3 -->
        <div class="bg-white border-2 border-gray-900 rounded-2xl sm:rounded-3xl p-6 sm:p-8 shadow-[4px_4px_0_0_#000000] hover:shadow-[6px_6px_0_0_#dc2626] hover:border-red-600 transition-all duration-300 group">
            <div class="w-12 h-12 sm:w-14 sm:h-14 rounded-xl bg-gradient-to-br from-red-600 to-red-500 flex items-center justify-center mb-4 sm:mb-5 border-2 border-gray-900 shadow-[2px_2px_0_0_#000000] group-hover:shadow-[3px_3px_0_0_#000000] transition-all">
                <svg class="w-6 h-6 sm:w-7 sm:h-7 text-white" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M2 11a1 1 0 011-1h2a1 1 0 011 1v5a1 1 0 01-1 1H3a1 1 0 01-1-1v-5zM8 7a1 1 0 011-1h2a1 1 0 011 1v9a1 1 0 01-1 1H9a1 1 0 01-1-1V7zM14 4a1 1 0 011-1h2a1 1 0 011 1v12a1 1 0 01-1 1h-2a1 1 0 01-1-1V4z"/>
                </svg>
            </div>
            <h3 class="text-lg sm:text-xl font-bold text-gray-900 mb-2">Información clara</h3>
            <p class="text-gray-600 text-xs sm:text-sm leading-relaxed">
                Visualiza reportes simples que facilitan la toma de decisiones financieras.
            </p>
        </div>

    </div>
</section>

<!-- =========================
     VISIÓN
========================= -->
<section class="py-20 sm:py-24 md:py-28 px-4 sm:px-6 text-center">
    <h2 class="text-3xl sm:text-4xl md:text-5xl font-semibold mb-4 sm:mb-5 text-gray-900">
        Nuestra visión
    </h2>

    <div class="w-16 sm:w-20 md:w-24 h-0.5 sm:h-1 bg-gradient-to-r from-red-600 to-amber-500 rounded-full mx-auto mb-5 sm:mb-6"></div>

    <p class="text-gray-600 text-sm sm:text-base md:text-lg lg:text-xl max-w-3xl mx-auto leading-relaxed border-l-2 border-red-200 pl-4 sm:pl-6 italic">
        Convertirnos en una herramienta esencial para la gestión financiera de empresas y emprendedores en Latinoamérica, simplificando procesos y ofreciendo mayor claridad en la administración del dinero.
    </p>
</section>

<!-- =========================
     EQUIPO (TARJETAS DE LOS FUNDADORES)
========================= -->
<section id="equipo" class="relative py-24 sm:py-28 md:py-32 overflow-hidden">

    <!-- Badge superior (como en la landing) -->
    <div class="text-center mb-12 sm:mb-14 md:mb-16">
        <div class="inline-flex items-center gap-2 px-4 py-1.5 bg-white border-2 border-gray-900 rounded-full shadow-[2px_2px_0_0_#000000]">
            <span class="w-1.5 h-1.5 bg-red-600 rounded-full animate-pulse"></span>
            <span class="text-[10px] font-bold text-gray-900 uppercase tracking-wider">TECNOLOGÍA Y EVOLUCIÓN</span>
        </div>
        <h2 class="text-3xl sm:text-4xl md:text-5xl font-extrabold mt-4 text-gray-900">EQUIPO AVASPACE</h2>
        <div class="w-16 sm:w-20 md:w-24 h-0.5 sm:h-1 bg-gradient-to-r from-red-600 to-amber-500 rounded-full mx-auto mt-4"></div>
    </div>

    <!-- Contenedor de las cards de equipo (2 columnas en desktop, 1 en móvil) -->
    <div class="max-w-6xl mx-auto grid grid-cols-1 md:grid-cols-2 gap-10 sm:gap-12 md:gap-16 lg:gap-20 px-4 sm:px-6">

        <!-- Card Juan Montalvo (CEO) -->
        <div class="relative bg-white border-2 border-gray-900 rounded-[2rem] sm:rounded-[3rem] p-8 sm:p-12 md:p-14 lg:p-16 text-center shadow-[8px_8px_0_0_#000000] hover:shadow-[12px_12px_0_0_#dc2626] hover:border-red-600 transition-all duration-500 group">

            <!-- Glow decorativo -->
            <div class="absolute inset-0 -z-10 flex justify-center items-center">
                <div class="w-[60%] h-[60%] bg-red-600/10 blur-[100px] rounded-full group-hover:bg-red-600/20 transition-all"></div>
            </div>

            <!-- Círculo rojo de fondo (más pequeño en móvil) -->
            <div class="absolute top-12 sm:top-16 left-1/2 -translate-x-1/2 w-32 sm:w-36 md:w-40 lg:w-48 h-32 sm:h-36 md:h-40 lg:h-48 bg-red-600 rounded-full opacity-20"></div>

            <!-- Imagen del perfil (placeholder) -->
            <div class="relative w-28 h-28 sm:w-32 sm:h-32 md:w-36 md:h-36 mx-auto mb-6 sm:mb-8 rounded-full bg-gradient-to-br from-red-100 to-red-50 border-4 border-gray-900 flex items-center justify-center shadow-[4px_4px_0_0_#000000] group-hover:shadow-[6px_6px_0_0_#dc2626] transition-all">
                <span class="text-4xl sm:text-5xl font-bold text-red-600">JM</span>
            </div>

            <h3 class="text-xl sm:text-2xl md:text-3xl font-bold text-gray-900">Juan Montalvo</h3>
            <p class="text-gray-500 text-sm sm:text-base mt-1">Co-Founder</p>

            <span class="inline-block mt-6 sm:mt-8 px-8 sm:px-10 md:px-12 py-2 sm:py-2.5 rounded-full bg-red-600 text-white font-semibold text-sm sm:text-base border-2 border-gray-900 shadow-[2px_2px_0_0_#000000] group-hover:shadow-[3px_3px_0_0_#000000] transition-all">
                CEO
            </span>

            <!-- Iconos sociales -->
            <div class="flex justify-center gap-3 sm:gap-4 mt-6 sm:mt-8">
                <a href="#" class="w-9 h-9 sm:w-10 sm:h-10 flex items-center justify-center rounded-xl bg-white border-2 border-gray-300 hover:border-red-400 shadow-sm hover:shadow-md transition-all hover:scale-110">
                    <svg class="w-4 h-4 sm:w-5 sm:h-5" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M23.498 6.186a2.998 2.998 0 0 0-2.11-2.12C19.504 3.5 12 3.5 12 3.5s-7.504 0-9.388.566a2.998 2.998 0 0 0-2.11 2.12C0 8.07 0 12 0 12s0 3.93.502 5.814a2.998 2.998 0 0 0 2.11 2.12C4.496 20.5 12 20.5 12 20.5s7.504 0 9.388-.566a2.998 2.998 0 0 0 2.11-2.12C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/>
                    </svg>
                </a>
                <a href="#" class="w-9 h-9 sm:w-10 sm:h-10 flex items-center justify-center rounded-xl bg-white border-2 border-gray-300 hover:border-red-400 shadow-sm hover:shadow-md transition-all hover:scale-110">
                    <svg class="w-4 h-4 sm:w-5 sm:h-5" viewBox="0 0 24 24" fill="currentColor">
                        <circle cx="12" cy="12" r="2.5"/>
                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 15c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5z"/>
                    </svg>
                </a>
                <a href="#" class="w-9 h-9 sm:w-10 sm:h-10 flex items-center justify-center rounded-xl bg-white border-2 border-gray-300 hover:border-red-400 shadow-sm hover:shadow-md transition-all hover:scale-110">
                    <svg class="w-4 h-4 sm:w-5 sm:h-5" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452z"/>
                    </svg>
                </a>
            </div>
        </div>

        <!-- Card Jesús Montejo (CTO) - Misma estructura -->
        <div class="relative bg-white border-2 border-gray-900 rounded-[2rem] sm:rounded-[3rem] p-8 sm:p-12 md:p-14 lg:p-16 text-center shadow-[8px_8px_0_0_#000000] hover:shadow-[12px_12px_0_0_#dc2626] hover:border-red-600 transition-all duration-500 group">

            <div class="absolute inset-0 -z-10 flex justify-center items-center">
                <div class="w-[60%] h-[60%] bg-red-600/10 blur-[100px] rounded-full group-hover:bg-red-600/20 transition-all"></div>
            </div>

            <div class="absolute top-12 sm:top-16 left-1/2 -translate-x-1/2 w-32 sm:w-36 md:w-40 lg:w-48 h-32 sm:h-36 md:h-40 lg:h-48 bg-red-600 rounded-full opacity-20"></div>

            <div class="relative w-28 h-28 sm:w-32 sm:h-32 md:w-36 md:h-36 mx-auto mb-6 sm:mb-8 rounded-full bg-gradient-to-br from-red-100 to-red-50 border-4 border-gray-900 flex items-center justify-center shadow-[4px_4px_0_0_#000000] group-hover:shadow-[6px_6px_0_0_#dc2626] transition-all">
                <span class="text-4xl sm:text-5xl font-bold text-red-600">JM</span>
            </div>

            <h3 class="text-xl sm:text-2xl md:text-3xl font-bold text-gray-900">Jesús Montejo</h3>
            <p class="text-gray-500 text-sm sm:text-base mt-1">Co-Founder</p>

            <span class="inline-block mt-6 sm:mt-8 px-8 sm:px-10 md:px-12 py-2 sm:py-2.5 rounded-full bg-red-600 text-white font-semibold text-sm sm:text-base border-2 border-gray-900 shadow-[2px_2px_0_0_#000000] group-hover:shadow-[3px_3px_0_0_#000000] transition-all">
                CTO
            </span>

            <div class="flex justify-center gap-3 sm:gap-4 mt-6 sm:mt-8">
                <a href="#" class="w-9 h-9 sm:w-10 sm:h-10 flex items-center justify-center rounded-xl bg-white border-2 border-gray-300 hover:border-red-400 shadow-sm hover:shadow-md transition-all hover:scale-110">
                    <svg class="w-4 h-4 sm:w-5 sm:h-5" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M23.498 6.186a2.998 2.998 0 0 0-2.11-2.12C19.504 3.5 12 3.5 12 3.5s-7.504 0-9.388.566a2.998 2.998 0 0 0-2.11 2.12C0 8.07 0 12 0 12s0 3.93.502 5.814a2.998 2.998 0 0 0 2.11 2.12C4.496 20.5 12 20.5 12 20.5s7.504 0 9.388-.566a2.998 2.998 0 0 0 2.11-2.12C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/>
                    </svg>
                </a>
                <a href="#" class="w-9 h-9 sm:w-10 sm:h-10 flex items-center justify-center rounded-xl bg-white border-2 border-gray-300 hover:border-red-400 shadow-sm hover:shadow-md transition-all hover:scale-110">
                    <svg class="w-4 h-4 sm:w-5 sm:h-5" viewBox="0 0 24 24" fill="currentColor">
                        <circle cx="12" cy="12" r="2.5"/>
                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 15c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5z"/>
                    </svg>
                </a>
                <a href="#" class="w-9 h-9 sm:w-10 sm:h-10 flex items-center justify-center rounded-xl bg-white border-2 border-gray-300 hover:border-red-400 shadow-sm hover:shadow-md transition-all hover:scale-110">
                    <svg class="w-4 h-4 sm:w-5 sm:h-5" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452z"/>
                    </svg>
                </a>
            </div>
        </div>
    </div>
</section>

<!-- =========================
     FOOTER (IDÉNTICO A LA LANDING)
========================= -->
<footer class="bg-zinc-950 text-gray-200 border-t border-zinc-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-10 md:py-12 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-6 sm:gap-8 items-start">

        <!-- Columna principal -->
        <div class="sm:col-span-2 space-y-2 sm:space-y-3 text-center sm:text-left">
            <div class="flex items-center gap-2 sm:gap-3 justify-center sm:justify-start">
                <img src="{{ asset('avaspace.svg') }}" alt="Avaspace" class="h-8 sm:h-9 md:h-10 brightness-0 invert">
                <h2 class="text-base xs:text-lg sm:text-xl font-semibold text-white">Controla tus gastos</h2>
            </div>
            <p class="text-xs sm:text-sm text-gray-400 max-w-sm mx-auto sm:mx-0">
                Convierte tus números en decisiones inteligentes para hacer crecer tu negocio.
            </p>
        </div>

        <!-- Avisos -->
        <div class="space-y-2 text-center sm:text-left">
            <h3 class="text-sm sm:text-base font-semibold text-white">Avisos</h3>
            <ul class="space-y-1 text-xs sm:text-sm text-gray-400">
                <li><a href="{{ route('aviso-de-privacidad') }}" class="hover:text-red-400 transition inline-block py-1">Aviso de privacidad</a></li>
                <li><a href="{{ route('terminos') }}" class="hover:text-red-400 transition inline-block py-1">Términos y condiciones</a></li>
            </ul>
        </div>

        <!-- Equipo -->
        <div class="space-y-2 text-center sm:text-left">
            <h3 class="text-sm sm:text-base font-semibold text-white">Equipo</h3>
            <ul class="space-y-1 text-xs sm:text-sm text-gray-400">
                <li><a href="{{ route('nosotros') }}" class="hover:text-red-400 transition inline-block py-1">Nosotros</a></li>
            </ul>
        </div>

        <!-- Social -->
        <div class="space-y-2 text-center sm:text-left">
            <h3 class="text-sm sm:text-base font-semibold text-white">Social</h3>
            <ul class="space-y-1 text-xs sm:text-sm text-gray-400">
                <li><a href="https://www.facebook.com/avaspace.io" class="hover:text-red-400 transition inline-block py-1" target="_blank">Facebook</a></li>
                <li><a href="https://www.instagram.com/avaspace.io/" class="hover:text-red-400 transition inline-block py-1" target="_blank">Instagram</a></li>
                <li><a href="https://www.youtube.com/@avaspace" class="hover:text-red-400 transition inline-block py-1" target="_blank">YouTube</a></li>
            </ul>
        </div>
    </div>

    <!-- Copyright -->
    <div class="border-t border-zinc-800 py-3 sm:py-4 text-center text-[10px] sm:text-xs text-gray-500 px-4">
        © {{ date('Y') }} Avaspace. Todos los derechos reservados.
    </div>
</footer>

</body>
</html>