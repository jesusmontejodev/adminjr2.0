<x-app-layout>
    <div class="max-w-2xl mx-auto p-6 bg-white rounded-lg shadow-md">

        <h1 class="text-2xl font-bold mb-6">Editar Transacción Interna</h1>

        {{-- Mostrar errores --}}
        @if($errors->any())
            <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-800 rounded">
                <ul class="list-disc pl-5">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('transaccionesinternas.update', $transaccion->id) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            {{-- Cuenta Origen --}}
            <div>
                <label for="cuenta_origen_id" class="block text-sm font-medium text-gray-700">Cuenta Origen</label>
                <select name="cuenta_origen_id" id="cuenta_origen_id"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                        required>
                    <option value="">-- Selecciona una cuenta --</option>
                    @foreach($cuentas as $cuenta)
                        <option value="{{ $cuenta->id }}"
                            {{ old('cuenta_origen_id', $transaccion->cuenta_origen_id) == $cuenta->id ? 'selected' : '' }}>
                            {{ $cuenta->nombre }} (Saldo: {{ number_format($cuenta->saldo_actual, 2) }})
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Cuenta Destino --}}
            <div>
                <label for="cuenta_destino_id" class="block text-sm font-medium text-gray-700">Cuenta Destino</label>
                <select name="cuenta_destino_id" id="cuenta_destino_id"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                        required>
                    <option value="">-- Selecciona una cuenta --</option>
                    @foreach($cuentas as $cuenta)
                        <option value="{{ $cuenta->id }}"
                            {{ old('cuenta_destino_id', $transaccion->cuenta_destino_id) == $cuenta->id ? 'selected' : '' }}>
                            {{ $cuenta->nombre }} (Saldo: {{ number_format($cuenta->saldo_actual, 2) }})
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Monto --}}
            <div>
                <label for="monto" class="block text-sm font-medium text-gray-700">Monto</label>
                <input type="number" name="monto" id="monto" step="0.01"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                    value="{{ old('monto', $transaccion->monto) }}" required>
            </div>

            {{-- Descripción --}}
            <div>
                <label for="descripcion" class="block text-sm font-medium text-gray-700">Descripción</label>
                <textarea name="descripcion" id="descripcion" rows="3"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">{{ old('descripcion', $transaccion->descripcion) }}</textarea>
            </div>

            <div>
                <button type="submit"
                        class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg shadow">
                    Guardar cambios
                </button>
                <a href="{{ route('transaccionesinternas.index') }}"
                    class="px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white rounded-lg shadow ml-2">
                    Cancelar
                </a>
            </div>
        </form>
    </div>
</x-app-layout>
