<x-app-layout>
<div class="relative z-10 p-6 sm:p-10 max-w-[1440px] mx-auto">
    <!-- HEADER -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-6 mb-10">
            <h1 class="flex items-center gap-3 text-white text-xl font-bold">
                <span class="icon-circle">
                    <!-- SVG account_balance -->
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round"stroke-linejoin="round"stroke-width="2"d="M4 12a8 8 0 0113.66-5.66L20 8"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12a8 8 0 01-13.66 5.66L4 16"/>
                    </svg>
            </span>
                Transacciones internas
            </h1>

       <a href="{{ route('transaccionesinternas.create') }}" class="btn-primary">
                <!-- SVG add -->
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M12 4v16m8-8H4"/>
                </svg>
                Nueva transacción
            </a>
    </div>

    <!-- TABLA / CARD -->
    <div class="tabla-container">
        <table class="tabla">
            <thead>
                <tr>
                    <th>Fecha</th>
                    <th>Cuenta origen</th>
                    <th>Cuenta destino</th>
                    <th>Monto</th>
                    <th>Descripción</th>
                    <th class="text-right">Acciones</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($transaccionesinternas as $t)
                <tr>
                    <td>{{ $t->created_at->format('d/m/Y H:i') }}</td>
                    <td>{{ $t->cuentaOrigen->nombre }}</td>
                    <td>{{ $t->cuentaDestino->nombre }}</td>
                    <td class="font-semibold">${{ number_format($t->monto, 2) }}</td>
                    <td>{{ $t->descripcion ?? '-' }}</td>

                    <td class="acciones-td">
                        <div class="acciones">
                            <a href="{{ route('transaccionesinternas.edit', $t) }}"
                               class="btn-action btn-edit">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M16.5 3.5a2.1 2.1 0 013 3L7 19l-4 1 1-4 12.5-12.5z"/>
                                    </svg>
                                    <span class="hidden sm:inline">Editar</span>
                            </a>

                            <form action="{{ route('transaccionesinternas.destroy', $t) }}"
                                  method="POST"
                                  onsubmit="return confirm('¿Eliminar transferencia?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn-action btn-delete">
                                   <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M3 6h18M8 6V4h8v2M6 6v14a2 2 0 002 2h8
                                                a2 2 0 002-2V6M10 11v6M14 11v6"/>
                                        </svg>
                                        <span class="hidden sm:inline">Eliminar</span>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center text-gray-400 py-6">
                        No hay transacciones internas registradas
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
</x-app-layout>