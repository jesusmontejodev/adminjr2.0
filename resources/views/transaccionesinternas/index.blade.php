<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Transacciones internas') }}
        </h2>
    </x-slot>

    <div class="transaccionesinternas-view relative z-10 p-6 sm:p-10">

        <!-- HEADER -->
        <div class="ti-topbar">
            <div class="ti-title-row">
                <span class="ti-title-icon">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 12a8 8 0 0113.66-5.66L20 8"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12a8 8 0 01-13.66 5.66L4 16"/>
                    </svg>
                </span>
                <div>
                    <h1>Transacciones internas</h1>
                    <div class="ti-title-sub">
                        {{ $transaccionesinternas->count() }} {{ $transaccionesinternas->count() === 1 ? 'transferencia registrada' : 'transferencias registradas' }}
                    </div>
                </div>
            </div>

            <a href="{{ route('transaccionesinternas.create') }}" class="ti-btn-new">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Nueva transacción
            </a>
        </div>

        @if($transaccionesinternas->isEmpty())
            <!-- ESTADO VACÍO -->
            <div class="ti-table-panel">
                <div class="ti-empty">
                    <div class="ti-empty-icon">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 12a8 8 0 0113.66-5.66L20 8"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12a8 8 0 01-13.66 5.66L4 16"/>
                        </svg>
                    </div>
                    <h3>No hay transacciones internas registradas</h3>
                    <p>Registra tu primera transferencia entre cuentas.</p>
                    <a href="{{ route('transaccionesinternas.create') }}" class="ti-btn-new">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        Crear mi primera transferencia
                    </a>
                </div>
            </div>
        @else
            <!-- TABLA -->
            <div class="ti-table-panel">
                <div class="ti-table-scroll">
                    <table class="ti-table">
                        <thead>
                            <tr>
                                <th>Fecha</th>
                                <th>Transferencia</th>
                                <th class="ti-right">Monto</th>
                                <th>Descripción</th>
                                <th class="ti-right">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($transaccionesinternas as $t)
                                <tr>
                                    <td>
                                        <div class="ti-date-cell">
                                            <div class="ti-date-icon">
                                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                            </div>
                                            <div>
                                                <div class="ti-date-main">{{ $t->created_at->format('d/m/Y') }}</div>
                                                <div class="ti-date-sub">{{ $t->created_at->format('h:i A') }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="ti-flow">
                                            <span class="ti-flow-acc"><span class="ti-flow-dot" style="background: var(--ti-danger);"></span>{{ $t->cuentaOrigen->nombre }}</span>
                                            <span class="ti-flow-arrow">
                                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
                                            </span>
                                            <span class="ti-flow-acc"><span class="ti-flow-dot" style="background: var(--ti-success);"></span>{{ $t->cuentaDestino->nombre }}</span>
                                        </div>
                                    </td>
                                    <td class="ti-right">
                                        <span class="ti-amount">${{ number_format($t->monto, 2) }}</span>
                                    </td>
                                    <td>
                                        <div class="ti-desc" title="{{ $t->descripcion }}">{{ $t->descripcion ?? '-' }}</div>
                                    </td>
                                    <td>
                                        <div class="ti-row-actions">
                                            <a href="{{ route('transaccionesinternas.edit', $t) }}" class="ti-icon-btn ti-edit" title="Editar">
                                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16.5 3.5a2.1 2.1 0 013 3L7 19l-4 1 1-4 12.5-12.5z"/></svg>
                                            </a>
                                            <form action="{{ route('transaccionesinternas.destroy', $t) }}" method="POST"
                                                  onsubmit="return confirm('¿Eliminar transferencia?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="ti-icon-btn ti-delete" title="Eliminar">
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
        });
    </script>
</x-app-layout>
