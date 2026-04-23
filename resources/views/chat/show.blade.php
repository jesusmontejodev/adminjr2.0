@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 to-slate-100">
    <div class="flex h-screen">
        <!-- Sidebar -->
        <div class="hidden md:flex md:w-64 bg-white shadow-lg border-r border-slate-200 flex-col">
            <div class="p-6 border-b border-slate-200">
                <div class="flex items-center justify-between">
                    <h2 class="text-lg font-bold text-slate-900">{{ $chat->title }}</h2>
                    <a href="{{ route('chat.index') }}" class="text-slate-500 hover:text-slate-700" title="Volver a chats">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </a>
                </div>
                <p class="text-xs text-slate-500 mt-2">Modelo: {{ ucfirst(str_replace('-', ' ', $chat->model)) }}</p>
            </div>
            <div class="flex-1 overflow-y-auto p-4">
                <div class="space-y-2">
                    <a href="{{ route('chat.show', $chat->id) }}" class="block w-full text-left px-4 py-2 bg-blue-100 text-blue-700 rounded-lg font-medium">
                        Chat Actual
                    </a>
                </div>
            </div>
            <div class="p-4 border-t border-slate-200">
                <a href="{{ route('chat.create') }}" class="w-full inline-flex items-center justify-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors text-sm font-medium">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Nuevo Chat
                </a>
            </div>
        </div>

        <!-- Main Chat Area -->
        <div class="flex-1 flex flex-col">
            <!-- Header -->
            <div class="bg-white border-b border-slate-200 px-6 py-4 shadow-sm">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-2xl font-bold text-slate-900">{{ $chat->title }}</h1>
                        <p class="text-sm text-slate-600">{{ $messages->count() }} mensajes</p>
                    </div>
                    <div class="flex gap-2">
                        <a href="{{ route('chat.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                            </svg>
                            Nuevo Chat
                        </a>
                        <a href="{{ route('chat.index') }}" class="inline-flex items-center px-4 py-2 bg-slate-200 text-slate-700 rounded-lg hover:bg-slate-300 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Messages Container -->
            <div class="flex-1 overflow-y-auto p-6 space-y-4" id="messages-container">
                @if($messages->isEmpty())
                    <div class="h-full flex items-center justify-center">
                        <div class="text-center">
                            <svg class="w-16 h-16 mx-auto text-slate-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                            </svg>
                            <h3 class="text-lg font-semibold text-slate-900 mb-2">Comienza la conversación</h3>
                            <p class="text-slate-600">Pregunta sobre tus finanzas y recibe análisis personalizados</p>
                        </div>
                    </div>
                @else
                    @foreach($messages as $message)
                        <div class="flex {{ $message->role === 'user' ? 'justify-end' : 'justify-start' }}" id="message-{{ $message->id }}">
                            <div class="flex gap-3 {{ $message->role === 'user' ? 'flex-row-reverse' : '' }} max-w-xl">
                                <!-- Avatar -->
                                <div class="flex-shrink-0">
                                    @if($message->role === 'user')
                                        <div class="w-8 h-8 rounded-full bg-blue-600 flex items-center justify-center text-white font-semibold">
                                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                        </div>
                                    @else
                                        <div class="w-8 h-8 rounded-full bg-gradient-to-br from-purple-500 to-pink-500 flex items-center justify-center text-white">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                                            </svg>
                                        </div>
                                    @endif
                                </div>

                                <!-- Message -->
                                <div>
                                    <div class="px-4 py-2 rounded-lg {{ $message->role === 'user' ? 'bg-blue-600 text-white' : 'bg-slate-200 text-slate-900' }}">
                                        <p class="text-sm">{{ nl2br(e($message->content)) }}</p>
                                    </div>
                                    <div class="text-xs text-slate-500 mt-1 {{ $message->role === 'user' ? 'text-right' : '' }}">
                                        @if($message->status === 'pending')
                                            <span class="inline-flex items-center">
                                                <svg class="animate-spin h-3 w-3 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8z"/>
                                                </svg>
                                                Procesando...
                                            </span>
                                        @elseif($message->status === 'processing')
                                            <span class="inline-flex items-center">
                                                <svg class="animate-spin h-3 w-3 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8z"/>
                                                </svg>
                                                Generando respuesta...
                                            </span>
                                        @elseif($message->status === 'completed')
                                            {{ $message->created_at->format('H:i') }}
                                            @if($message->tokens_used)
                                                • Tokens: {{ $message->tokens_used }}
                                            @endif
                                        @elseif($message->status === 'failed')
                                            <span class="text-red-600">Error al procesar</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>

            <!-- Input Area -->
            <div class="bg-white border-t border-slate-200 p-6 shadow-lg">
                <form id="message-form" class="flex gap-3">
                    @csrf
                    <div class="flex-1 relative">
                        <input 
                            type="text"
                            id="message-input"
                            name="content"
                            placeholder="Escribe tu pregunta sobre tus finanzas..."
                            class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            autocomplete="off"
                            required
                        >
                    </div>
                    <button 
                        type="submit"
                        id="send-button"
                        class="inline-flex items-center px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors font-medium">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                        </svg>
                    </button>
                </form>
                <p class="text-xs text-slate-500 mt-2">
                    💡 Cuéntale sobre tus transacciones, gastos, ingresos o pide análisis de tus datos financieros
                </p>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('message-form');
    const input = document.getElementById('message-input');
    const sendButton = document.getElementById('send-button');
    const messagesContainer = document.getElementById('messages-container');

    // Auto-scroll al final (solo si está vacío)
    if (messagesContainer) {
        messagesContainer.scrollTop = messagesContainer.scrollHeight;
    }

    form.addEventListener('submit', async function(e) {
        e.preventDefault();

        const content = input.value.trim();
        if (!content) return;

        // Deshabilitar botón
        sendButton.disabled = true;
        sendButton.style.opacity = '0.5';

        try {
            const response = await fetch('{{ route("chat.store-message", $chat->id) }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                    'Accept': 'application/json',
                },
                body: JSON.stringify({ content }),
            });

            if (response.ok) {
                const data = await response.json();
                input.value = '';
                
                // Mostrar el mensaje del usuario inmediatamente
                location.reload();
                
                // Script para polling del estado
                setTimeout(() => {
                    checkForNewMessages();
                }, 1000);
            } else {
                const errorData = await response.json().catch(() => ({ message: 'Error desconocido' }));
                alert('Error al enviar el mensaje: ' + (errorData.message || errorData.error || 'Error desconocido'));
            }
        } catch (error) {
            console.error('Error:', error);
            alert('Error al enviar el mensaje: ' + error.message);
        } finally {
            sendButton.disabled = false;
            sendButton.style.opacity = '1';
        }
    });

    // Polling para verificar nuevos mensajes
    function checkForNewMessages() {
        setInterval(() => {
            fetch(window.location.href)
                .then(r => r.text())
                .then(html => {
                    const newDoc = new DOMParser().parseFromString(html, 'text/html');
                    const newMessages = newDoc.getElementById('messages-container');
                    if (newMessages && newMessages.innerHTML !== messagesContainer.innerHTML) {
                        messagesContainer.innerHTML = newMessages.innerHTML;
                        messagesContainer.scrollTop = messagesContainer.scrollHeight;
                    }
                });
        }, 2000);
    }
});
</script>
@endsection
