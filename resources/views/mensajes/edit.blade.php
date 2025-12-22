<x-app-layout>
    <div class="max-w-3xl mx-auto px-6 py-8">
        <h1 class="text-2xl font-semibold mb-6">Editar Mensaje</h1>

        <form action="{{ route('mensajes.update', $mensaje->id) }}" method="POST">
            @csrf
            @method('PUT')
            @include('mensajes.form')
        </form>
    </div>
</x-app-layout>
