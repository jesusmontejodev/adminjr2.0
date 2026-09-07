<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Nueva Cuenta') }}
        </h2>
    </x-slot>

    <div class="cuentas-view relative z-10 p-6 sm:p-10">

        <!-- HEADER -->
        <div class="cv-topbar">
            <div class="cv-title-row">
                <span class="cv-title-icon">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                </span>
                <div>
                    <h1>Nueva Cuenta</h1>
                    <div class="cv-title-sub">Agrega una cuenta para gestionar tus finanzas</div>
                </div>
            </div>

            <a href="{{ route('cuentas.index') }}" class="cv-btn-secondary">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 18l-6-6 6-6"/>
                </svg>
                Volver
            </a>
        </div>

        <!-- MENSAJES -->
        @if (session('error'))
            <div class="cv-alert cv-alert--error">{{ session('error') }}</div>
        @endif

        @if ($errors->any())
            <div class="cv-alert cv-alert--error">
                <strong>Corrige los errores:</strong>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- FORMULARIO -->
        <div class="cv-form-panel">
            <form action="{{ route('cuentas.store') }}" method="POST">
                @csrf

                <div class="cv-field">
                    <label for="nombre" class="cv-label">Nombre de la cuenta *</label>
                    <input type="text" name="nombre" id="nombre"
                        value="{{ old('nombre') }}"
                        class="cv-input"
                        placeholder="Ej: Cuenta Corriente, Ahorros..."
                        required autofocus>
                    @error('nombre') <p class="cv-input-error">{{ $message }}</p> @enderror
                </div>

                <div class="cv-field">
                    <label for="saldo_inicial" class="cv-label">Saldo inicial *</label>
                    <div class="cv-input-prefix-wrap">
                        <span class="cv-input-prefix">$</span>
                        <input
                            type="number"
                            name="saldo_inicial"
                            id="saldo_inicial"
                            step="0.01"
                            min="0"
                            value="{{ old('saldo_inicial') }}"
                            class="cv-input"
                            required
                        >
                    </div>
                    @error('saldo_inicial') <p class="cv-input-error">{{ $message }}</p> @enderror
                </div>

                <div class="cv-field">
                    <label for="descripcion" class="cv-label">Descripción</label>
                    <textarea name="descripcion" id="descripcion" rows="4"
                        class="cv-textarea"
                        placeholder="Descripción opcional...">{{ old('descripcion') }}</textarea>
                    @error('descripcion') <p class="cv-input-error">{{ $message }}</p> @enderror
                </div>

                <div class="cv-form-foot">
                    <p class="cv-form-hint">Los campos marcados con * son obligatorios</p>

                    <div class="cv-form-actions">
                        <a href="{{ route('cuentas.index') }}" class="cv-btn-secondary">Cancelar</a>
                        <button type="submit" class="cv-btn-new">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                            </svg>
                            Crear Cuenta
                        </button>
                    </div>
                </div>
            </form>
        </div>

    </div>
</x-app-layout>
