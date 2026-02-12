<x-app-layout>
<div class="relative z-10 p-6 sm:p-10 max-w-[1440px] mx-auto">
    <!-- HEADER -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-6 mb-10">
         <h1 class="flex items-center gap-3 text-gray-900 dark:text-white text-xl font-bold">
                <span class="icon-circle">
                    <!-- SVG account_balance -->
                   <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5
                        a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9
                        a2 2 0 00-2-2M5 11V9a2 2 0 012-2
                        m0 0V5a2 2 0 012-2h6
                        a2 2 0 012 2v2M7 7h10"/>
                </svg>
            </span>
                Categorias
            </h1>

        <a href="{{ route('categorias.create') }}" class="btn-primary">
           <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M12 4v16m8-8H4"/>
                </svg>
            Nueva categoría
        </a>
    </div>

    <!-- TABLA -->
    <div class="tabla-container">
        <table class="tabla">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th></th>
                </tr>   
            </thead>


            <tbody>
                @foreach ($categorias as $categoria)
                    <tr>
                        <!-- NOMBRE -->
                        <td>
                            <div class="flex items-center gap-2 font-semibold">
                                <svg class="w-[18px] h-[18px] text-red-400"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M7 7h10l4 5-4 5H7a2 2 0 01-2-2V9a2 2 0 012-2z"/>
                                </svg>
                                {{ $categoria->nombre }}
                            </div>
                        </td>
                        
                    
                        <!-- ACCIONES -->
                        <td class="acciones-td">
                            <div class="acciones">
                                <a href="{{ route('categorias.edit', $categoria) }}"
                                   class="btn-action btn-edit">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M16.5 3.5a2.1 2.1 0 013 3L7 19l-4 1 1-4 12.5-12.5z"/>
                                    </svg>
                                    <span class="hidden sm:inline">Editar</span>
                                </a>

                                <form action="{{ route('categorias.destroy', $categoria) }}"
                                      method="POST"
                                      onsubmit="return confirm('¿Eliminar esta categoría?')">
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit" class="btn-action btn-delete">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M3 6h18M8 6V4h8v2M6 6v14a2 2 0 002 2h8
                                                a2 2 0 002-2V6M10 11v6M14 11v6"/>
                                        </svg>
                                        <span class="hidden sm:inline">Eliminar</span>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>

        </table>
    </div>
</div>
</x-app-layout>