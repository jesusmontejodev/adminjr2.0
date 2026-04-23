<?php

use App\Models\User;
use App\Models\Chat;
use App\Models\ChatMessage;
use App\Jobs\ProcessChatMessage;

require 'bootstrap/app.php';

$app = require_once 'bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

try {
    // Find or create a test user
    $user = User::first() ?? User::factory()->create();
    
    // Create a new chat or get first
    $chat = $user->chats()->first();
    if (!$chat) {
        $chat = $user->chats()->create([
            'title' => 'Test Chat',
            'model' => 'gpt-4o-mini',
        ]);
        
        // Generate financial context
        $context = $chat->generateFinancialContext();
        $chat->update(['system_prompt' => $context]);
    }
    
    echo "✓ User ID: {$user->id}\n";
    echo "✓ Chat ID: {$chat->id}\n";
    
    // Create a test message
    $message = $chat->messages()->create([
        'role' => 'user',
        'content' => '¿Cuál es mi saldo actual? Analiza mis transacciones.',
        'status' => 'pending'
    ]);
    
    echo "✓ Message ID: {$message->id}\n";
    echo "✓ Message Content: {$message->content}\n";
    echo "✓ Message Status: {$message->status}\n";
    
    // Dispatch the job
    ProcessChatMessage::dispatch($message);
    echo "✓ Job dispatched successfully!\n";
    echo "\nWaiting for job to process...\n";
    sleep(3);
    
    // Check if job was processed
    $message->refresh();
    echo "\nMessage Status After Processing: {$message->status}\n";
    
    // If completed, show response
    if ($message->status === 'completed') {
        $response = $chat->messages()
            ->where('role', 'assistant')
            ->latest()
            ->first();
        
        if ($response) {
            echo "\n✓ AI Response received!\n";
            echo "Response: " . substr($response->content, 0, 200) . "...\n";
            echo "Tokens used: {$response->tokens_used}\n";
        }
    } elseif ($message->status === 'failed') {
        echo "\n✗ Job failed!\n";
    } else {
        echo "\nJob still processing or pending...\n";
    }
    
} catch (\Throwable $e) {
    echo "Error: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . ":{$e->getLine()}\n";
}
