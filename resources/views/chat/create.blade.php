<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Nuevo Chat') }}
        </h2>
    </x-slot>

    <div class="form-create">
    <div class="relative z-10 max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

        <!-- HEADER -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-6 mb-10">
            <div>
                <h1 class="flex items-center gap-3 text-xl font-bold">
                    <span class="icon-circle">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                    </span>
                    Crear Nuevo Chat
                </h1>
                <p class="mt-2 text-sm text-red-300">
                    Configura un nuevo chat con tu Asesor Financiero IA
                </p>
            </div>

            <a href="{{ route('chat.index') }}">
                <button type="button" class="btn-primary">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 18l-6-6 6-6"/>
                    </svg>
                    Volver
                </button>
            </a>
        </div>

        <!-- ERRORES -->
        @if ($errors->any())
            <div class="alert-error mb-6">
                <strong>Corrige los errores:</strong>
                <ul class="list-disc pl-5 mt-2 text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- CARD -->
        <div class="card">
            <form action="{{ route('chat.store') }}" method="POST" class="p-6 space-y-6">
                @csrf

                <!-- TÍTULO -->
                <div>
                    <label for="title" class="label">Título del Chat *</label>
                    <input
                        type="text"
                        id="title"
                        name="title"
                        placeholder="Ej: Análisis de Gastos Mensuales"
                        class="input"
                        value="{{ old('title') }}"
                        required
                        autofocus
                    >
                    <p class="mt-2 text-xs text-gray-400">Ej: "Optimizar mis gastos", "Análisis de ingresos", "Preguntas sobre impuestos"</p>
                </div>

                <!-- MODELO -->
                <div>
                    <label for="model" class="label">Modelo de IA</label>
                    <select id="model" name="model" class="input">
                        <option value="gpt-4o-mini" selected>GPT-4o Mini (Recomendado - Rápido y económico)</option>
                        <option value="gpt-4o">GPT-4o (Más potente)</option>
                        <option value="gpt-4-turbo">GPT-4 Turbo (Muy potente)</option>
                        <option value="gpt-4">GPT-4 (Más preciso)</option>
                        <option value="gpt-3.5-turbo">GPT-3.5 Turbo (Básico)</option>
                    </select>
                    <p class="mt-2 text-xs text-gray-400">Los modelos más potentes ofrecen mejor análisis pero consumen más tokens</p>
                </div>

                <!-- INFO -->
                <div class="rounded-xl border border-red-500/30 bg-red-500/5 p-4">
                    <div class="flex gap-3">
                        <svg class="w-5 h-5 text-red-400 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                        </svg>
                        <div>
                            <h3 class="text-sm font-medium text-red-300">¿Cómo funciona?</h3>
                            <div class="mt-2 text-sm text-gray-400">
                                <p>Una vez creado el chat, tendrás acceso a un Asesor Financiero IA que:</p>
                                <ul class="list-disc list-inside mt-2 space-y-1">
                                    <li>Analiza automáticamente tus transacciones y cuentas</li>
                                    <li>Proporciona recomendaciones personalizadas</li>
                                    <li>Responde preguntas sobre tus finanzas</li>
                                    <li>Mantiene el historial de todos tus chats</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- FOOTER -->
                <div class="flex flex-col sm:flex-row sm:justify-between gap-4 pt-6 border-t border-white/10">
                    <p class="text-xs text-gray-400">
                        Los campos marcados con * son obligatorios
                    </p>

                    <div class="flex gap-3">
                        <a href="{{ route('chat.index') }}" class="btn-cancel">Cancelar</a>
                        <button type="submit" class="btn-primary">Crear Chat</button>
                    </div>
                </div>
            </form>
        </div>

    </div>
    </div>
</x-app-layout>
