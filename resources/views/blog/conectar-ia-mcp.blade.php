<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Cómo conectar tu asistente de IA a AdminJR con MCP | Avaspace</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Guía paso a paso para crear un token de acceso y conectar un asistente de IA a tu cuenta de AdminJR usando MCP.">

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
        <a href="{{ route('blog.index') }}" class="text-sm font-medium text-gray-600 hover:text-red-600 transition-colors">
            &larr; Volver al blog
        </a>
    </div>
</header>

<!-- CONTENIDO -->
<main class="max-w-3xl mx-auto px-6 py-16 space-y-10">

    <div class="space-y-3">
        <span class="inline-block text-xs font-semibold uppercase tracking-wide text-red-600 bg-red-50 px-3 py-1 rounded-full">
            Guía práctica
        </span>
        <h1 class="text-3xl font-bold">Cómo conectar tu asistente de IA a AdminJR con MCP</h1>
        <p class="text-sm text-gray-500">Última actualización: {{ date('d/m/Y') }}</p>
    </div>

    <section class="space-y-4">
        <p>
            AdminJR expone una API pensada para que un asistente de IA conectado por
            <strong>MCP</strong> (Model Context Protocol) pueda leer y registrar información
            en tu cuenta a nombre tuyo: consultar tus cuentas y saldos, revisar transacciones
            o registrar un gasto que le dictas por chat o voz.
        </p>
        <p>
            Todo el acceso se controla con <strong>tokens personales</strong>: cadenas secretas
            que tú generas, con permisos y fecha de vencimiento definidos por ti. Cualquier
            aplicación o asistente que tenga el token puede actuar como si fueras tú, así que
            trátalo con el mismo cuidado que una contraseña.
        </p>
    </section>

    <section class="space-y-4">
        <h2 class="text-xl font-semibold">1. Crea tu token de acceso</h2>
        <ol class="list-decimal pl-6 space-y-2">
            <li>Inicia sesión en AdminJR y entra a <strong>Integraciones IA</strong> en el menú lateral.</li>
            <li>Lee el aviso de beneficios y riesgos, y confirma que lo entiendes.</li>
            <li>
                Completa el formulario:
                <ul class="list-disc pl-6 mt-1 space-y-1 text-gray-700">
                    <li><strong>Nombre</strong>: algo que te ayude a identificarlo después, ej. "Asistente de gastos en Claude".</li>
                    <li><strong>Descripción</strong>: para qué lo vas a usar y qué IA lo consumirá.</li>
                    <li><strong>Permisos</strong>: "Solo lectura" si solo quieres consultar datos, o "Lectura y escritura" si también quieres que registre movimientos.</li>
                    <li><strong>Vence en</strong>: 7, 30, 90 días o 1 año. No existen tokens permanentes.</li>
                </ul>
            </li>
            <li>Copia el token que se muestra: <strong>solo se ve una vez</strong>. Guárdalo en un lugar seguro (tu gestor de contraseñas, por ejemplo).</li>
        </ol>
    </section>

    <section class="space-y-4">
        <h2 class="text-xl font-semibold">2. Úsalo desde tu asistente o herramienta de automatización</h2>
        <p>
            El token se envía como un <em>Bearer token</em> en el header <code class="bg-gray-100 px-1.5 py-0.5 rounded text-sm">Authorization</code>
            de cada solicitud. Por ejemplo, para confirmar que el token funciona y ver qué permisos tiene:
        </p>
        <pre class="bg-gray-900 text-gray-100 text-xs sm:text-sm rounded-xl p-4 overflow-x-auto"><code>curl https://tu-dominio.com/api/mcp/whoami \
  -H "Authorization: Bearer TU_TOKEN_AQUI" \
  -H "Accept: application/json"</code></pre>
        <p>
            Si configuras un servidor o cliente MCP genérico, normalmente solo necesitas indicarle
            la URL base (<code class="bg-gray-100 px-1.5 py-0.5 rounded text-sm">/api/mcp</code>) y el token como credencial de autenticación tipo Bearer.
            Consulta la
            <a href="{{ route('blog.referencia-api-mcp') }}" class="text-red-600 font-medium hover:underline">referencia técnica</a>
            para ver todos los endpoints disponibles.
        </p>
    </section>

    <section class="space-y-4">
        <h2 class="text-xl font-semibold">3. Ejemplos de automatización</h2>
        <ul class="list-disc pl-6 space-y-2">
            <li><strong>Registro de gastos por chat:</strong> le dices a tu asistente "gasté 250 pesos en gasolina" y este llama a la API para crear la transacción en la cuenta correcta.</li>
            <li><strong>Consulta de saldos:</strong> tu asistente responde "¿cuánto tengo en mi cuenta BBVA?" leyendo <code class="bg-gray-100 px-1.5 py-0.5 rounded text-sm">/api/mcp/cuentas</code> en tiempo real.</li>
            <li><strong>Reportes automáticos:</strong> un flujo programado (n8n, Zapier, un script propio) consulta tus transacciones del mes y te envía un resumen.</li>
        </ul>
    </section>

    <section class="space-y-4">
        <h2 class="text-xl font-semibold">4. Buenas prácticas de seguridad</h2>
        <ul class="list-disc pl-6 space-y-2">
            <li>Crea un token distinto por cada asistente o automatización, con un nombre y descripción claros.</li>
            <li>Usa "Solo lectura" salvo que realmente necesites que la IA registre información por ti.</li>
            <li>Nunca compartas el token por chat, correo o lo subas a un repositorio público.</li>
            <li>Si sospechas que se filtró, revócalo de inmediato desde <strong>Integraciones IA</strong>: el acceso se corta al instante.</li>
            <li>Un token nunca puede leer ni escribir datos de otro usuario, sin importar qué le pidas o qué IDs use: siempre queda limitado a tu propia cuenta.</li>
        </ul>
    </section>

    <div class="bg-white border border-gray-200 rounded-2xl p-6 text-sm text-gray-600">
        ¿Vas a integrar la API en tu propia herramienta? Revisa la
        <a href="{{ route('blog.referencia-api-mcp') }}" class="text-red-600 font-medium hover:underline">referencia técnica completa</a>.
    </div>

</main>

<footer class="border-t border-gray-300 py-8 text-center text-xs text-gray-400">
    &copy; {{ date('Y') }} Avaspace. Todos los derechos reservados.
</footer>

</body>
</html>
