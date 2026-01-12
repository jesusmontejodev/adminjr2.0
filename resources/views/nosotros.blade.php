<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Nosotros | Avaspace</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined"
      rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-gradient-to-br from-black via-[#0f1115] to-[#1a1d23] text-white overflow-x-hidden">

<header class="max-w-7xl mx-auto px-6 py-6">
    <div class="flex justify-between items-center rounded-full px-8 py-4 
                bg-white/10 backdrop-blur-md border border-white/10 shadow-lg">

        <!-- LOGO + NOMBRE -->
        <div class="flex items-center gap-3">
            <img src="{{ asset('avaspace.svg') }}" alt="Avaspace" class="h-10">
            <span class="text-white font-bold text-lg tracking-wide">
                Avaspace
            </span>
        </div>

        <!-- ACCIONES -->
        <div class="flex gap-4">
            <a href="{{ route('login') }}"
               class="px-6 py-2 rounded-full border border-white/40 text-sm 
                      hover:bg-white hover:text-black transition font-medium">
                Iniciar sesión 
            </a>

            <a href="{{ route('register') }}"
               class="px-6 py-2 rounded-full border border-red-900 bg-red-600 
                      hover:bg-white hover:text-black transition font-medium">
                Crear cuenta
            </a>
        </div>

    </div>
</header>

<!-- HERO NOSOTROS -->
<section class="mt-32 relative overflow-hidden">

    <!-- glow principal -->
    <div class="absolute inset-0 -z-10 flex justify-center items-center">
        <div class="w-[70%] h-[70%] bg-red-600/20 blur-[180px] rounded-full"></div>
    </div>

    <div class="text-center mb-24">
        <p class="text-sm tracking-[0.35em] text-white/60 mb-6">
            TECNOLOGÍA Y EVOLUCIÓN
        </p>

        <h1 class="text-4xl md:text-5xl font-extrabold">
            EQUIPO AVASPACE
        </h1>
    </div>

    <!-- CARDS -->
    <div class="max-w-6xl mx-auto grid md:grid-cols-2 gap-16 px-6">

        <!-- JUAN -->
        <div class="relative bg-white/10 backdrop-blur-xl
                    border border-red-600/40 rounded-[3rem]
                    p-16 text-center shadow-2xl">

            <div class="absolute inset-0 -z-10 flex justify-center items-center">
                <div class="w-[60%] h-[60%] bg-red-600/20 blur-3xl rounded-full"></div>
            </div>

            <div class="absolute top-16 left-1/2 -translate-x-1/2
                        w-48 h-48 bg-red-600 rounded-full"></div>

            <img src="{{ asset('CEO-Juan.svg') }}"
                 alt="Juan Montalvo"
                 class="relative w-36 h-36 mx-auto mb-10">

            <h3 class="text-2xl font-bold">Juan Montalvo</h3>
            <p class="text-white/60 mt-2">Co-Founder</p>

            <span class="inline-block mt-10 px-12 py-3 rounded-full
                         bg-red-600 font-semibold">
                CEO
            </span>
           <!-- ICONOS SOCIALES -->
<div class="flex justify-center gap-6 mt-10">

    <!-- YOUTUBE -->
    <a href="https://youtube.com"
       target="_blank"
       class="w-10 h-10 flex items-center justify-center
              rounded-xl bg-white
              hover:scale-110 transition">

        <svg xmlns="http://www.w3.org/2000/svg"
             viewBox="0 0 24 24"
             fill="black"
             class="w-6 h-6">
            <path d="M23.498 6.186a2.998 2.998 0 0 0-2.11-2.12C19.504 3.5 12 3.5 12 3.5s-7.504 0-9.388.566a2.998 2.998 0 0 0-2.11 2.12C0 8.07 0 12 0 12s0 3.93.502 5.814a2.998 2.998 0 0 0 2.11 2.12C4.496 20.5 12 20.5 12 20.5s7.504 0 9.388-.566a2.998 2.998 0 0 0 2.11-2.12C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/>
        </svg>
    </a>

    <!-- INSTAGRAM -->
    <a href="https://instagram.com"
       target="_blank"
       class="w-10 h-10 flex items-center justify-center
              rounded-xl bg-white
              hover:scale-110 transition">

        <svg xmlns="http://www.w3.org/2000/svg"
             viewBox="0 0 24 24"
             fill="black"
             class="w-6 h-6">
            <path d="M7 2C4.243 2 2 4.243 2 7v10c0 2.757 2.243 5 5 5h10c2.757 0 5-2.243 5-5V7c0-2.757-2.243-5-5-5H7zm10 2c1.654 0 3 1.346 3 3v10c0 1.654-1.346 3-3 3H7c-1.654 0-3-1.346-3-3V7c0-1.654 1.346-3 3-3h10zm-5 3a5 5 0 1 0 0 10 5 5 0 0 0 0-10zm0 2a3 3 0 1 1 0 6 3 3 0 0 1 0-6zm4.5-.9a1.1 1.1 0 1 0 0 2.2 1.1 1.1 0 0 0 0-2.2z"/>
        </svg>
    </a>

    <!-- LINKEDIN -->
    <a href="https://linkedin.com"
       target="_blank"
       class="w-10 h-10 flex items-center justify-center
              rounded-xl bg-white
              hover:scale-110 transition">

        <svg xmlns="http://www.w3.org/2000/svg"
             viewBox="0 0 24 24"
             fill="black"
             class="w-6 h-6">
            <path d="M4.98 3.5C3.33 3.5 2 4.83 2 6.48c0 1.63 1.31 2.98 2.94 2.98h.03c1.68 0 2.98-1.35 2.98-2.98C7.94 4.83 6.66 3.5 4.98 3.5zM2.4 20.5h5.17V9H2.4v11.5zM9.34 9h4.96v1.57h.07c.69-1.31 2.38-2.69 4.9-2.69 5.24 0 6.2 3.45 6.2 7.93v4.69h-5.17v-4.16c0-.99-.02-2.26-1.38-2.26-1.38 0-1.59 1.08-1.59 2.19v4.23H9.34V9z"/>
        </svg>
    </a>

</div>

        </div>

        <!-- JESUS -->
        <div class="relative bg-white/10 backdrop-blur-xl
                    border border-red-600/40 rounded-[3rem]
                    p-16 text-center shadow-2xl">

            <div class="absolute inset-0 -z-10 flex justify-center items-center">
                <div class="w-[60%] h-[60%] bg-red-600/20 blur-3xl rounded-full"></div>
            </div>

            <div class="absolute top-16 left-1/2 -translate-x-1/2
                        w-48 h-48 bg-red-600 rounded-full"></div>

            <img src="{{ asset('CTO-Jesus.svg') }}"
                 alt="Jesús Montejo"
                 class="relative w-36 h-36 mx-auto mb-10">

            <h3 class="text-2xl font-bold">Jesús Montejo</h3>
            <p class="text-white/60 mt-2">Co-Founder</p>

            <span class="inline-block mt-10 px-12 py-3 rounded-full
                         bg-red-600 font-semibold">
                CTO
            </span>
                     <!-- ICONOS SOCIALES -->
<div class="flex justify-center gap-6 mt-10">

    <!-- YOUTUBE -->
    <a href="https://youtube.com"
       target="_blank"
       class="w-10 h-10 flex items-center justify-center
              rounded-xl bg-white
              hover:scale-110 transition">

        <svg xmlns="http://www.w3.org/2000/svg"
             viewBox="0 0 24 24"
             fill="black"
             class="w-6 h-6">
            <path d="M23.498 6.186a2.998 2.998 0 0 0-2.11-2.12C19.504 3.5 12 3.5 12 3.5s-7.504 0-9.388.566a2.998 2.998 0 0 0-2.11 2.12C0 8.07 0 12 0 12s0 3.93.502 5.814a2.998 2.998 0 0 0 2.11 2.12C4.496 20.5 12 20.5 12 20.5s7.504 0 9.388-.566a2.998 2.998 0 0 0 2.11-2.12C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/>
        </svg>
    </a>

    <!-- INSTAGRAM -->
    <a href="https://instagram.com"
       target="_blank"
       class="w-10 h-10 flex items-center justify-center
              rounded-xl bg-white
              hover:scale-110 transition">

        <svg xmlns="http://www.w3.org/2000/svg"
             viewBox="0 0 24 24"
             fill="black"
             class="w-6 h-6">
            <path d="M7 2C4.243 2 2 4.243 2 7v10c0 2.757 2.243 5 5 5h10c2.757 0 5-2.243 5-5V7c0-2.757-2.243-5-5-5H7zm10 2c1.654 0 3 1.346 3 3v10c0 1.654-1.346 3-3 3H7c-1.654 0-3-1.346-3-3V7c0-1.654 1.346-3 3-3h10zm-5 3a5 5 0 1 0 0 10 5 5 0 0 0 0-10zm0 2a3 3 0 1 1 0 6 3 3 0 0 1 0-6zm4.5-.9a1.1 1.1 0 1 0 0 2.2 1.1 1.1 0 0 0 0-2.2z"/>
        </svg>
    </a>

    <!-- LINKEDIN -->
    <a href="https://linkedin.com"
       target="_blank"
       class="w-10 h-10 flex items-center justify-center
              rounded-xl bg-white
              hover:scale-110 transition">

        <svg xmlns="http://www.w3.org/2000/svg"
             viewBox="0 0 24 24"
             fill="black"
             class="w-6 h-6">
            <path d="M4.98 3.5C3.33 3.5 2 4.83 2 6.48c0 1.63 1.31 2.98 2.94 2.98h.03c1.68 0 2.98-1.35 2.98-2.98C7.94 4.83 6.66 3.5 4.98 3.5zM2.4 20.5h5.17V9H2.4v11.5zM9.34 9h4.96v1.57h.07c.69-1.31 2.38-2.69 4.9-2.69 5.24 0 6.2 3.45 6.2 7.93v4.69h-5.17v-4.16c0-.99-.02-2.26-1.38-2.26-1.38 0-1.59 1.08-1.59 2.19v4.23H9.34V9z"/>
        </svg>
    </a>

</div>
        </div>
    </div>
</section>

<!-- FOOTER (SIN CAMBIOS) -->
<footer class="bg-white text-black border-t border-gray-200">
    <div class="max-w-7xl mx-auto px-6 py-12 grid grid-cols-1 md:grid-cols-5 gap-8 items-start">

        <div class="md:col-span-2 space-y-3">
            <div class="flex items-center gap-3">
                <img src="{{ asset('avaspace.svg') }}" alt="Avaspace" class="h-10">
                <h2 class="text-xl font-semibold">Controla tus gastos</h2>
            </div>
            <p class="text-sm text-gray-600 max-w-sm">
                Avaspace, la herramienta para vendedores.
            </p>
        </div>

        <div class="space-y-2 text-sm">
            <h3 class="font-semibold">Avisos</h3>
            <ul class="space-y-1 text-gray-600">
                <li><a href="#">Aviso de privacidad</a></li>
                <li><a href="#">Términos y condiciones</a></li>
            </ul>
        </div>

        <div class="space-y-2 text-sm">
            <h3 class="font-semibold">Equipo</h3>
            <ul class="space-y-1 text-gray-600">
                <li><a href="{{ route('nosotros') }}">Nosotros</a></li>
                <li><a href="#">Blog</a></li>
            </ul>
        </div>

        <div class="space-y-2 text-sm">
            <h3 class="font-semibold">Social</h3>
            <ul class="space-y-1 text-gray-600">
                <li><a href="#">Facebook</a></li>
                <li><a href="#">Instagram</a></li>
                <li><a href="#">YouTube</a></li>
                <li><a href="#">LinkedIn</a></li>
            </ul>
        </div>
    </div>

    <div class="border-t border-gray-200 py-4 text-center text-xs text-gray-500">
        © {{ date('Y') }} Avaspace. Todos los derechos reservados.
    </div>
</footer>
</body>
</html>