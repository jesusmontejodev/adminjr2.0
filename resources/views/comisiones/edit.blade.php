<x-app-layout>
    <div class="max-w-4xl mx-auto px-6 py-10">
        <h1 class="text-2xl font-bold text-gray-900 dark:text-gray-100 mb-6">Editar pago pendiente</h1>

        <form action="{{ route('comisiones.update', $comision->id) }}" method="POST">
            @csrf
            @method('PUT')
            @include('comisiones.form')
        </form>
    </div>
</x-app-layout>
