@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 to-slate-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Header -->
        <div class="flex items-center justify-between mb-8">
            <div>
                <h1 class="text-3xl font-bold text-slate-900">Asesor Financiero IA</h1>
                <p class="text-slate-600 mt-2">Chats con análisis de tus datos financieros</p>
            </div>
            <a href="{{ route('chat.create') }}" class="inline-flex items-center px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors shadow-lg">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Nuevo Chat
            </a>
        </div>

        @if($chats->isEmpty())
            <!-- Empty State -->
            <div class="bg-white rounded-lg shadow-lg p-12 text-center">
                <svg class="w-16 h-16 mx-auto text-slate-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                </svg>
                <h3 class="text-xl font-semibold text-slate-900 mb-2">No hay chats aún</h3>
                <p class="text-slate-600 mb-6">Crea tu primer chat para comenzar a analizar tus datos financieros con IA</p>
                <a href="{{ route('chat.create') }}" class="inline-flex items-center px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Crear Nuevo Chat
                </a>
            </div>
        @else
            <!-- Chats Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($chats as $chat)
                    <div class="bg-white rounded-lg shadow-lg hover:shadow-xl transition-shadow overflow-hidden group">
                        <div class="p-6">
                            <div class="flex items-start justify-between mb-4">
                                <div class="flex-1">
                                    <h3 class="text-lg font-semibold text-slate-900 group-hover:text-blue-600 transition-colors">
                                        {{ $chat->title }}
                                    </h3>
                                    <p class="text-sm text-slate-500 mt-1">
                                        Modelo: <span class="font-medium text-slate-700">{{ ucfirst(str_replace('-', ' ', $chat->model)) }}</span>
                                    </p>
                                </div>
                                <div class="bg-blue-100 text-blue-700 text-xs font-semibold px-3 py-1 rounded-full">
                                    {{ $chat->messages->count() }} mensajes
                                </div>
                            </div>

                            <div class="mb-4">
                                <p class="text-sm text-slate-600">
                                    <span class="font-medium">Creado:</span> {{ $chat->created_at->diffForHumans() }}
                                </p>
                                <p class="text-sm text-slate-600 mt-1">
                                    <span class="font-medium">Actualizado:</span> {{ $chat->updated_at->diffForHumans() }}
                                </p>
                            </div>

                            <div class="flex gap-3">
                                <a href="{{ route('chat.show', $chat->id) }}" class="flex-1 inline-flex items-center justify-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors text-sm font-medium">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                                    </svg>
                                    Abrir
                                </a>
                                <button 
                                    type="button"
                                    onclick="if(confirm('¿Eliminar este chat?')) { document.getElementById('delete-form-{{ $chat->id }}').submit(); }"
                                    class="inline-flex items-center justify-center px-4 py-2 bg-red-100 text-red-600 rounded-lg hover:bg-red-200 transition-colors text-sm font-medium">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                </button>
                            </div>

                            <form id="delete-form-{{ $chat->id }}" action="{{ route('chat.destroy', $chat->id) }}" method="POST" style="display: none;">
                                @csrf
                                @method('DELETE')
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>
@endsection
