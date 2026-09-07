<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Analista de Datos') }}
        </h2>
    </x-slot>

    <div class="analistajr-view relative z-10 p-6 sm:p-10">

        <!-- HEADER -->
        <div class="av-topbar">
            <div class="av-title-row">
                <span class="av-title-icon">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                    </svg>
                </span>
                <div>
                    <h1>Analista de Datos</h1>
                    <div class="av-title-sub">Visualiza y analiza tu información financiera en detalle</div>
                </div>
            </div>

            <button onclick="exportarReporte()" class="av-btn-new">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                Exportar CSV
            </button>
        </div>

        <!-- FILTROS -->
        <div class="av-filters">
            <div class="av-filters-head">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                </svg>
                Filtros
            </div>

            <div class="av-filter-grid">
                <div class="av-field">
                    <label>Período</label>
                    <select id="filtro-periodo" class="av-select">
                        <option value="0">Todo el tiempo</option>
                        <option value="30">Últimos 30 días</option>
                        <option value="90">Últimos 90 días</option>
                        <option value="365">Último año</option>
                    </select>
                </div>

                <div class="av-field">
                    <label>Cuenta</label>
                    <select id="filtro-cuenta" class="av-select">
                        <option value="">Todas las cuentas</option>
                    </select>
                </div>

                <button onclick="recargarDatos()" class="av-btn-apply">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9 8 8 0 113.01 15.1"/>
                    </svg>
                    Filtrar
                </button>
                <button onclick="resetFiltros()" class="av-btn-reset">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9 8 8 0 113.01 15.1"/>
                    </svg>
                    Resetear
                </button>
            </div>
        </div>

        <!-- KPIS -->
        <div class="av-stats-grid">
            <div class="av-stat-card av-stat-card--hero" style="--av-tile-border: var(--av-hero-border); --av-tile-soft: var(--av-hero-soft); --av-tile-color: var(--av-hero);">
                <div class="av-stat-icon">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div>
                    <div class="av-stat-label">Patrimonio Total</div>
                    <div class="av-stat-value av-display av-stat-value--gradient" id="kpi-patrimonio">$0.00</div>
                </div>
            </div>

            <div class="av-stat-card" style="--av-tile-soft: var(--av-success-soft); --av-tile-color: var(--av-success);">
                <div class="av-stat-icon">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19V5m0 0l-6 6m6-6l6 6"/>
                    </svg>
                </div>
                <div>
                    <div class="av-stat-label">Total Ingresos</div>
                    <div class="av-stat-value av-display" id="kpi-ingresos" style="color: var(--av-success);">$0.00</div>
                </div>
            </div>

            <div class="av-stat-card" style="--av-tile-soft: var(--av-danger-soft); --av-tile-color: var(--av-danger);">
                <div class="av-stat-icon">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v14m0 0l-6-6m6 6l6-6"/>
                    </svg>
                </div>
                <div>
                    <div class="av-stat-label">Total Gastos</div>
                    <div class="av-stat-value av-display" id="kpi-gastos" style="color: var(--av-danger);">$0.00</div>
                </div>
            </div>

            <div class="av-stat-card" style="--av-tile-soft: var(--av-blue-soft); --av-tile-color: var(--av-blue);">
                <div class="av-stat-icon">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                    </svg>
                </div>
                <div>
                    <div class="av-stat-label">Balance</div>
                    <div class="av-stat-value av-display" id="kpi-balance" style="color: var(--av-blue);">$0.00</div>
                </div>
            </div>
        </div>

        <!-- GRÁFICAS GRID 1 -->
        <div class="av-charts-grid">
            <div class="av-chart-panel">
                <div class="av-chart-head">
                    <span class="av-chart-bar"></span>
                    <h3>Distribución por Categoría</h3>
                </div>
                <div class="av-chart-body"><div id="chart-categoria"></div></div>
            </div>

            <div class="av-chart-panel">
                <div class="av-chart-head">
                    <span class="av-chart-bar" style="background: var(--av-success);"></span>
                    <h3>Balance por Cuenta</h3>
                </div>
                <div class="av-chart-body"><div id="chart-cuentas"></div></div>
            </div>
        </div>

        <!-- GRÁFICAS GRID 2 -->
        <div class="av-charts-grid">
            <div class="av-chart-panel">
                <div class="av-chart-head">
                    <span class="av-chart-bar" style="background: var(--av-chart-4);"></span>
                    <h3>Tendencia Mensual (12 meses)</h3>
                </div>
                <div class="av-chart-body"><div id="chart-tendencia"></div></div>
            </div>

            <div class="av-chart-panel">
                <div class="av-chart-head">
                    <span class="av-chart-bar" style="background: var(--av-chart-5);"></span>
                    <h3>Flujo de Caja (6 meses)</h3>
                </div>
                <div class="av-chart-body"><div id="chart-flujo"></div></div>
            </div>
        </div>

        <!-- GRÁFICAS GRID 3 -->
        <div class="av-charts-grid">
            <div class="av-chart-panel">
                <div class="av-chart-head">
                    <span class="av-chart-bar" style="background: var(--av-chart-7);"></span>
                    <h3>Histórico de Saldo</h3>
                </div>
                <div class="av-chart-body"><div id="chart-historico"></div></div>
            </div>

            <div class="av-chart-panel">
                <div class="av-chart-head">
                    <span class="av-chart-bar" style="background: var(--av-accent);"></span>
                    <h3>Top 10 Gastos</h3>
                </div>
                <div class="av-chart-body"><div id="chart-top"></div></div>
            </div>
        </div>

        <!-- TABLA -->
        <div class="av-table-panel">
            <div class="av-table-head">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                <h3>Últimas Transacciones</h3>
            </div>
            <div class="av-table-scroll">
                <table class="av-table">
                    <thead>
                        <tr>
                            <th>Fecha</th>
                            <th>Cuenta</th>
                            <th>Categoría</th>
                            <th>Tipo</th>
                            <th class="av-right">Monto</th>
                            <th>Descripción</th>
                        </tr>
                    </thead>
                    <tbody id="tabla-transacciones">
                        <tr><td colspan="6" class="av-empty-row">Cargando transacciones...</td></tr>
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    <script src="https://unpkg.com/lightweight-charts@4.2.3/dist/lightweight-charts.standalone.production.js"></script>
    <script>
        // Datos del servidor (renderizados directamente desde Laravel)
        const datosServidor = {!! json_encode([
            'resumen' => $resumen,
            'por_categoria' => $por_categoria,
            'por_cuenta' => $por_cuenta,
            'tendencia_mensual' => $tendencia_mensual,
            'flujo_caja' => $flujo_caja,
            'historico_saldo' => $historico_saldo,
            'top_gastos' => $top_gastos,
            'transacciones' => $transacciones,
            'cuentas' => $cuentas
        ]) !!};

        const CHART_COLORS = ['#d7263d', '#2563eb', '#16a34a', '#9333ea', '#d97706', '#db2777', '#0891b2', '#ea580c'];

        let datosActuales = null;

        document.addEventListener('DOMContentLoaded', async () => {
            cargarCuentas();
            datosActuales = datosServidor;
            actualizarUI();
        });

        function cargarCuentas() {
            const select = document.getElementById('filtro-cuenta');
            datosServidor.cuentas.forEach(c => {
                const opt = document.createElement('option');
                opt.value = c.id;
                opt.textContent = c.nombre;
                select.appendChild(opt);
            });
        }

        async function recargarDatos() {
            try {
                const periodo = parseInt(document.getElementById('filtro-periodo').value);
                const cuenta_id = document.getElementById('filtro-cuenta').value;

                const params = new URLSearchParams();
                if (periodo > 0) params.append('dias', periodo);
                if (cuenta_id) params.append('cuenta_id', cuenta_id);

                const url = '/api/analistajr/datos?' + params.toString();

                const res = await fetch(url);
                if (!res.ok) throw new Error('Error en respuesta');

                datosActuales = await res.json();
                if (!datosActuales.success) throw new Error(datosActuales.error);

                actualizarUI();

            } catch (e) {
                console.error('Error al filtrar:', e);
                if (typeof showToast === 'function') {
                    showToast('Error: ' + e.message, 'error');
                } else {
                    alert('Error: ' + e.message);
                }
            }
        }

        function actualizarUI() {
            actualizarKPIs();
            dibujarGraficas();
            actualizarTabla();
        }

        function actualizarKPIs() {
            const r = datosActuales.resumen;
            document.getElementById('kpi-patrimonio').textContent = '$' + parseMonto(r.patrimonio_total);
            document.getElementById('kpi-ingresos').textContent = '$' + parseMonto(r.total_ingresos);
            document.getElementById('kpi-gastos').textContent = '$' + parseMonto(r.total_gastos);
            document.getElementById('kpi-balance').textContent = '$' + parseMonto(r.balance);
        }

        function dibujarGraficas() {
            dibujarCategoria();
            dibujarCuentas();
            dibujarTendencia();
            dibujarFlujo();
            dibujarHistorico();
            dibujarTop();
        }

        function dibujarCategoria() {
            const container = document.getElementById('chart-categoria');
            if (!container) return;

            const datos = datosActuales.por_categoria || [];
            if (datos.length === 0) {
                container.innerHTML = '<p class="av-empty-mini">Sin datos</p>';
                return;
            }

            container.innerHTML = '';

            const total = datos.reduce((sum, d) => sum + parseFloat(d.monto_total), 0);

            datos.forEach((item, idx) => {
                const porcentaje = (parseFloat(item.monto_total) / total * 100).toFixed(1);
                const color = CHART_COLORS[idx % CHART_COLORS.length];

                const row = document.createElement('div');
                row.className = 'av-bar-row';
                row.innerHTML = `
                    <div class="av-bar-label">
                        <span class="av-bar-dot" style="background:${color};"></span>
                        <span class="av-bar-name">${item.categoria_nombre}</span>
                    </div>
                    <div style="display:flex; align-items:center;">
                        <div class="av-bar-track"><div class="av-bar-fill" style="width:${porcentaje}%; background:${color};"></div></div>
                        <span class="av-bar-pct">${porcentaje}%</span>
                    </div>
                `;
                container.appendChild(row);
            });
        }

        function dibujarCuentas() {
            const container = document.getElementById('chart-cuentas');
            if (!container) return;

            const datos = datosActuales.por_cuenta || [];
            if (datos.length === 0) {
                container.innerHTML = '<p class="av-empty-mini">Sin cuentas</p>';
                return;
            }

            container.innerHTML = '';

            const maxSaldo = Math.max(...datos.map(d => parseFloat(d.saldo)));

            datos.forEach(item => {
                const porcentaje = (parseFloat(item.saldo) / maxSaldo * 100).toFixed(1);
                const isPositive = parseFloat(item.saldo) >= 0;

                const row = document.createElement('div');
                row.className = 'av-acc-row';
                row.innerHTML = `
                    <div class="av-acc-head">
                        <span class="av-acc-name">${item.cuenta_nombre}</span>
                        <span class="av-acc-amount" style="color:${isPositive ? 'var(--av-success)' : 'var(--av-danger)'};">$${parseMonto(item.saldo)}</span>
                    </div>
                    <div class="av-acc-track"><div class="av-acc-fill" style="width:${porcentaje}%;"></div></div>
                `;
                container.appendChild(row);
            });
        }

        function dibujarTendencia() {
            const container = document.getElementById('chart-tendencia');
            if (!container) return;

            const datos = datosActuales.tendencia_mensual || [];
            if (datos.length === 0) return;

            container.innerHTML = '';
            const chart = LightweightCharts.createChart(container, {
                layout: {
                    textColor: document.documentElement.classList.contains('dark') ? '#d1d5db' : '#374151',
                    background: { type: 'solid', color: 'transparent' }
                },
                timeScale: { timeVisible: true, secondsVisible: false },
                height: 300
            });

            const ingresosSeries = chart.addLineSeries({
                color: '#10b981',
                lineWidth: 2,
                title: 'Ingresos'
            });

            const gastosSeries = chart.addLineSeries({
                color: '#ed465c',
                lineWidth: 2,
                title: 'Gastos'
            });

            const ingresosData = datos.map((d, i) => ({
                time: i,
                value: parseFloat(d.ingresos) || 0
            }));

            const gastosData = datos.map((d, i) => ({
                time: i,
                value: parseFloat(d.gastos) || 0
            }));

            ingresosSeries.setData(ingresosData);
            gastosSeries.setData(gastosData);

            chart.timeScale().fitContent();
        }

        function dibujarFlujo() {
            const container = document.getElementById('chart-flujo');
            if (!container) return;

            const datos = datosActuales.flujo_caja || [];
            if (datos.length === 0) return;

            container.innerHTML = '';
            const chart = LightweightCharts.createChart(container, {
                layout: {
                    textColor: document.documentElement.classList.contains('dark') ? '#d1d5db' : '#374151',
                    background: { type: 'solid', color: 'transparent' }
                },
                height: 300
            });

            const entradasSeries = chart.addHistogramSeries({
                color: '#10b981',
                title: 'Entradas'
            });

            const salidasSeries = chart.addHistogramSeries({
                color: '#ed465c',
                title: 'Salidas'
            });

            const entradasData = datos.map((d, i) => ({
                time: i,
                value: parseFloat(d.entradas) || 0
            }));

            const salidasData = datos.map((d, i) => ({
                time: i,
                value: parseFloat(d.salidas) || 0
            }));

            entradasSeries.setData(entradasData);
            salidasSeries.setData(salidasData);
        }

        function dibujarHistorico() {
            const container = document.getElementById('chart-historico');
            if (!container) return;

            const datos = datosActuales.historico_saldo || [];
            if (datos.length === 0) return;

            container.innerHTML = '';
            const chart = LightweightCharts.createChart(container, {
                layout: {
                    textColor: document.documentElement.classList.contains('dark') ? '#d1d5db' : '#374151',
                    background: { type: 'solid', color: 'transparent' }
                },
                timeScale: { timeVisible: true, secondsVisible: false },
                height: 300
            });

            const saldoSeries = chart.addLineSeries({
                color: '#3b82f6',
                lineWidth: 2,
                title: 'Saldo'
            });

            const saldoData = datos.map((d, i) => ({
                time: i,
                value: parseFloat(d.saldo) || 0
            }));

            saldoSeries.setData(saldoData);
            chart.timeScale().fitContent();
        }

        function dibujarTop() {
            const container = document.getElementById('chart-top');
            if (!container) return;

            const datos = datosActuales.top_gastos || [];
            if (datos.length === 0) {
                container.innerHTML = '<p class="av-empty-mini">Sin datos</p>';
                return;
            }

            container.innerHTML = '';

            const maxMonto = Math.max(...datos.map(d => parseFloat(d.monto)));

            datos.forEach((item) => {
                const porcentaje = (parseFloat(item.monto) / maxMonto * 100).toFixed(1);

                const row = document.createElement('div');
                row.className = 'av-top-row';
                row.innerHTML = `
                    <div class="av-top-info">
                        <p class="av-top-desc">${item.descripcion.substring(0, 30)}</p>
                        <div class="av-top-track"><div class="av-top-fill" style="width:${porcentaje}%;"></div></div>
                    </div>
                    <span class="av-top-amount">$${parseMonto(item.monto)}</span>
                `;
                container.appendChild(row);
            });
        }

        function actualizarTabla() {
            const tbody = document.getElementById('tabla-transacciones');
            const txs = datosActuales.transacciones || [];

            if (!txs || txs.length === 0) {
                tbody.innerHTML = '<tr><td colspan="6" class="av-empty-row">Sin transacciones</td></tr>';
                return;
            }

            tbody.innerHTML = txs.map(tx => `
                <tr>
                    <td>${tx.fecha}</td>
                    <td class="av-muted">${tx.cuenta?.nombre || '-'}</td>
                    <td class="av-muted">${tx.categoria?.nombre || '-'}</td>
                    <td>
                        <span class="av-chip" style="--av-chip-soft: ${tx.tipo === 'ingreso' ? 'var(--av-success-soft)' : 'var(--av-danger-soft)'}; --av-chip-color: ${tx.tipo === 'ingreso' ? 'var(--av-success)' : 'var(--av-danger)'};">
                            ${tx.tipo === 'ingreso' ? '↑' : '↓'} ${tx.tipo}
                        </span>
                    </td>
                    <td class="av-right" style="font-weight:700; color:${tx.tipo === 'ingreso' ? 'var(--av-success)' : 'var(--av-danger)'};">$${parseMonto(tx.monto)}</td>
                    <td class="av-muted">${tx.descripcion || '-'}</td>
                </tr>
            `).join('');
        }

        function parseMonto(n) {
            return parseFloat(n || 0).toFixed(2);
        }

        function resetFiltros() {
            document.getElementById('filtro-periodo').value = '0';
            document.getElementById('filtro-cuenta').value = '';
            datosActuales = datosServidor;
            actualizarUI();
        }

        function exportarReporte() {
            const periodo = document.getElementById('filtro-periodo').value;
            const url = '/api/analistajr/exportar?periodo=' + periodo;
            window.location.href = url;
        }
    </script>
</x-app-layout>
