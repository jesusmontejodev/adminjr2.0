<x-app-layout>
    <div class="min-h-screen bg-gray-50 dark:bg-gray-900 transition-colors duration-300">
        <!-- Header Mejorado -->
        <div class="bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700 shadow-sm">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 sm:py-8">
                <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                    <div>
                        <div class="flex items-center gap-3 mb-2">
                            <div class="p-2 bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                                </svg>
                            </div>
                            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Analista de Datos</h1>
                        </div>
                        <p class="text-gray-600 dark:text-gray-400 text-sm">Visualiza y analiza tu información financiera en detalle</p>
                    </div>

                    <button onclick="exportarReporte()" class="flex items-center gap-2 px-4 py-2.5 bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white rounded-lg font-medium transition-all hover:shadow-lg">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        Exportar CSV
                    </button>
                </div>
            </div>
        </div>

        <!-- Filtros Mejorados -->
        <div class="bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700 sticky top-0 z-40 shadow-sm">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
                <div class="flex items-center gap-2 mb-4">
                    <svg class="w-5 h-5 text-gray-600 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                    </svg>
                    <h3 class="text-sm font-semibold text-gray-900 dark:text-white">Filtros</h3>
                </div>
                
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3">
                    <!-- Período -->
                    <div>
                        <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1.5">Período</label>
                        <select id="filtro-periodo" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition text-sm">
                            <option value="0">Todo el tiempo</option>
                            <option value="30">Últimos 30 días</option>
                            <option value="90">Últimos 90 días</option>
                            <option value="365">Último año</option>
                        </select>
                    </div>

                    <!-- Cuenta -->
                    <div>
                        <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1.5">Cuenta</label>
                        <select id="filtro-cuenta" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition text-sm">
                            <option value="">Todas las cuentas</option>
                        </select>
                    </div>

                    <!-- Botones -->
                    <div class="flex gap-2 sm:col-span-2 lg:col-span-2">
                        <button onclick="recargarDatos()" class="flex-1 flex items-center justify-center gap-2 px-3 py-2 bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white rounded-lg font-medium transition-all hover:shadow-md text-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9 8 8 0 113.01 15.1"/>
                            </svg>
                            Filtrar
                        </button>
                        <button onclick="resetFiltros()" class="flex-1 flex items-center justify-center gap-2 px-3 py-2 bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600 text-gray-900 dark:text-white rounded-lg font-medium transition text-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9 8 8 0 113.01 15.1"/>
                            </svg>
                            Resetear
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Contenido Principal -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

            <!-- KPIs -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <!-- Patrimonio Total -->
                <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm border border-gray-200 dark:border-gray-700 hover:shadow-md transition-all">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600 dark:text-gray-400 mb-1">Patrimonio Total</p>
                            <p class="text-2xl sm:text-3xl font-bold text-gray-900 dark:text-white" id="kpi-patrimonio">$0.00</p>
                        </div>
                        <div class="p-3 bg-blue-100 dark:bg-blue-900/30 rounded-lg">
                            <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Total Ingresos -->
                <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm border border-gray-200 dark:border-gray-700 hover:shadow-md transition-all">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600 dark:text-gray-400 mb-1">Total Ingresos</p>
                            <p class="text-2xl sm:text-3xl font-bold text-green-600 dark:text-green-400" id="kpi-ingresos">$0.00</p>
                        </div>
                        <div class="p-3 bg-green-100 dark:bg-green-900/30 rounded-lg">
                            <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Total Gastos -->
                <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm border border-gray-200 dark:border-gray-700 hover:shadow-md transition-all">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600 dark:text-gray-400 mb-1">Total Gastos</p>
                            <p class="text-2xl sm:text-3xl font-bold text-red-600 dark:text-red-400" id="kpi-gastos">$0.00</p>
                        </div>
                        <div class="p-3 bg-red-100 dark:bg-red-900/30 rounded-lg">
                            <svg class="w-6 h-6 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"/>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Balance -->
                <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm border border-gray-200 dark:border-gray-700 hover:shadow-md transition-all">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600 dark:text-gray-400 mb-1">Balance</p>
                            <p class="text-2xl sm:text-3xl font-bold text-purple-600 dark:text-purple-400" id="kpi-balance">$0.00</p>
                        </div>
                        <div class="p-3 bg-purple-100 dark:bg-purple-900/30 rounded-lg">
                            <svg class="w-6 h-6 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Gráficas Grid 1 -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
                <!-- Distribución por Categoría -->
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                        <div class="w-1 h-6 bg-gradient-to-b from-blue-500 to-blue-600 rounded"></div>
                        Distribución por Categoría
                    </h3>
                    <div style="height: 300px; position: relative;">
                        <div id="chart-categoria"></div>
                    </div>
                </div>

                <!-- Balance por Cuenta -->
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                        <div class="w-1 h-6 bg-gradient-to-b from-green-500 to-green-600 rounded"></div>
                        Balance por Cuenta
                    </h3>
                    <div style="height: 300px; position: relative;">
                        <div id="chart-cuentas"></div>
                    </div>
                </div>
            </div>

            <!-- Gráficas Grid 2 -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
                <!-- Tendencia Mensual -->
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                        <div class="w-1 h-6 bg-gradient-to-b from-purple-500 to-purple-600 rounded"></div>
                        Tendencia Mensual (12 meses)
                    </h3>
                    <div style="height: 300px; position: relative;">
                        <div id="chart-tendencia"></div>
                    </div>
                </div>

                <!-- Flujo de Caja -->
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                        <div class="w-1 h-6 bg-gradient-to-b from-orange-500 to-orange-600 rounded"></div>
                        Flujo de Caja (6 meses)
                    </h3>
                    <div style="height: 300px; position: relative;">
                        <div id="chart-flujo"></div>
                    </div>
                </div>
            </div>

            <!-- Gráficas Grid 3 -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
                <!-- Histórico -->
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                        <div class="w-1 h-6 bg-gradient-to-b from-cyan-500 to-cyan-600 rounded"></div>
                        Histórico de Saldo
                    </h3>
                    <div style="height: 300px; position: relative;">
                        <div id="chart-historico"></div>
                    </div>
                </div>

                <!-- Top Gastos -->
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                        <div class="w-1 h-6 bg-gradient-to-b from-rose-500 to-rose-600 rounded"></div>
                        Top 10 Gastos
                    </h3>
                    <div style="height: 300px; position: relative;">
                        <div id="chart-top"></div>
                    </div>
                </div>
            </div>

            <!-- Tabla de Transacciones -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 p-6 overflow-hidden">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    Últimas Transacciones
                </h3>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead class="border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-700/50">
                            <tr class="text-gray-700 dark:text-gray-300 font-semibold">
                                <th class="text-left px-4 py-3">Fecha</th>
                                <th class="text-left px-4 py-3">Cuenta</th>
                                <th class="text-left px-4 py-3">Categoría</th>
                                <th class="text-left px-4 py-3">Tipo</th>
                                <th class="text-right px-4 py-3">Monto</th>
                                <th class="text-left px-4 py-3">Descripción</th>
                            </tr>
                        </thead>
                        <tbody id="tabla-transacciones">
                            <tr class="text-gray-500 text-center">
                                <td colspan="6" class="py-8">Cargando transacciones...</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>

    <script src="https://unpkg.com/lightweight-charts@4/dist/lightweight-charts.production.min.js"></script>
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

        let datosActuales = null;

        document.addEventListener('DOMContentLoaded', async () => {
            // Cargar cuentas en el dropdown
            cargarCuentas();
            
            // Mostrar datos iniciales
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

                // Preparar parámetros
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
                alert('Error: ' + e.message);
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
                container.innerHTML = '<p class="text-gray-500 dark:text-gray-400 p-4 text-center">Sin datos</p>';
                return;
            }

            // Limpiar contenedor
            container.innerHTML = '';
            
            // Crear gráfico de tabla simple para categorías
            const table = document.createElement('div');
            table.className = 'space-y-2';
            
            const total = datos.reduce((sum, d) => sum + parseFloat(d.monto_total), 0);
            
            datos.forEach((item, idx) => {
                const porcentaje = (parseFloat(item.monto_total) / total * 100).toFixed(1);
                const colors = ['bg-blue-500', 'bg-red-500', 'bg-green-500', 'bg-purple-500', 'bg-yellow-500', 'bg-pink-500', 'bg-cyan-500', 'bg-orange-500'];
                
                const row = document.createElement('div');
                row.className = 'flex items-center justify-between';
                row.innerHTML = `
                    <div class="flex items-center gap-2 flex-1">
                        <div class="${colors[idx % colors.length]} w-3 h-3 rounded-full"></div>
                        <span class="text-sm text-gray-700 dark:text-gray-300 truncate">${item.categoria_nombre}</span>
                    </div>
                    <div class="text-right">
                        <div class="w-24 bg-gray-200 dark:bg-gray-700 rounded-full h-2 overflow-hidden">
                            <div class="${colors[idx % colors.length]} h-full rounded-full" style="width: ${porcentaje}%"></div>
                        </div>
                        <span class="text-xs text-gray-600 dark:text-gray-400">${porcentaje}%</span>
                    </div>
                `;
                table.appendChild(row);
            });
            
            container.appendChild(table);
        }

        function dibujarCuentas() {
            const container = document.getElementById('chart-cuentas');
            if (!container) return;
            
            const datos = datosActuales.por_cuenta || [];
            if (datos.length === 0) {
                container.innerHTML = '<p class="text-gray-500 dark:text-gray-400 p-4 text-center">Sin cuentas</p>';
                return;
            }

            container.innerHTML = '';
            const list = document.createElement('div');
            list.className = 'space-y-3';
            
            const maxSaldo = Math.max(...datos.map(d => parseFloat(d.saldo)));
            
            datos.forEach(item => {
                const porcentaje = (parseFloat(item.saldo) / maxSaldo * 100).toFixed(1);
                const isPositive = parseFloat(item.saldo) >= 0;
                
                const row = document.createElement('div');
                row.innerHTML = `
                    <div class="flex justify-between items-center mb-1">
                        <span class="text-sm font-medium text-gray-700 dark:text-gray-300">${item.cuenta_nombre}</span>
                        <span class="text-sm font-semibold ${isPositive ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400'}">$${parseMonto(item.saldo)}</span>
                    </div>
                    <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2 overflow-hidden">
                        <div class="bg-green-500 h-full rounded-full" style="width: ${porcentaje}%"></div>
                    </div>
                `;
                list.appendChild(row);
            });
            
            container.appendChild(list);
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
                color: '#ef4444',
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
                color: '#ef4444',
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
            if (datos.length === 0) return;

            container.innerHTML = '';
            const list = document.createElement('div');
            list.className = 'space-y-2';
            
            const maxMonto = Math.max(...datos.map(d => parseFloat(d.monto)));
            
            datos.forEach((item, idx) => {
                const porcentaje = (parseFloat(item.monto) / maxMonto * 100).toFixed(1);
                
                const row = document.createElement('div');
                row.className = 'flex items-center justify-between';
                row.innerHTML = `
                    <div class="flex-1 min-w-0">
                        <p class="text-xs text-gray-600 dark:text-gray-400 truncate">${item.descripcion.substring(0, 30)}</p>
                        <div class="mt-1 w-full bg-gray-200 dark:bg-gray-700 rounded-full h-1.5 overflow-hidden">
                            <div class="bg-rose-500 h-full rounded-full" style="width: ${porcentaje}%"></div>
                        </div>
                    </div>
                    <div class="text-right ml-2">
                        <span class="text-xs font-semibold text-rose-600 dark:text-rose-400">$${parseMonto(item.monto)}</span>
                    </div>
                `;
                list.appendChild(row);
            });
            
            container.appendChild(list);
        }

        function actualizarTabla() {
            const tbody = document.getElementById('tabla-transacciones');
            const txs = datosActuales.transacciones || [];
            
            if (!txs || txs.length === 0) {
                tbody.innerHTML = '<tr class="text-gray-500 dark:text-gray-400 text-center"><td colspan="6" class="py-8">Sin transacciones</td></tr>';
                return;
            }

            tbody.innerHTML = txs.map(tx => `
                <tr class="border-b border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                    <td class="px-4 py-3 text-gray-900 dark:text-gray-100">${tx.fecha}</td>
                    <td class="px-4 py-3 text-gray-700 dark:text-gray-300">${tx.cuenta?.nombre || '-'}</td>
                    <td class="px-4 py-3 text-gray-700 dark:text-gray-300">${tx.categoria?.nombre || '-'}</td>
                    <td class="px-4 py-3">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium ${
                            tx.tipo === 'ingreso' 
                                ? 'bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-300' 
                                : 'bg-red-100 dark:bg-red-900/30 text-red-800 dark:text-red-300'
                        }">
                            ${tx.tipo === 'ingreso' ? '↑' : '↓'} ${tx.tipo}
                        </span>
                    </td>
                    <td class="px-4 py-3 text-right font-semibold ${tx.tipo === 'ingreso' ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400'}">$${parseMonto(tx.monto)}</td>
                    <td class="px-4 py-3 text-gray-600 dark:text-gray-400 text-xs">${tx.descripcion || '-'}</td>
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
