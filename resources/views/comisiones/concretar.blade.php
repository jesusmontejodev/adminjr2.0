<x-app-layout>
    <div class="max-w-4xl mx-auto px-6 py-10">
        <h1 class="text-2xl font-bold text-gray-900 dark:text-gray-100 mb-6">Crear nuevo pago pendiente</h1>

        <form action="{{ route('comisiones.concretar', $comision->id) }}" method="POST">
            @csrf

            {{-- Nombre del asesor --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nombre del asesor</label>
                <input type="text" name="nombre"
                    value="{{ old('nombre', $comision->nombre ?? '') }}"
                    class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-800 text-gray-900 dark:text-gray-100 shadow-sm"
                    readonly>
            </div>

            {{-- Precio --}}
            <div>
                <label for="precio" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Monto</label>
                <input type="number" step="0.01" name="monto" id="precio"
                    value="{{ old('monto', $comision->precio ?? '') }}"
                    class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-800 text-gray-900 dark:text-gray-100 shadow-sm">
            </div>

            {{-- Cuenta --}}
            <div>
                <label for="cuenta_id" class="block text-sm font-medium text-gray-700">Cuenta</label>
                <select name="cuenta_id" id="cuenta_id"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                    required>
                    <option value="">-- Selecciona una cuenta --</option>
                    @foreach($cuentas as $cuenta)
                        <option value="{{ $cuenta->id }}"
                            {{ old('cuenta_id') == $cuenta->id ? 'selected' : '' }}>
                            {{ $cuenta->nombre }} (Saldo: {{ number_format($cuenta->saldo_actual, 2) }})
                        </option>
                    @endforeach
                </select>
                @error('cuenta_id')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Categoría --}}
            <div>
                <label for="categoria_id" class="block text-sm font-medium text-gray-700">Categoría</label>
                <select name="categoria_id" id="categoria_id" required
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                    <option value="">-- Selecciona una categoría --</option>
                    @foreach($categorias as $categoria)
                        <option value="{{ $categoria->id }}"
                            {{ old('categoria_id') == $categoria->id ? 'selected' : '' }}>
                            {{ $categoria->nombre }}
                        </option>
                    @endforeach
                </select>
                @error('categoria_id')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Tipo --}}
            <div>
                <label for="tipo" class="block text-sm font-medium text-gray-700">Tipo</label>
                <select name="tipo" id="tipo" required
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                    <option value="">-- Selecciona tipo --</option>
                    <option value="ingreso" {{ old('tipo') == 'ingreso' ? 'selected' : '' }}>Ingreso</option>
                    <option value="gasto" {{ old('tipo') == 'gasto' ? 'selected' : '' }}>Gasto</option>
                </select>
                @error('tipo')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Botón --}}
            <div class="mt-6">
                <button type="submit"
                    class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg shadow">
                    Hacer transacción
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
