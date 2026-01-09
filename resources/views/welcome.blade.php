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
   <section class="text-center space-y-8 relative">

    <!-- subtítulo -->
   <h2 class="text-3xl md:text-4xl font-medium text-white leading-tight text-center mx-auto">
    Controla tus
    <span class="text-red-500 font-bold">finanzas</span>
    o las de
    <span class="text-red-500 font-bold">tu negocio</span> 
    con un mensaje de 
     <span class="text-red-500 font-bold">WhatsApp</span> 
    </h2>


    <!-- descripción -->
    <p class="text-lg md:text-xl text-white/70 max-w-3xl mx-auto leading-relaxed">
        <span class="text-white font-medium">Admin JR</span> organiza tus finanzas,
        controla tus <span class="text-red-500 font-medium">ingresos y egresos</span>,
        te recuerda pagos y mantiene tu negocio en orden  
        <span class="text-white font-medium">sin contratar a un administrador</span>.
        <br><br>
        Diseñado para 
        <span class="text-red-500 font-medium">emprendedores</span>,
        <span class="text-red-500 font-medium">freelancers</span> y
        <span class="text-red-500 font-medium">pequeños negocios</span>
        que necesitan  
        <span class="text-white font-medium">claridad,</span>
        <span class="text-white font-medium">control</span>
             y
        <span class="text-white font-medium">tiempo libre</span>.
    </p>

    <!-- botones -->
    <div class="flex flex-col sm:flex-row justify-center gap-6 pt-6">

        <!-- botón principal -->
        <a href="{{ asset('PDF/BROCHURE_AVASPACE_ADMIN_JR_2.pdf') }}"
           download
           class="px-10 py-4 rounded-full font-semibold
                  bg-red-600 text-white
                  hover:bg-red-700 transition
                  shadow-lg shadow-red-600/30">
            Descargar brochure
        </a>
    </div>

    <!-- glow decorativo -->
    <div class="absolute inset-0 -z-10 flex justify-center">
        <div class="w-[60%] h-[60%] bg-red-600/20 blur-3xl rounded-full"></div>
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
            La mejor 
            <span class="text-red-600">herramienta de automatización</span> 
            administrativa
        </h3>

        <p class="text-white/70 text-lg leading-relaxed">
            Admin JR te ayuda a visualizar el estado real de tu negocio en segundos.
            Centraliza <span class="text-white font-medium">ingresos</span>,
            <span class="text-white font-medium">egresos</span>,
            recordatorios y reportes en una sola plataforma diseñada para emprendedores
            que buscan administrar de forma
            <span class="text-red-500 font-medium">simple</span>,
            <span class="text-red-500 font-medium">rápida</span> y
            <span class="text-red-500 font-medium">sin errores</span>.
        </p>
    </div>

    <!-- IMAGEN (SIN CAMBIOS) -->
    <div class="flex justify-center">
        <div class="relative w-full max-w-md rounded-2xl 
                    overflow-hidden bg-white/10 backdrop-blur-md 
                    border border-white/10 shadow-2xl">
            <img 
                src="{{ asset('images/grafica.jpg') }}" 
                alt="Dashboard Admin JR"
                class="w-full h-auto object-cover"
            >
        </div>
    </div>

</section>

  <!-- FEATURES -->
<section class="mt-32">
    <h2 class="text-4xl font-extrabold text-center mb-16 text-white">
        Características <span class="text-red-600">principales</span>
    </h2>

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
                Automatiza tus <span class="text-red-500">ingresos y egresos</span>
            </h4>

            <p class="text-white/70 leading-relaxed">
                Admin JR registra tus movimientos de manera intuitiva y te permite
                tener control total de tu flujo de efectivo sin depender de hojas
                de Excel o procesos manuales.
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
                Olvídate de pagos atrasados, cuentas pendientes o cargos olvidados.
                Admin JR envía alertas automáticas para mantener tu negocio al día
                y evitar fugas de dinero.
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
                Reportes <span class="text-red-500">claros y visibles</span>
            </h4>

            <p class="text-white/70 leading-relaxed">
                Obtén reportes fáciles de entender, gráficos dinámicos y
                resúmenes que muestran exactamente cómo va tu negocio,
                todo en un solo dashboard.
            </p>
        </div>

    </div>
</section>


    <!-- FAQ -->
    <!---<section class="mt-32 max-w-3xl mx-auto">
        <h2 class="text-4xl font-extrabold text-center mb-12 text-white">
            Preguntas <span class="text-red-600">frecuentes</span>
        </h2>

        <div class="space-y-6">
            <div class="bg-white/10 p-6 rounded-xl border border-white/10">
                <h4 class="font-semibold text-white">¿Puedo usar Admin Jr gratis?</h4>
                <p class="text-white/70 mt-2">Sí, puedes comenzar sin costo.</p>
            </div>

            <div class="bg-white/10 p-6 rounded-xl border border-white/10">
                <h4 class="font-semibold text-white">¿Es compatible con celular?</h4>
                <p class="text-white/70 mt-2">Totalmente responsive.</p>
            </div>
        </div>
    </section>-->

    <!-- CTA -->
<section class="mt-32 flex justify-center">
    <div class="relative w-full max-w-4xl bg-white/10 p-10 rounded-2xl border border-white/10 text-center overflow-hidden">

        <!-- glow -->
        <div class="absolute inset-0 -z-10 flex justify-center items-center">
            <div class="w-[60%] h-[60%] bg-red-600/20 blur-3xl rounded-full"></div>
        </div>

        <h3 class="text-3xl font-extrabold text-white mb-4">
            Empieza hoy <span class="text-red-600"></span>
        </h3>

        <p class="text-white/70 mb-6">
            Haz la diferencia y administra mejor tu empresa desde ahora.
        </p>

        <a href="{{ route('register') }}"
           class="inline-block px-10 py-3 rounded-full bg-red-600 hover:bg-red-700 transition font-semibold text-white">
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
                <li><a href="#">Nosotros</a></li>
                <li><a href="#">Blog</a></li>
            </ul>
        </div>

        <div class="space-y-2 text-sm">
            <h3 class="font-semibold">Comprar</h3>
            <ul class="space-y-1 text-gray-600">
                <li><a href="#">Spacetools</a></li>
                <li><a href="#">Precios</a></li>
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