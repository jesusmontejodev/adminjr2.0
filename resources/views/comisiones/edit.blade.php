<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Editar pago pendiente') }}
        </h2>
    </x-slot>

    <div class="max-w-4xl mx-auto px-6 py-10">

        <form action="{{ route('comisiones.update', $comision->id) }}" method="POST">
            @csrf
            @method('PUT')
            @include('comisiones.form')
        </form>
    </div>
</x-app-layout>
