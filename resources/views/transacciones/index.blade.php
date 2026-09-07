{{-- resources/views/transacciones/index.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Transacciones') }}
        </h2>
    </x-slot>

    <div class="transacciones-view relative z-10 p-6 sm:p-10">

        <!-- HEADER -->
        <div class="tv-topbar">
            <div class="tv-title-row">
                <span class="tv-title-icon">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/>
                    </svg>
                </span>
                <div>
                    <h1>Transacciones</h1>
                    <div class="tv-title-sub">
                        {{ $transacciones->count() }} {{ $transacciones->count() == 1 ? 'transacción' : 'transacciones' }}
                    </div>
                </div>
            </div>

            <div class="tv-actions">
                <button onclick="exportTableToCSV('transacciones.csv')" class="tv-btn-outline" title="Exportar a CSV">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    Exportar CSV
                </button>

                <a href="{{ route('transacciones.create') }}" class="tv-btn-new">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Nueva Transacción
                </a>
            </div>
        </div>

        <!-- RESUMEN -->
        <div class="tv-stats-grid">
            <div class="tv-stat-card" style="--tv-tile-soft: var(--tv-success-soft); --tv-tile-color: var(--tv-success);">
                <div class="tv-stat-icon">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19V5m0 0l-6 6m6-6l6 6"/>
                    </svg>
                </div>
                <div>
                    <div class="tv-stat-label">Ingresos</div>
                    <div class="tv-stat-value tv-display">${{ number_format($totalIngresos, 2) }}</div>
                </div>
            </div>

            <div class="tv-stat-card" style="--tv-tile-soft: var(--tv-danger-soft); --tv-tile-color: var(--tv-danger);">
                <div class="tv-stat-icon">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v14m0 0l-6-6m6 6l6-6"/>
                    </svg>
                </div>
                <div>
                    <div class="tv-stat-label">Egresos</div>
                    <div class="tv-stat-value tv-display">${{ number_format($totalEgresos, 2) }}</div>
                </div>
            </div>

            <div class="tv-stat-card" style="--tv-tile-soft: var(--tv-amber-soft); --tv-tile-color: var(--tv-amber);">
                <div class="tv-stat-icon">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <rect x="3" y="6" width="18" height="12" rx="2"/><circle cx="12" cy="12" r="3"/><path stroke-linecap="round" d="M3 9h2M19 9h2M3 15h2M19 15h2"/>
                    </svg>
                </div>
                <div>
                    <div class="tv-stat-label">Costos</div>
                    <div class="tv-stat-value tv-display">${{ number_format($totalCostos, 2) }}</div>
                </div>
            </div>

            <div class="tv-stat-card" style="--tv-tile-soft: var(--tv-blue-soft); --tv-tile-color: var(--tv-blue);">
                <div class="tv-stat-icon">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 17l6-6 4 4 7-7"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 4h7v7"/>
                    </svg>
                </div>
                <div>
                    <div class="tv-stat-label">Inversiones</div>
                    <div class="tv-stat-value tv-display">${{ number_format($totalInversion, 2) }}</div>
                </div>
            </div>
        </div>

        <!-- FILTROS -->
        <div class="tv-filters">
            <div class="tv-filters-head">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                </svg>
                Filtros
            </div>

            <form action="{{ route('transacciones.index') }}" method="GET">
                <div class="tv-filter-grid">
                    <div class="tv-field">
                        <label>Buscar</label>
                        <div class="tv-search-wrap">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                            <input type="text" name="search" placeholder="Descripción..." value="{{ request('search') }}" class="tv-input">
                        </div>
                    </div>

                    <div class="tv-field">
                        <label>Tipo</label>
                        <select name="tipo" class="tv-select">
                            <option value="">Todos los tipos</option>
                            @foreach($tipos as $tipo)
                                <option value="{{ $tipo }}" {{ request('tipo') == $tipo ? 'selected' : '' }}>{{ ucfirst($tipo) }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="tv-field">
                        <label>Cuenta</label>
                        <select name="cuenta_id" class="tv-select">
                            <option value="">Todas las cuentas</option>
                            @foreach($cuentas as $cuenta)
                                <option value="{{ $cuenta->id }}" {{ request('cuenta_id') == $cuenta->id ? 'selected' : '' }}>{{ $cuenta->nombre }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="tv-field">
                        <label>Categoría</label>
                        <select name="categoria_id" class="tv-select">
                            <option value="">Todas las categorías</option>
                            @foreach($categorias as $categoria)
                                <option value="{{ $categoria->id }}" {{ request('categoria_id') == $categoria->id ? 'selected' : '' }}>{{ $categoria->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="tv-filter-grid tv-filter-grid--dates">
                    <div class="tv-field">
                        <label>Desde</label>
                        <input type="date" name="fecha_desde" value="{{ request('fecha_desde') }}" class="tv-input">
                    </div>
                    <div class="tv-field">
                        <label>Hasta</label>
                        <input type="date" name="fecha_hasta" value="{{ request('fecha_hasta') }}" class="tv-input">
                    </div>
                </div>

                <div class="tv-filter-footer">
                    <div>
                        @if(request()->anyFilled(['search', 'tipo', 'cuenta_id', 'categoria_id', 'fecha_desde', 'fecha_hasta']))
                            <a href="{{ route('transacciones.index') }}" class="tv-btn-clear">
                                <svg viewBox="0 0 24 24" fill="none"><path d="M6 18L18 6M6 6l12 12" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                Limpiar filtros
                            </a>
                        @endif
                    </div>

                    <button type="submit" class="tv-btn-apply">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                        </svg>
                        Aplicar filtros
                    </button>
                </div>
            </form>
        </div>

        <!-- TABLA -->
        <div class="tv-table-panel">
            <div class="tv-table-head">
                <h3>Lista de Transacciones</h3>
                <p>Mostrando {{ $transacciones->count() }} {{ $transacciones->count() == 1 ? 'transacción' : 'transacciones' }}</p>
            </div>

            @if($transacciones->isEmpty())
                <div class="tv-empty">
                    <div class="tv-empty-icon">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                    </div>
                    <h3>
                        @if(request()->anyFilled(['search', 'tipo', 'cuenta_id', 'categoria_id', 'fecha_desde', 'fecha_hasta']))
                            No se encontraron transacciones con los filtros aplicados
                        @else
                            No hay transacciones registradas
                        @endif
                    </h3>
                    <p>Comienza creando tu primera transacción.</p>
                    <a href="{{ route('transacciones.create') }}" class="tv-btn-new">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                        Crear transacción
                    </a>
                </div>
            @else
                <div class="tv-table-scroll">
                    <table id="transacciones-table" class="tv-table">
                        <thead>
                            <tr>
                                <th>
                                    <a href="{{ route('transacciones.index', array_merge(request()->all(), ['sort_by' => 'fecha', 'sort_dir' => request('sort_dir') == 'asc' ? 'desc' : 'asc'])) }}">
                                        <span>Fecha</span>
                                        @if(request('sort_by') == 'fecha')
                                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="{{ request('sort_dir') == 'asc' ? 'transform:rotate(180deg)' : '' }}"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"/></svg>
                                        @endif
                                    </a>
                                </th>
                                <th>Cuenta</th>
                                <th>Categoría</th>
                                <th>Tipo</th>
                                <th>
                                    <a href="{{ route('transacciones.index', array_merge(request()->all(), ['sort_by' => 'monto', 'sort_dir' => request('sort_dir') == 'asc' ? 'desc' : 'asc'])) }}">
                                        <span>Monto</span>
                                        @if(request('sort_by') == 'monto')
                                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="{{ request('sort_dir') == 'asc' ? 'transform:rotate(180deg)' : '' }}"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"/></svg>
                                        @endif
                                    </a>
                                </th>
                                <th>Descripción</th>
                                <th class="tv-right">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $tipoEstilos = [
                                    'ingreso'   => ['soft' => 'var(--tv-success-soft)', 'color' => 'var(--tv-success)'],
                                    'egreso'    => ['soft' => 'var(--tv-danger-soft)',  'color' => 'var(--tv-danger)'],
                                    'costo'     => ['soft' => 'var(--tv-amber-soft)',   'color' => 'var(--tv-amber)'],
                                    'inversion' => ['soft' => 'var(--tv-blue-soft)',    'color' => 'var(--tv-blue)'],
                                ];
                            @endphp
                            @foreach ($transacciones as $transaccion)
                                @php $estilo = $tipoEstilos[$transaccion->tipo] ?? ['soft' => 'var(--tv-surface-2)', 'color' => 'var(--tv-text-dim)']; @endphp
                                <tr>
                                    <td>
                                        <div class="tv-date-cell">
                                            <div class="tv-date-icon">
                                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                            </div>
                                            <div>
                                                <div class="tv-date-main">{{ $transaccion->fecha->format('d/m/Y') }}</div>
                                                <div class="tv-date-sub">{{ $transaccion->created_at->format('h:i A') }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="tv-cuenta-cell">
                                            <span class="tv-cuenta-dot" style="background: {{ $estilo['color'] }};"></span>
                                            {{ $transaccion->cuenta->nombre }}
                                        </div>
                                    </td>
                                    <td>
                                        <span class="tv-chip tv-chip-cat">{{ $transaccion->categoria->nombre }}</span>
                                    </td>
                                    <td>
                                        <span class="tv-chip" style="--tv-chip-soft: {{ $estilo['soft'] }}; --tv-chip-color: {{ $estilo['color'] }};">
                                            <span class="tv-chip-dot"></span>
                                            {{ ucfirst($transaccion->tipo) }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="tv-amount" style="color: {{ $estilo['color'] }};">
                                            {{ $transaccion->tipo === 'ingreso' ? '+' : '-' }}${{ number_format($transaccion->monto, 2) }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="tv-desc" title="{{ $transaccion->descripcion }}">{{ $transaccion->descripcion ?? 'Sin descripción' }}</div>
                                    </td>
                                    <td>
                                        <div class="tv-row-actions">
                                            <a href="{{ route('transacciones.edit', $transaccion) }}" class="tv-icon-btn tv-edit" title="Editar">
                                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16.5 3.5a2.1 2.1 0 013 3L7 19l-4 1 1-4 12.5-12.5z"/></svg>
                                            </a>
                                            <form action="{{ route('transacciones.destroy', $transaccion) }}" method="POST"
                                                  onsubmit="return confirm('¿Seguro que deseas eliminar esta transacción?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="tv-icon-btn tv-delete" title="Eliminar">
                                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6h18M8 6V4h8v2M6 6v14a2 2 0 002 2h8a2 2 0 002-2V6M10 11v6M14 11v6"/></svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            @if(session('success'))
                showToast(@json(session('success')), 'success');
            @endif
            @if(session('error'))
                showToast(@json(session('error')), 'error');
            @endif
        });

        function exportTableToCSV(filename) {
            var csv = [];
            var rows = document.querySelectorAll("#transacciones-table tr");

            for (var i = 0; i < rows.length; i++) {
                var row = [], cols = rows[i].querySelectorAll("td, th");

                // Omitir la última columna (acciones) si es una fila de datos
                var colsToExport = i === 0 ? cols : Array.from(cols).slice(0, -1);

                for (var j = 0; j < colsToExport.length; j++) {
                    // Limpiar el texto de cada celda
                    let text = colsToExport[j].innerText.trim();

                    // Para las celdas con formato de moneda, quitar el símbolo $ si es necesario
                    if (text.includes('$') && !isNaN(text.replace('$', '').replace(',', ''))) {
                        text = text.replace('$', '').replace(',', '');
                    }

                    // Escapar comillas dobles y encerrar en comillas si contiene comas o saltos de línea
                    text = text.replace(/"/g, '""');
                    if (text.includes(',') || text.includes('\n') || text.includes('"')) {
                        text = '"' + text + '"';
                    }

                    row.push(text);
                }
                csv.push(row.join(","));
            }

            // Descargar archivo CSV
            downloadCSV(csv.join("\n"), filename);

            // Mostrar notificación de éxito
            showToast('Exportación completada. El archivo CSV se ha descargado.', 'success');
        }

        function downloadCSV(csv, filename) {
            var csvFile;
            var downloadLink;

            // CSV file
            csvFile = new Blob(["﻿" + csv], {type: "text/csv;charset=utf-8;"});

            // Download link
            downloadLink = document.createElement("a");

            // File name
            downloadLink.download = filename;

            // Create a link to the file
            downloadLink.href = window.URL.createObjectURL(csvFile);

            // Hide download link
            downloadLink.style.display = "none";

            // Add the link to DOM
            document.body.appendChild(downloadLink);

            // Click download link
            downloadLink.click();

            // Limpiar después de la descarga
            setTimeout(() => {
                document.body.removeChild(downloadLink);
            }, 100);
        }
    </script>
</x-app-layout>
