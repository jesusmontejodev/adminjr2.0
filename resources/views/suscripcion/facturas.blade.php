<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-semibold text-2xl text-white leading-tight">
                    {{ __('Mis Facturas') }}
                </h2>
                <p class="text-gray-400 mt-1">Historial de pagos y facturas</p>
            </div>

            <div class="flex space-x-3">
                <a href="{{ route('dashboard') }}"
                   class="px-4 py-2 bg-gray-800 hover:bg-gray-700 text-gray-300 text-sm rounded-lg border border-gray-700 transition">
                    <i class="fas fa-arrow-left mr-2"></i>Volver
                </a>
                <a href="{{ route('suscripcion.portal-facturacion') }}"
                   target="_blank"
                   class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white text-sm rounded-lg transition">
                    <i class="fas fa-cog mr-2"></i>Gestionar Suscripción
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            @if($invoices->isEmpty())
                <div class="bg-gray-900/50 rounded-xl p-8 text-center border border-gray-800">
                    <i class="fas fa-receipt text-4xl text-gray-700 mb-4"></i>
                    <h3 class="text-xl font-semibold text-gray-300 mb-2">No hay facturas</h3>
                    <p class="text-gray-500 mb-6">Todavía no tienes facturas generadas.</p>
                    <a href="{{ route('planes') }}"
                       class="px-6 py-3 bg-red-600 hover:bg-red-700 text-white font-medium rounded-lg transition">
                        Ver Planes
                    </a>
                </div>
            @else
                <div class="bg-gray-900/50 rounded-xl border border-gray-800 overflow-hidden">
                    <div class="p-6 border-b border-gray-800">
                        <h3 class="text-lg font-semibold text-white">Historial de Facturas</h3>
                        <p class="text-gray-400 text-sm mt-1">Todas tus facturas de suscripción</p>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead>
                                <tr class="border-b border-gray-800">
                                    <th class="text-left py-4 px-6 text-gray-400 font-medium">Fecha</th>
                                    <th class="text-left py-4 px-6 text-gray-400 font-medium">Descripción</th>
                                    <th class="text-left py-4 px-6 text-gray-400 font-medium">Total</th>
                                    <th class="text-left py-4 px-6 text-gray-400 font-medium">Estado</th>
                                    <th class="text-left py-4 px-6 text-gray-400 font-medium">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($invoices as $invoice)
                                    <tr class="border-b border-gray-800/50 hover:bg-gray-900/30">
                                        <td class="py-4 px-6 text-gray-300">
                                            {{ $invoice->date()->format('d/m/Y') }}
                                        </td>
                                        <td class="py-4 px-6 text-gray-300">
                                            {{ $invoice->description }}
                                        </td>
                                        <td class="py-4 px-6 text-gray-300">
                                            {{ $invoice->total() }}
                                        </td>
                                        <td class="py-4 px-6">
                                            @if($invoice->paid)
                                                <span class="px-3 py-1 bg-green-900/30 text-green-400 text-xs rounded-full">
                                                    Pagada
                                                </span>
                                            @else
                                                <span class="px-3 py-1 bg-red-900/30 text-red-400 text-xs rounded-full">
                                                    Pendiente
                                                </span>
                                            @endif
                                        </td>
                                        <td class="py-4 px-6">
                                            <a href="{{ route('suscripcion.descargar-factura', $invoice->id) }}"
                                               class="px-3 py-1.5 bg-gray-800 hover:bg-gray-700 text-gray-300 text-xs rounded-lg border border-gray-700 transition">
                                                <i class="fas fa-download mr-1.5"></i>
                                                Descargar
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="p-6 border-t border-gray-800 bg-gray-900/30">
                        <p class="text-gray-400 text-sm">
                            <i class="fas fa-info-circle mr-2"></i>
                            Todas las facturas son generadas automáticamente por Stripe.
                            Para más detalles visita el
                            <a href="{{ route('suscripcion.portal-facturacion') }}"
                               target="_blank"
                               class="text-red-400 hover:text-red-300">portal de facturación</a>.
                        </p>
                    </div>
                </div>
            @endif

        </div>
    </div>

</x-app-layout>
