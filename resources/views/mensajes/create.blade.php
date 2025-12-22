<x-app-layout>
    <div class="max-w-3xl mx-auto px-6 py-8">
        <h1 class="text-2xl font-semibold mb-6">Crear Mensaje</h1>

        <form action="{{ route('mensajes.store') }}" method="POST">
            @include('mensajes.form')
        </form>
    </div>
</x-app-layout>
