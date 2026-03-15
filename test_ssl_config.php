<?php

require 'vendor/autoload.php';

// Test SSL certificate configuration options
echo "Testing OpenAI client with SSL certificate options...\n\n";

// Check if we can pass cURL options to the factory
$certPath = __DIR__ . '/storage/certs/cacert.pem';
echo "Certificate path: $certPath\n";
echo "Certificate exists: " . (file_exists($certPath) ? "YES" : "NO") . "\n\n";

try {
    // Try different approaches to configure SSL
    
    // Approach 1: Using PSR-18 HTTP client factory
    if (class_exists('OpenAI\ClientFactory')) {
        echo "Method 1: OpenAI\ClientFactory\n";
        // Check if we can use PSR HTTP client
        $factory = new \OpenAI\Factory();
        echo "  Available\n";
    }
    
    // Approach 2: Check if we can configure via environment or dependency injection
    if (class_exists('GuzzleHttp\Client')) {
        echo "Method 2: Using Guzzle HTTP client\n";
        // GuzzleHttp should support 'verify' option for SSL
        echo "  Available - can use 'verify' => \$certPath\n";
    }
    
    // Approach 3: Check if we can modify PHP curl settings globally
    echo "\nMethod 3 (Global PHP config):\n";
    echo "  Current curl.cainfo: " . ini_get('curl.cainfo') . "\n";
    
    // Try to set it temporarily for this script
    ini_set('curl.cainfo', $certPath);
    echo "  Set curl.cainfo to: " . ini_get('curl.cainfo') . "\n";
    
    // Now try to create a client with this configuration
    $factory = new \OpenAI\Factory();
    $client = $factory->make(env('OPENAI_API_KEY'));
    echo "\n✓ Client created successfully with SSL certificate configured!\n";
    echo "  Client class: " . get_class($client) . "\n";
    
} catch (\Throwable $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
