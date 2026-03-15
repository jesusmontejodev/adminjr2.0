<?php

require 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$messageId = 23;
$message = \App\Models\ChatMessage::find($messageId);

if (!$message) {
    echo "Message #23 not found\n";
    exit(1);
}

$chat = $message->chat;

echo "Message #23 Status: {$message->status}\n";
echo "Chat responses:\n";

$responses = $chat->messages()->where('role', 'assistant')->orderBy('id', 'desc')->get();
foreach ($responses as $resp) {
    echo "  - ID {$resp->id}: Status={$resp->status}, Content=" . substr($resp->content, 0, 100) . "\n";
}
