class DashboardFinanciero {
    constructor() {
        this.datos = {};
        this.datosFiltrados = [];
        this.filtros = {
            fecha: { desde: null, hasta: null },
            tipo: 'todos',
            cuenta: 'todas',
            excluirCuentas: [] // Nuevo filtro para excluir cuentas
        };
        this.charts = {};
        this.inicializar();
    }

    async inicializar() {
        this.mostrarLoading(true);
        await this.cargarDatos();
        this.inicializarEventos();
        this.inicializarTabs();
        this.mostrarLoading(false);
    }

    async cargarDatos() {
        try {
            const response = await fetch('/api/transacciones/graficos/datos');
            if (!response.ok) throw new Error('Error al cargar datos');

            const data = await response.json();
            if (!data.success) throw new Error(data.error || 'Error en formato de datos');

            this.datos = data;
            this.datosFiltrados = data.transacciones || [];
            this.mostrarResumen();

        } catch (error) {
            this.mostrarError('Error al cargar datos: ' + error.message);
            console.error('Error:', error);
        }
    }

    inicializarEventos() {
        // Filtros
        document.getElementById('btn-aplicar-filtros').addEventListener('click', () => this.aplicarFiltros());
        document.getElementById('btn-limpiar-filtros').addEventListener('click', () => this.limpiarFiltros());

        // Manejar la selección de "Ninguna" en excluir cuentas
        document.getElementById('filtro-excluir-cuentas').addEventListener('change', (e) => {
            this.manejarSeleccionExcluirCuentas(e);
        });

        // Intervalo del gráfico
        document.getElementById('chart-interval')?.addEventListener('change', (e) => {
            this.actualizarGraficoFlujo();
        });

        // Responsive charts
        window.addEventListener('resize', () => {
            if (this.charts.flujo && this.charts.flujo.resize) {
                const container = document.getElementById('chart-container');
                if (container) {
                    this.charts.flujo.resize(container.clientWidth, 400);
                }
            }
        });
    }

    manejarSeleccionExcluirCuentas(e) {
        const select = e.target;
        const opciones = Array.from(select.options);
        const opcionNinguna = opciones.find(opt => opt.value === 'ninguna');
        const opcionesSeleccionadas = opciones.filter(opt => opt.selected);

        // Si se selecciona "Ninguna", deseleccionar todo lo demás
        if (opcionesSeleccionadas.some(opt => opt.value === 'ninguna')) {
            opciones.forEach(opt => {
                if (opt.value !== 'ninguna') {
                    opt.selected = false;
                }
            });
        }
        // Si se selecciona cualquier otra cuenta, deseleccionar "Ninguna"
        else if (opcionesSeleccionadas.length > 0 && opcionNinguna.selected) {
            opcionNinguna.selected = false;
        }
    }

    inicializarTabs() {
        document.querySelectorAll('.tab-button').forEach(button => {
            button.addEventListener('click', (e) => {
                const tabId = e.currentTarget.dataset.tab;
                this.cambiarTab(tabId);
            });
        });
    }

    cambiarTab(tabId) {
        // Actualizar botones
        document.querySelectorAll('.tab-button').forEach(btn => {
            btn.classList.remove('active', 'border-blue-500', 'text-blue-600', 'dark:text-blue-400');
            btn.classList.add('border-transparent', 'text-gray-500', 'dark:text-gray-400');
        });

        // Activar botón actual
        const activeBtn = document.querySelector(`[data-tab="${tabId}"]`);
        activeBtn.classList.add('active', 'border-blue-500', 'text-blue-600', 'dark:text-blue-400');
        activeBtn.classList.remove('border-transparent', 'text-gray-500', 'dark:text-gray-400');

        // Ocultar todos los contenidos
        document.querySelectorAll('.tab-content').forEach(content => {
            content.classList.add('hidden');
        });

        // Mostrar contenido actual
        document.getElementById(`content-${tabId}`).classList.remove('hidden');

        // Cargar contenido específico
        this.cargarContenidoTab(tabId);
    }

    cargarContenidoTab(tabId) {
        switch(tabId) {
            case 'resumen':
                this.mostrarResumen();
                break;
            case 'flujo':
                this.mostrarFlujo();
                break;
        }
    }

    aplicarFiltros() {
        const desde = document.getElementById('filtro-desde').value;
        const hasta = document.getElementById('filtro-hasta').value;
        const tipo = document.getElementById('filtro-tipo').value;
        const cuenta = document.getElementById('filtro-cuenta').value;

        // Obtener cuentas a excluir
        const excluirCuentasSelect = document.getElementById('filtro-excluir-cuentas');
        const excluirCuentas = Array.from(excluirCuentasSelect.selectedOptions)
            .map(option => option.value)
            .filter(value => value !== 'ninguna');

        console.log('Aplicando filtros:', { desde, hasta, tipo, cuenta, excluirCuentas });

        // Actualizar filtros
        this.filtros = {
            fecha: { desde, hasta },
            tipo: tipo,
            cuenta: cuenta,
            excluirCuentas: excluirCuentas
        };

        // Aplicar filtros a los datos
        this.aplicarFiltrosADatos();

        // Actualizar la vista actual
        this.actualizarVistaActual();
        this.mostrarExito('Filtros aplicados correctamente');
    }

    aplicarFiltrosADatos() {
        let datosFiltrados = this.datos.transacciones || [];

        // Filtrar por fecha
        if (this.filtros.fecha.desde) {
            datosFiltrados = datosFiltrados.filter(transaccion => {
                return new Date(transaccion.fecha) >= new Date(this.filtros.fecha.desde);
            });
        }

        if (this.filtros.fecha.hasta) {
            datosFiltrados = datosFiltrados.filter(transaccion => {
                return new Date(transaccion.fecha) <= new Date(this.filtros.fecha.hasta);
            });
        }

        // Filtrar por tipo
        if (this.filtros.tipo !== 'todos') {
            datosFiltrados = datosFiltrados.filter(transaccion => {
                return transaccion.tipo === this.filtros.tipo;
            });
        }

        // Filtrar por cuenta (incluir)
        if (this.filtros.cuenta !== 'todas') {
            datosFiltrados = datosFiltrados.filter(transaccion => {
                return transaccion.cuenta_id == this.filtros.cuenta ||
                    transaccion.cuenta?.id == this.filtros.cuenta;
            });
        }

        // Filtrar excluyendo cuentas específicas (nueva funcionalidad)
        if (this.filtros.excluirCuentas.length > 0) {
            datosFiltrados = datosFiltrados.filter(transaccion => {
                const cuentaId = transaccion.cuenta_id?.toString() || transaccion.cuenta?.id?.toString();
                return !this.filtros.excluirCuentas.includes(cuentaId);
            });
        }

        this.datosFiltrados = datosFiltrados;
        console.log('Datos después de filtrar:', this.datosFiltrados.length, 'transacciones');
    }

    limpiarFiltros() {
        document.getElementById('filtro-desde').value = '';
        document.getElementById('filtro-hasta').value = '';
        document.getElementById('filtro-tipo').value = 'todos';
        document.getElementById('filtro-cuenta').value = 'todas';

        // Limpiar selección de excluir cuentas
        const excluirCuentasSelect = document.getElementById('filtro-excluir-cuentas');
        Array.from(excluirCuentasSelect.options).forEach(option => {
            option.selected = option.value === 'ninguna';
        });

        this.filtros = {
            fecha: { desde: null, hasta: null },
            tipo: 'todos',
            cuenta: 'todas',
            excluirCuentas: []
        };

        // Restaurar datos originales
        this.datosFiltrados = this.datos.transacciones || [];

        this.actualizarVistaActual();
        this.mostrarExito('Filtros limpiados correctamente');
    }

    mostrarResumen() {
        const content = document.getElementById('content-resumen');

        // Calcular estadísticas con datos filtrados
        const estadisticas = this.calcularEstadisticas();

        // Calcular cuentas incluidas
        const cuentasIncluidas = this.obtenerCuentasIncluidas();
        const totalCuentasIncluidas = cuentasIncluidas.length;
        const totalCuentasExcluidas = this.filtros.excluirCuentas.length;

        const kpis = [
            {
                title: 'Patrimonio Total',
                value: `$${this.calcularPatrimonioTotal().toLocaleString()}`,
                border: 'border-blue-500',
                trend: this.calcularCrecimientoPatrimonio(),
                subtitle: `${totalCuentasIncluidas} cuentas incluidas${totalCuentasExcluidas > 0 ? ` (${totalCuentasExcluidas} excluidas)` : ''}`
            },
            {
                title: 'Ingresos Filtrados',
                value: `$${estadisticas.totalIngresos.toLocaleString()}`,
                border: 'border-green-500',
                trend: { valor: 0, positivo: true },
                subtitle: `${estadisticas.transaccionesIngresos} transacciones`
            },
            {
                title: 'Gastos Filtrados',
                value: `$${estadisticas.totalGastos.toLocaleString()}`,
                border: 'border-red-500',
                trend: { valor: 0, positivo: false },
                subtitle: `${estadisticas.transaccionesGastos} transacciones`
            },
            {
                title: 'Balance Filtrado',
                value: `$${estadisticas.balance.toLocaleString()}`,
                border: estadisticas.balance >= 0 ? 'border-green-500' : 'border-red-500',
                trend: { valor: Math.abs(estadisticas.balance), positivo: estadisticas.balance >= 0 },
                subtitle: estadisticas.balance >= 0 ? 'Superávit' : 'Déficit'
            }
        ];

        content.innerHTML = `
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
                ${kpis.map(kpi => `
                    <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md border-l-4 ${kpi.border} border border-gray-200 dark:border-gray-700">
                        <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-300">${kpi.title}</h3>
                        <p class="text-3xl font-bold text-gray-900 dark:text-white mt-2">${kpi.value}</p>
                        <p class="text-sm ${kpi.trend.positivo ? 'text-green-500' : 'text-red-500'} mt-1">
                            ${kpi.trend.positivo ? '↗' : '↘'}
                            ${kpi.trend.valor > 0 ? `$${kpi.trend.valor.toLocaleString()}` : ''}
                        </p>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">${kpi.subtitle}</p>
                    </div>
                `).join('')}
            </div>
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md border border-gray-200 dark:border-gray-700">
                    <h3 class="text-lg font-semibold mb-4 text-gray-900 dark:text-white">Últimas Transacciones</h3>
                    <div id="ultimas-transacciones"></div>
                </div>
                <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md border border-gray-200 dark:border-gray-700">
                    <h3 class="text-lg font-semibold mb-4 text-gray-900 dark:text-white">Resumen por Tipo</h3>
                    <div id="resumen-tipos"></div>
                </div>
            </div>
        `;

        this.mostrarUltimasTransacciones();
        this.mostrarResumenTipos(estadisticas);
    }

    calcularEstadisticas() {
        const transaccionesIngresos = this.datosFiltrados.filter(t => t.tipo === 'ingreso');
        const transaccionesGastos = this.datosFiltrados.filter(t => t.tipo === 'gasto');

        const totalIngresos = transaccionesIngresos.reduce((sum, t) => sum + parseFloat(t.monto), 0);
        const totalGastos = transaccionesGastos.reduce((sum, t) => sum + parseFloat(t.monto), 0);
        const balance = totalIngresos - totalGastos;

        return {
            totalIngresos,
            totalGastos,
            balance,
            transaccionesIngresos: transaccionesIngresos.length,
            transaccionesGastos: transaccionesGastos.length,
            totalTransacciones: this.datosFiltrados.length
        };
    }

    obtenerCuentasIncluidas() {
        if (!this.datos.cuentas) return [];

        return this.datos.cuentas.filter(cuenta =>
            !this.filtros.excluirCuentas.includes(cuenta.id.toString())
        );
    }

    calcularPatrimonioTotal() {
        const cuentasIncluidas = this.obtenerCuentasIncluidas();
        return cuentasIncluidas.reduce((total, cuenta) =>
            total + parseFloat(cuenta.saldo_actual), 0
        ) || 0;
    }

    calcularCrecimientoPatrimonio() {
        const cuentasIncluidas = this.obtenerCuentasIncluidas();

        const totalActual = cuentasIncluidas.reduce((total, cuenta) =>
            total + parseFloat(cuenta.saldo_actual), 0
        );

        const totalInicial = cuentasIncluidas.reduce((total, cuenta) =>
            total + parseFloat(cuenta.saldo_inicial), 0
        );

        return {
            valor: totalActual - totalInicial,
            positivo: totalActual >= totalInicial
        };
    }

    mostrarUltimasTransacciones() {
        const contenedor = document.getElementById('ultimas-transacciones');
        if (!contenedor) return;

        // Ordenar por fecha descendente y tomar las últimas 5
        const transacciones = [...this.datosFiltrados]
            .sort((a, b) => new Date(b.fecha) - new Date(a.fecha))
            .slice(0, 5);

        let html = '<div class="space-y-3">';

        if (transacciones.length === 0) {
            html = '<p class="text-gray-500 dark:text-gray-400 text-center py-4">No hay transacciones que coincidan con los filtros</p>';
        } else {
            transacciones.forEach(transaccion => {
                html += `
                    <div class="flex items-center justify-between p-3 border border-gray-200 dark:border-gray-600 rounded-lg">
                        <div class="flex-1">
                            <div class="font-medium text-gray-900 dark:text-white">${transaccion.descripcion}</div>
                            <div class="text-sm text-gray-500 dark:text-gray-400">
                                ${new Date(transaccion.fecha).toLocaleDateString()} •
                                ${transaccion.categoria?.nombre || 'Sin categoría'}
                            </div>
                        </div>
                        <div class="text-right">
                            <div class="font-bold ${transaccion.tipo === 'ingreso' ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400'}">
                                $${parseFloat(transaccion.monto).toLocaleString()}
                            </div>
                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium ${
                                transaccion.tipo === 'ingreso' ?
                                'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300' :
                                'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300'
                            }">
                                ${transaccion.tipo}
                            </span>
                        </div>
                    </div>
                `;
            });
        }

        html += '</div>';
        contenedor.innerHTML = html;
    }

    mostrarResumenTipos(estadisticas) {
        const contenedor = document.getElementById('resumen-tipos');
        if (!contenedor) return;

        const { totalIngresos, totalGastos, balance, transaccionesIngresos, transaccionesGastos } = estadisticas;

        const html = `
            <div class="space-y-4">
                <div class="grid grid-cols-2 gap-4">
                    <div class="bg-green-50 dark:bg-green-900/20 p-4 rounded-lg border border-green-200 dark:border-green-800">
                        <div class="text-green-600 dark:text-green-400 font-bold text-lg">$${totalIngresos.toLocaleString()}</div>
                        <div class="text-green-500 dark:text-green-300 text-sm">Ingresos</div>
                        <div class="text-xs text-green-400 dark:text-green-200">${transaccionesIngresos} transacciones</div>
                    </div>
                    <div class="bg-red-50 dark:bg-red-900/20 p-4 rounded-lg border border-red-200 dark:border-red-800">
                        <div class="text-red-600 dark:text-red-400 font-bold text-lg">$${totalGastos.toLocaleString()}</div>
                        <div class="text-red-500 dark:text-red-300 text-sm">Gastos</div>
                        <div class="text-xs text-red-400 dark:text-red-200">${transaccionesGastos} transacciones</div>
                    </div>
                </div>
                <div class="bg-${balance >= 0 ? 'green' : 'red'}-50 dark:bg-${balance >= 0 ? 'green' : 'red'}-900/20 p-4 rounded-lg border border-${balance >= 0 ? 'green' : 'red'}-200 dark:border-${balance >= 0 ? 'green' : 'red'}-800">
                    <div class="text-${balance >= 0 ? 'green' : 'red'}-600 dark:text-${balance >= 0 ? 'green' : 'red'}-400 font-bold text-lg">$${Math.abs(balance).toLocaleString()}</div>
                    <div class="text-${balance >= 0 ? 'green' : 'red'}-500 dark:text-${balance >= 0 ? 'green' : 'red'}-300 text-sm">${balance >= 0 ? 'Superávit' : 'Déficit'}</div>
                </div>
            </div>
        `;

        contenedor.innerHTML = html;
    }

    mostrarFlujo() {
        this.inicializarGraficoFlujo();
    }

    inicializarGraficoFlujo() {
        const contenedor = document.getElementById('chart-container');
        if (!contenedor || !window.LightweightCharts) return;

        // Limpiar gráfico anterior
        if (this.charts.flujo) {
            this.charts.flujo.remove();
        }

        const datos = this.procesarDatosParaGrafico();
        const isDarkMode = document.documentElement.classList.contains('dark');

        const chart = LightweightCharts.createChart(contenedor, {
            width: contenedor.clientWidth,
            height: 400,
            layout: {
                backgroundColor: isDarkMode ? '#1f2937' : '#ffffff',
                textColor: isDarkMode ? '#000000ff' : '#374151',
            },
            grid: {
                vertLines: { color: isDarkMode ? '#374151' : '#e5e7eb' },
                horzLines: { color: isDarkMode ? '#374151' : '#e5e7eb' },
            },
            timeScale: {
                timeVisible: true,
                secondsVisible: false,
            }
        });

        const series = chart.addAreaSeries({
            topColor: isDarkMode ? 'rgba(59, 130, 246, 0.4)' : 'rgba(59, 130, 246, 0.3)',
            bottomColor: isDarkMode ? 'rgba(59, 130, 246, 0.1)' : 'rgba(59, 130, 246, 0.05)',
            lineColor: 'rgba(59, 130, 246, 1)',
            lineWidth: 2,
        });

        series.setData(datos);
        chart.timeScale().fitContent();

        this.charts.flujo = chart;
    }

    procesarDatosParaGrafico() {
        const transaccionesPorFecha = {};

        this.datosFiltrados.forEach(transaccion => {
            try {
                const fecha = transaccion.fecha.split('T')[0];
                const monto = parseFloat(transaccion.monto);

                if (!transaccionesPorFecha[fecha]) {
                    transaccionesPorFecha[fecha] = 0;
                }
                transaccionesPorFecha[fecha] += transaccion.tipo === 'ingreso' ? monto : -monto;
            } catch (error) {
                console.warn('Transacción ignorada:', error.message, transaccion);
            }
        });

        return Object.entries(transaccionesPorFecha)
            .map(([time, value]) => ({
                time,
                value: parseFloat(value.toFixed(2))
            }))
            .sort((a, b) => a.time.localeCompare(b.time));
    }

    actualizarVistaActual() {
        const activeTab = document.querySelector('.tab-button.active').dataset.tab;
        this.cargarContenidoTab(activeTab);
    }

    mostrarLoading(mostrar) {
        const loading = document.getElementById('loading-state');
        loading.classList.toggle('hidden', !mostrar);
    }

    mostrarError(mensaje) {
        this.mostrarEstado(mensaje, 'error');
    }

    mostrarExito(mensaje) {
        this.mostrarEstado(mensaje, 'success');
    }

    mostrarEstado(mensaje, tipo = 'info') {
        const estado = document.getElementById('estado');
        const colores = {
            error: 'text-red-600 bg-red-50 border-red-200 dark:bg-red-900/20 dark:border-red-800',
            success: 'text-green-600 bg-green-50 border-green-200 dark:bg-green-900/20 dark:border-green-800',
            info: 'text-blue-600 bg-blue-50 border-blue-200 dark:bg-blue-900/20 dark:border-blue-800'
        };

        estado.innerHTML = `
            <div class="inline-flex items-center px-4 py-3 rounded-lg border ${colores[tipo]}">
                <span class="mr-2">${tipo === 'error' ? '❌' : tipo === 'success' ? '✅' : 'ℹ️'}</span>
                ${mensaje}
            </div>
        `;
        estado.classList.remove('hidden');

        setTimeout(() => {
            estado.classList.add('hidden');
        }, 5000);
    }

    actualizarGraficoFlujo() {
        // Re-inicializar gráfico con nuevo intervalo
        this.inicializarGraficoFlujo();
    }
}

// Inicialización cuando el DOM esté listo
document.addEventListener('DOMContentLoaded', () => {
    window.dashboard = new DashboardFinanciero();
});
