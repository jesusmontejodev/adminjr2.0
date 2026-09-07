<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="dashboard-view relative z-10 p-6 sm:p-10">

        <!-- HEADER -->
        <div class="mb-8">
            <h1>Hola, {{ explode(' ', Auth::user()->name)[0] }}</h1>
            <div class="dv-subtitle">{{ now()->locale('es')->isoFormat('dddd, D [de] MMMM') }}</div>
        </div>

        <!-- RACHA -->
        @php
            $flameOff = $racha['actual'] === 0;
        @endphp
        <div class="dv-streak-card">
            <div class="dv-streak-main">
                <div class="dv-streak-flame {{ $flameOff ? 'dv-off' : '' }}">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M12 22c4.418 0 8-3.134 8-7 0-2.5-1.5-4-2.5-5.5-.5 2-1.5 3-2.5 2 1-3-1-6-3.5-7.5.5 2.5-.5 4.5-2.5 6.5C7.5 12 6 13.5 6 15c0 3.866 2.686 7 6 7z"/>
                    </svg>
                </div>
                <div>
                    <div class="dv-streak-num dv-display">{{ $racha['actual'] }} <span style="font-size:16px; font-weight:600; color:var(--dv-text-faint);">{{ $racha['actual'] === 1 ? 'día' : 'días' }}</span></div>
                    <div class="dv-streak-label">
                        @if($racha['actual'] === 0)
                            Registra una transacción hoy para empezar tu racha
                        @elseif($racha['activaHoy'])
                            Racha activa &middot; ya registraste hoy
                        @else
                            Racha activa &middot; registra hoy para no perderla
                        @endif
                    </div>
                </div>
            </div>

            <div class="dv-streak-meta">
                <div class="dv-streak-meta-item">
                    <div class="dv-num dv-display">{{ $racha['mejor'] }}</div>
                    <div class="dv-lbl">Mejor racha</div>
                </div>
                <div class="dv-streak-meta-item">
                    <div class="dv-num dv-display">{{ $racha['totalDiasActivos'] }}</div>
                    <div class="dv-lbl">Días activos en total</div>
                </div>
            </div>

            <div class="dv-streak-days">
                @foreach($racha['ultimos7Dias'] as $dia)
                    <div class="dv-day">
                        <span class="dv-day-lbl">{{ $dia['etiqueta'] }}</span>
                        <span class="dv-day-dot {{ $dia['activo'] ? 'dv-active' : '' }} {{ $dia['esHoy'] ? 'dv-today' : '' }}"></span>
                    </div>
                @endforeach
            </div>

            <div class="dv-streak-note">
                <b>La disciplina construye el hábito.</b> Cada día que registras tus movimientos financieros fortalece tu racha y te da una visión más clara de tu negocio.
            </div>
        </div>

        <!-- RESUMEN -->
        <div class="dv-section-title"><h2>Resumen financiero</h2><div class="dv-line"></div></div>
        <div class="dv-stats-grid">
            <div class="dv-stat-card dv-stat-card--hero" style="--dv-tile-border: var(--dv-hero-border); --dv-tile-soft: var(--dv-hero-soft); --dv-tile-color: var(--dv-hero);">
                <div class="dv-stat-icon">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 2v20M17 6.5c0-2-2.5-3.5-5-3.5S7 4.5 7 6.5 9.5 9 12 9s5 1.5 5 3.5-2.5 3.5-5 3.5-5-1.5-5-3.5"/>
                    </svg>
                </div>
                <div>
                    <div class="dv-stat-label">Saldo Total</div>
                    <div class="dv-stat-value dv-display dv-stat-value--gradient">${{ number_format($saldoTotal, 2) }}</div>
                </div>
            </div>

            <div class="dv-stat-card" style="--dv-tile-border: var(--dv-success-soft); --dv-tile-soft: var(--dv-success-soft); --dv-tile-color: var(--dv-success);">
                <div class="dv-stat-icon">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19V5m0 0l-6 6m6-6l6 6"/>
                    </svg>
                </div>
                <div>
                    <div class="dv-stat-label">Ingresos del mes</div>
                    <div class="dv-stat-value dv-display">${{ number_format($ingresosMes, 2) }}</div>
                </div>
            </div>

            <div class="dv-stat-card" style="--dv-tile-border: var(--dv-danger-soft); --dv-tile-soft: var(--dv-danger-soft); --dv-tile-color: var(--dv-danger);">
                <div class="dv-stat-icon">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v14m0 0l-6-6m6 6l6-6"/>
                    </svg>
                </div>
                <div>
                    <div class="dv-stat-label">Egresos del mes</div>
                    <div class="dv-stat-value dv-display">${{ number_format($egresosMes, 2) }}</div>
                </div>
            </div>
        </div>

        <!-- ACTIVIDAD RECIENTE -->
        <div class="dv-section-title"><h2>Actividad reciente</h2><div class="dv-line"></div></div>
        <div class="dv-panel">
            @forelse($actividadReciente as $mov)
                @php
                    $tipoInfo = match($mov->tipo) {
                        'ingreso' => ['label' => 'Ingreso', 'signo' => '+', 'soft' => 'var(--dv-success-soft)', 'color' => 'var(--dv-success)'],
                        'egreso' => ['label' => 'Egreso', 'signo' => '-', 'soft' => 'var(--dv-danger-soft)', 'color' => 'var(--dv-danger)'],
                        'inversion' => ['label' => 'Inversión', 'signo' => '-', 'soft' => 'var(--dv-accent-soft)', 'color' => 'var(--dv-accent)'],
                        'costo' => ['label' => 'Costo', 'signo' => '-', 'soft' => 'var(--dv-accent-soft)', 'color' => 'var(--dv-accent)'],
                        default => ['label' => ucfirst($mov->tipo), 'signo' => '', 'soft' => 'var(--dv-accent-soft)', 'color' => 'var(--dv-accent)'],
                    };
                @endphp
                <div class="dv-activity-item">
                    <div class="dv-activity-icon" style="--dv-ai-soft: {{ $tipoInfo['soft'] }}; --dv-ai-color: {{ $tipoInfo['color'] }};">
                        @if($mov->tipo === 'ingreso')
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19V5m0 0l-6 6m6-6l6 6"/></svg>
                        @elseif($mov->tipo === 'egreso')
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v14m0 0l-6-6m6 6l6-6"/></svg>
                        @else
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/></svg>
                        @endif
                    </div>
                    <div class="dv-activity-body">
                        <div class="dv-activity-title">{{ $mov->descripcion ?: $tipoInfo['label'] }}</div>
                        <div class="dv-activity-sub">
                            {{ $mov->fecha->format('d/m/Y') }}
                            @if($mov->cuenta) &middot; {{ $mov->cuenta->nombre }} @endif
                            @if($mov->categoria) &middot; {{ $mov->categoria->nombre }} @endif
                        </div>
                    </div>
                    <div class="dv-activity-amount" style="color: {{ $tipoInfo['color'] }};">
                        {{ $tipoInfo['signo'] }}${{ number_format($mov->monto, 2) }}
                    </div>
                </div>
            @empty
                <div class="dv-empty">
                    <div class="dv-empty-icon">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/></svg>
                    </div>
                    Aún no tienes transacciones registradas.
                </div>
            @endforelse
        </div>

        <!-- ACCESOS RÁPIDOS -->
        <div class="dv-section-title"><h2>Accesos rápidos</h2><div class="dv-line"></div></div>
        <div class="dv-quicklinks">
            <a href="{{ route('cuentas.index') }}" class="dv-quicklink">
                <div class="dv-quicklink-icon">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                </div>
                <span class="dv-quicklink-label">Cuentas</span>
            </a>
            <a href="{{ route('categorias.index') }}" class="dv-quicklink">
                <div class="dv-quicklink-icon">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                </div>
                <span class="dv-quicklink-label">Categorías</span>
            </a>
            <a href="{{ route('transacciones.index') }}" class="dv-quicklink">
                <div class="dv-quicklink-icon">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/></svg>
                </div>
                <span class="dv-quicklink-label">Transacciones</span>
            </a>
            <a href="{{ route('transacciones.hoja-calculo') }}" class="dv-quicklink">
                <div class="dv-quicklink-icon">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2m6-2v2M3 9h18M5 9v12a2 2 0 002 2h10a2 2 0 002-2V9M5 9l1-2h12l1 2M7 13h2m4 0h2m4 0h2"/></svg>
                </div>
                <span class="dv-quicklink-label">Hoja Cálculo</span>
            </a>
            <a href="{{ route('numeros-whatsapp.index') }}" class="dv-quicklink">
                <div class="dv-quicklink-icon">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                </div>
                <span class="dv-quicklink-label">WhatsApp</span>
            </a>
            <a href="{{ route('chat.index') }}" class="dv-quicklink">
                <div class="dv-quicklink-icon">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                </div>
                <span class="dv-quicklink-label">Asesor IA</span>
            </a>
        </div>

    </div>
</x-app-layout>
