<x-app-layout>
    <div class="max-w-3xl mx-auto py-6">
        <h1 class="text-2xl font-bold mb-6">Editar Transacción</h1>

        @if ($errors->any())
            <div class="mb-4 p-4 bg-red-100 text-red-800 rounded-lg">
                <ul class="list-disc pl-6">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('transacciones.update', $transaccion->id) }}" method="POST" class="space-y-6 bg-white p-6 rounded-lg shadow-md">
            @csrf
            @method('PUT')
            @include('transacciones.form')

            <div class="flex justify-end space-x-3 mt-6">
                <a href="{{ route('transacciones.index') }}" class="px-4 py-2 bg-gray-200 rounded-md hover:bg-gray-300 transition-colors">Cancelar</a>
                <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 transition-colors">Actualizar</button>
            </div>
        </form>

    </div>
</x-app-layout>
