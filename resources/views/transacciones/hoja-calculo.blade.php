<x-app-layout>
    <style>
        :root {
            --bg: #0b0b0e;
            --surface: #12141a;
            --surface2: #18181b;
            --border: #ffffff17;
            --border-bright: #ffffff24;
            --accent: #ef4444;
            --accent-hover: #dc2626;
            --green: #22c55e;
            --red: #ef4444;
            --text: #f1f5f9;
            --text-dim: #94a3b8;
            --text-dimmer: #64748b;
            --header-bg: #18181b;
            --select-bg: rgba(239, 68, 68, 0.1);
            --select-border: #ef4444;
            --cell-h: 28px;
            --col-w: 120px;
            --row-header-w: 50px;
        }

        * { box-sizing: border-box; margin: 0; padding: 0; }

        .hoja-calculo-container {
            font-family: 'IBM Plex Sans', sans-serif;
            background: var(--bg);
            color: var(--text);
            height: 100%;
            display: flex;
            flex-direction: column;
            overflow: hidden;
            border-radius: 12px;
            margin: 12px 12px 12px 12px;
        }

        /* ── TOP NAVIGATION BAR ── */
        #topbar {
            display: flex;
            align-items: center;
            padding: 0 20px;
            height: 56px;
            background: var(--surface);
            border-bottom: 1px solid var(--border);
            gap: 20px;
            flex-shrink: 0;
            justify-content: space-between;
            border-radius: 12px 12px 0 0;
            margin: 12px 12px 0 12px;
        }

        .topbar-left {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        #logo {
            font-family: 'IBM Plex Mono', monospace;
            font-size: 14px;
            font-weight: 600;
            color: var(--accent);
            letter-spacing: 2px;
            text-transform: uppercase;
        }

        .divider {
            width: 1px;
            height: 28px;
            background: var(--border);
        }

        .breadcrumb {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 13px;
            color: var(--text-dim);
        }

        .breadcrumb a {
            color: var(--accent);
            text-decoration: none;
            transition: color 0.2s;
        }

        .breadcrumb a:hover {
            color: var(--accent-hover);
        }

        .topbar-links {
            display: flex;
            gap: 4px;
        }

        .topbar-link {
            padding: 6px 12px;
            border-radius: 6px;
            font-size: 12px;
            color: var(--text-dim);
            background: transparent;
            border: 1px solid transparent;
            text-decoration: none;
            cursor: pointer;
            transition: all 0.2s;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .topbar-link:hover {
            background: var(--surface2);
            color: var(--text);
            border-color: var(--border-bright);
        }

        .topbar-link.active {
            background: rgba(239, 68, 68, 0.1);
            color: var(--accent);
            border-color: var(--accent);
        }

        /* ── TOOLBAR ── */
        #toolbar {
            display: flex;
            align-items: center;
            padding: 0 12px;
            height: 40px;
            background: var(--surface2);
            border-bottom: 1px solid var(--border);
            gap: 4px;
            flex-shrink: 0;
            flex-wrap: nowrap;
            overflow-x: auto;
            margin: 0 12px;
        }

        .tb-group {
            display: flex;
            gap: 2px;
            align-items: center;
            padding: 0 6px;
            border-right: 1px solid var(--border);
        }
        .tb-group:last-child { border-right: none; }

        .tb-btn {
            height: 28px;
            min-width: 28px;
            padding: 0 8px;
            background: transparent;
            border: 1px solid transparent;
            border-radius: 4px;
            color: var(--text-dim);
            cursor: pointer;
            font-family: 'IBM Plex Mono', monospace;
            font-size: 12px;
            display: flex; align-items: center; justify-content: center;
            gap: 4px;
            transition: all 0.12s;
            white-space: nowrap;
        }
        .tb-btn:hover { background: var(--border); color: var(--text); border-color: var(--border-bright); }
        .tb-btn.active { background: rgba(239, 68, 68, 0.2); color: var(--accent); border-color: var(--accent); }

        .tb-select, .tb-input {
            height: 28px;
            padding: 0 8px;
            background: var(--bg);
            border: 1px solid var(--border);
            border-radius: 4px;
            color: var(--text);
            font-family: 'IBM Plex Mono', monospace;
            font-size: 12px;
            cursor: pointer;
            outline: none;
        }
        .tb-select:focus, .tb-input:focus { border-color: var(--accent); }

        /* ── FORMULA BAR ── */
        #formulabar {
            display: flex;
            align-items: center;
            height: 34px;
            background: var(--surface);
            border-bottom: 1px solid var(--border);
            flex-shrink: 0;
            gap: 0;
            margin: 0 12px;
        }

        #cell-ref {
            width: 80px;
            flex-shrink: 0;
            text-align: center;
            font-family: 'IBM Plex Mono', monospace;
            font-size: 12px;
            color: var(--accent);
            border-right: 1px solid var(--border);
            padding: 0 8px;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            user-select: none;
        }

        #fx-label {
            padding: 0 10px;
            font-family: 'IBM Plex Mono', monospace;
            font-size: 13px;
            color: var(--text-dim);
            font-style: italic;
            border-right: 1px solid var(--border);
            height: 100%;
            display: flex;
            align-items: center;
        }

        #formula-input {
            flex: 1;
            background: transparent;
            border: none;
            outline: none;
            color: var(--text);
            font-family: 'IBM Plex Mono', monospace;
            font-size: 13px;
            padding: 0 12px;
            height: 100%;
        }

        /* ── SPREADSHEET AREA ── */
        #sheet-container {
            flex: 1;
            overflow: hidden;
            position: relative;
            margin: 0 12px;
        }

        #sheet-scroll {
            width: 100%;
            height: 100%;
            overflow: auto;
            position: relative;
        }

        #sheet-scroll::-webkit-scrollbar { width: 8px; height: 8px; }
        #sheet-scroll::-webkit-scrollbar-track { background: var(--surface); }
        #sheet-scroll::-webkit-scrollbar-thumb { background: var(--border-bright); border-radius: 4px; }
        #sheet-scroll::-webkit-scrollbar-corner { background: var(--surface); }

        #grid-wrapper {
            position: relative;
            display: inline-block;
            min-width: 100%;
            border-radius: 0 0 12px 12px;
            overflow: hidden;
        }

        /* ── HEADER ROW ── */
        #col-headers {
            display: flex;
            position: sticky;
            top: 0;
            z-index: 10;
            background: var(--header-bg);
            border-bottom: 2px solid var(--border-bright);
            border-radius: 0;
        }

        .corner-cell {
            width: var(--row-header-w);
            min-width: var(--row-header-w);
            height: var(--cell-h);
            background: var(--header-bg);
            border-right: 1px solid var(--border-bright);
            position: sticky;
            left: 0;
            z-index: 20;
        }

        .col-header {
            width: var(--col-w);
            min-width: var(--col-w);
            height: var(--cell-h);
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'IBM Plex Mono', monospace;
            font-size: 11px;
            font-weight: 600;
            color: var(--text-dim);
            border-right: 1px solid var(--border);
            cursor: pointer;
            user-select: none;
            transition: background 0.1s;
            letter-spacing: 1px;
        }
        .col-header:hover { background: var(--surface2); color: var(--text); }

        /* ── ROWS ── */
        .grid-row {
            display: flex;
            border-bottom: 1px solid var(--border);
        }

        .row-header {
            width: var(--row-header-w);
            min-width: var(--row-header-w);
            height: var(--cell-h);
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'IBM Plex Mono', monospace;
            font-size: 11px;
            color: var(--text-dim);
            background: var(--header-bg);
            border-right: 1px solid var(--border-bright);
            cursor: pointer;
            user-select: none;
            position: sticky;
            left: 0;
            z-index: 5;
            transition: background 0.1s;
        }

        /* ── CELLS ── */
        .cell {
            width: var(--col-w);
            min-width: var(--col-w);
            height: var(--cell-h);
            border-right: 1px solid var(--border);
            padding: 0 6px;
            display: flex;
            align-items: center;
            cursor: cell;
            position: relative;
            overflow: hidden;
            font-size: 13px;
            white-space: nowrap;
            transition: background 0.05s;
            user-select: none;
        }

        .cell.selected {
            background: var(--select-bg) !important;
            box-shadow: inset 0 0 0 1px var(--select-border);
            z-index: 2;
        }

        .cell.active-cell {
            background: rgba(239, 68, 68, 0.08) !important;
            box-shadow: inset 0 0 0 2px var(--accent);
            z-index: 3;
        }

        .cell.in-range {
            background: rgba(239, 68, 68, 0.08) !important;
        }

        .cell-content {
            width: 100%;
            overflow: hidden;
            text-overflow: ellipsis;
            pointer-events: none;
        }

        .cell-content.align-right { text-align: right; }
        .cell-content.align-center { text-align: center; }
        .cell-content.error { color: var(--red); }
        .cell-content.success { color: var(--green); }

        /* ── INLINE EDITOR ── */
        #cell-editor {
            position: absolute;
            display: none;
            z-index: 100;
            background: var(--bg);
            border: 2px solid var(--accent);
            font-family: 'IBM Plex Mono', monospace;
            font-size: 13px;
            color: var(--text);
            padding: 0 6px;
            outline: none;
            box-shadow: 0 4px 20px rgba(239, 68, 68, 0.3);
        }

        #form-save-btn:hover {
            background: var(--accent-hover);
            box-shadow: 0 2px 8px rgba(239, 68, 68, 0.4);
        }

        #form-save-btn:active {
            transform: scale(0.98);
        }

        /* ── STATUS BAR ── */
        #statusbar {
            height: 28px;
            background: var(--surface);
            border-top: 1px solid var(--border);
            display: flex;
            align-items: center;
            padding: 0 16px;
            gap: 20px;
            flex-shrink: 0;
            font-family: 'IBM Plex Mono', monospace;
            font-size: 11px;
            color: var(--text-dim);
            border-radius: 0 0 12px 12px;
            margin: 0 12px 12px 12px;
        }

        .status-item { display: flex; gap: 6px; align-items: center; }
        .status-label { color: var(--text-dimmer); }
        .status-val { color: var(--text-dim); }
        .status-val.highlight { color: var(--accent); }

        /* ── LOADING ── */
        .loading {
            display: none;
            text-align: center;
            padding: 20px;
            color: var(--text-dim);
        }
        .loading.active { display: block; }
    </style>

    <div class="flex-1 flex flex-col overflow-hidden h-screen hoja-calculo-container">
        <!-- TOP NAVIGATION BAR -->
    <div id="topbar">
        <div class="topbar-left">
            <div id="logo">AdminJR</div>
            <div class="divider"></div>
            <div class="breadcrumb">
                <a href="{{ route('transacciones.index') }}" title="Volver a transacciones">Transacciones</a>
                <span>/</span>
                <span>Hoja de Cálculo</span>
            </div>
        </div>

        <div class="topbar-links">
            <a href="{{ route('transacciones.index') }}" class="topbar-link" title="Vista de tabla">
                <i class="fas fa-table"></i> Tabla
            </a>
            <a href="{{ route('transacciones.hoja-calculo') }}" class="topbar-link active" title="Vista de hoja">
                <i class="fas fa-th"></i> Hoja
            </a>
            <div class="divider" style="margin: 0 4px;"></div>
            <a href="{{ route('dashboard') }}" class="topbar-link" title="Panel principal">
                <i class="fas fa-home"></i>
            </a>
        </div>
    </div>

    <!-- TOOLBAR -->
    <div id="toolbar">
        <div class="tb-group">
            <select class="tb-select" id="cuenta-filter" title="Filtrar por cuenta">
                <option value="">Todas las cuentas</option>
            </select>
            <select class="tb-select" id="tipo-filter" title="Filtrar por tipo">
                <option value="">Todos los tipos</option>
                <option value="ingreso">Ingreso</option>
                <option value="egreso">Egreso</option>
                <option value="inversion">Inversión</option>
                <option value="costo">Costo</option>
            </select>
        </div>
        <div class="tb-group">
            <input type="date" class="tb-input" id="fecha-desde" title="Fecha desde" style="width: auto;">
            <input type="date" class="tb-input" id="fecha-hasta" title="Fecha hasta" style="width: auto;">
        </div>
        <div class="tb-group">
            <button class="tb-btn" id="btn-refresh" title="Recargar">🔄</button>
            <button class="tb-btn" id="btn-export" title="Exportar CSV">↓ CSV</button>
        </div>
        <div class="tb-group">
            <button class="tb-btn" id="btn-delete" title="Eliminar fila">🗑</button>
        </div>
    </div>

    <!-- FORMULA BAR -->
    <div id="formulabar">
        <div id="cell-ref">-</div>
        <div id="fx-label">Info</div>
        <input id="formula-input" type="text" placeholder="Vista: transacciones del usuario" readonly>
    </div>

    <!-- SPREADSHEET + FORM PANEL -->
    <div style="display: flex; gap: 12px; flex: 1; overflow: hidden;">
        <!-- TABLA A LA IZQUIERDA -->
        <div id="sheet-container">
            <div id="sheet-scroll">
                <div class="loading active" id="loading">Cargando transacciones...</div>
                <div id="grid-wrapper" style="display:none">
                    <div id="col-headers"></div>
                    <div id="grid-body"></div>
                </div>
            </div>
            <input id="cell-editor" type="text" spellcheck="false" autocomplete="off">
        </div>

        <!-- FORMULARIO A LA DERECHA -->
        <div id="form-panel" style="width: 280px; background: var(--surface); border: 1px solid var(--border); border-radius: 8px; display: flex; flex-direction: column; gap: 12px; overflow: hidden;">
            <!-- Encabezado fijo -->
            <div style="padding: 16px 16px 0 16px; flex-shrink: 0;">
                <h3 style="margin: 0; font-size: 14px; color: var(--accent); text-transform: uppercase; letter-spacing: 1px;">Nueva Transacción</h3>
            </div>
            
            <!-- Campos scrolleables -->
            <div style="padding: 0 16px; overflow-y: auto; flex: 1;">
                <!-- Fecha -->
                <div style="margin-bottom: 12px;">
                    <label style="display: block; font-size: 11px; color: var(--text-dim); margin-bottom: 4px; text-transform: uppercase;">Fecha</label>
                    <input type="date" id="form-fecha" style="width: 100%; padding: 6px 8px; background: var(--surface2); border: 1px solid var(--border); border-radius: 4px; color: var(--text); font-size: 13px; font-family: inherit;">
                </div>

                <!-- Cuenta -->
                <div style="margin-bottom: 12px;">
                    <label style="display: block; font-size: 11px; color: var(--text-dim); margin-bottom: 4px; text-transform: uppercase;">Cuenta</label>
                    <select id="form-cuenta" style="width: 100%; padding: 6px 8px; background: var(--surface2); border: 1px solid var(--border); border-radius: 4px; color: var(--text); font-size: 13px; font-family: inherit;">
                        <option value="">Selecciona...</option>
                    </select>
                </div>

                <!-- Monto -->
                <div style="margin-bottom: 12px;">
                    <label style="display: block; font-size: 11px; color: var(--text-dim); margin-bottom: 4px; text-transform: uppercase;">Monto</label>
                    <input type="number" id="form-monto" step="0.01" min="0.01" style="width: 100%; padding: 6px 8px; background: var(--surface2); border: 1px solid var(--border); border-radius: 4px; color: var(--text); font-size: 13px; font-family: inherit;" placeholder="0.00">
                </div>

                <!-- Tipo -->
                <div style="margin-bottom: 12px;">
                    <label style="display: block; font-size: 11px; color: var(--text-dim); margin-bottom: 4px; text-transform: uppercase;">Tipo</label>
                    <select id="form-tipo" style="width: 100%; padding: 6px 8px; background: var(--surface2); border: 1px solid var(--border); border-radius: 4px; color: var(--text); font-size: 13px; font-family: inherit;">
                        <option value="">Selecciona...</option>
                        <option value="ingreso">Ingreso</option>
                        <option value="egreso">Egreso</option>
                        <option value="inversion">Inversión</option>
                        <option value="costo">Costo</option>
                    </select>
                </div>

                <!-- Descripción -->
                <div>
                    <label style="display: block; font-size: 11px; color: var(--text-dim); margin-bottom: 4px; text-transform: uppercase;">Descripción</label>
                    <textarea id="form-descripcion" style="width: 100%; height: 60px; padding: 6px 8px; background: var(--surface2); border: 1px solid var(--border); border-radius: 4px; color: var(--text); font-size: 13px; font-family: inherit; resize: none;" placeholder="Opcional..."></textarea>
                </div>
            </div>

            <!-- Botón fijo al bottom -->
            <div style="padding: 12px 16px 16px 16px; border-top: 1px solid var(--border); flex-shrink: 0;">
                <div id="form-status" style="font-size: 12px; color: var(--text-dim); text-align: center; margin-bottom: 8px;">LISTO</div>
                <button id="form-save-btn" style="width: 100%; padding: 10px 12px; background: var(--accent); border: none; border-radius: 4px; color: white; font-size: 13px; font-weight: 600; cursor: pointer; text-transform: uppercase; letter-spacing: 0.5px; transition: all 0.2s;">💾 Guardar</button>
            </div>
        </div>
    </div>

    <!-- STATUS BAR -->
    <div id="statusbar">
        <div class="status-item"><span class="status-label">TOTAL</span><span class="status-val" id="st-total">$0.00</span></div>
        <div class="status-item"><span class="status-label">INGRESOS</span><span class="status-val success" id="st-ingreso">$0.00</span></div>
        <div class="status-item"><span class="status-label">EGRESOS</span><span class="status-val" id="st-egreso">$0.00</span></div>
        <div class="status-item"><span class="status-label">FILAS</span><span class="status-val" id="st-count">0</span></div>
        <div style="flex:1"></div>
        <div class="status-item" title="Debug: Datos de nueva transacción" onclick="console.table(window.newRowData); alert('Ver consola (F12)')">
            <span class="status-val" id="status-msg">LISTO</span>
        </div>
    </div>

<script>
// ─────────────────────────────────────────────
//  CONFIG
// ─────────────────────────────────────────────
const ROWS = 100;
const COLS = 6;
const COLUMNS = ['ID', 'Fecha', 'Cuenta', 'Monto', 'Tipo', 'Descripción'];

// ─────────────────────────────────────────────
//  STATE
// ─────────────────────────────────────────────
let transacciones = [];
let newRowData = {}; // Para almacenar datos de nueva transacción
let isSavingTransaction = false; // Prevenir guardados simultáneos
let activeCell = null;
let selStart = null;
let selEnd = null;
let isEditing = false;
let mouseDown = false;

// ─────────────────────────────────────────────
//  HELPERS
// ─────────────────────────────────────────────
const cellId = (r, c) => `${r}_${c}`;
const getCell = (r, c) => document.getElementById(`cell-${cellId(r, c)}`);

async function loadTransacciones() {
    try {
        const params = new URLSearchParams();
        const cuentaId = document.getElementById('cuenta-filter').value;
        const tipo = document.getElementById('tipo-filter').value;
        const desde = document.getElementById('fecha-desde').value;
        const hasta = document.getElementById('fecha-hasta').value;

        if (cuentaId) params.append('cuenta_id', cuentaId);
        if (tipo) params.append('tipo', tipo);
        if (desde) params.append('fecha_desde', desde);
        if (hasta) params.append('fecha_hasta', hasta);

        const response = await fetch(`/api/transacciones-hoja?${params}`, {
            headers: {
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        });

        if (!response.ok) throw new Error('Error al cargar transacciones (status ' + response.status + ')');
        
        const data = await response.json();
        transacciones = data.data || data;
        console.log('✓ Transacciones recargadas:', transacciones.length);
        renderAll();
        updateStatusBar();
    } catch (error) {
        console.error('Error cargando transacciones:', error);
        document.getElementById('status-msg').textContent = 'Error al recargar: ' + error.message;
        
        // Reintentar después de 2 segundos
        setTimeout(() => {
            console.log('Reintentando cargar transacciones...');
            loadTransacciones();
        }, 2000);
    }
}

// ─────────────────────────────────────────────
//  DOM BUILDING
// ─────────────────────────────────────────────
const gridBody = document.getElementById('grid-body');
const colHeaders = document.getElementById('col-headers');

function buildGrid() {
    colHeaders.innerHTML = '';
    const corner = document.createElement('div');
    corner.className = 'corner-cell';
    colHeaders.appendChild(corner);

    COLUMNS.forEach(col => {
        const h = document.createElement('div');
        h.className = 'col-header';
        h.textContent = col;
        colHeaders.appendChild(h);
    });

    gridBody.innerHTML = '';
    for (let r = 0; r < ROWS; r++) {
        const row = document.createElement('div');
        row.className = 'grid-row';

        const rh = document.createElement('div');
        rh.className = 'row-header';
        rh.textContent = r + 1;
        row.appendChild(rh);

        for (let c = 0; c < COLS; c++) {
            const cell = document.createElement('div');
            cell.className = 'cell';
            cell.id = `cell-${cellId(r, c)}`;
            cell.dataset.r = r;
            cell.dataset.c = c;

            const content = document.createElement('div');
            content.className = 'cell-content';
            cell.appendChild(content);

            cell.addEventListener('mousedown', e => onCellMouseDown(e, r, c));
            cell.addEventListener('mouseover', e => onCellMouseOver(e, r, c));

            row.appendChild(cell);
        }
        gridBody.appendChild(row);
    }
}

// ─────────────────────────────────────────────
//  RENDER
// ─────────────────────────────────────────────
function renderCell(r, c) {
    const cell = getCell(r, c);
    if (!cell) return;

    const isNewRow = r >= transacciones.length;
    const content = cell.querySelector('.cell-content');
    let value = '';

    if (isNewRow && newRowData) {
        // Mostrar datos de la fila nueva
        switch(c) {
            case 0: value = '-'; break; // ID no se muestra (se asigna en servidor)
            case 1: value = newRowData.fecha || ''; break;
            case 2: value = newRowData.cuenta_nombre || ''; break;
            case 3: value = newRowData.monto ? `$${parseFloat(newRowData.monto).toFixed(2)}` : ''; break;
            case 4: value = newRowData.tipo || ''; break;
            case 5: value = newRowData.descripcion || ''; break;
        }
    } else if (r < transacciones.length) {
        const tx = transacciones[r];
        switch(c) {
            case 0: value = tx.id; break;
            case 1: value = tx.fecha; break;
            case 2: value = tx.cuenta?.nombre || '-'; break;
            case 3: value = `$${parseFloat(tx.monto).toFixed(2)}`; break;
            case 4: value = tx.tipo; break;
            case 5: value = tx.descripcion || '-'; break;
        }
    }

    content.textContent = value;
    content.className = 'cell-content';
    
    // Color coding by type
    if (c === 4) {
        const tipoVal = isNewRow ? newRowData.tipo : transacciones[r]?.tipo;
        if (tipoVal === 'ingreso') content.classList.add('success');
        else if (tipoVal === 'egreso') content.classList.add('error');
    }
    if (c === 3 || c === 0) content.classList.add('align-right');
}

function renderAll() {
    for (let r = 0; r < ROWS; r++)
        for (let c = 0; c < COLS; c++)
            renderCell(r, c);
    updateSelection();
}

// ─────────────────────────────────────────────
//  SELECTION & INTERACTION
// ─────────────────────────────────────────────
function updateSelection() {
    document.querySelectorAll('.cell').forEach(el => {
        el.classList.remove('selected', 'active-cell', 'in-range');
    });

    if (!activeCell) return;

    if (selStart && selEnd) {
        const r1 = Math.min(selStart.r, selEnd.r), r2 = Math.max(selStart.r, selEnd.r);
        const c1 = Math.min(selStart.c, selEnd.c), c2 = Math.max(selStart.c, selEnd.c);

        for (let r = r1; r <= r2; r++) {
            for (let c = c1; c <= c2; c++) {
                const el = getCell(r, c);
                if (el) el.classList.add('in-range');
            }
        }
    }

    const el = getCell(activeCell.r, activeCell.c);
    if (el) {
        el.classList.remove('in-range');
        el.classList.add('active-cell');
    }

    document.getElementById('cell-ref').textContent = `${COLUMNS[activeCell.c]}${activeCell.r + 1}`;
    
    if (activeCell.r < transacciones.length) {
        const tx = transacciones[activeCell.r];
        document.getElementById('formula-input').value = JSON.stringify(tx).substring(0, 50) + '...';
    }
}

function setActive(r, c) {
    activeCell = { r, c };
    selStart = { r, c };
    selEnd = { r, c };
    updateSelection();
}

function onCellMouseDown(e, r, c) {
    if (e.button !== 0) return;
    mouseDown = true;
    if (isEditing) commitEdit();
    setActive(r, c);
}

function onCellMouseOver(e, r, c) {
    if (!mouseDown) return;
    selEnd = { r, c };
    updateSelection();
}

document.addEventListener('mouseup', () => { mouseDown = false; });

// ─────────────────────────────────────────────
//  EDITING
// ─────────────────────────────────────────────
const editor = document.getElementById('cell-editor');

function startEditing(r, c, event) {
    if (isEditing) commitEdit();
    
    isEditing = true;
    const cellEl = getCell(r, c);
    const isNewRow = r >= transacciones.length;
    
    // Resetear el tipo de editor siempre al inicio
    editor.type = 'text';
    editor.step = '';
    editor.min = '';
    editor.max = '';
    editor.pattern = '';
    editor.removeAttribute('maxLength'); // Sin límite por defecto
    
    // Obtener dimensiones de la celda
    let editorWidth = cellEl.offsetWidth;
    let editorHeight = cellEl.offsetHeight;
    
    editor.style.display = 'block';
    editor.style.left = cellEl.offsetLeft + 'px';
    editor.style.top = cellEl.offsetTop + 'px';
    editor.style.width = editorWidth + 'px';
    editor.style.height = editorHeight + 'px';
    editor.style.overflow = 'hidden';
    editor.style.boxSizing = 'border-box';

    // Para filas existentes, solo ciertos campos
    if (!isNewRow) {
        const tx = transacciones[r];
        if (c === 3) { 
            editor.type = 'number';
            editor.step = '0.01';
            editor.min = '0.01';
            editor.value = tx.monto;
        }
        else if (c === 5) { 
            editor.type = 'text';
            editor.value = tx.descripcion || '';
        }
        else return cancelEdit();
    } else {
        // Para filas nuevas, permitir editar más campos
        switch(c) {
            case 1: // Fecha
                editor.type = 'date';
                editor.value = new Date().toISOString().split('T')[0];
                break;
            case 2: // Cuenta
                // Mostrar dropdown en lugar de editor
                showCuentaSelector(r, c, event);
                return;
            case 3: // Monto
                editor.type = 'number';
                editor.step = '0.01';
                editor.min = '0.01';
                editor.value = '';
                break;
            case 4: // Tipo
                // Mostrar selector de tipo
                showTipoSelector(r, c, event);
                return;
            case 5: // Descripción
                editor.type = 'text';
                editor.value = '';
                break;
            default:
                return cancelEdit();
        }
    }

    editor.focus();
    editor.select();
}

async function commitEdit() {
    if (!isEditing || !activeCell) return;
    isEditing = false;

    const r = activeCell.r;
    const c = activeCell.c;
    const newValue = editor.value;

    console.log(`commitEdit: guardando r=${r}, c=${c}`);

    // Guardar sin tocar DOM, esperar respuesta
    await saveCellChange(r, c, newValue);
    
    // Solo ocultar después de completar
    editor.style.display = 'none';
}

function cancelEdit() {
    isEditing = false;
    editor.style.display = 'none';
    // Limpiar los cambios no guardados en la nueva fila
    const r = activeCell?.r;
    if (r && r >= transacciones.length) {
        // No limpiar newRowData aquí, podría estar editando múltiples campos
    }
}

async function updateTransaccion(id, data) {
    try {
        const response = await fetch(`/transacciones/${id}`, {
            method: 'PATCH',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            },
            body: JSON.stringify(data)
        });

        if (response.ok) {
            document.getElementById('status-msg').textContent = 'Guardado ✓';
            setTimeout(() => loadTransacciones(), 500);
        }
    } catch (error) {
        console.error('Error:', error);
        document.getElementById('status-msg').textContent = 'Error al guardar';
    }
}

// ─────────────────────────────────────────────
//  NEW ROW CREATION
// ─────────────────────────────────────────────
// ─────────────────────────────────────────────
//  NEW ROW CREATION
// ─────────────────────────────────────────────
function showCuentaSelector(r, c, event) {
    cancelEdit();
    const cellContent = document.createElement('div'); // Dummy para compatibilidad
    
    const select = document.createElement('select');
    select.id = 'inline-select-cuenta';
    select.style.cssText = 'position:fixed;z-index:101;' +
        'border:2px solid var(--accent);font-family:IBM Plex Mono;' +
        'background:var(--bg);color:var(--text);' +
        'font-size:13px;outline:none;padding:4px 8px;margin:0;box-sizing:border-box;' +
        'min-width:200px;';
    
    select.style.left = event.pageX + 'px';
    select.style.top = event.pageY + 'px';

    const cuentaFilter = document.getElementById('cuenta-filter');
    console.log('Cuentas disponibles en filtro:', cuentaFilter.options.length);
    
    if (cuentaFilter.options.length <= 1) {
        alert('No hay cuentas disponibles. Crea una cuenta primero.');
        return;
    }

    const placeholder = document.createElement('option');
    placeholder.value = '';
    placeholder.textContent = 'Selecciona...';
    placeholder.disabled = true;
    placeholder.selected = true;
    select.appendChild(placeholder);

    for (let opt of cuentaFilter.options) {
        if (opt.value) {
            const cloned = opt.cloneNode(true);
            console.log('Agregando opción:', opt.value, '-', opt.text);
            select.appendChild(cloned);
        }
    }

    const handleChange = (e) => {
        const cuentaId = e.target.value;
        const cuentaNombre = e.target.options[e.target.selectedIndex].text;
        
        console.log('Cuenta seleccionada:', cuentaId, '-', cuentaNombre);
        
        if (cuentaId) {
            // Guardar en newRowData y luego usar saveCellChange
            newRowData.cuenta_nombre = cuentaNombre;
            saveCellChange(r, c, cuentaId);
        }
        
        // Remover el select después de procesar
        try {
            if (document.body.contains(select)) {
                document.body.removeChild(select);
            }
        } catch (e) {
            console.warn('Error removiendo select de cuenta:', e);
        }
    };

    const handleBlur = () => {
        // No hacer nada en blur, permitir que change event controle la limpieza
    };

    select.addEventListener('change', handleChange);
    select.addEventListener('blur', handleBlur);

    document.body.appendChild(select);
    select.focus();
    select.click(); // Abrir el dropdown automáticamente
}

function showTipoSelector(r, c, event) {
    cancelEdit();
    const cellContent = document.createElement('div'); // Dummy para compatibilidad
    
    const select = document.createElement('select');
    select.id = 'inline-select-tipo';
    select.style.cssText = 'position:fixed;z-index:101;' +
        'border:2px solid var(--accent);font-family:IBM Plex Mono;' +
        'background:var(--bg);color:var(--text);' +
        'font-size:13px;outline:none;padding:4px 8px;margin:0;box-sizing:border-box;' +
        'min-width:150px;';
    
    select.style.left = event.pageX + 'px';
    select.style.top = event.pageY + 'px';

    const placeholder = document.createElement('option');
    placeholder.value = '';
    placeholder.textContent = 'Selecciona...';
    placeholder.disabled = true;
    placeholder.selected = true;
    select.appendChild(placeholder);

    ['ingreso', 'egreso', 'inversion', 'costo'].forEach(tipo => {
        const option = document.createElement('option');
        option.value = tipo;
        option.textContent = tipo.charAt(0).toUpperCase() + tipo.slice(1);
        select.appendChild(option);
    });

    const handleChange = (e) => {
        const tipoSeleccionado = e.target.value;
        
        console.log('Tipo seleccionado:', tipoSeleccionado);
        
        if (tipoSeleccionado) {
            // Usar saveCellChange para guardar directamente
            saveCellChange(r, c, tipoSeleccionado);
        }
        
        // Remover el select después de procesar
        try {
            if (document.body.contains(select)) {
                document.body.removeChild(select);
            }
        } catch (e) {
            console.warn('Error removiendo select de tipo:', e);
        }
    };

    const handleBlur = () => {
        // No hacer nada en blur, permitir que change event controle la limpieza
    };

    select.addEventListener('change', handleChange);
    select.addEventListener('blur', handleBlur);

    document.body.appendChild(select);
    select.focus();
    select.click(); // Abrir el dropdown automáticamente
}

// Mapeo de columnas a nombres de campos en BD
function getFieldName(c) {
    const mapping = {
        1: 'fecha',
        2: 'cuenta_id',
        3: 'monto',
        4: 'tipo',
        5: 'descripcion'
    };
    return mapping[c] || null;
}

// Guardar cambio individual de celda (modular)
async function saveCellChange(r, c, value) {
    const fieldName = getFieldName(c);
    if (!fieldName) return false;

    const isNewRow = r >= transacciones.length;
    
    try {
        // Validaciones básicas
        if (fieldName === 'monto') {
            if (isNaN(value) || parseFloat(value) <= 0) {
                alert('⚠ Monto inválido');
                return false;
            }
            value = parseFloat(value);
        } else if (fieldName === 'cuenta_id') {
            value = parseInt(value);
        }

        // NUEVA TRANSACCIÓN: Acumular en newRowData, crear cuando tenga los 3 requeridos
        if (isNewRow && !newRowData.id) {
            console.log('📝 Acumulando:', fieldName, '=', value);
            newRowData[fieldName] = value;
            
            // Si tiene los 3 campos requeridos, crear
            if (newRowData.cuenta_id && newRowData.monto && newRowData.tipo) {
                const payload = {
                    cuenta_id: newRowData.cuenta_id,
                    monto: newRowData.monto,
                    tipo: newRowData.tipo,
                    descripcion: newRowData.descripcion || null,
                    fecha: newRowData.fecha || null
                };

                const response = await fetch(`/api/transacciones-hoja`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    },
                    body: JSON.stringify(payload)
                });

                if (response.ok) {
                    const result = await response.json();
                    newRowData.id = result.id || result.data?.id;
                    console.log('✓ Creada transacción ID:', newRowData.id);
                } else {
                    const error = await response.json();
                    alert('❌ Error al guardar:\n' + JSON.stringify(error.errors || error.message));
                    console.error('Error POST:', error);
                    return false;
                }
            }
        }
        // TRANSACCIÓN EXISTENTE O NUEVA CON ID: Editar silenciosamente
        else if (newRowData.id || !isNewRow) {
            const txId = newRowData.id || transacciones[r]?.id;
            if (!txId) return false;

            console.log('✏ Guardando transacción', txId, ':', fieldName);
            
            const payload = { [fieldName]: value };

            const response = await fetch(`/transacciones/${txId}`, {
                method: 'PATCH',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                },
                body: JSON.stringify(payload)
            });

            if (!response.ok) {
                const error = await response.json();
                alert('❌ Error al guardar:\n' + (error.message || 'Error desconocido'));
                console.error('Error PATCH:', error);
                return false;
            }
            
            console.log('✓ Guardado:', fieldName);
        }
        
        // Guardar en newRowData para próximas ediciones
        newRowData[fieldName] = value;
        return true;

    } catch (error) {
        alert('❌ Error: ' + error.message);
        console.error('Error en saveCellChange:', error);
        return false;
    }
}

async function guardarNuevaTransaccion() {
    // DEPRECADO: Mantener para backwards compatibility
    // El nuevo flujo usa saveCellChange() para cada celda
    console.log('⚠ guardarNuevaTransaccion() deprecated, usar saveCellChange()');
    return false;
}

async function guardarNuevaTransaccionOld() {
    // Prevenir guardados simultáneos
    if (isSavingTransaction) {
        console.log('⏳ Guardado en progreso, evitando duplicados');
        return false;
    }

    // Validar que tenga datos mínimos
    if (!newRowData.cuenta_id || !newRowData.monto || !newRowData.tipo) {
        console.log('Faltan datos:', newRowData);
        document.getElementById('status-msg').textContent = 'Faltan datos requeridos';
        return false;
    }

    isSavingTransaction = true;
    console.log('🔒 Guardando nueva transacción:', newRowData);
    document.getElementById('status-msg').textContent = '⏳ Guardando...';

    try {
        const payload = {
            cuenta_id: newRowData.cuenta_id,
            monto: newRowData.monto,
            tipo: newRowData.tipo,
            descripcion: newRowData.descripcion || null,
            fecha: newRowData.fecha || null
        };

        console.log('Payload enviado:', JSON.stringify(payload));

        const response = await fetch(`/api/transacciones-hoja`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            },
            body: JSON.stringify(payload)
        });

        console.log('Response status:', response.status);
        
        // Intentar parsear como JSON
        const text = await response.text();
        console.log('Response body:', text);
        
        let result;
        try {
            result = JSON.parse(text);
        } catch (e) {
            console.error('No se pudo parsear JSON:', e);
            document.getElementById('status-msg').textContent = 'Error en respuesta del servidor';
            isSavingTransaction = false;
            return false;
        }

        if (response.ok && result.success) {
            document.getElementById('status-msg').textContent = '✓ Transacción creada';
            console.log('✓ Transacción guardada exitosamente');
            
            // Limpiar COMPLETAMENTE newRowData antes de recargar
            newRowData = {
                fecha: '',
                cuenta_id: null,
                cuenta_nombre: '',
                monto: null,
                tipo: '',
                descripcion: ''
            };
            
            // Recargar transacciones
            console.log('Recargando transacciones...');
            setTimeout(() => {
                loadTransacciones().then(() => {
                    console.log('✓ Recarga completa');
                    isSavingTransaction = false;
                    // Renderizar la nueva fila vacía
                    if (transacciones.length > 0) {
                        const newRowIdx = transacciones.length;
                        for (let c = 0; c < COLS; c++) {
                            renderCell(newRowIdx, c);
                        }
                        setActive(newRowIdx, 1);
                    }
                });
            }, 300);
            
            return true;
        } else {
            // Manejo de errores según el código de estado
            let errorMsg = result.message || 'Error desconocido';
            
            if (response.status === 400) {
                // Error de validación de negocio (ej: saldo insuficiente)
                if (result.saldo_actual !== undefined) {
                    errorMsg = `Saldo insuficiente: tienes $${result.saldo_actual.toFixed(2)}, necesitas $${result.monto_requerido.toFixed(2)}`;
                }
                document.getElementById('status-msg').textContent = '⚠ ' + errorMsg;
            } else if (response.status === 422) {
                // Error de validación de datos
                if (result.errors) {
                    errorMsg = Object.values(result.errors).join(', ');
                }
                document.getElementById('status-msg').textContent = '✗ ' + errorMsg;
            } else if (response.status === 500) {
                // Error del servidor
                document.getElementById('status-msg').textContent = '✗ Error del servidor: ' + errorMsg;
            } else {
                document.getElementById('status-msg').textContent = '✗ Error: ' + errorMsg;
            }
            
            console.warn('Error response:', {status: response.status, result});
            isSavingTransaction = false;
            return false;
        }
    } catch (error) {
        console.error('Error en fetch:', error);
        document.getElementById('status-msg').textContent = '✗ Error: ' + error.message;
        isSavingTransaction = false;
        return false;
    }
}

// ─────────────────────────────────────────────
//  KEYBOARD NAVIGATION
// ─────────────────────────────────────────────
document.addEventListener('keydown', e => {
    if (!activeCell) return;

    if (isEditing) {
        if (e.key === 'Enter') { 
            commitEdit();
            e.preventDefault();
            return;
        }
        if (e.key === 'Escape') {
            cancelEdit();
            e.preventDefault();
            return;
        }
        if (e.key === 'Tab') {
            commitEdit();
            const isNewRow = activeCell.r >= transacciones.length;
            // En filas nuevas, no navegar con Tab
            if (!isNewRow) {
                moveActive(0, 1);
            }
            e.preventDefault();
            return;
        }
        return;
    }

    if (e.key === 'Delete' || e.key === 'Backspace') {
        e.preventDefault(); return;
    }

    if (e.key === 'Enter') { 
        const isNewRow = activeCell.r >= transacciones.length;
        if (isNewRow) {
            // En filas nuevas, no hacer nada (el usuario debe dar tab para siguiente campo)
            e.preventDefault();
            return;
        } else {
            moveActive(1, 0); 
        }
        e.preventDefault(); 
        return; 
    }
    if (e.key === 'ArrowUp') { moveActive(-1, 0); e.preventDefault(); return; }
    if (e.key === 'ArrowDown') { moveActive(1, 0); e.preventDefault(); return; }
    if (e.key === 'ArrowLeft') { moveActive(0, -1); e.preventDefault(); return; }
    if (e.key === 'ArrowRight') { moveActive(0, 1); e.preventDefault(); return; }

    if (e.key === 'F2') { startEditing(activeCell.r, activeCell.c); e.preventDefault(); return; }
});

function moveActive(dr, dc) {
    if (!activeCell) return;
    const maxRow = transacciones.length; // Permitir ir una fila más abajo para agregar
    const r = Math.max(0, Math.min(maxRow, activeCell.r + dr));
    const c = Math.max(0, Math.min(COLS - 1, activeCell.c + dc));
    setActive(r, c);
    scrollToCell(r, c);
}

function scrollToCell(r, c) {
    const el = getCell(r, c);
    if (el) el.scrollIntoView({ block: 'nearest', inline: 'nearest' });
}

// ─────────────────────────────────────────────
//  STATUS BAR
// ─────────────────────────────────────────────
function updateStatusBar() {
    let total = 0, ingresos = 0, egresos = 0;

    transacciones.forEach(tx => {
        const monto = parseFloat(tx.monto);
        if (tx.tipo === 'ingreso') ingresos += monto;
        else egresos += monto;
    });

    total = ingresos - egresos;

    document.getElementById('st-total').textContent = `$${total.toFixed(2)}`;
    document.getElementById('st-ingreso').textContent = `$${ingresos.toFixed(2)}`;
    document.getElementById('st-egreso').textContent = `$${egresos.toFixed(2)}`;
    document.getElementById('st-count').textContent = transacciones.length;
}

// ─────────────────────────────────────────────
//  EXPORT CSV
// ─────────────────────────────────────────────
document.getElementById('btn-export').addEventListener('click', () => {
    let csv = COLUMNS.join(',') + '\n';
    transacciones.forEach(tx => {
        csv += `${tx.id},${tx.fecha},"${tx.cuenta?.nombre || '-'}",${tx.monto},${tx.tipo},"${(tx.descripcion || '').replace(/"/g, '""')}"\n`;
    });
    const blob = new Blob([csv], { type: 'text/csv;charset=utf-8;' });
    const link = document.createElement("a");
    link.href = URL.createObjectURL(blob);
    link.download = `transacciones_${new Date().toISOString().split('T')[0]}.csv`;
    link.click();
});

// ─────────────────────────────────────────────
//  DELETE ROW
// ─────────────────────────────────────────────
document.getElementById('btn-delete').addEventListener('click', async () => {
    if (!activeCell || activeCell.r >= transacciones.length) return;
    
    const tx = transacciones[activeCell.r];
    if (!confirm(`¿Eliminar transacción #${tx.id}?`)) return;

    try {
        const response = await fetch(`/transacciones/${tx.id}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            }
        });

        if (response.ok) {
            document.getElementById('status-msg').textContent = 'Eliminado ✓';
            loadTransacciones();
        }
    } catch (error) {
        console.error('Error:', error);
        document.getElementById('status-msg').textContent = 'Error al eliminar';
    }
});

// ─────────────────────────────────────────────
//  FILTERS & REFRESH
// ─────────────────────────────────────────────
document.getElementById('btn-refresh').addEventListener('click', loadTransacciones);
document.getElementById('cuenta-filter').addEventListener('change', loadTransacciones);
document.getElementById('tipo-filter').addEventListener('change', loadTransacciones);
document.getElementById('fecha-desde').addEventListener('change', loadTransacciones);
document.getElementById('fecha-hasta').addEventListener('change', loadTransacciones);

// Cargar opciones de cuenta
async function loadCuentas() {
    try {
        const response = await fetch(`/api/cuentas-del-usuario`, {
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
            }
        });

        if (response.ok) {
            const cuentas = await response.json();
            ['cuenta-filter', 'form-cuenta'].forEach(id => {
                const select = document.getElementById(id);
                if (select) {
                    cuentas.forEach(cuenta => {
                        const option = document.createElement('option');
                        option.value = cuenta.id;
                        option.textContent = cuenta.nombre;
                        select.appendChild(option);
                    });
                }
            });
        }
    } catch (error) {
        console.error('Error al cargar cuentas:', error);
    }
}

// Auto-guardar cambios del formulario
async function saveFormField(fieldName, value) {
    const statusEl = document.getElementById('form-status');
    
    // Si es submit manual desde el botón
    if (fieldName === 'submit') {
        if (!newRowData.id) {
            // Nueva transacción
            const payload = {
                cuenta_id: newRowData.cuenta_id,
                monto: newRowData.monto,
                tipo: newRowData.tipo,
                descripcion: newRowData.descripcion || null,
                fecha: newRowData.fecha || null
            };

            statusEl.textContent = '💾 Guardando...';
            try {
                const response = await fetch(`/api/transacciones-hoja`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    },
                    body: JSON.stringify(payload)
                });

                if (response.ok) {
                    const result = await response.json();
                    statusEl.textContent = '✓ Guardado';
                    
                    // Recargar tabla y limpiar
                    setTimeout(() => {
                        loadTransacciones();
                        document.getElementById('form-fecha').value = new Date().toISOString().split('T')[0];
                        document.getElementById('form-cuenta').value = '';
                        document.getElementById('form-monto').value = '';
                        document.getElementById('form-tipo').value = '';
                        document.getElementById('form-descripcion').value = '';
                        newRowData = {};
                        statusEl.textContent = 'LISTO';
                    }, 500);
                } else {
                    const error = await response.json();
                    statusEl.textContent = '❌ Error';
                    alert('Error: ' + (error.message || JSON.stringify(error.errors)));
                }
            } catch (error) {
                statusEl.textContent = '❌ Error';
                alert('Error: ' + error.message);
            }
        }
        return;
    }
    
    // No auto-guardar: solo acumular datos
    if (!newRowData.id) {
        // Nueva transacción: acumular en newRowData
        if (fieldName === 'cuenta') {
            newRowData.cuenta_id = parseInt(value);
            newRowData.cuenta_nombre = document.querySelector(`#form-cuenta option[value="${value}"]`)?.textContent || '';
        } else if (fieldName === 'monto') {
            newRowData.monto = value ? parseFloat(value) : null;
        } else {
            newRowData[fieldName] = value;
        }
        
        // Mostrar estado de edición
        const filledCount = [newRowData.cuenta_id, newRowData.monto, newRowData.tipo].filter(v => v).length;
        statusEl.textContent = `✎ ${filledCount}/3 campos`;
    }
}

// Inicializar event listeners del formulario
function initFormListeners() {
    const fields = {
        'form-fecha': 'fecha',
        'form-cuenta': 'cuenta',
        'form-monto': 'monto',
        'form-tipo': 'tipo',
        'form-descripcion': 'descripcion'
    };
    
    Object.entries(fields).forEach(([id, fieldName]) => {
        const el = document.getElementById(id);
        if (el) {
            el.addEventListener('change', (e) => {
                saveFormField(fieldName, e.target.value);
            });
            el.addEventListener('blur', (e) => {
                if (e.target.value) {
                    saveFormField(fieldName, e.target.value);
                }
            });
        }
    });
    
    // Establecer fecha actual por defecto
    const dateInput = document.getElementById('form-fecha');
    if (dateInput) {
        dateInput.value = new Date().toISOString().split('T')[0];
    }
    
    // Botón guardar manual
    const saveBtn = document.getElementById('form-save-btn');
    if (saveBtn) {
        saveBtn.addEventListener('click', () => {
            const statusEl = document.getElementById('form-status');
            
            // Validar que tenga los 3 campos requeridos
            if (!newRowData.cuenta_id || !newRowData.monto || !newRowData.tipo) {
                statusEl.textContent = '❌ Falta: Cuenta, Monto o Tipo';
                alert('Por favor completa todos los campos requeridos.');
                return;
            }
            
            // Guardar manualmente
            saveFormField('submit', '');
        });
    }
}

// ─────────────────────────────────────────────
//  INIT
// ─────────────────────────────────────────────
function init() {
    buildGrid();
    loadCuentas();
    initFormListeners();
    loadTransacciones();
    document.getElementById('grid-wrapper').style.display = 'block';
    document.getElementById('loading').classList.remove('active');
    
    // Exponer funciones globales para debugging
    window.testDebug = function() {
        console.clear();
        console.log('=== ESTADO DE HOJAS DE CÁLCULO ===');
        console.log('newRowData:', newRowData);
        console.log('activeCell:', activeCell);
        console.log('transacciones.length:', transacciones.length);
        console.log('isEditing:', isEditing);
        return {newRowData, activeCell, transacciones: transacciones.length, isEditing};
    };
    
    console.log('✓ Hoja de cálculo iniciada. Usa testDebug() en la consola para ver el estado.');
}

// Esperar a que el DOM esté listo
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', init);
} else {
    init();
}
</script>
    </div>
</x-app-layout>
