<x-app-layout>
    <div class="container mx-auto p-6 text-gray-100">
        <!-- Navegación por Tabs -->
        <div class="border-b border-gray-700 mb-6">
            <nav class="-mb-px flex space-x-8">
                <button data-tab="resumen" class="tab-button active border-blue-500 text-blue-400 whitespace-nowrap border-b-2 py-4 px-1 text-sm font-medium transition-colors duration-200">
                    📊 Resumen Ejecutivo
                </button>
                <button data-tab="flujo" class="tab-button border-transparent text-gray-400 hover:border-gray-600 hover:text-gray-300 whitespace-nowrap border-b-2 py-4 px-1 text-sm font-medium transition-colors duration-200">
                    📈 Flujo de Transacciones
                </button>
            </nav>
        </div>

        <!-- Filtros -->
        <div class="bg-gray-800 p-6 rounded-lg shadow-md mb-6 border border-gray-700">
            <h2 class="text-xl font-bold mb-4 text-white">Filtros</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-1">Fecha Desde</label>
                    <input type="date" id="filtro-desde" class="w-full border border-gray-600 rounded-md px-3 py-2 bg-gray-700 text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-1">Fecha Hasta</label>
                    <input type="date" id="filtro-hasta" class="w-full border border-gray-600 rounded-md px-3 py-2 bg-gray-700 text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-1">Tipo</label>
                    <select id="filtro-tipo" class="w-full border border-gray-600 rounded-md px-3 py-2 bg-gray-700 text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="todos">Todos</option>
                        <option value="ingreso">Ingresos</option>
                        <option value="gasto">Gastos</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-1">Cuenta</label>
                    <select id="filtro-cuenta" class="w-full border border-gray-600 rounded-md px-3 py-2 bg-gray-700 text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="todas">Todas las cuentas</option>
                        @foreach($cuentas as $cuenta)
                            <option value="{{ $cuenta->id }}">{{ $cuenta->nombre }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- Nuevo filtro para excluir cuentas -->
            <div class="mt-4">
                <label class="block text-sm font-medium text-gray-300 mb-1">Excluir Cuentas del Balance</label>
                <select id="filtro-excluir-cuentas" multiple
                        class="w-full border border-gray-600 rounded-md px-3 py-2 bg-gray-700 text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 min-h-[80px]">
                    <option value="ninguna">Ninguna</option>
                    @foreach($cuentas as $cuenta)
                        <option value="{{ $cuenta->id }}">{{ $cuenta->nombre }}</option>
                    @endforeach
                </select>
                <p class="text-xs text-gray-400 mt-1">Mantén Ctrl (Cmd en Mac) para seleccionar múltiples cuentas</p>
            </div>

            <div class="flex gap-2 mt-4">
                <button id="btn-aplicar-filtros" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md transition-colors duration-200 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 focus:ring-offset-gray-800">
                    Aplicar Filtros
                </button>
                <button id="btn-limpiar-filtros" class="bg-gray-600 hover:bg-gray-500 text-white px-4 py-2 rounded-md transition-colors duration-200 focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 focus:ring-offset-gray-800">
                    Limpiar Filtros
                </button>
            </div>
        </div>

        <!-- Loading -->
        <div id="loading-state" class="hidden fixed inset-0 bg-gray-800 bg-opacity-75 flex justify-center items-center z-50">
            <div class="p-5 border border-gray-700 rounded-md bg-gray-900 shadow-lg text-center">
                <div class="flex items-center justify-center mb-3">
                    <svg class="animate-spin h-8 w-8 text-blue-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.4 0 0 5.4 0 12h4z"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-medium text-white">Cargando datos...</h3>
            </div>
        </div>

        <!-- Contenido Tabs -->
        <div id="content-resumen" class="tab-content"></div>

        <div id="content-flujo" class="tab-content hidden">
            <div class="bg-gray-800 p-6 rounded-lg shadow-md border border-gray-700">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold text-white">Flujo de Transacciones</h3>
                    <div class="flex gap-2">
                        <select id="chart-interval" class="text-sm border border-gray-600 rounded px-3 py-1 bg-gray-700 text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="day">Diario</option>
                            <option value="week" selected>Semanal</option>
                            <option value="month">Mensual</option>
                        </select>
                    </div>
                </div>
                <div id="chart-container" style="width: 100%; height: 400px;"></div>
            </div>
        </div>

        <!-- Estado -->
        <div id="estado" class="mt-4 text-center hidden text-gray-300"></div>
        <div id="data-info"></div>
    </div>

    <!-- Scripts -->
    <script src="https://unpkg.com/lightweight-charts@4.1.0/dist/lightweight-charts.standalone.production.js"></script>
    @vite([
        'resources/js/analistajr/dashboard.js'
    ])

</x-app-layout>
