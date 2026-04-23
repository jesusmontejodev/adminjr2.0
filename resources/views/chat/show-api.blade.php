@extends('layouts.app')

@section('content')
<div class="oa-chat-shell min-h-[calc(100vh-3rem)] overflow-hidden rounded-[28px] border border-black/5 bg-[#f7f7f8] text-[#1f1f1f] shadow-[0_24px_80px_rgba(15,23,42,0.08)]">
    <div class="flex h-[calc(100vh-3rem)] overflow-hidden">
        <aside class="hidden w-72 shrink-0 flex-col border-r border-white/10 bg-[#171717] text-white lg:flex">
            <div class="border-b border-white/10 px-6 py-6">
                <div class="flex items-start justify-between gap-3">
                    <div>
                        <p class="text-[11px] font-medium uppercase tracking-[0.22em] text-white/45">Open Finance</p>
                        <h2 class="mt-3 text-xl font-semibold leading-tight text-white">{{ $chat->title }}</h2>
                    </div>
                    <a href="{{ route('chat.index') }}" class="rounded-full border border-white/10 p-2 text-white/60 transition hover:border-white/20 hover:text-white" title="Volver a chats">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </a>
                </div>
                <div class="mt-6 rounded-2xl border border-white/10 bg-white/5 px-4 py-4">
                    <p class="text-xs text-white/45">Modelo</p>
                    <p class="mt-2 text-sm font-medium text-white">{{ ucfirst(str_replace('-', ' ', $chat->model)) }}</p>
                </div>
            </div>

            <div class="flex-1 px-4 py-5">
                <div class="rounded-2xl border border-emerald-400/20 bg-emerald-400/10 px-4 py-4">
                    <p class="text-[11px] font-medium uppercase tracking-[0.2em] text-emerald-200/70">Estado</p>
                    <p class="mt-3 text-sm leading-6 text-white/80">Asistente listo para responder sobre saldos, gastos, ingresos y movimientos recientes.</p>
                </div>

                <div class="mt-4 rounded-2xl border border-white/8 bg-white/4 px-4 py-4 text-sm leading-6 text-white/72">
                    <p>La respuesta aparece en la misma petición y luego se dibuja poco a poco en pantalla.</p>
                </div>
            </div>

            <div class="border-t border-white/10 p-4">
                <a href="{{ route('chat.create') }}" class="inline-flex w-full items-center justify-center gap-2 rounded-2xl bg-white px-4 py-3 text-sm font-semibold text-[#171717] transition hover:bg-white/90">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Nuevo chat
                </a>
            </div>
        </aside>

        <section class="flex min-w-0 flex-1 flex-col bg-[#f7f7f8]">
            <header class="border-b border-black/5 bg-[#f7f7f8]/95 px-6 py-5 backdrop-blur">
                <div class="mx-auto flex w-full max-w-4xl items-center justify-between gap-4">
                    <div>
                        <p class="text-[11px] font-medium uppercase tracking-[0.24em] text-[#10a37f]">OpenAI Style Chat</p>
                        <h1 class="mt-2 text-2xl font-semibold tracking-tight text-[#111827]">{{ $chat->title }}</h1>
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="hidden rounded-full bg-white px-4 py-2 text-sm text-slate-500 shadow-sm ring-1 ring-black/5 sm:block">
                            <span id="message-count">0</span> mensajes
                        </div>
                        <a href="{{ route('chat.index') }}" class="inline-flex items-center justify-center rounded-full bg-white p-3 text-slate-500 shadow-sm ring-1 ring-black/5 transition hover:text-slate-700">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                            </svg>
                        </a>
                    </div>
                </div>
            </header>

            <div class="flex-1 overflow-y-auto px-4 py-6 sm:px-6" id="messages-container">
                <div class="mx-auto flex min-h-full w-full max-w-4xl items-center justify-center" id="empty-state-wrapper">
                    <div class="max-w-md text-center">
                        <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-2xl bg-white shadow-sm ring-1 ring-black/5">
                            <svg class="h-8 w-8 text-[#10a37f]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                            </svg>
                        </div>
                        <h3 class="mt-6 text-2xl font-semibold tracking-tight text-slate-900">Haz una pregunta financiera</h3>
                        <p class="mt-3 text-sm leading-7 text-slate-500">Obtén respuestas sobre movimientos, cuentas, ingresos y gastos con una presentación estilo ChatGPT.</p>
                    </div>
                </div>
            </div>

            <div class="border-t border-black/5 bg-[#f7f7f8] px-4 py-5 sm:px-6">
                <div class="mx-auto w-full max-w-4xl">
                    <div class="rounded-[28px] bg-white p-3 shadow-[0_8px_40px_rgba(15,23,42,0.08)] ring-1 ring-black/5">
                        <div class="flex items-end gap-3">
                            <div class="min-w-0 flex-1">
                                <label for="message-input" class="sr-only">Escribe tu mensaje</label>
                                <textarea
                                    id="message-input"
                                    rows="1"
                                    class="oa-input min-h-[52px] w-full resize-none border-0 bg-transparent px-3 py-3 text-[15px] leading-7 text-slate-800 placeholder:text-slate-400 focus:outline-none focus:ring-0"
                                    placeholder="Escribe tu pregunta sobre tus finanzas..."
                                ></textarea>
                            </div>
                            <button id="send-btn"
                                class="inline-flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-[#10a37f] text-white transition hover:bg-[#0d8b6c] disabled:cursor-not-allowed disabled:opacity-60"
                                onclick="sendMessage()">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2m0 0v-8"/>
                                </svg>
                            </button>
                        </div>
                        <div id="error-message" class="mt-2 hidden rounded-2xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                            <p id="error-text"></p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>
@endsection

@push('scripts')
@vite('resources/js/chat-api.js')
<style>
    .oa-chat-shell {
        background-image: radial-gradient(circle at top, rgba(16, 163, 127, 0.08), transparent 28%);
    }

    .oa-message-copy {
        white-space: pre-wrap;
        word-break: break-word;
    }

    .oa-cursor {
        display: inline-block;
        width: 0.65ch;
        height: 1.1em;
        margin-left: 2px;
        vertical-align: text-bottom;
        border-radius: 999px;
        background: #10a37f;
        animation: oaBlink 1s step-end infinite;
    }

    .oa-thinking-dots span {
        display: inline-block;
        width: 6px;
        height: 6px;
        margin-right: 4px;
        border-radius: 999px;
        background: #10a37f;
        animation: oaBounce 1.2s infinite ease-in-out;
    }

    .oa-thinking-dots span:nth-child(2) {
        animation-delay: 0.18s;
    }

    .oa-thinking-dots span:nth-child(3) {
        animation-delay: 0.36s;
        margin-right: 0;
    }

    .oa-message-enter {
        animation: oaFadeUp 0.28s ease-out;
    }

    @keyframes oaBlink {
        50% {
            opacity: 0;
        }
    }

    @keyframes oaBounce {
        0%, 80%, 100% {
            transform: translateY(0);
            opacity: 0.4;
        }
        40% {
            transform: translateY(-4px);
            opacity: 1;
        }
    }

    @keyframes oaFadeUp {
        from {
            opacity: 0;
            transform: translateY(10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
</style>
<script>
    const chatId = {{ $chat->id }};
    const userName = "{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}";
    let messages = [];
    let isLoading = false;
    let chatAPIReady = false;

    function waitForChatAPI(callback, attempts = 0) {
        if (typeof window.chatAPI !== 'undefined') {
            chatAPIReady = true;
            callback();
            return;
        }

        if (attempts < 50) {
            setTimeout(() => waitForChatAPI(callback, attempts + 1), 100);
            return;
        }

        showError('Error: No se pudo cargar la librería de chat');
    }

    document.addEventListener('DOMContentLoaded', () => {
        waitForChatAPI(async () => {
            await window.chatAPI.initSanctum();
            await loadMessages();

            const input = document.getElementById('message-input');
            autoResizeTextarea(input);

            input.addEventListener('input', () => autoResizeTextarea(input));
            input.addEventListener('keydown', (event) => {
                if (event.key === 'Enter' && !event.shiftKey) {
                    event.preventDefault();

                    if (!isLoading) {
                        sendMessage();
                    }
                }
            });
        });
    });

    async function loadMessages() {
        try {
            const result = await window.chatAPI.getChat(chatId);

            if (!result.success || !result.data.messages) {
                showError('No se pudieron cargar los datos del chat');
                return;
            }

            messages = result.data.messages;
            renderMessages();
            updateMessageCount();

            if (messages.length > 0) {
                hideEmptyState();
            }
        } catch (error) {
            showError(`Error al cargar los mensajes: ${error.message}`);
        }
    }

    async function sendMessage() {
        const input = document.getElementById('message-input');
        const btn = document.getElementById('send-btn');
        const content = input.value.trim();

        if (!content || isLoading || !chatAPIReady) {
            return;
        }

        isLoading = true;
        btn.disabled = true;

        const tempUserId = `temp-user-${Date.now()}`;
        const tempAssistantId = `temp-assistant-${Date.now()}`;
        const originalButtonContent = btn.innerHTML;

        messages.push({
            id: tempUserId,
            role: 'user',
            content,
            status: 'processing',
            created_at: new Date().toISOString(),
        });

        messages.push({
            id: tempAssistantId,
            role: 'assistant',
            content: '',
            status: 'processing',
            created_at: new Date().toISOString(),
            isThinking: true,
        });

        input.value = '';
        autoResizeTextarea(input);
        btn.innerHTML = `
            <svg class="h-5 w-5 animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
            </svg>
        `;

        renderMessages();
        updateMessageCount();
        hideEmptyState();
        clearError();

        try {
            const result = await window.chatAPI.sendMessage(chatId, content);

            if (!result.success) {
                throw new Error('No se pudo procesar la respuesta');
            }

            messages = messages.filter((msg) => msg.id !== tempUserId && msg.id !== tempAssistantId);
            messages.push(result.data.user_message);

            const assistantMessage = {
                ...result.data.assistant_message,
                content: '',
                fullContent: result.data.assistant_message.content || '',
                isTyping: result.data.assistant_message.status !== 'failed',
            };

            messages.push(assistantMessage);
            renderMessages();
            updateMessageCount();

            if (assistantMessage.isTyping) {
                await animateAssistantMessage(assistantMessage.id, assistantMessage.fullContent);
            }
        } catch (error) {
            messages = messages.filter((msg) => msg.id !== tempUserId && msg.id !== tempAssistantId);
            renderMessages();
            updateMessageCount();
            showError(error.message || 'Error al enviar el mensaje');
        } finally {
            isLoading = false;
            btn.disabled = false;
            btn.innerHTML = originalButtonContent;
            input.focus();
        }
    }

    function renderMessages() {
        const container = document.getElementById('messages-container');

        if (messages.length === 0) {
            container.innerHTML = `
                <div class="mx-auto flex min-h-full w-full max-w-4xl items-center justify-center" id="empty-state-wrapper">
                    <div class="max-w-md text-center">
                        <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-2xl bg-white shadow-sm ring-1 ring-black/5">
                            <svg class="h-8 w-8 text-[#10a37f]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                            </svg>
                        </div>
                        <h3 class="mt-6 text-2xl font-semibold tracking-tight text-slate-900">Haz una pregunta financiera</h3>
                        <p class="mt-3 text-sm leading-7 text-slate-500">Obtén respuestas sobre movimientos, cuentas, ingresos y gastos con una presentación estilo ChatGPT.</p>
                    </div>
                </div>
            `;
            return;
        }

        const messagesHTML = messages.map((msg) => {
            const isUser = msg.role === 'user';
            const isThinking = Boolean(msg.isThinking);
            const isTyping = Boolean(msg.isTyping);
            const badge = isUser
                ? `<div class="flex h-9 w-9 items-center justify-center rounded-full bg-[#111827] text-sm font-semibold text-white shadow-sm">${userName}</div>`
                : `<div class="flex h-10 w-10 items-center justify-center overflow-hidden rounded-full bg-black shadow-[0_10px_30px_rgba(0,0,0,0.22)] ring-1 ring-white/10"><span class="block h-7 w-7 leading-none">{!! str_replace(['<svg ', '</svg>'], ['<svg class="h-7 w-7" ', '</svg>'], trim(view('components.application-logo')->render())) !!}</span></div>`;

            const content = isThinking
                ? `
                    <div class="flex items-center gap-3 text-sm text-slate-500">
                        <div class="oa-thinking-dots"><span></span><span></span><span></span></div>
                        <span>Analizando tu información...</span>
                    </div>
                `
                : `${escapeHtml(msg.content || '')}${isTyping ? '<span class="oa-cursor"></span>' : ''}`;

            const meta = isThinking
                ? 'Pensando...'
                : isTyping
                    ? 'Escribiendo...'
                    : msg.status === 'failed'
                        ? 'No se pudo completar la respuesta'
                        : `${formatDate(msg.created_at)}${msg.tokens_used ? ` · ${msg.tokens_used} tokens` : ''}`;

            return `
                <article class="oa-message-enter mx-auto mb-6 flex w-full max-w-4xl gap-4 ${isUser ? 'justify-end' : 'justify-start'}" id="message-${msg.id}">
                    <div class="flex w-full max-w-3xl gap-4 ${isUser ? 'flex-row-reverse' : ''}">
                        <div class="shrink-0">${badge}</div>
                        <div class="min-w-0 flex-1">
                            <div class="rounded-[24px] px-5 py-4 shadow-sm ring-1 ${isUser ? 'bg-[#111827] text-white ring-black/5' : 'bg-white text-slate-800 ring-black/5'}">
                                <div class="oa-message-copy text-[15px] leading-7 ${isUser ? 'text-white/95' : 'text-slate-700'}" data-message-content="${msg.id}">${content}</div>
                            </div>
                            <div class="mt-2 px-1 text-xs ${isUser ? 'text-right text-slate-400' : 'text-slate-500'}">${meta}</div>
                        </div>
                    </div>
                </article>
            `;
        }).join('');

        container.innerHTML = `<div class="pb-4 pt-2">${messagesHTML}</div>`;
        container.scrollTop = container.scrollHeight;
    }

    async function animateAssistantMessage(messageId, fullContent) {
        const message = messages.find((item) => String(item.id) === String(messageId));

        if (!message) {
            return;
        }

        const target = document.querySelector(`[data-message-content="${messageId}"]`);

        if (!target || !fullContent) {
            message.content = fullContent;
            message.isTyping = false;
            delete message.fullContent;
            renderMessages();
            return;
        }

        let index = 0;

        while (index < fullContent.length) {
            const chunkSize = getTypingChunkSize(fullContent, index);
            index = Math.min(index + chunkSize, fullContent.length);
            message.content = fullContent.slice(0, index);
            target.innerHTML = `${escapeHtml(message.content)}<span class="oa-cursor"></span>`;
            document.getElementById('messages-container').scrollTop = document.getElementById('messages-container').scrollHeight;
            await sleep(getTypingDelay(fullContent, index));
        }

        message.content = fullContent;
        message.isTyping = false;
        delete message.fullContent;
        renderMessages();
    }

    function getTypingChunkSize(text, index) {
        const currentChar = text[index] || '';

        if (currentChar === '\n') {
            return 1;
        }

        if (/[.,;:!?]/.test(currentChar)) {
            return 1;
        }

        return Math.min(3, text.length - index);
    }

    function getTypingDelay(text, index) {
        const previousChar = text[index - 1] || '';

        if (previousChar === '\n') {
            return 100;
        }

        if (/[.,;:!?]/.test(previousChar)) {
            return 80;
        }

        return 16;
    }

    function updateMessageCount() {
        document.getElementById('message-count').textContent = messages.length;
    }

    function hideEmptyState() {
        const emptyState = document.getElementById('empty-state-wrapper');

        if (emptyState) {
            emptyState.remove();
        }
    }

    function showError(message) {
        const errorDiv = document.getElementById('error-message');
        const errorText = document.getElementById('error-text');
        errorText.textContent = message;
        errorDiv.classList.remove('hidden');
    }

    function clearError() {
        document.getElementById('error-message').classList.add('hidden');
    }

    function escapeHtml(text) {
        const map = {
            '&': '&amp;',
            '<': '&lt;',
            '>': '&gt;',
            '"': '&quot;',
            "'": '&#039;'
        };

        return String(text).replace(/[&<>"']/g, (char) => map[char]);
    }

    function formatDate(dateString) {
        const date = new Date(dateString);
        return date.toLocaleTimeString('es-ES', { hour: '2-digit', minute: '2-digit' });
    }

    function sleep(ms) {
        return new Promise((resolve) => setTimeout(resolve, ms));
    }

    function autoResizeTextarea(element) {
        element.style.height = 'auto';
        element.style.height = `${Math.min(element.scrollHeight, 220)}px`;
    }
</script>
@endpush
