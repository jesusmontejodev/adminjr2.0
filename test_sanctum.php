<?php

require 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Support\Facades\Route;

echo "Checking routes...\n\n";

// Get all routes
$routes = Route::getRoutes();
$apiRoutes = [];

foreach ($routes as $route) {
    if (strpos($route->uri, 'api') !== false || strpos($route->uri, 'chat') !== false) {
        $apiRoutes[] = [
            'method' => implode('|', $route->methods),
            'path' => $route->uri,
            'action' => $route->getActionName(),
        ];
    }
}

echo "Found " . count($apiRoutes) . " API routes\n";
foreach ($apiRoutes as $route) {
    printf("[%-6s] %s\n", $route['method'], $route['path']);
}

// Check Sanctum
echo "\n\nChecking Sanctum...\n";
echo "Sanctum installed: " . (class_exists('Laravel\Sanctum\Sanctum') ? "YES" : "NO") . "\n";

// Check Auth
echo "\nChecking Auth Guard...\n";
echo "Available guards: " . implode(', ', array_keys(config('auth.guards'))) . "\n";

// Check if user has tokens table
echo "\nChecking personal_access_tokens table...\n";
try {
    $count = \Illuminate\Support\Facades\DB::table('personal_access_tokens')->count();
    echo "personal_access_tokens exists with $count records\n";
} catch (\Exception $e) {
    echo "Table doesn't exist or error: " . $e->getMessage() . "\n";
}

echo "\n✓ Diagnostics complete\n";
