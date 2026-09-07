<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Detalle de Cuenta por Cobrar') }}
        </h2>
    </x-slot>

    <div class="max-w-4xl mx-auto px-6 py-10">

        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6 space-y-4">
            <p><strong>Nombre clave:</strong> {{ $cuenta->nombre_clave }}</p>
            <p><strong>Descripción:</strong> {{ $cuenta->descripcion }}</p>
            <p><strong>Monto:</strong> ${{ number_format($cuenta->monto, 2) }}</p>
            <p><strong>Fecha:</strong> {{ $cuenta->fecha }}</p>
            <p><strong>Estado:</strong>
                @if($cuenta->concretado)
                    ✅ Pagado
                @else
                    ⏳ Pendiente
                @endif
            </p>
        </div>

        <div class="mt-6">
            <a href="{{ route('cuentasporcobrar.index') }}"
                class="px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white rounded-lg shadow">
                ⬅ Volver
            </a>
        </div>
    </div>
</x-app-layout>
