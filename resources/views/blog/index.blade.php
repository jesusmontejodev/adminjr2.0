<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Blog y documentación | Avaspace</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Guías y documentación técnica para conectar asistentes de IA (MCP) a AdminJR y automatizar tus finanzas.">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-[#f0f2f5] text-[#1c1e21] overflow-x-hidden">

<!-- HEADER -->
<header class="bg-white border-b border-gray-300">
    <div class="max-w-6xl mx-auto px-6 py-4 flex justify-between items-center">
        <a href="{{ route('home') }}" class="flex items-center gap-3">
            <img src="{{ asset('avaspace.svg') }}" class="h-8">
            <span class="font-semibold text-lg">Avaspace</span>
        </a>
        <a href="{{ route('home') }}" class="text-sm font-medium text-gray-600 hover:text-red-600 transition-colors">
            &larr; Volver al inicio
        </a>
    </div>
</header>

<!-- CONTENIDO -->
<main class="max-w-4xl mx-auto px-6 py-16 space-y-10">

    <div class="space-y-3">
        <span class="inline-block text-xs font-semibold uppercase tracking-wide text-red-600 bg-red-50 px-3 py-1 rounded-full">
            Blog &amp; Documentación
        </span>
        <h1 class="text-3xl sm:text-4xl font-bold">Automatiza tus finanzas con IA</h1>
        <p class="text-gray-600 max-w-2xl">
            Guías y referencia técnica para conectar asistentes de IA a tu cuenta de AdminJR
            usando MCP, y construir tus propias automatizaciones de forma segura.
        </p>
    </div>

    <div class="grid sm:grid-cols-2 gap-6">
        @php
            $posts = [
                [
                    'route' => 'blog.conectar-ia-mcp',
                    'categoria' => 'Guía práctica',
                    'titulo' => 'Cómo conectar tu asistente de IA a AdminJR con MCP',
                    'resumen' => 'Paso a paso para crear tu primer token, entender los riesgos y usarlo en automatizaciones reales: registrar gastos, consultar saldos y más.',
                ],
                [
                    'route' => 'blog.referencia-api-mcp',
                    'categoria' => 'Referencia técnica',
                    'titulo' => 'Referencia técnica: API MCP de AdminJR',
                    'resumen' => 'Autenticación, abilities, endpoints disponibles, parámetros, respuestas y códigos de error para integrar la API de MCP en tus propias herramientas.',
                ],
            ];
        @endphp

        @foreach ($posts as $post)
            <a href="{{ route($post['route']) }}" class="block bg-white border border-gray-200 rounded-2xl p-6 hover:shadow-lg hover:border-red-200 transition-all">
                <span class="text-xs font-semibold uppercase tracking-wide text-red-600">{{ $post['categoria'] }}</span>
                <h2 class="text-lg font-bold mt-2 mb-2">{{ $post['titulo'] }}</h2>
                <p class="text-sm text-gray-600">{{ $post['resumen'] }}</p>
                <span class="inline-block mt-4 text-sm font-medium text-red-600">Leer artículo &rarr;</span>
            </a>
        @endforeach
    </div>

    <div class="bg-white border border-gray-200 rounded-2xl p-6 text-sm text-gray-600">
        ¿Ya tienes cuenta? Genera tus tokens de acceso para IA desde
        <a href="{{ route('mcp-tokens.index') }}" class="text-red-600 font-medium hover:underline">Integraciones IA</a>
        dentro de tu panel.
    </div>

</main>

<footer class="border-t border-gray-300 py-8 text-center text-xs text-gray-400">
    &copy; {{ date('Y') }} Avaspace. Todos los derechos reservados.
</footer>

</body>
</html>
