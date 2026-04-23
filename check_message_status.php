<?php

require 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\ChatMessage;

try {
    echo "Checking latest message status...\n\n";
    
    // Get the latest message we created
    $message = ChatMessage::latest()->first();
    
    if (!$message) {
        echo "No messages found\n";
        exit(1);
    }
    
    echo "Message ID: {$message->id}\n";
    echo "Chat ID: {$message->chat_id}\n";
    echo "Role: {$message->role}\n";
    echo "Content: " . substr($message->content, 0, 50) . "...\n";
    echo "Status: {$message->status}\n";
    echo "Tokens Used: " . ($message->tokens_used ?? 'N/A') . "\n";
    echo "Created: {$message->created_at}\n";
    
    // Check if there's a response from AI
    $response = ChatMessage::where('chat_id', $message->chat_id)
        ->where('role', 'assistant')
        ->latest()
        ->first();
    
    if ($response) {
        echo "\n✓ AI Response found!\n";
        echo "Response ID: {$response->id}\n";
        echo "Response Status: {$response->status}\n";
        echo "Response Content: " . substr($response->content, 0, 200) . "...\n";
        echo "Response Tokens: {$response->tokens_used}\n";
    } else {
        echo "\n✗ No AI response found\n";
    }
    
} catch (\Throwable $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
