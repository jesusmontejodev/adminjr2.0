<?php

require 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\User;
use Illuminate\Support\Facades\Route;

echo "Testing API Endpoints\n";
echo "====================\n\n";

// Get first user
$user = User::first();
if (!$user) {
    echo "No usuario found!\n";
    exit(1);
}

echo "Testing with user: {$user->name} (ID: {$user->id})\n\n";

// Create a fake request with the user authenticated
$request = \Illuminate\Http\Request::create('/api/chat', 'GET');
$request->setUserResolver(fn() => $user);

// Test ChatController::index directly
echo "1. Testing API Controller method directly...\n";
try {
    $controller = new \App\Http\Controllers\Api\ChatController();
    $response = $controller->index($request);
    $data = json_decode($response->getContent(), true);
    
    echo "   ✓ Success\n";
    echo "   Status: " . $response->getStatusCode() . "\n";
    echo "   Response: " . json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) . "\n";
} catch (\Throwable $e) {
    echo "   ✗ Error: " . $e->getMessage() . "\n";
    echo "   File: " . $e->getFile() . ":" . $e->getLine() . "\n";
}

echo "\n2. Testing ChatAPI::show method...\n";
try {
    $chat = $user->chats()->first();
    if (!$chat) {
        echo "   No chats found for user\n";
    } else {
        $controller = new \App\Http\Controllers\Api\ChatController();
        $response = $controller->show($request, $chat);
        $data = json_decode($response->getContent(), true);
        
        echo "   ✓ Success\n";
        echo "   Status: " . $response->getStatusCode() . "\n";
        echo "   Chat ID: {$data['data']['id']}\n";
        echo "   Messages: " . count($data['data']['messages']) . "\n";
    }
} catch (\Throwable $e) {
    echo "   ✗ Error: " . $e->getMessage() . "\n";
}

echo "\n✓ API Tests Complete\n";
