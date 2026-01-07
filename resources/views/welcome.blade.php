<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Admin Jr | Avaspace</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-gradient-to-br from-black via-[#0f1115] to-[#1a1d23] text-white overflow-x-hidden">

    <!-- HEADER -->
    <header class="max-w-7xl mx-auto px-6 py-6">
        <div class="flex justify-between items-center rounded-full px-8 py-4 
                    bg-white/10 backdrop-blur-md border border-white/10 shadow-lg">
            
            <!-- LOGO -->
            <img src="{{ asset('avaspace.svg') }}" alt="Avaspace" class="h-10">

            <!-- ACCIONES -->
            <div class="flex gap-4">
                <a href="{{ route('login') }}"
                   class="px-6 py-2 rounded-full border border-white/40 text-sm hover:bg-white hover:text-black transition">
                    Iniciar sesión
                </a>

                <a href="{{ route('register') }}"
                   class="px-6 py-2 rounded-full bg-red-600 hover:bg-red-700 text-sm transition">
                    Registrarse
                </a>
            </div>
        </div>
    </header>

    <!-- HERO -->
    <main class="max-w-7xl mx-auto px-6 pt-24 pb-24 relative">

        <!-- TEXTO -->
        <div class="text-center space-y-6 relative z-10">
            <h1 class="text-5xl md:text-6xl font-extrabold tracking-wide">
                Admin Jr.
            </h1>

            <p class="text-lg md:text-xl text-white/70 max-w-3xl mx-auto">
                Controla y optimiza los gastos de tu empresa desde una sola plataforma,
                con análisis inteligente y métricas claras para tomar mejores decisiones.
            </p>

            <!-- CTA -->
            <div class="flex justify-center gap-6 pt-6">
                <a href="#"
                   class="px-10 py-3 rounded-full border border-red-500 text-red-400 hover:bg-red-600 hover:text-white transition">
                    Ver funcionalidades
                </a>
            </div>
        </div>

        <!-- MOCKUP / VIDEO -->
        <div class="relative mt-24 flex justify-center">
            <!-- glow -->
            <div class="absolute inset-0 flex justify-center">
                <div class="w-[80%] h-[80%] bg-red-600/20 blur-3xl rounded-full"></div>
            </div>

            <!-- ventana -->
            <div class="relative w-full max-w-5xl rounded-2xl overflow-hidden 
                        bg-white/10 backdrop-blur-xl border border-white/10 shadow-2xl">
                
                <!-- barra superior -->
                <div class="flex items-center gap-2 px-4 py-3 bg-black/40">
                    <span class="w-3 h-3 bg-red-500 rounded-full"></span>
                    <span class="w-3 h-3 bg-yellow-400 rounded-full"></span>
                    <span class="w-3 h-3 bg-green-500 rounded-full"></span>
                </div>

                <!-- video -->
                <div class="aspect-video">
                    <iframe
                        class="w-full h-full"
                        src="https://www.youtube.com/embed/mjW6kuUwr6c"
                        title="Admin Jr Demo"
                        frameborder="0"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                        allowfullscreen>
                    </iframe>
                </div>
            </div>
        </div>

        <!-- CTA CARD -->
        <div class="mt-20 flex justify-center">
            <div class="w-full max-w-4xl rounded-2xl bg-white/10 backdrop-blur-md 
                        border border-white/10 px-10 py-10 text-center shadow-xl">
                
                <h3 class="text-3xl font-bold mb-4">
                    únete a admin Jr.
                </h3>

                <p class="text-white/70 mb-6">
                    Empieza a controlar tus gastos y toma mejores decisiones desde hoy.
                </p>

                <a href="{{ route('register') }}"
                   class="inline-block px-10 py-3 rounded-full bg-red-600 hover:bg-red-700 transition font-medium">
                    Crear cuenta
                </a>
            </div>
        </div>

    </main>

    <!-- FOOTER -->
    <footer class="bg-white text-black border-t border-gray-200">
        <div class="max-w-7xl mx-auto px-6 py-12 grid grid-cols-1 md:grid-cols-5 gap-8 items-start">

            <!-- Branding -->
            <div class="md:col-span-2 space-y-3">
                <div class="flex items-center gap-3">
                    <img src="{{ asset('avaspace.svg') }}" alt="Avaspace" class="h-10">
                    <h2 class="text-xl font-semibold">
                        Controla tus gastos
                    </h2>
                </div>
                <p class="text-sm text-gray-600 max-w-sm">
                    Avaspace, la herramienta para vendedores.
                </p>
            </div>

            <!-- Avisos -->
            <div class="space-y-2 text-sm">
                <h3 class="font-semibold">Avisos</h3>
                <ul class="space-y-1 text-gray-600">
                    <li><a href="#" class="hover:text-black">Aviso de privacidad</a></li>
                    <li><a href="#" class="hover:text-black">Términos y condiciones</a></li>
                </ul>
            </div>

            <!-- Equipo -->
            <div class="space-y-2 text-sm">
                <h3 class="font-semibold">Equipo</h3>
                <ul class="space-y-1 text-gray-600">
                    <li><a href="#" class="hover:text-black">Nosotros</a></li>
                    <li><a href="#" class="hover:text-black">Blog</a></li>
                </ul>
            </div>

            <!-- Comprar -->
            <div class="space-y-2 text-sm">
                <h3 class="font-semibold">Comprar</h3>
                <ul class="space-y-1 text-gray-600">
                    <li><a href="#" class="hover:text-black">Spacetools</a></li>
                    <li><a href="#" class="hover:text-black">Precios</a></li>
                </ul>
            </div>

            <!-- Social -->
            <div class="space-y-2 text-sm">
                <h3 class="font-semibold">Social</h3>
                <ul class="space-y-1 text-gray-600">
                    <li><a href="#" class="hover:text-black">Facebook</a></li>
                    <li><a href="#" class="hover:text-black">Instagram</a></li>
                    <li><a href="#" class="hover:text-black">YouTube</a></li>
                    <li><a href="#" class="hover:text-black">LinkedIn</a></li>
                </ul>
            </div>
        </div>

        <!-- Bottom -->
        <div class="border-t border-gray-200 py-4 text-center text-xs text-gray-500">
            © {{ date('Y') }} Avaspace. Todos los derechos reservados.
        </div>
    </footer>

</body>
</html>