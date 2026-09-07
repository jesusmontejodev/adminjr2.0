<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Categorías') }}
        </h2>
    </x-slot>

    <div class="categorias-view relative z-10 p-6 sm:p-10">

        <!-- HEADER -->
        <div class="cg-topbar">
            <div class="cg-title-row">
                <span class="cg-title-icon">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                    </svg>
                </span>
                <div>
                    <h1>Categorías</h1>
                    <div class="cg-title-sub">
                        {{ $categorias->count() }} {{ $categorias->count() === 1 ? 'categoría registrada' : 'categorías registradas' }}
                    </div>
                </div>
            </div>

            <a href="{{ route('categorias.create') }}" class="cg-btn-new">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Nueva categoría
            </a>
        </div>

        @if($categorias->isEmpty())
            <!-- ESTADO VACÍO -->
            <div class="cg-empty-preview">
                <div class="cg-empty-icon">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                    </svg>
                </div>
                <h3>Aún no tienes categorías</h3>
                <p>Crea tu primera categoría para organizar tus movimientos.</p>
                <a href="{{ route('categorias.create') }}" class="cg-btn-new">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Crear mi primera categoría
                </a>
            </div>
        @else
            <!-- BÚSQUEDA -->
            <div class="cg-toolbar">
                <div class="cg-search-box">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/>
                    </svg>
                    <input type="text" id="cg-search" placeholder="Buscar categoría por nombre...">
                </div>
            </div>

            <!-- LISTA DE CATEGORÍAS -->
            <div class="cg-panel" id="cg-list">
                @foreach ($categorias as $categoria)
                    <div class="cg-row" data-nombre="{{ Str::lower($categoria->nombre) }}">
                        <div class="cg-row-icon">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M7 7h10l4 5-4 5H7a2 2 0 01-2-2V9a2 2 0 012-2z"/>
                            </svg>
                        </div>
                        <div class="cg-row-name" title="{{ $categoria->nombre }}">{{ $categoria->nombre }}</div>

                        <div class="cg-row-actions">
                            <a href="{{ route('categorias.edit', $categoria) }}" class="cg-icon-btn cg-edit" title="Editar">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16.5 3.5a2.1 2.1 0 013 3L7 19l-4 1 1-4 12.5-12.5z"/>
                                </svg>
                            </a>

                            <form action="{{ route('categorias.destroy', $categoria) }}" method="POST"
                                  onsubmit="return confirm('¿Eliminar esta categoría?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="cg-icon-btn cg-delete" title="Eliminar">
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6h18M8 6V4h8v2M6 6v14a2 2 0 002 2h8a2 2 0 002-2V6M10 11v6M14 11v6"/>
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="cg-no-results" id="cg-no-results" style="display:none;">
                Ninguna categoría coincide con tu búsqueda.
            </div>
        @endif
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            @if(session('success'))
                showToast(@json(session('success')), 'success');
            @endif
            @if(session('error'))
                showToast(@json(session('error')), 'error');
            @endif

            var searchInput = document.getElementById('cg-search');
            var list = document.getElementById('cg-list');
            var noResults = document.getElementById('cg-no-results');

            if (!list || !searchInput) return;

            searchInput.addEventListener('input', function () {
                var term = (searchInput.value || '').toLowerCase().trim();
                var rows = list.querySelectorAll('.cg-row');
                var visibleCount = 0;

                rows.forEach(function (row) {
                    var matches = row.dataset.nombre.indexOf(term) !== -1;
                    row.classList.toggle('cg-hidden', !matches);
                    if (matches) visibleCount++;
                });

                noResults.style.display = visibleCount === 0 ? 'block' : 'none';
            });
        });
    </script>
</x-app-layout>
