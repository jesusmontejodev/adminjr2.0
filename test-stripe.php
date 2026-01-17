<?php

require __DIR__ . '/vendor/autoload.php';

// Cargar variables de entorno
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

echo "=== VERIFICACIÓN DE CONFIGURACIÓN STRIPE ===\n\n";

// 1. Verificar claves en .env
$stripeKey = $_ENV['STRIPE_KEY'] ?? $_SERVER['STRIPE_KEY'] ?? 'NO ENCONTRADA';
$stripeSecret = $_ENV['STRIPE_SECRET'] ?? $_SERVER['STRIPE_SECRET'] ?? 'NO ENCONTRADA';

echo "1. STRIPE_KEY encontrada: " . substr($stripeKey, 0, 30) . "...\n";
echo "   Longitud: " . strlen($stripeKey) . " caracteres\n";
echo "   ¿Empieza con pk_? " . (strpos($stripeKey, 'pk_') === 0 ? '✅ SÍ' : '❌ NO') . "\n\n";

echo "2. STRIPE_SECRET encontrada: " . substr($stripeSecret, 0, 30) . "...\n";
echo "   Longitud: " . strlen($stripeSecret) . " caracteres\n";
echo "   ¿Empieza con sk_? " . (strpos($stripeSecret, 'sk_') === 0 ? '✅ SÍ' : '❌ NO') . "\n\n";

// 2. Probar conexión con Stripe
try {
    \Stripe\Stripe::setApiKey($stripeSecret);

    echo "3. Probando conexión con Stripe...\n";

    // Crear un customer de prueba
    $customer = \Stripe\Customer::create([
        'email' => 'test_' . time() . '@example.com',
        'description' => 'Cliente de prueba'
    ]);

    echo "   ✅ Conexión EXITOSA!\n";
    echo "   Customer ID: " . $customer->id . "\n";
    echo "   Email: " . $customer->email . "\n\n";

    // Limpiar: eliminar customer de prueba
    $customer->delete();
    echo "   Customer de prueba eliminado.\n";

} catch (\Stripe\Exception\AuthenticationException $e) {
    echo "   ❌ ERROR DE AUTENTICACIÓN: " . $e->getMessage() . "\n";
    echo "   Posible causa: Clave inválida o modo test desactivado.\n\n";
} catch (\Stripe\Exception\ApiErrorException $e) {
    echo "   ❌ ERROR DE API: " . $e->getMessage() . "\n\n";
} catch (\Exception $e) {
    echo "   ❌ ERROR GENERAL: " . $e->getMessage() . "\n\n";
}

// 3. Verificar configuración Laravel
echo "4. Verificando configuración Laravel...\n";
echo "   APP_ENV: " . ($_ENV['APP_ENV'] ?? 'no definido') . "\n";
echo "   APP_DEBUG: " . ($_ENV['APP_DEBUG'] ?? 'no definido') . "\n";
echo "   APP_URL: " . ($_ENV['APP_URL'] ?? 'no definido') . "\n\n";

// 4. Mostrar contenido real del .env (censurado)
echo "5. Contenido de .env (censurado):\n";
$envFile = __DIR__ . '/.env';
if (file_exists($envFile)) {
    $lines = file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (strpos($line, 'STRIPE') !== false || strpos($line, 'APP_') === 0) {
            // Censurar parte de las claves
            if (strpos($line, 'STRIPE_KEY=') === 0) {
                $value = substr($line, 11);
                echo "   STRIPE_KEY=" . substr($value, 0, 20) . "..." . substr($value, -10) . "\n";
            } elseif (strpos($line, 'STRIPE_SECRET=') === 0) {
                $value = substr($line, 14);
                echo "   STRIPE_SECRET=" . substr($value, 0, 20) . "..." . substr($value, -10) . "\n";
            } else {
                echo "   " . $line . "\n";
            }
        }
    }
}

echo "\n=== FIN DE VERIFICACIÓN ===\n";
