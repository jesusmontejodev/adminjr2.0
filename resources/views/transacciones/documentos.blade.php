<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Documentos') }}
        </h2>
    </x-slot>

    <div class="relative z-10 p-6 sm:p-10 max-w-5xl mx-auto">

        <div class="flex items-center justify-between gap-4 mb-8 flex-wrap">
            <div>
                <h1 class="text-xl font-bold text-gray-900 dark:text-white">Copias e importaciones</h1>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                    Historial de las copias que generaste y los archivos que subiste desde la Hoja de Cálculo.
                </p>
            </div>
            <a href="{{ route('transacciones.hoja-calculo') }}"
               class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-semibold
                      bg-transparent border border-red-500/45 text-red-600
                      dark:border-red-500/45 dark:text-red-400
                      hover:bg-red-50 dark:hover:bg-red-500/10 transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 18l-6-6 6-6"/>
                </svg>
                Volver a la hoja
            </a>
        </div>

        @if (session('success'))
            <div class="mb-6 px-4 py-3 rounded-xl text-sm bg-green-50 text-green-700 border border-green-200 dark:bg-green-500/10 dark:text-green-400 dark:border-green-500/20">
                {{ session('success') }}
            </div>
        @endif

        @if ($documentos->isEmpty())
            <div class="rounded-2xl border border-dashed border-gray-300 dark:border-white/10 p-14 text-center
                        bg-white dark:bg-black/40 dark:backdrop-blur-2xl">
                <div class="w-14 h-14 rounded-2xl mx-auto mb-4 flex items-center justify-center
                            bg-red-50 text-red-500 dark:bg-red-500/10 dark:text-red-400">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m-6 4h6m2 5H7a2 2 0 01-2-2V4a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V20a2 2 0 01-2 2z"/>
                    </svg>
                </div>
                <h3 class="font-semibold text-gray-900 dark:text-white mb-1">Todavía no tienes documentos</h3>
                <p class="text-sm text-gray-500 dark:text-gray-400">
                    Genera una copia desde la Hoja de Cálculo para empezar.
                </p>
            </div>
        @else
            <div class="rounded-2xl border border-gray-200 dark:border-red-500/10 overflow-hidden
                        bg-white dark:bg-black/40 dark:backdrop-blur-2xl">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="text-left text-xs uppercase tracking-wide text-gray-500 dark:text-gray-400 border-b border-gray-200 dark:border-white/10">
                            <th class="px-5 py-3 font-semibold">Nombre</th>
                            <th class="px-5 py-3 font-semibold">Tipo</th>
                            <th class="px-5 py-3 font-semibold">Estado</th>
                            <th class="px-5 py-3 font-semibold">Filas</th>
                            <th class="px-5 py-3 font-semibold">Fecha</th>
                            <th class="px-5 py-3 font-semibold text-right">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($documentos as $documento)
                            @php
                                $estadoStyles = [
                                    'listo' => 'bg-green-50 text-green-700 dark:bg-green-500/10 dark:text-green-400',
                                    'importado' => 'bg-green-50 text-green-700 dark:bg-green-500/10 dark:text-green-400',
                                    'pendiente_revision' => 'bg-red-50 text-red-700 dark:bg-red-500/10 dark:text-red-400',
                                    'error' => 'bg-red-50 text-red-700 dark:bg-red-500/10 dark:text-red-400',
                                    'descartado' => 'bg-gray-100 text-gray-500 dark:bg-white/5 dark:text-gray-400',
                                ];
                                $estadoLabel = [
                                    'listo' => 'Listo',
                                    'importado' => 'Importado',
                                    'pendiente_revision' => 'Pendiente de revisión',
                                    'error' => 'Error',
                                    'descartado' => 'Descartado',
                                ];
                            @endphp
                            <tr class="border-b border-gray-100 dark:border-white/5 last:border-0" data-documento-id="{{ $documento->id }}">
                                <td class="px-5 py-3 text-gray-900 dark:text-gray-100 font-medium">{{ $documento->nombre }}</td>
                                <td class="px-5 py-3 text-gray-500 dark:text-gray-400">
                                    {{ $documento->tipo === 'exportacion' ? 'Copia' : 'Importación' }}
                                </td>
                                <td class="px-5 py-3">
                                    <span class="inline-flex px-2.5 py-1 rounded-full text-xs font-semibold {{ $estadoStyles[$documento->estado] ?? '' }}">
                                        {{ $estadoLabel[$documento->estado] ?? $documento->estado }}
                                    </span>
                                </td>
                                <td class="px-5 py-3 text-gray-500 dark:text-gray-400">
                                    @if($documento->tipo === 'importacion')
                                        {{ $documento->filas_importadas ?? 0 }} / {{ $documento->filas_detectadas ?? 0 }} nuevas
                                    @else
                                        {{ $documento->filas_detectadas ?? '-' }}
                                    @endif
                                </td>
                                <td class="px-5 py-3 text-gray-500 dark:text-gray-400">{{ $documento->created_at->format('d/m/Y H:i') }}</td>
                                <td class="px-5 py-3">
                                    <div class="flex items-center justify-end gap-2">
                                        @if ($documento->estado === 'pendiente_revision')
                                            <button type="button"
                                                    class="doc-confirmar px-3 py-1.5 rounded-lg text-xs font-semibold border border-green-500/45 text-green-600 dark:text-green-400 hover:bg-green-50 dark:hover:bg-green-500/10 transition"
                                                    data-id="{{ $documento->id }}">
                                                Confirmar
                                            </button>
                                            <button type="button"
                                                    class="doc-descartar px-3 py-1.5 rounded-lg text-xs font-semibold border border-red-500/45 text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-500/10 transition"
                                                    data-id="{{ $documento->id }}">
                                                Descartar
                                            </button>
                                        @else
                                            <a href="{{ route('documentos.descargar', $documento) }}"
                                               class="px-3 py-1.5 rounded-lg text-xs font-semibold border border-gray-300 dark:border-white/15 text-gray-600 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-white/5 transition">
                                                Descargar
                                            </a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-6">
                {{ $documentos->links() }}
            </div>
        @endif
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const csrf = document.querySelector('meta[name="csrf-token"]').content;

            document.querySelectorAll('.doc-confirmar').forEach(function (btn) {
                btn.addEventListener('click', async function () {
                    if (!confirm('¿Confirmar e importar los movimientos detectados en este documento?')) return;
                    btn.disabled = true;
                    try {
                        const res = await fetch(`/documentos/${btn.dataset.id}/confirmar`, {
                            method: 'POST',
                            headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': csrf }
                        });
                        const data = await res.json();
                        if (!res.ok || !data.success) {
                            alert('⚠ ' + (data.message || 'No se pudo importar.'));
                            btn.disabled = false;
                            return;
                        }
                        alert(`✓ ${data.importadas} de ${data.total} movimiento(s) importado(s).`);
                        window.location.reload();
                    } catch (e) {
                        alert('⚠ Error al importar.');
                        btn.disabled = false;
                    }
                });
            });

            document.querySelectorAll('.doc-descartar').forEach(function (btn) {
                btn.addEventListener('click', async function () {
                    if (!confirm('¿Descartar este documento sin importar sus movimientos?')) return;
                    btn.disabled = true;
                    try {
                        await fetch(`/documentos/${btn.dataset.id}/descartar`, {
                            method: 'POST',
                            headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': csrf }
                        });
                        window.location.reload();
                    } catch (e) {
                        alert('⚠ Error al descartar.');
                        btn.disabled = false;
                    }
                });
            });
        });
    </script>
</x-app-layout>
