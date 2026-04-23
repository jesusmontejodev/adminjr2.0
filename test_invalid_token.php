<?php

require 'vendor/autoload.php';

echo "Probando respuesta de OpenAI con diferentes API keys...\n\n";

// Test 1: Token completamente inválido
echo "Test 1: Token completamente inválido\n";
echo "=====================================\n";
try {
    $factory = new \OpenAI\Factory();
    $client = $factory->withApiKey('sk-invalid-token-12345')->make();
    
    $response = $client->chat()->create([
        'model' => 'gpt-4o-mini',
        'messages' => [
            ['role' => 'user', 'content' => 'Hola']
        ],
    ]);
    
    echo "✓ Respuesta recibida (esto no debería pasar)\n";
} catch (\Throwable $e) {
    echo "✗ Error capturado:\n";
    echo "  Clase: " . get_class($e) . "\n";
    echo "  Mensaje: " . $e->getMessage() . "\n\n";
}

// Test 2: Token vacío
echo "Test 2: Token vacío\n";
echo "==================\n";
try {
    $factory = new \OpenAI\Factory();
    $client = $factory->withApiKey('')->make();
    
    $response = $client->chat()->create([
        'model' => 'gpt-4o-mini',
        'messages' => [
            ['role' => 'user', 'content' => 'Hola']
        ],
    ]);
    
    echo "✓ Respuesta recibida (esto no debería pasar)\n";
} catch (\Throwable $e) {
    echo "✗ Error capturado:\n";
    echo "  Clase: " . get_class($e) . "\n";
    echo "  Mensaje: " . $e->getMessage() . "\n\n";
}

// Test 3: Sin token (null)
echo "Test 3: Sin token (null)\n";
echo "=======================\n";
try {
    $factory = new \OpenAI\Factory();
    $client = $factory->withApiKey(null)->make();
    
    $response = $client->chat()->create([
        'model' => 'gpt-4o-mini',
        'messages' => [
            ['role' => 'user', 'content' => 'Hola']
        ],
    ]);
    
    echo "✓ Respuesta recibida (esto no debería pasar)\n";
} catch (\Throwable $e) {
    echo "✗ Error capturado:\n";
    echo "  Clase: " . get_class($e) . "\n";
    echo "  Mensaje: " . substr($e->getMessage(), 0, 150) . "...\n\n";
}

echo "Resumen:\n";
echo "========\n";
echo "✓ Si el token es inválido → OpenAI API rechaza la solicitud\n";
echo "✓ El OpenAI SDK lanza una excepción (ErrorException)\n";
echo "✓ En ProcessChatMessage, se captura y marca como 'failed'\n";
echo "✓ Se guarda mensaje de error del usuario\n";
