<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Nosotros | Avaspace</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gradient-to-br from-black via-[#0f1115] to-[#1a1d23] text-white overflow-x-hidden">

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

<!-- SECCIÓN EQUIPO -->
<section class="relative py-32">

    <!-- TEXTO SUPERIOR -->
    <div class="relative text-center mb-24">

        <!-- glow sutil -->
        <div class="absolute inset-0 flex justify-center items-center -z-10">
            <div class="w-[380px] h-[140px]
                        bg-red-600/15
                        blur-[120px]
                        rounded-full"></div>
        </div>

        <p class="text-sm tracking-[0.35em] text-white/60 mb-6">
            TECNOLOGÍA Y EVOLUCIÓN
        </p>

        <h1 class="text-4xl md:text-5xl font-extrabold">
            EQUIPO AVASPACE
        </h1>
    </div>

    <!-- CARDS -->
    <div class="max-w-6xl mx-auto grid md:grid-cols-2 gap-20 px-6">

        <!-- JUAN -->
        <div class="relative bg-white/10 backdrop-blur-xl
                    border border-red-600/40 rounded-[3rem]
                    p-16 text-center shadow-2xl">

            <div class="absolute inset-0 -z-10 flex justify-center items-center">
                <div class="w-[45%] h-[45%]
                            bg-red-600/15
                            blur-[120px]
                            rounded-full"></div>
            </div>

            <div class="absolute top-16 left-1/2 -translate-x-1/2
                        w-48 h-48 bg-red-600 rounded-full"></div>

            <img src="{{ asset('CEO-Juan.svg') }}"
                 class="relative w-36 h-36 mx-auto mb-10">
                 <br>

            <h3 class="text-2xl font-bold">Juan Montalvo</h3>
            <p class="text-white/60 mt-2">Co-Founder</p>

            <span class="inline-block mt-10 px-12 py-3 rounded-full
                         bg-red-600 font-semibold">
                CEO
            </span>
            <br>
           <!-- ICONOS SOCIALES -->
<div class="flex justify-center gap-5 mt-6">

    <!-- YOUTUBE -->
    <a href="#"
       class="w-11 h-11 flex items-center justify-center
              rounded-xl bg-white
              shadow-md
              hover:scale-110 transition">

        <svg xmlns="http://www.w3.org/2000/svg"
             viewBox="0 0 24 24"
             class="w-6 h-6">
            <path fill="#000000"
                  d="M23.498 6.186a2.998 2.998 0 0 0-2.11-2.12C19.504 3.5 12 3.5 12 3.5s-7.504 0-9.388.566a2.998 2.998 0 0 0-2.11 2.12C0 8.07 0 12 0 12s0 3.93.502 5.814a2.998 2.998 0 0 0 2.11 2.12C4.496 20.5 12 20.5 12 20.5s7.504 0 9.388-.566a2.998 2.998 0 0 0 2.11-2.12C24 15.93 24 12 24 12s0-3.93-.502-5.814z"/>
            <path fill="#FFFFFF"
                  d="M9.545 15.568V8.432L15.818 12l-6.273 3.568z"/>
        </svg>
    </a>

    <!-- INSTAGRAM -->
    <a href="#"
       class="w-11 h-11 flex items-center justify-center
              rounded-xl bg-white
              shadow-md
              hover:scale-110 transition">

        <svg xmlns="http://www.w3.org/2000/svg"
             viewBox="0 0 24 24"
             class="w-6 h-6">
            <path fill="#000000"
                  d="M7 2C4.243 2 2 4.243 2 7v10c0 2.757 2.243 5 5 5h10c2.757 0 5-2.243 5-5V7c0-2.757-2.243-5-5-5H7z"/>
            <circle cx="12" cy="12" r="3.2" fill="#FFFFFF"/>
            <circle cx="17.2" cy="6.8" r="1.1" fill="#FFFFFF"/>
        </svg>
    </a>

    <!-- LINKEDIN -->
    <a href="#"
       class="w-11 h-11 flex items-center justify-center
              rounded-xl bg-white
              shadow-md
              hover:scale-110 transition">

        <svg xmlns="http://www.w3.org/2000/svg"
             viewBox="0 0 24 24"
             class="w-6 h-6">
            <path fill="#000000"
                  d="M22.23 0H1.77C.79 0 0 .774 0 1.727v20.545C0 23.227.79 24 1.77 24h20.46C23.21 24 24 23.227 24 22.273V1.727C24 .774 23.21 0 22.23 0z"/>
            <path fill="#FFFFFF"
                  d="M3.56 9h3.6v12h-3.6V9zM5.34 3.5a2.08 2.08 0 1 0 0 4.16 2.08 2.08 0 0 0 0-4.16zM9.56 9h3.45v1.64h.05c.48-.9 1.65-1.84 3.4-1.84 3.63 0 4.3 2.39 4.3 5.49V21h-3.6v-5.46c0-1.3-.02-2.97-1.81-2.97-1.81 0-2.09 1.41-2.09 2.87V21h-3.6V9z"/>
        </svg>
    </a>

</div>
        </div>

        <!-- JESÚS -->
        <div class="relative bg-white/10 backdrop-blur-xl
                    border border-red-600/40 rounded-[3rem]
                    p-16 text-center shadow-2xl">

            <div class="absolute inset-0 -z-10 flex justify-center items-center">
                <div class="w-[45%] h-[45%]
                            bg-red-600/15
                            blur-[120px]
                            rounded-full"></div>
            </div>

            <div class="absolute top-16 left-1/2 -translate-x-1/2
                        w-48 h-48 bg-red-600 rounded-full"></div>

            <img src="{{ asset('CTO-Jesus.svg') }}"
                 class="relative w-36 h-36 mx-auto mb-10">
                 <br>

            <h3 class="text-2xl font-bold">Jesús Montejo</h3>
            <p class="text-white/60 mt-2">Co-Founder</p>

            <span class="inline-block mt-10 px-12 py-3 rounded-full
                         bg-red-600 font-semibold">
                CTO
            </span>
            <br>
            <!-- ICONOS SOCIALES -->
<div class="flex justify-center gap-5 mt-6">

    <!-- YOUTUBE -->
    <a href="#"
       class="w-11 h-11 flex items-center justify-center
              rounded-xl bg-white
              shadow-md
              hover:scale-110 transition">

        <svg xmlns="http://www.w3.org/2000/svg"
             viewBox="0 0 24 24"
             class="w-6 h-6">
            <path fill="#000000"
                  d="M23.498 6.186a2.998 2.998 0 0 0-2.11-2.12C19.504 3.5 12 3.5 12 3.5s-7.504 0-9.388.566a2.998 2.998 0 0 0-2.11 2.12C0 8.07 0 12 0 12s0 3.93.502 5.814a2.998 2.998 0 0 0 2.11 2.12C4.496 20.5 12 20.5 12 20.5s7.504 0 9.388-.566a2.998 2.998 0 0 0 2.11-2.12C24 15.93 24 12 24 12s0-3.93-.502-5.814z"/>
            <path fill="#FFFFFF"
                  d="M9.545 15.568V8.432L15.818 12l-6.273 3.568z"/>
        </svg>
    </a>

    <!-- INSTAGRAM -->
    <a href="#"
       class="w-11 h-11 flex items-center justify-center
              rounded-xl bg-white
              shadow-md
              hover:scale-110 transition">

        <svg xmlns="http://www.w3.org/2000/svg"
             viewBox="0 0 24 24"
             class="w-6 h-6">
            <path fill="#000000"
                  d="M7 2C4.243 2 2 4.243 2 7v10c0 2.757 2.243 5 5 5h10c2.757 0 5-2.243 5-5V7c0-2.757-2.243-5-5-5H7z"/>
            <circle cx="12" cy="12" r="3.2" fill="#FFFFFF"/>
            <circle cx="17.2" cy="6.8" r="1.1" fill="#FFFFFF"/>
        </svg>
    </a>

    <!-- LINKEDIN -->
    <a href="#"
       class="w-11 h-11 flex items-center justify-center
              rounded-xl bg-white
              shadow-md
              hover:scale-110 transition">

        <svg xmlns="http://www.w3.org/2000/svg"
             viewBox="0 0 24 24"
             class="w-6 h-6">
            <path fill="#000000"
                  d="M22.23 0H1.77C.79 0 0 .774 0 1.727v20.545C0 23.227.79 24 1.77 24h20.46C23.21 24 24 23.227 24 22.273V1.727C24 .774 23.21 0 22.23 0z"/>
            <path fill="#FFFFFF"
                  d="M3.56 9h3.6v12h-3.6V9zM5.34 3.5a2.08 2.08 0 1 0 0 4.16 2.08 2.08 0 0 0 0-4.16zM9.56 9h3.45v1.64h.05c.48-.9 1.65-1.84 3.4-1.84 3.63 0 4.3 2.39 4.3 5.49V21h-3.6v-5.46c0-1.3-.02-2.97-1.81-2.97-1.81 0-2.09 1.41-2.09 2.87V21h-3.6V9z"/>
        </svg>
    </a>

</div>
        </div>
    </div>
</section>

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