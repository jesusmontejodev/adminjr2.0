<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Integraciones IA') }}
        </h2>
    </x-slot>

    @php
        $totalTokens = $tokens->count();
        $tokensVencidos = $tokens->filter(fn ($t) => $t->expires_at && $t->expires_at->isPast())->count();
        $tokensActivos = $totalTokens - $tokensVencidos;
        $tokensEscritura = $tokens->filter(fn ($t) => in_array('write:own', $t->abilities ?? []))->count();
    @endphp

    <div class="ia-view relative z-10 p-6 sm:p-10">

        <!-- HEADER -->
        <div class="ia-topbar">
            <div>
                <div class="ia-title-row">
                    <span class="ia-title-icon">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            <rect x="9" y="9" width="6" height="6" rx="1" stroke-width="2"/>
                        </svg>
                    </span>
                    <h1>Integraciones IA</h1>
                </div>
                <div class="ia-title-sub">Conecta asistentes de IA a tu cuenta mediante tokens de acceso MCP</div>
            </div>

            @if($totalTokens > 0)
                <span class="ia-status-badge">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 21a9 9 0 100-18 9 9 0 000 18z"/>
                    </svg>
                    {{ $tokensActivos }} {{ $tokensActivos === 1 ? 'token activo' : 'tokens activos' }}
                </span>
            @endif
        </div>

        <!-- ALERTAS -->
        @if (session('status'))
            <div class="ia-alert ia-alert--success">{{ session('status') }}</div>
        @endif

        @if (session('error'))
            <div class="ia-alert ia-alert--error">{{ session('error') }}</div>
        @endif

        <!-- TOKEN RECIÉN CREADO -->
        @if (session('mcp_token_plano'))
            <div class="ia-panel ia-reveal-panel">
                <div class="ia-reveal-title">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z"/>
                    </svg>
                    Copia tu token ahora — no se volverá a mostrar
                </div>
                <code class="ia-token-code">{{ session('mcp_token_plano') }}</code>
            </div>
        @endif

        <!-- RESUMEN -->
        @if($totalTokens > 0)
            <div class="ia-stats-grid">
                <div class="ia-stat-card ia-stat-card--hero" style="--ia-tile-border: var(--ia-hero-border); --ia-tile-soft: var(--ia-hero-soft); --ia-tile-color: var(--ia-hero);">
                    <div class="ia-stat-icon">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/>
                        </svg>
                    </div>
                    <div>
                        <div class="ia-stat-label">Tokens Totales</div>
                        <div class="ia-stat-value ia-display ia-stat-value--gradient">{{ $totalTokens }}</div>
                    </div>
                </div>

                <div class="ia-stat-card" style="--ia-tile-soft: var(--ia-success-soft); --ia-tile-color: var(--ia-success);">
                    <div class="ia-stat-icon">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div>
                        <div class="ia-stat-label">Tokens Activos</div>
                        <div class="ia-stat-value ia-display">{{ $tokensActivos }}</div>
                    </div>
                </div>

                <div class="ia-stat-card" style="--ia-tile-soft: rgba(168,85,247,.14); --ia-tile-color: #a855f7;">
                    <div class="ia-stat-icon">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16.5 3.5a2.1 2.1 0 013 3L7 19l-4 1 1-4 12.5-12.5z"/>
                        </svg>
                    </div>
                    <div>
                        <div class="ia-stat-label">Con permiso de escritura</div>
                        <div class="ia-stat-value ia-display">{{ $tokensEscritura }}</div>
                    </div>
                </div>
            </div>
        @endif

        <!-- ================= AVISO DE BENEFICIOS Y RIESGOS ================= -->
        <div class="ia-section-title"><h2>Acceso desde asistentes de IA</h2><div class="ia-line"></div></div>
        <div class="ia-panel">
            <p class="ia-panel-desc">
                Puedes generar tokens de acceso para que un asistente de IA (por ejemplo, conectado por MCP)
                consulte y registre información en tu cuenta. Un token solo puede leer y escribir
                <strong>los datos de tu propio usuario</strong>: nunca los de otras personas.
            </p>

            <div class="ia-info-grid">
                <div class="ia-info-box ia-info-box--success">
                    <h3>Beneficios</h3>
                    <ul>
                        <li>Registra ingresos y gastos hablando con tu asistente de IA.</li>
                        <li>Consulta saldos y transacciones sin abrir la app.</li>
                        <li>Automatiza reportes y recordatorios financieros.</li>
                    </ul>
                </div>
                <div class="ia-info-box ia-info-box--danger">
                    <h3>Riesgos</h3>
                    <ul>
                        <li>Cualquiera que tenga el token puede leer o modificar tus datos financieros.</li>
                        <li>Nunca compartas el token ni lo pegues en lugares públicos o inseguros.</li>
                        <li>Si sospechas que se filtró, revócalo de inmediato desde esta página.</li>
                        <li>Todos los tokens vencen automáticamente; no existen tokens permanentes.</li>
                    </ul>
                </div>
            </div>

            @unless ($terminosAceptados)
                <form method="POST" action="{{ route('mcp-tokens.aceptar') }}">
                    @csrf
                    <button type="submit" class="ia-btn-primary">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        Entiendo los riesgos y beneficios, continuar
                    </button>
                </form>
            @else
                <p class="ia-panel-foot">
                    Aceptaste este aviso el {{ optional(auth()->user()->mcp_terms_accepted_at)->format('d/m/Y H:i') }}.
                </p>
            @endunless
        </div>

        <!-- ================= CREAR TOKEN ================= -->
        @if ($terminosAceptados)
            <div class="ia-section-title"><h2>Crear nuevo token</h2><div class="ia-line"></div></div>
            <div class="ia-panel">
                <form method="POST" action="{{ route('mcp-tokens.store') }}" class="max-w-xl">
                    @csrf

                    <div class="ia-field">
                        <label for="name" class="ia-label">Nombre del token</label>
                        <input id="name" name="name" type="text" class="ia-input"
                            value="{{ old('name') }}" required maxlength="100"
                            placeholder="Ej. Asistente de gastos en Claude">
                        @error('name') <p class="ia-input-error">{{ $message }}</p> @enderror
                    </div>

                    <div class="ia-field">
                        <label for="description" class="ia-label">¿Para qué sirve este token? ¿Qué IA lo va a usar?</label>
                        <textarea id="description" name="description" rows="3" required maxlength="1000"
                            class="ia-textarea"
                            placeholder="Ej. Lo usará mi asistente personal en Claude para registrar mis gastos diarios desde WhatsApp.">{{ old('description') }}</textarea>
                        @error('description') <p class="ia-input-error">{{ $message }}</p> @enderror
                    </div>

                    <div class="ia-field">
                        <label for="modo" class="ia-label">Permisos</label>
                        <select id="modo" name="modo" required class="ia-select">
                            <option value="solo_lectura" {{ old('modo') === 'solo_lectura' ? 'selected' : '' }}>Solo lectura (consultar datos)</option>
                            <option value="lectura_escritura" {{ old('modo') === 'lectura_escritura' ? 'selected' : '' }}>Lectura y escritura (consultar y registrar datos)</option>
                        </select>
                        @error('modo') <p class="ia-input-error">{{ $message }}</p> @enderror
                    </div>

                    <div class="ia-field">
                        <label for="duracion" class="ia-label">Vence en</label>
                        <select id="duracion" name="duracion" required class="ia-select">
                            <option value="7" {{ old('duracion') === '7' ? 'selected' : '' }}>7 días</option>
                            <option value="30" {{ old('duracion', '30') === '30' ? 'selected' : '' }}>30 días</option>
                            <option value="90" {{ old('duracion') === '90' ? 'selected' : '' }}>90 días</option>
                            <option value="365" {{ old('duracion') === '365' ? 'selected' : '' }}>1 año</option>
                        </select>
                        @error('duracion') <p class="ia-input-error">{{ $message }}</p> @enderror
                    </div>

                    <button type="submit" class="ia-btn-primary">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        Crear token
                    </button>
                </form>
            </div>
        @endif

        <!-- ================= TOKENS EXISTENTES ================= -->
        <div class="ia-section-title"><h2>Tus tokens</h2><div class="ia-line"></div></div>
        <div class="ia-panel" style="padding: 0;">
            @if ($tokens->isEmpty())
                <div class="ia-empty">Aún no has creado ningún token.</div>
            @else
                @foreach ($tokens as $token)
                    @php
                        $abilities = $token->abilities ?? [];
                        $esEscritura = in_array('write:own', $abilities);
                        $vencido = $token->expires_at && $token->expires_at->isPast();
                    @endphp
                    <div class="ia-token-row">
                        <div style="min-width:0;">
                            <div class="ia-token-name-row">
                                <span class="ia-token-name">{{ $token->name }}</span>
                                <span class="ia-badge {{ $esEscritura ? 'ia-badge--write' : 'ia-badge--read' }}">
                                    {{ $esEscritura ? 'Lectura y escritura' : 'Solo lectura' }}
                                </span>
                                @if ($vencido)
                                    <span class="ia-badge ia-badge--expired">Vencido</span>
                                @endif
                            </div>
                            @if ($token->description)
                                <p class="ia-token-desc">{{ $token->description }}</p>
                            @endif
                            <p class="ia-token-meta">
                                Creado: {{ $token->created_at->format('d/m/Y') }}
                                &middot; Vence: {{ $token->expires_at?->format('d/m/Y H:i') ?? 'N/D' }}
                                &middot; Último uso: {{ $token->last_used_at?->format('d/m/Y H:i') ?? 'nunca' }}
                            </p>
                        </div>
                        <form method="POST" action="{{ route('mcp-tokens.destroy', $token->id) }}"
                              onsubmit="return confirm('¿Revocar este token? Cualquier IA que lo use dejará de tener acceso de inmediato.');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="ia-btn-danger">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6h18M8 6V4h8v2M6 6v14a2 2 0 002 2h8a2 2 0 002-2V6M10 11v6M14 11v6"/>
                                </svg>
                                Revocar
                            </button>
                        </form>
                    </div>
                @endforeach
            @endif
        </div>

    </div>
</x-app-layout>
