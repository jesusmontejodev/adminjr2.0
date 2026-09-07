<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Cuentas') }}
        </h2>
    </x-slot>

    <div class="cuentas-view relative z-10 p-6 sm:p-10">

        <!-- HEADER -->
        <div class="cv-topbar">
            <div class="cv-title-row">
                <span class="cv-title-icon">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                    </svg>
                </span>
                <div>
                    <h1>Mis Cuentas</h1>
                    <div class="cv-title-sub">
                        {{ $cuentas->count() }} {{ $cuentas->count() === 1 ? 'cuenta registrada' : 'cuentas registradas' }}
                    </div>
                </div>
            </div>

            <a href="{{ route('cuentas.create') }}" class="cv-btn-new">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Nueva Cuenta
            </a>
        </div>

        @if($cuentas->isEmpty())
            <!-- ESTADO VACÍO -->
            <div class="cv-empty-preview">
                <div class="cv-empty-icon">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                    </svg>
                </div>
                <h3>Aún no tienes cuentas</h3>
                <p>Crea tu primera cuenta para empezar a registrar movimientos.</p>
                <a href="{{ route('cuentas.create') }}" class="cv-btn-new">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Crear mi primera cuenta
                </a>
            </div>
        @else
            @php
                $variacion = $saldoTotal - $saldoInicialTotal;
                $variacionPct = $saldoInicialTotal != 0 ? ($variacion / abs($saldoInicialTotal)) * 100 : null;
                $variacionPositiva = $variacion >= 0;
            @endphp

            <!-- RESUMEN -->
            <div class="cv-stats-grid">
                <div class="cv-stat-card cv-stat-card--hero" style="--cv-tile-border: var(--cv-hero-border); --cv-tile-soft: var(--cv-hero-soft); --cv-tile-color: var(--cv-hero);">
                    <div class="cv-stat-icon">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 2v20M17 6.5c0-2-2.5-3.5-5-3.5S7 4.5 7 6.5 9.5 9 12 9s5 1.5 5 3.5-2.5 3.5-5 3.5-5-1.5-5-3.5"/>
                        </svg>
                    </div>
                    <div>
                        <div class="cv-stat-label">Saldo Total</div>
                        <div class="cv-stat-value cv-display cv-stat-value--gradient">${{ number_format($saldoTotal, 2) }}</div>
                    </div>
                </div>

                <div class="cv-stat-card" style="--cv-tile-soft: var(--cv-accent-soft); --cv-tile-color: var(--cv-accent);">
                    <div class="cv-stat-icon">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div>
                        <div class="cv-stat-label">Cuentas Activas</div>
                        <div class="cv-stat-value cv-display">{{ $cuentasActivas }} <span style="font-size:14px;color:var(--cv-text-faint);font-weight:600;">/ {{ $cuentas->count() }}</span></div>
                    </div>
                </div>

                <div class="cv-stat-card" style="--cv-tile-soft: var({{ $variacionPositiva ? '--cv-success-soft' : '--cv-danger-soft' }}); --cv-tile-color: var({{ $variacionPositiva ? '--cv-success' : '--cv-danger' }});">
                    <div class="cv-stat-icon">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-9 9-4-4-6 6"/>
                        </svg>
                    </div>
                    <div>
                        <div class="cv-stat-label">Variación desde saldo inicial</div>
                        <div class="cv-stat-value cv-display cv-small" style="color: {{ $variacionPositiva ? 'var(--cv-success)' : 'var(--cv-danger)' }};">
                            {{ $variacionPositiva ? '+' : '-' }}${{ number_format(abs($variacion), 2) }}
                        </div>
                        @if($variacionPct !== null)
                            <div class="cv-stat-foot">{{ $variacionPct >= 0 ? '+' : '' }}{{ number_format($variacionPct, 1) }}% acumulado</div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- TOOLBAR -->
            <div class="cv-toolbar">
                <div class="cv-search-box">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/>
                    </svg>
                    <input type="text" id="cv-search" placeholder="Buscar cuenta por nombre...">
                </div>
                <div class="cv-sort-wrap">
                    <select id="cv-sort" class="cv-sort-select">
                        <option value="nombre">Nombre (A-Z)</option>
                        <option value="saldo-desc">Mayor saldo primero</option>
                        <option value="saldo-asc">Menor saldo primero</option>
                    </select>
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 9l6 6 6-6"/>
                    </svg>
                </div>
            </div>

            <!-- GRID DE CUENTAS -->
            <div class="cv-accounts-grid" id="cv-grid">
                @foreach ($cuentas as $cuenta)
                    @php
                        $diff = $cuenta->saldo_actual - $cuenta->saldo_inicial;
                        $pct = $cuenta->saldo_inicial != 0 ? ($diff / abs($cuenta->saldo_inicial)) * 100 : null;
                        $tieneMovimientos = $cuenta->transacciones_count > 0;
                    @endphp
                    <div class="cv-acc-card" data-nombre="{{ Str::lower($cuenta->nombre) }}" data-saldo="{{ $cuenta->saldo_actual }}">
                        <div class="cv-acc-head">
                            <div class="cv-acc-avatar">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 10h18M5 10V20h14V10M9 20V14h6v6M12 3l8 5H4l8-5z"/>
                                </svg>
                            </div>
                            <div style="min-width:0;">
                                <div class="cv-acc-name" title="{{ $cuenta->nombre }}">{{ $cuenta->nombre }}</div>
                                @if($cuenta->descripcion)
                                    <div class="cv-acc-desc" title="{{ $cuenta->descripcion }}">{{ $cuenta->descripcion }}</div>
                                @else
                                    <div class="cv-acc-desc cv-empty">Sin descripción</div>
                                @endif
                            </div>
                        </div>

                        <div class="cv-acc-balance-row">
                            <span class="cv-acc-balance cv-display {{ $cuenta->saldo_actual < 0 ? 'cv-negative' : '' }}">
                                {{ $cuenta->saldo_actual < 0 ? '-' : '' }}${{ number_format(abs($cuenta->saldo_actual), 2) }}
                            </span>
                        </div>

                        @if($diff == 0.0)
                            <span class="cv-delta-chip" style="--cv-chip-soft: var(--cv-surface-2); --cv-chip-color: var(--cv-text-faint);">
                                Sin cambios
                            </span>
                        @elseif($diff > 0)
                            <span class="cv-delta-chip">
                                <svg viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M14.707 12.707a1 1 0 01-1.414 0L10 9.414l-3.293 3.293a1 1 0 01-1.414-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 010 1.414z" clip-rule="evenodd"/></svg>
                                {{ $pct !== null ? '+' . number_format($pct, 1) . '% desde apertura' : '+$' . number_format($diff, 2) . ' desde apertura' }}
                            </span>
                        @else
                            <span class="cv-delta-chip" style="--cv-chip-soft: var(--cv-danger-soft); --cv-chip-color: var(--cv-danger);">
                                <svg viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/></svg>
                                {{ $pct !== null ? number_format($pct, 1) . '% desde apertura' : '-$' . number_format(abs($diff), 2) . ' desde apertura' }}
                            </span>
                        @endif

                        <div class="cv-acc-foot">
                            @if($tieneMovimientos)
                                <span class="cv-locked-note">
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0110 0v4"/></svg>
                                    Tiene movimientos
                                </span>
                            @else
                                <span></span>
                            @endif

                            <div class="cv-acc-foot-actions">
                                <a href="{{ route('cuentas.edit', $cuenta->id) }}" class="cv-icon-btn cv-edit" title="Editar">
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16.5 3.5a2.1 2.1 0 013 3L7 19l-4 1 1-4 12.5-12.5z"/>
                                    </svg>
                                </a>

                                @if($tieneMovimientos)
                                    <button type="button" class="cv-icon-btn cv-locked" title="No se puede eliminar: tiene movimientos" disabled>
                                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0110 0v4"/></svg>
                                    </button>
                                @else
                                    <form action="{{ route('cuentas.destroy', $cuenta->id) }}" method="POST"
                                          onsubmit="return confirm('¿Eliminar esta cuenta?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="cv-icon-btn cv-delete" title="Eliminar">
                                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6h18M8 6V4h8v2M6 6v14a2 2 0 002 2h8a2 2 0 002-2V6M10 11v6M14 11v6"/>
                                            </svg>
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="cv-no-results" id="cv-no-results" style="display:none;">
                Ninguna cuenta coincide con tu búsqueda.
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

            var searchInput = document.getElementById('cv-search');
            var sortSelect = document.getElementById('cv-sort');
            var grid = document.getElementById('cv-grid');
            var noResults = document.getElementById('cv-no-results');

            if (!grid) return;

            function applyFilter() {
                var term = (searchInput.value || '').toLowerCase().trim();
                var cards = grid.querySelectorAll('.cv-acc-card');
                var visibleCount = 0;

                cards.forEach(function (card) {
                    var matches = card.dataset.nombre.indexOf(term) !== -1;
                    card.classList.toggle('cv-hidden', !matches);
                    if (matches) visibleCount++;
                });

                noResults.style.display = visibleCount === 0 ? 'block' : 'none';
            }

            function applySort() {
                var cards = Array.prototype.slice.call(grid.querySelectorAll('.cv-acc-card'));
                var mode = sortSelect.value;

                cards.sort(function (a, b) {
                    if (mode === 'saldo-desc') {
                        return parseFloat(b.dataset.saldo) - parseFloat(a.dataset.saldo);
                    }
                    if (mode === 'saldo-asc') {
                        return parseFloat(a.dataset.saldo) - parseFloat(b.dataset.saldo);
                    }
                    return a.dataset.nombre.localeCompare(b.dataset.nombre);
                });

                cards.forEach(function (card) { grid.appendChild(card); });
            }

            if (searchInput) searchInput.addEventListener('input', applyFilter);
            if (sortSelect) sortSelect.addEventListener('change', applySort);
        });
    </script>
</x-app-layout>
