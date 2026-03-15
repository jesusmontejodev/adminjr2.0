@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 to-slate-100">
    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Header -->
        <div class="mb-8">
            <a href="{{ route('chat.index') }}" class="inline-flex items-center text-blue-600 hover:text-blue-700 mb-4">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
                Volver a Chats
            </a>
            <h1 class="text-3xl font-bold text-slate-900">Crear Nuevo Chat</h1>
            <p class="text-slate-600 mt-2">Configura un nuevo chat con tu Asesor Financiero IA</p>
        </div>

        <!-- Form Card -->
        <div class="bg-white rounded-lg shadow-lg p-8">
            <form action="{{ route('chat.store') }}" method="POST" class="space-y-6">
                @csrf

                <!-- Title Input -->
                <div>
                    <label for="title" class="block text-sm font-medium text-slate-700 mb-2">
                        Título del Chat <span class="text-red-500">*</span>
                    </label>
                    <input 
                        type="text"
                        id="title"
                        name="title"
                        placeholder="Ej: Análisis de Gastos Mensuales"
                        class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('title') border-red-500 @enderror"
                        value="{{ old('title') }}"
                        required
                    >
                    @error('title')
                        <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                    @enderror
                    <p class="text-slate-600 text-sm mt-2">Ej: "Optimizar mis gastos", "Análisis de ingresos", "Preguntas sobre impuestos"</p>
                </div>

                <!-- Model Selection -->
                <div>
                    <label for="model" class="block text-sm font-medium text-slate-700 mb-2">
                        Modelo de IA
                    </label>
                    <select 
                        id="model"
                        name="model"
                        class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('model') border-red-500 @enderror"
                    >
                        <option value="gpt-4o-mini" selected>GPT-4o Mini (Recomendado - Rápido y económico)</option>
                        <option value="gpt-4o">GPT-4o (Más potente)</option>
                        <option value="gpt-4-turbo">GPT-4 Turbo (Muy potente)</option>
                        <option value="gpt-4">GPT-4 (Más preciso)</option>
                        <option value="gpt-3.5-turbo">GPT-3.5 Turbo (Básico)</option>
                    </select>
                    @error('model')
                        <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                    @enderror
                    <p class="text-slate-600 text-sm mt-2">Los modelos más potentes ofrecen mejor análisis pero consumen más tokens</p>
                </div>

                <!-- Info Box -->
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-blue-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-blue-800">
                                ¿Cómo funciona?
                            </h3>
                            <div class="mt-2 text-sm text-blue-700">
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

                <!-- Buttons -->
                <div class="flex gap-4 pt-6">
                    <button 
                        type="submit"
                        class="flex-1 inline-flex items-center justify-center px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors font-medium">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        Crear Chat
                    </button>
                    <a 
                        href="{{ route('chat.index') }}"
                        class="flex-1 inline-flex items-center justify-center px-6 py-3 bg-slate-200 text-slate-700 rounded-lg hover:bg-slate-300 transition-colors font-medium">
                        Cancelar
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
