<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Editar Mensaje') }}
        </h2>
    </x-slot>

    <div class="max-w-3xl mx-auto px-6 py-8">

        <form action="{{ route('mensajes.update', $mensaje->id) }}" method="POST">
            @csrf
            @method('PUT')
            @include('mensajes.form')
        </form>
    </div>
</x-app-layout>
