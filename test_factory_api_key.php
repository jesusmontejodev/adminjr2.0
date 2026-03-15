<?php

require 'vendor/autoload.php';

echo "Testing OpenAI Factory API key configuration...\n\n";

$apiKey = getenv('OPENAI_API_KEY') ?: $_ENV['OPENAI_API_KEY'] ?? null;
echo "API Key from env: " . ($apiKey ? "YES (length: " . strlen($apiKey) . ")" : "NO") . "\n";

if ($apiKey) {
    echo "API Key starts with: " . substr($apiKey, 0, 10) . "...\n";
}

// Try different ways to create the client
$methods = [
    'Factory with $apiKey as string' => function() use ($apiKey) {
        $factory = new \OpenAI\Factory();
        return $factory->make($apiKey);
    },
    'Factory with array' => function() use ($apiKey) {
        $factory = new \OpenAI\Factory();
        return $factory->make(['api_key' => $apiKey]);
    },
    'Factory -> withApiKey' => function() use ($apiKey) {
        $factory = new \OpenAI\Factory();
        if (method_exists($factory, 'withApiKey')) {
            return $factory->withApiKey($apiKey)->make();
        }
        return null;
    },
];

foreach ($methods as $name => $callable) {
    echo "\nTrying: $name\n";
    try {
        $client = $callable();
        if ($client) {
            $reflection = new ReflectionClass($client);
            $properties = $reflection->getProperties();
            echo "  ✓ Client created: " . get_class($client) . "\n";
            
            // Try to check if it has the key somehow
            foreach ($properties as $prop) {
                $prop->setAccessible(true);
                $name_prop = $prop->getName();
                if (strpos(strtolower($name_prop), 'key') !== false || strpos(strtolower($name_prop), 'token') !== false) {
                    echo "    Found property: $name_prop\n";
                }
            }
        } else {
            echo "  ⚠ Returned null\n";
        }
    } catch (\Throwable $e) {
        echo "  ✗ Error: " . $e->getMessage() . "\n";
    }
}

echo "\n\nChecking Factory class methods...\n";
$factory_methods = get_class_methods(new \OpenAI\Factory());
echo "Factory methods:\n";
foreach ($factory_methods as $method) {
    echo "  - $method\n";
}
