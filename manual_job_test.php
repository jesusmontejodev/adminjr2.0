<?php

require 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\User;
use App\Models\Chat;
use App\Models\ChatMessage;
use App\Jobs\ProcessChatMessage;

try {
    echo "Manual Job Execution Test\n";
    echo "=========================\n\n";
    
    // Get user and chat
    $user = User::first();
    $chat = $user->chats()->first();
    
    if (!$user || !$chat) {
        echo "❌ User or Chat not found\n";
        exit(1);
    }
    
    echo "✓ User: {$user->name}\n";
    echo "✓ Chat: {$chat->title}\n\n";
    
    // Create a message
    $message = $chat->messages()->create([
        'role' => 'user',
        'content' => '¿Cuál es mi balance total?',
        'status' => 'pending'
    ]);
    
    echo "✓ Message created (ID: {$message->id})\n";
    echo "✓ Initial Status: {$message->status}\n\n";
    
    echo "Executing job manually...\n";
    
    // Try to execute the job directly
    try {
        (new ProcessChatMessage($message))->handle();
        echo "✓ Job executed successfully!\n";
    } catch (\Throwable $e) {
        echo "✗ Job failed with error:\n";
        echo "  Class: " . get_class($e) . "\n";
        echo "  Message: " . $e->getMessage() . "\n";
        echo "  File: " . $e->getFile() . ":" . $e->getLine() . "\n";
    }
    
    // Check final status
    $message->refresh();
    echo "\n✓ Final Status: {$message->status}\n";
    
    if ($message->status === 'completed') {
        echo "✓ SUCCESS!\n";
        $response = $chat->messages()
            ->where('role', 'assistant')
            ->latest()
            ->first();
        
        if ($response) {
            echo "✓ AI Response received\n";
            echo "  Content: " . substr($response->content, 0, 100) . "...\n";
        }
    }
    
} catch (\Throwable $e) {
    echo "Fatal Error: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . ":" . $e->getLine() . "\n";
}
