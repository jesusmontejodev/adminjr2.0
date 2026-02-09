<x-app-layout>
    <div class="relative z-10 p-6 sm:p-10">

        <!-- HEADER -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-6 mb-10">
            <h1 class="flex items-center gap-3 text-white text-xl font-bold">
                <span class="icon-circle">
                    <!-- SVG account_balance -->
                   <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                </svg>
            </span>
                Mis Cuentas
            </h1>

            <a href="{{ route('cuentas.create') }}" class="btn-primary">
                <!-- SVG add -->
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M12 4v16m8-8H4"/>
                </svg>
                Nueva Cuenta
            </a>
        </div>

        <!-- SALDO TOTAL -->
        <div class="saldo-card mb-10">
            <div>
                <p class="saldo-label">Saldo Total</p>
                <p class="saldo-monto">
                    ${{ number_format($cuentas->sum('saldo_actual'), 2) }}
                </p>
            </div>

            <div class="icon-circle">
                <!-- SVG paid -->
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 2v20M17 6.5c0-2-2.5-3.5-5-3.5S7 4.5 7 6.5
                        9.5 9 12 9s5 1.5 5 3.5-2.5 3.5-5 3.5-5-1.5-5-3.5"/>
                </svg>
            </div>
        </div>

        <!-- TABLA -->
<div class="tabla-container overflow-x-auto">
    <table class="tabla min-w-[720px]">
        <thead>
            <tr>
                <th>ID</th>
                <th>Cuenta</th>
                <th>Saldo</th>
                <th class="hidden md:table-cell">Descripción</th>
                <th class="text-right">Acciones</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($cuentas as $cuenta)
                <tr>
                    <td>{{ $cuenta->id }}</td>

                    <!-- ✅ CUENTA (SIN FLEX EN TD) -->
                    <td class="font-semibold">
                        <div class="celda-flex">
                            <svg class="w-[18px] h-[18px] text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M3 10h18M5 10V20h14V10M9 20V14h6v6M12 3l8 5H4l8-5z"/>
                            </svg>
                            {{ $cuenta->nombre }}
                        </div>
                    </td>

                    <td class="saldo-verde">
                        ${{ number_format($cuenta->saldo_actual, 2) }}
                    </td>

                    <td class="hidden md:table-cell">
                        {{ $cuenta->descripcion }}
                    </td>

                    <!-- ✅ ACCIONES (DIV INTERNO) -->
                    <td class="td-acciones">
                        <div class="acciones">
                            <a href="{{ route('cuentas.edit', $cuenta->id) }}" class="btn-action btn-edit">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M16.5 3.5a2.1 2.1 0 013 3L7 19l-4 1 1-4 12.5-12.5z"/>
                                </svg>
                                <span class="hidden sm:inline">Editar</span>
                            </a>

                            <form action="{{ route('cuentas.destroy', $cuenta->id) }}"
                                  method="POST"
                                  onsubmit="return confirm('¿Eliminar esta cuenta?')">
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
            @endforeach
        </tbody>
    </table>
</div>


    </div>
</x-app-layout>