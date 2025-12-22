{{-- resources/views/transacciones/interna.blade.php --}}

@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Transferencia Interna</h1>

    {{-- Mostrar errores de validación --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('transacciones.interna.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="cuenta_origen" class="form-label">Cuenta Origen</label>
            <select name="cuenta_origen" id="cuenta_origen" class="form-select" required>
                <option value="" disabled selected>Selecciona una cuenta</option>
                @foreach($cuentas as $cuenta)
                    <option value="{{ $cuenta->id }}">
                        {{ $cuenta->nombre }} (Saldo: ${{ number_format($cuenta->saldo_actual, 2) }})
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="cuenta_destino" class="form-label">Cuenta Destino</label>
            <select name="cuenta_destino" id="cuenta_destino" class="form-select" required>
                <option value="" disabled selected>Selecciona una cuenta</option>
                @foreach($cuentas as $cuenta)
                    <option value="{{ $cuenta->id }}">
                        {{ $cuenta->nombre }} (Saldo: ${{ number_format($cuenta->saldo_actual, 2) }})
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="monto" class="form-label">Monto</label>
            <input type="number" name="monto" id="monto" class="form-control" step="0.01" min="0.01" required>
        </div>

        <div class="mb-3">
            <label for="descripcion" class="form-label">Descripción (opcional)</label>
            <textarea name="descripcion" id="descripcion" class="form-control" rows="2"></textarea>
        </div>

        <button type="submit" class="btn btn-primary">Realizar Transferencia</button>
        <a href="{{ route('transacciones.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection
