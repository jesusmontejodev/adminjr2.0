<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Referencia técnica: API MCP de AdminJR | Avaspace</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Endpoints, autenticación, permisos y códigos de respuesta de la API MCP de AdminJR para desarrolladores.">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        code.inline { background: #f3f4f6; padding: 0.1rem 0.4rem; border-radius: 0.35rem; font-size: 0.85em; }
        table.api-table th, table.api-table td { padding: 0.5rem 0.75rem; border-bottom: 1px solid #e5e7eb; text-align: left; vertical-align: top; }
        table.api-table th { background: #f9fafb; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.03em; color: #6b7280; }
    </style>
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
            Referencia técnica
        </span>
        <h1 class="text-3xl font-bold">Referencia técnica: API MCP de AdminJR</h1>
        <p class="text-sm text-gray-500">Última actualización: {{ date('d/m/Y') }}</p>
        <p class="text-gray-600">
            Documentación para desarrolladores que integran asistentes de IA o automatizaciones
            propias contra la API de AdminJR. Si buscas la guía paso a paso para usuarios finales,
            consulta <a href="{{ route('blog.conectar-ia-mcp') }}" class="text-red-600 font-medium hover:underline">cómo conectar tu IA con MCP</a>.
        </p>
    </div>

    <section class="space-y-4">
        <h2 class="text-xl font-semibold">Autenticación</h2>
        <p>
            La API usa tokens personales de <a href="https://laravel.com/docs/sanctum" target="_blank" class="text-red-600 hover:underline">Laravel Sanctum</a>,
            generados por cada usuario desde <strong>Integraciones IA</strong> dentro de su panel.
            Se envían como Bearer token en cada solicitud:
        </p>
        <pre class="bg-gray-900 text-gray-100 text-xs sm:text-sm rounded-xl p-4 overflow-x-auto"><code>Authorization: Bearer &lt;token&gt;
Accept: application/json</code></pre>
        <p>
            Cada token tiene una fecha de vencimiento obligatoria (no existen tokens permanentes)
            y puede revocarse en cualquier momento desde la interfaz; una vez revocado o vencido,
            cualquier solicitud con ese token responde <code class="inline">401 Unauthorized</code>.
        </p>
    </section>

    <section class="space-y-4">
        <h2 class="text-xl font-semibold">Permisos (abilities)</h2>
        <p>
            Cada token tiene una de estas combinaciones de permisos, elegida al crearlo:
        </p>
        <table class="api-table w-full text-sm bg-white rounded-xl overflow-hidden border border-gray-200">
            <thead>
                <tr><th>Ability</th><th>Permite</th></tr>
            </thead>
            <tbody>
                <tr><td><code class="inline">read:own</code></td><td>Leer cuentas, categorías y transacciones del usuario dueño del token.</td></tr>
                <tr><td><code class="inline">write:own</code></td><td>Crear transacciones a nombre del usuario dueño del token (siempre además de <code class="inline">read:own</code>).</td></tr>
            </tbody>
        </table>
        <p>
            Una solicitud que requiere una ability que el token no tiene responde
            <code class="inline">403 Forbidden</code>.
        </p>
    </section>

    <section class="space-y-4">
        <h2 class="text-xl font-semibold">Aislamiento por usuario</h2>
        <p>
            Todas las operaciones se resuelven exclusivamente a partir del usuario dueño del token
            autenticado — nunca de un identificador que envíes en la URL o el cuerpo de la solicitud.
            Un token jamás puede leer ni escribir cuentas, categorías o transacciones de otro usuario:
            si intentas usar un <code class="inline">cuenta_id</code> o <code class="inline">categoria_id</code>
            que no te pertenece, la API responde <code class="inline">404 Not Found</code>, como si no existiera.
        </p>
    </section>

    <section class="space-y-4">
        <h2 class="text-xl font-semibold">Endpoints</h2>

        <div class="bg-white border border-gray-200 rounded-2xl p-5 space-y-2">
            <div class="flex items-center gap-2">
                <span class="text-xs font-bold text-white bg-blue-600 px-2 py-0.5 rounded">GET</span>
                <code class="inline">/api/mcp/whoami</code>
            </div>
            <p class="text-sm text-gray-600">Requiere <code class="inline">read:own</code>. Devuelve el usuario dueño del token y las abilities/expiración del token actual. Útil para que un agente se autodescubra.</p>
        </div>

        <div class="bg-white border border-gray-200 rounded-2xl p-5 space-y-2">
            <div class="flex items-center gap-2">
                <span class="text-xs font-bold text-white bg-blue-600 px-2 py-0.5 rounded">GET</span>
                <code class="inline">/api/mcp/cuentas</code>
            </div>
            <p class="text-sm text-gray-600">Requiere <code class="inline">read:own</code>. Devuelve todas las cuentas del usuario, con su saldo actual.</p>
        </div>

        <div class="bg-white border border-gray-200 rounded-2xl p-5 space-y-2">
            <div class="flex items-center gap-2">
                <span class="text-xs font-bold text-white bg-blue-600 px-2 py-0.5 rounded">GET</span>
                <code class="inline">/api/mcp/categorias</code>
            </div>
            <p class="text-sm text-gray-600">Requiere <code class="inline">read:own</code>. Devuelve todas las categorías del usuario.</p>
        </div>

        <div class="bg-white border border-gray-200 rounded-2xl p-5 space-y-2">
            <div class="flex items-center gap-2">
                <span class="text-xs font-bold text-white bg-blue-600 px-2 py-0.5 rounded">GET</span>
                <code class="inline">/api/mcp/transacciones</code>
            </div>
            <p class="text-sm text-gray-600">Requiere <code class="inline">read:own</code>. Lista las transacciones del usuario, más recientes primero.</p>
            <p class="text-sm text-gray-600 font-medium mt-2">Parámetros de query (todos opcionales):</p>
            <ul class="list-disc pl-6 text-sm text-gray-600 space-y-1">
                <li><code class="inline">cuenta_id</code> — filtra por cuenta</li>
                <li><code class="inline">categoria_id</code> — filtra por categoría</li>
                <li><code class="inline">desde</code> / <code class="inline">hasta</code> — rango de fechas (YYYY-MM-DD)</li>
                <li><code class="inline">limite</code> — máximo de resultados (por defecto 100, tope 500)</li>
            </ul>
        </div>

        <div class="bg-white border border-gray-200 rounded-2xl p-5 space-y-2">
            <div class="flex items-center gap-2">
                <span class="text-xs font-bold text-white bg-green-600 px-2 py-0.5 rounded">POST</span>
                <code class="inline">/api/mcp/transacciones</code>
            </div>
            <p class="text-sm text-gray-600">Requiere <code class="inline">write:own</code>. Crea una transacción y actualiza el saldo de la cuenta.</p>
            <p class="text-sm text-gray-600 font-medium mt-2">Body JSON:</p>
            <pre class="bg-gray-900 text-gray-100 text-xs sm:text-sm rounded-xl p-4 overflow-x-auto"><code>{
  "cuenta_id": 7,
  "categoria_id": 2,
  "tipo": "ingreso",
  "monto": 250.00,
  "descripcion": "Depósito",
  "fecha": "2026-08-16"
}</code></pre>
            <p class="text-sm text-gray-600">
                <code class="inline">tipo</code> debe ser uno de: <code class="inline">ingreso</code>, <code class="inline">egreso</code>, <code class="inline">inversion</code>, <code class="inline">costo</code>.
                <code class="inline">fecha</code> es opcional (por defecto hoy). <code class="inline">cuenta_id</code> y <code class="inline">categoria_id</code> deben pertenecer al usuario dueño del token.
            </p>
        </div>
    </section>

    <section class="space-y-4">
        <h2 class="text-xl font-semibold">Códigos de respuesta comunes</h2>
        <table class="api-table w-full text-sm bg-white rounded-xl overflow-hidden border border-gray-200">
            <thead>
                <tr><th>Código</th><th>Significado</th></tr>
            </thead>
            <tbody>
                <tr><td><code class="inline">200 / 201</code></td><td>Solicitud exitosa (201 al crear una transacción).</td></tr>
                <tr><td><code class="inline">401</code></td><td>Token ausente, inválido, vencido o revocado.</td></tr>
                <tr><td><code class="inline">403</code></td><td>El token no tiene la ability requerida (ej. token de solo lectura intentando escribir).</td></tr>
                <tr><td><code class="inline">404</code></td><td>La cuenta o categoría indicada no existe o no pertenece al usuario del token.</td></tr>
                <tr><td><code class="inline">422</code></td><td>Datos inválidos (ej. <code class="inline">tipo</code> no reconocido, saldo insuficiente).</td></tr>
            </tbody>
        </table>
    </section>

    <section class="space-y-4">
        <h2 class="text-xl font-semibold">Ejemplo completo</h2>
        <pre class="bg-gray-900 text-gray-100 text-xs sm:text-sm rounded-xl p-4 overflow-x-auto"><code>curl -X POST https://tu-dominio.com/api/mcp/transacciones \
  -H "Authorization: Bearer TU_TOKEN_AQUI" \
  -H "Accept: application/json" \
  -H "Content-Type: application/json" \
  -d '{
    "cuenta_id": 7,
    "categoria_id": 2,
    "tipo": "egreso",
    "monto": 80.50,
    "descripcion": "Compra de prueba"
  }'</code></pre>
    </section>

    <div class="bg-white border border-gray-200 rounded-2xl p-6 text-sm text-gray-600">
        ¿Primera vez integrando esto? Empieza por la
        <a href="{{ route('blog.conectar-ia-mcp') }}" class="text-red-600 font-medium hover:underline">guía paso a paso</a>
        para crear tu token.
    </div>

</main>

<footer class="border-t border-gray-300 py-8 text-center text-xs text-gray-400">
    &copy; {{ date('Y') }} Avaspace. Todos los derechos reservados.
</footer>

</body>
</html>
