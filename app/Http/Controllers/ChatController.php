<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Models\ChatMessage;
use App\Jobs\ProcessChatMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $chats = Auth::user()->chats()->latest()->get();
        return view('chat.index', compact('chats'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('chat.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'model' => 'nullable|string|in:gpt-4,gpt-4-turbo,gpt-4o,gpt-4o-mini,gpt-3.5-turbo',
        ]);

        $chat = Auth::user()->chats()->create([
            'title' => $validated['title'],
            'model' => $validated['model'] ?? 'gpt-4o-mini',
        ]);

        return redirect()->route('chat.show', $chat->id)
            ->with('success', 'Chat creado exitosamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(Chat $chat)
    {
        // Verificar que el usuario sea propietario del chat
        if ($chat->user_id !== Auth::id()) {
            abort(403, 'No autorizado para ver este chat');
        }

        // Usar nueva vista con API y JavaScript
        return view('chat.show-api', compact('chat'));
    }

    /**
     * Store a new message in the chat.
     */
    public function storeMessage(Request $request, Chat $chat)
    {
        // Verificar que el usuario sea propietario del chat
        if ($chat->user_id !== Auth::id()) {
            abort(403, 'No autorizado para acceder a este chat');
        }

        $validated = $request->validate([
            'content' => 'required|string|min:1|max:10000',
        ]);

        // Crear mensaje del usuario
        $userMessage = $chat->messages()->create([
            'role' => 'user',
            'content' => $validated['content'],
            'status' => 'pending',
        ]);

        // Despachar job para procesar el mensaje con OpenAI
        ProcessChatMessage::dispatch($userMessage);

        // Siempre devolver JSON
        return response()->json([
            'success' => true,
            'message' => 'Mensaje enviado. Procesando respuesta...',
            'user_message_id' => $userMessage->id,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Chat $chat)
    {
        // Verificar que el usuario sea propietario del chat
        if ($chat->user_id !== Auth::id()) {
            abort(403, 'No autorizado para eliminar este chat');
        }

        $chat->delete();

        return redirect()->route('chat.index')
            ->with('success', 'Chat eliminado exitosamente');
    }
}
