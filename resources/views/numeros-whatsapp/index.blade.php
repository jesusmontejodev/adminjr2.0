<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('WhatsApp') }}
        </h2>
    </x-slot>

    <div class="whatsapp-view relative z-10 p-6 sm:p-10">

        <!-- HEADER -->
        <div class="wa-topbar">
            <div>
                <div class="wa-title-row">
                    <span class="wa-title-icon">
                        <svg fill="currentColor" viewBox="0 0 32 32" aria-hidden="true">
                            <path d="M16 3C9.373 3 4 8.373 4 15c0 2.637.87 5.073 2.33 7.054L4 29l7.194-2.25A11.94 11.94 0 0016 27c6.627 0 12-5.373 12-12S22.627 3 16 3zm0 21.5a9.43 9.43 0 01-4.816-1.324l-.344-.203-4.266 1.332 1.39-4.15-.223-.37A9.454 9.454 0 016.5 15C6.5 9.757 10.757 5.5 16 5.5S25.5 9.757 25.5 15 21.243 24.5 16 24.5zm4.792-6.82c-.262-.132-1.55-.764-1.79-.85-.24-.088-.414-.132-.588.132-.174.262-.676.85-.83 1.026-.152.174-.304.196-.566.064-.262-.132-1.108-.408-2.11-1.3-.78-.696-1.306-1.556-1.458-1.818-.152-.262-.016-.404.116-.536.12-.118.262-.304.394-.458.132-.152.174-.262.262-.436.088-.174.044-.326-.022-.458-.064-.132-.588-1.418-.806-1.946-.212-.51-.426-.44-.588-.448-.152-.008-.326-.01-.5-.01s-.458.064-.698.326c-.24.262-.918.894-.918 2.178 0 1.284.94 2.524 1.072 2.7.132.174 1.85 2.82 4.48 3.954.626.27 1.114.432 1.494.554.628.2 1.2.172 1.652.104.504-.074 1.55-.634 1.77-1.246.218-.612.218-1.136.152-1.246-.064-.108-.24-.174-.502-.306z"/>
                        </svg>
                    </span>
                    <h1>
                        WhatsApp connection
                        <span class="wa-status-badge">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 21a9 9 0 100-18 9 9 0 000 18z"/>
                            </svg>
                            WhatsApp on
                        </span>
                    </h1>
                </div>
                <div class="wa-title-sub">Gestiona y configura tus números de WhatsApp</div>
            </div>

            @if($puedeAgregar)
                <a href="{{ route('numeros-whatsapp.create') }}" class="wa-btn-new">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Nuevo número
                </a>
            @else
                <span class="wa-limit-chip" title="Alcanzaste el límite de tu plan ({{ $limite }})">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                    </svg>
                    Límite alcanzado ({{ $numeros->count() }}/{{ $limite }})
                </span>
            @endif
        </div>

        <!-- RESUMEN -->
        @if($numeros->isNotEmpty())
            <div class="wa-stat-card">
                <div class="wa-stat-icon">
                    <svg fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path d="M21 6.5a2.5 2.5 0 00-2.5-2.5H5.5A2.5 2.5 0 003 6.5v7A2.5 2.5 0 005.5 16H9l3 3 3-3h3.5A2.5 2.5 0 0021 13.5v-7z"/>
                    </svg>
                </div>
                <div>
                    <div class="wa-stat-label">Números Totales</div>
                    <div class="wa-stat-value wa-display wa-stat-value--gradient">{{ $numeros->count() }} <span style="font-size:15px; color:var(--wa-text-faint); font-weight:600;">/ {{ $limite }}</span></div>
                    <div class="wa-stat-foot">Números conectados de tu límite de plan</div>
                </div>
            </div>
        @endif

        @if($numeros->isEmpty())
            <!-- ESTADO VACÍO -->
            <div class="wa-empty-preview">
                <div class="wa-empty-icon">
                    <svg fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path d="M7 5h10a4 4 0 014 4v5a4 4 0 01-4 4h-3l-2.5 2.5L9 18H7a4 4 0 01-4-4V9a4 4 0 014-4z"/>
                    </svg>
                </div>
                <h3>Sin números configurados</h3>
                <p>Conecta tu primer número de WhatsApp Business</p>
                @if($puedeAgregar)
                    <a href="{{ route('numeros-whatsapp.create') }}" class="wa-btn-new">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        Conectar número
                    </a>
                @else
                    <p class="wa-empty-note">Tu plan no permite conectar números de WhatsApp.</p>
                @endif
            </div>
        @else
            <!-- GRID TARJETAS -->
            <div class="wa-grid">
                @foreach($numeros as $numero)
                    <div class="wa-card">
                        <div class="wa-card-head">
                            <div class="wa-card-head-left">
                                <span class="wa-card-icon">
                                    <svg fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                        <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.86 19.86 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.86 19.86 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.12.81.3 1.6.54 2.36a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.72-1.72a2 2 0 0 1 2.11-.45c.76.24 1.55.42 2.36.54a2 2 0 0 1 1.72 2z"/>
                                    </svg>
                                </span>
                                <div style="min-width:0;">
                                    <div class="wa-card-title" title="{{ $numero->numero_internacional }}">{{ $numero->numero_internacional }}</div>
                                    <div class="wa-card-id">ID: {{ substr($numero->id, 0, 8) }}...</div>
                                </div>
                            </div>

                            <a href="{{ route('numeros-whatsapp.edit', $numero->id) }}" class="wa-card-menu" title="Editar">
                                <svg fill="currentColor" viewBox="0 0 24 24">
                                    <circle cx="12" cy="5" r="1.8"/><circle cx="12" cy="12" r="1.8"/><circle cx="12" cy="19" r="1.8"/>
                                </svg>
                            </a>
                        </div>

                        <div class="wa-card-badge-row">
                            <span class="wa-badge">Personal</span>
                        </div>

                        <div class="wa-card-info">
                            <div class="wa-info-box">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.86 19.86 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.86 19.86 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.12.81.3 1.6.54 2.36a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.72-1.72a2 2 0 0 1 2.11-.45c.76.24 1.55.42 2.36.54a2 2 0 0 1 1.72 2z"/>
                                </svg>
                                <p>Número local</p>
                                <strong>{{ $numero->numero_local }}</strong>
                            </div>

                            <div class="wa-info-box">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <circle cx="12" cy="12" r="10"/>
                                    <path d="M12 2a15 15 0 010 20"/>
                                    <path d="M2 12h20"/>
                                    <path d="M4 8h16"/>
                                    <path d="M4 16h16"/>
                                </svg>
                                <p>País</p>
                                <strong>{{ $numero->pais }}</strong>
                            </div>
                        </div>

                        <div class="wa-card-foot">
                            <span class="wa-status-dot"><span class="dot"></span> Inactivo</span>
                            <span>{{ $numero->created_at->diffForHumans() }}</span>
                        </div>
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
            @if(session('limit_warning'))
                showToast(@json('Ya usas ' . session('limit_warning')['actual'] . ' de ' . session('limit_warning')['limite'] . ' números de WhatsApp permitidos por tu plan.'), 'warning');
            @endif
        });
    </script>
</x-app-layout>
