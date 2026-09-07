<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Asesor IA') }}
        </h2>
    </x-slot>

    <div class="chat-view relative z-10 p-6 sm:p-10">

        <!-- HEADER -->
        <div class="ch-topbar">
            <div class="ch-title-row">
                <span class="ch-title-icon">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                    </svg>
                </span>
                <div>
                    <h1>Asesor Financiero IA</h1>
                    <div class="ch-title-sub">Chats con análisis de tus datos financieros</div>
                </div>
            </div>

            <a href="{{ route('chat.create') }}" class="ch-btn-new">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Nuevo Chat
            </a>
        </div>

        @if($chats->isEmpty())
            <!-- ESTADO VACÍO -->
            <div class="ch-empty-preview">
                <div class="ch-empty-icon">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                    </svg>
                </div>
                <h3>No hay chats aún</h3>
                <p>Crea tu primer chat para comenzar a analizar tus datos financieros con IA</p>
                <a href="{{ route('chat.create') }}" class="ch-btn-new">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Crear Nuevo Chat
                </a>
            </div>
        @else
            <!-- GRID DE CHATS -->
            <div class="ch-grid">
                @foreach($chats as $chat)
                    <div class="ch-card">
                        <div class="ch-card-head">
                            <div style="min-width:0;">
                                <div class="ch-card-title" title="{{ $chat->title }}">{{ $chat->title }}</div>
                                <div class="ch-card-model">Modelo: <strong>{{ ucfirst(str_replace('-', ' ', $chat->model)) }}</strong></div>
                            </div>
                            <span class="ch-badge">{{ $chat->messages->count() }} mensajes</span>
                        </div>

                        <div class="ch-card-meta">
                            <div><b>Creado:</b> {{ $chat->created_at->diffForHumans() }}</div>
                            <div><b>Actualizado:</b> {{ $chat->updated_at->diffForHumans() }}</div>
                        </div>

                        <div class="ch-card-actions">
                            <a href="{{ route('chat.show', $chat->id) }}" class="ch-btn-open">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                                Abrir
                            </a>
                            <button type="button"
                                    onclick="if(confirm('¿Eliminar este chat?')) { document.getElementById('delete-form-{{ $chat->id }}').submit(); }"
                                    class="ch-icon-btn" title="Eliminar">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            </button>
                        </div>

                        <form id="delete-form-{{ $chat->id }}" action="{{ route('chat.destroy', $chat->id) }}" method="POST" style="display: none;">
                            @csrf
                            @method('DELETE')
                        </form>
                    </div>
                @endforeach
            </div>
        @endif

    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            @if(session('success'))
                showToast(@json(session('success')), 'success');
            @endif
            @if(session('error'))
                showToast(@json(session('error')), 'error');
            @endif
        });
    </script>
</x-app-layout>
