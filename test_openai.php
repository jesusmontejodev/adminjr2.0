<?php

require 'vendor/autoload.php';

// Verificar qué exista
echo "Verificando el SDK OpenAI...\n";

// Buscar la factoría
if (class_exists('OpenAI\Factory')) {
    echo "OpenAI\Factory existe: SÍ\n";
    try {
        $factory = new \OpenAI\Factory();
        $client = $factory->make(env('OPENAI_API_KEY'));
        echo "Cliente creado con Factory: " . get_class($client) . "\n";
    } catch (\Throwable $e) {
        echo "Error con Factory: " . $e->getMessage() . "\n";
    }
}

// Buscar funciones helper
echo "\nBuscando helpers globales...\n";
if (function_exists('OpenAI')) {
    echo "Función OpenAI() existe\n";
    try {
        $client = OpenAI(env('OPENAI_API_KEY'));
        echo "Cliente creado con helper: " . get_class($client) . "\n";
    } catch (\Throwable $e) {
        echo "Error con helper: " . $e->getMessage() . "\n";
    }
}

// Mirar qué está disponible
$functions = get_defined_functions();
$openai_functions = array_filter($functions['user'], fn($f) => stripos($f, 'openai') !== false || stripos($f, 'chat') !== false);
if (!empty($openai_functions)) {                            
    echo "\nFunciones disponibles relacionadas con OpenAI:\n";
    foreach ($openai_functions as $f) {
        echo "  - $f\n";
    }
}
