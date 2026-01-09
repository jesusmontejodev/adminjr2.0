<x-app-layout>
    <div class="max-w-lg mx-auto mt-8">
        <form action="{{ route('transaccionesinternas.store') }}" method="POST" class="space-y-6 bg-white p-6 rounded-lg shadow-md">
            @csrf

            {{-- Cuenta origen --}}
            <div>
                <label for="cuenta_origen_id" class="block text-sm font-medium text-gray-700">
                    Cuenta origen:
                </label>
                <select name="cuenta_origen_id" id="cuenta_origen_id"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-gray-700"
                    required>
                    <option value="">-- Selecciona una cuenta --</option>
                    @foreach($cuentas as $cuenta)
                        <option value="{{ $cuenta->id }}"
                            {{ old('cuenta_origen_id') == $cuenta->id ? 'selected' : '' }}>
                            {{ $cuenta->nombre }} (Saldo: {{ number_format($cuenta->saldo_actual, 2) }})
                        </option>
                    @endforeach
                </select>
                @error('cuenta_origen_id')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Cuenta destino --}}
            <div>
                <label for="cuenta_destino_id" class="block text-sm font-medium text-gray-700">
                    Cuenta destino:
                </label>
                <select name="cuenta_destino_id" id="cuenta_destino_id"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-gray-700"
                    required>
                    <option value="">-- Selecciona una cuenta --</option>
                    @foreach($cuentas as $cuenta)
                        <option value="{{ $cuenta->id }}"
                            {{ old('cuenta_destino_id') == $cuenta->id ? 'selected' : '' }}>
                            {{ $cuenta->nombre }} (Saldo: {{ number_format($cuenta->saldo_actual, 2) }})
                        </option>
                    @endforeach
                </select>
                @error('cuenta_destino_id')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Monto --}}
            <div>
                <label for="monto" class="block text-sm font-medium text-gray-700">
                    Monto:
                </label>
                <input type="number" step="0.01" min="0.01" name="monto" id="monto"
                    value="{{ old('monto') }}"
                    class="text-gray-700 mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                    required
                    placeholder="0"

                    >
                @error('monto')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Descripción (opcional) --}}
            <div>
                <label for="descripcion" class="block text-sm font-medium text-gray-700">
                    Descripción:
                </label>
                <textarea name="descripcion" id="descripcion" rows="3"
                    placeholder="Descripción"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-gray-700" >{{ old('descripcion') }}</textarea>
                @error('descripcion')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Botón submit --}}
            <div class="flex justify-end">
                <button type="submit"
                    class="px-4 py-2 bg-indigo-600 text-white rounded-md shadow hover:bg-indigo-700">
                    Guardar transacción
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
