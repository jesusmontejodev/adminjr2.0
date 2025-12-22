<x-app-layout>
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-8 text-black">
        <h1 class="text-2xl font-semibold text-gray-900 mb-6">Crear Cuenta</h1>

        @if ($errors->any())
            <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('cuentas.store') }}" method="POST" class="bg-white shadow rounded-lg p-6">
            @csrf

            <div class="mb-4 ">
                <label for="nombre" class="block text-sm font-medium text-black">Nombre</label>
                <input type="text" name="nombre" id="nombre"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                    value="{{ old('nombre') }}" required>
            </div>

            <div class="mb-4">
                <label for="saldo_inicial" class="block text-sm font-medium text-gray-700">Saldo Inicial</label>
                <input type="number" step="0.01" name="saldo_inicial" id="saldo_inicial"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                    value="{{ old('saldo_inicial') }}" required>
            </div>

            <div class="mb-4">
                <label for="descripcion" class="block text-sm font-medium text-gray-700">Descripción</label>
                <textarea name="descripcion" id="descripcion"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                    rows="3">{{ old('descripcion') }}</textarea>
            </div>

            <div class="flex space-x-2">
                <button type="submit"
                        class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-md shadow">
                    Guardar
                </button>
                <a href="{{ route('cuentas.index') }}"
                    class="px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white rounded-md shadow">
                    Cancelar
                </a>
            </div>
        </form>
    </div>
</x-app-layout>
