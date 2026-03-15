<?php

require 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

// Use Laravel's DB facade
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Chat;
use App\Jobs\ProcessChatMessage;

try {
    echo "Testing OpenAI Chat Integration\n";
    echo "================================\n\n";
    
    // Get first user or create one
    $user = User::first();
    if (!$user) {
        echo "Error: No users found in database\n";
        exit(1);
    }
    
    echo "✓ Found User: {$user->name} (ID: {$user->id})\n";
    
    // Check or create chat
    $chat = $user->chats()->first();
    if (!$chat) {
        echo "Creating new chat...\n";
        $chat = $user->chats()->create([
            'title' => 'Financial Advisor Chat',
            'model' => 'gpt-4o-mini',
        ]);
        
        // Generate financial context
        $context = $chat->generateFinancialContext();
        $chat->update(['system_prompt' => substr($context, 0, 5000)]); // Limit to 5000 chars
    }
    
    echo "✓ Using Chat: {$chat->title} (ID: {$chat->id})\n";
    echo "  Model: {$chat->model}\n";
    echo "  System Prompt Length: " . strlen($chat->system_prompt ?? '') . " chars\n";
    
    // Create user message
    $message = $chat->messages()->create([
        'role' => 'user',
        'content' => '¿Cuál es mi saldo total y cuál fue mi gasto mayor este mes?',
        'status' => 'pending'
    ]);
    
    echo "\n✓ Created Message (ID: {$message->id})\n";
    echo "  Content: " . substr($message->content, 0, 50) . "...\n";
    echo "  Status: {$message->status}\n";
    
    // Dispatch job
    echo "\nDispatching ProcessChatMessage job...\n";
    ProcessChatMessage::dispatch($message);
    echo "✓ Job dispatched!\n";
    
    echo "\nWaiting for job to process (max 10 seconds)...\n";
    
    // Check every 2 seconds if job completed
    for ($i = 0; $i < 5; $i++) {
        sleep(2);
        $message->refresh();
        echo "  Status: {$message->status}\n";
        
        if ($message->status !== 'pending') {
            break;
        }
    }
    
    echo "\n" . str_repeat("=", 50) . "\n";
    echo "FINAL RESULT\n";
    echo str_repeat("=", 50) . "\n";
    
    if ($message->status === 'completed') {
        echo "✓ SUCCESS! Message was processed by OpenAI\n";
        echo "  Final Status: {$message->status}\n";
        echo "  Tokens Used: {$message->tokens_used}\n";
        
        // Get AI response
        $response = $chat->messages()
            ->where('role', 'assistant')
            ->latest()
            ->first();
        
        if ($response) {
            echo "\n✓ AI Response:\n";
            echo "  " . substr($response->content, 0, 200) . "...\n";
            echo "  Response Tokens: {$response->tokens_used}\n";
        }
    } elseif ($message->status === 'failed') {
        echo "✗ FAILED! Job encountered an error\n";
        echo "  Check storage/logs/laravel.log for details\n";
    } else {
        echo "⏳ Job still processing or pending\n";
        echo "  Current Status: {$message->status}\n";
    }
    
} catch (\Throwable $e) {
    echo "Error: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . ":{$e->getLine()}\n";
    exit(1);
}
