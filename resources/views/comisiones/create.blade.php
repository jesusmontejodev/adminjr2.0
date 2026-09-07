<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Crear nuevo pago pendiente') }}
        </h2>
    </x-slot>

    <div class="max-w-4xl mx-auto px-6 py-10">

        <form action="{{ route('comisiones.store') }}" method="POST">
            @include('comisiones.form')
        </form>
    </div>
</x-app-layout>
