<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Chat;
use Illuminate\Http\Request;
use App\Jobs\ProcessChatMessage;

class ChatController extends Controller
{
    /**
     * Obtener todos los chats del usuario
     */
    public function index(Request $request)
    {
        $chats = $request->user()
            ->chats()
            ->withCount('messages')
            ->latest()
            ->get()
            ->map(function ($chat) {
                return [
                    'id' => $chat->id,
                    'title' => $chat->title,
                    'model' => $chat->model,
                    'messages_count' => $chat->messages_count,
                    'created_at' => $chat->created_at,
                ];
            });

        return response()->json([
            'success' => true,
            'data' => $chats,
        ]);
    }

    /**
     * Crear nuevo chat
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'model' => 'required|in:gpt-4o-mini,gpt-4o,gpt-4-turbo,gpt-4,gpt-3.5-turbo',
        ]);

        $chat = $request->user()->chats()->create([
            'title' => $validated['title'],
            'model' => $validated['model'],
            'system_prompt' => '',
        ]);

        return response()->json([
            'success' => true,
            'data' => [
                'id' => $chat->id,
                'title' => $chat->title,
                'model' => $chat->model,
            ],
        ], 201);
    }

    /**
     * Obtener chat con sus mensajes
     */
    public function show(Request $request, Chat $chat)
    {
        // Verificar que The chat pertenece al usuario
        if ($chat->user_id !== $request->user()->id) {
            return response()->json([
                'success' => false,
                'message' => 'No puedes acceder a este chat',
            ], 403);
        }

        // Generar contexto financiero si no existe
        if (!$chat->system_prompt) {
            $chat->update(['system_prompt' => $chat->generateFinancialContext()]);
        }

        $messages = $chat->messages()
            ->orderBy('created_at')
            ->get()
            ->map(fn($msg) => [
                'id' => $msg->id,
                'role' => $msg->role,
                'content' => $msg->content,
                'status' => $msg->status,
                'tokens_used' => $msg->tokens_used,
                'created_at' => $msg->created_at,
            ]);

        return response()->json([
            'success' => true,
            'data' => [
                'id' => $chat->id,
                'title' => $chat->title,
                'model' => $chat->model,
                'messages' => $messages,
            ],
        ]);
    }

    /**
     * Enviar mensaje al chat
     */
    public function sendMessage(Request $request, Chat $chat)
    {
        // Verificar que el chat pertenece al usuario
        if ($chat->user_id !== $request->user()->id) {
            return response()->json([
                'success' => false,
                'message' => 'No puedes acceder a este chat',
            ], 403);
        }

        $validated = $request->validate([
            'content' => 'required|string|max:5000',
        ]);

        // Generar contexto financiero si no existe
        if (!$chat->system_prompt) {
            $chat->update(['system_prompt' => $chat->generateFinancialContext()]);
        }

        // Crear mensaje del usuario
        $userMessage = $chat->messages()->create([
            'role' => 'user',
            'content' => $validated['content'],
            'status' => 'pending',
        ]);

        $result = (new ProcessChatMessage($userMessage))->process();

        return response()->json([
            'success' => true,
            'data' => [
                'processed' => $result['processed'],
                'user_message' => $result['user_message'],
                'assistant_message' => $result['assistant_message'],
            ],
        ], 201);
    }

    /**
     * Obtener mensajes más recientes del chat (para polling)
     */
    public function getMessages(Request $request, Chat $chat)
    {
        // Verificar que el chat pertenece al usuario
        if ($chat->user_id !== $request->user()->id) {
            return response()->json([
                'success' => false,
                'message' => 'No puedes acceder a este chat',
            ], 403);
        }

        $since = $request->query('since'); // timestamp del último mensaje conocido

        $query = $chat->messages()->orderBy('created_at');

        if ($since) {
            $query->where('created_at', '>', $since);
        }

        $messages = $query->get()
            ->map(fn($msg) => [
                'id' => $msg->id,
                'role' => $msg->role,
                'content' => $msg->content,
                'status' => $msg->status,
                'tokens_used' => $msg->tokens_used,
                'created_at' => $msg->created_at,
            ]);

        return response()->json([
            'success' => true,
            'data' => $messages,
        ]);
    }

    /**
     * Eliminar chat
     */
    public function destroy(Request $request, Chat $chat)
    {
        // Verificar que el chat pertenece al usuario
        if ($chat->user_id !== $request->user()->id) {
            return response()->json([
                'success' => false,
                'message' => 'No puedes eliminar este chat',
            ], 403);
        }

        $chat->delete();

        return response()->json([
            'success' => true,
            'message' => 'Chat eliminado correctamente',
        ]);
    }
}
