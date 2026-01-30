<!-- resources/views/partials/prompt-card.blade.php -->
@props(['prompt', 'mode' => 'view'])

<div
    class="bg-gray-800 rounded-xl border border-gray-700 overflow-hidden hover:border-indigo-500/50 transition-all duration-300 group h-full flex flex-col shadow-lg hover:shadow-indigo-500/10">
    <!-- Header del Card -->
    <div class="p-5 flex-grow">
        <div class="flex justify-between items-start mb-3">
            <!-- Categoría Badge -->
            <span
                class="px-2.5 py-1 rounded-full text-xs font-medium bg-indigo-900/50 text-indigo-300 border border-indigo-700/30">
                {{ $prompt->category->name ?? 'General' }}
            </span>

            @if($mode !== 'guest')
                <!-- Menú de acciones (Solo para usuarios logueados) -->
                <button class="text-gray-400 hover:text-white transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z">
                        </path>
                    </svg>
                </button>
            @endif
        </div>

        <!-- Título -->
        <h3 class="text-xl font-bold text-white mb-2 group-hover:text-indigo-400 transition-colors">
            {{ $prompt->title }}
        </h3>

        <!-- Descripción Corta -->
        <p class="text-gray-400 text-sm line-clamp-3 mb-4">
            {{ $prompt->description }}
        </p>

        <!-- Etiquetas -->
        @if(isset($prompt->tags) && count($prompt->tags) > 0)
            <div class="flex flex-wrap gap-2 mb-4">
                @foreach($prompt->tags->take(3) as $tag)
                    <span
                        class="text-xs text-gray-500 bg-gray-900 px-2 py-1 rounded border border-gray-800">#{{ $tag->name }}</span>
                @endforeach
            </div>
        @endif
    </div>

    <!-- Footer del Card -->
    <div class="px-5 py-4 bg-gray-900/50 border-t border-gray-700/50 flex items-center justify-between">
        <!-- Autor -->
        <div class="flex items-center space-x-2">
            <div
                class="w-6 h-6 rounded-full bg-gradient-to-tr from-indigo-500 to-purple-500 flex items-center justify-center text-xs font-bold text-white shadow-sm">
                {{ substr($prompt->user->name ?? 'A', 0, 1) }}
            </div>
            <span class="text-xs text-gray-400 truncate max-w-[100px]">{{ $prompt->user->name ?? 'Anónimo' }}</span>
        </div>

        <!-- Acciones según Modo -->
        @if($mode === 'guest')
            <a href="{{ route('login') }}"
                class="text-sm font-medium text-indigo-400 hover:text-indigo-300 transition-colors flex items-center group/link">
                Ver detalle
                <svg class="w-4 h-4 ml-1 transform group-hover/link:translate-x-1 transition-transform" fill="none"
                    stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </a>
        @else
            <div class="flex space-x-3">
                <button class="text-gray-400 hover:text-indigo-400 transition-colors" title="Editar">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                        </path>
                    </svg>
                </button>
                <button class="text-gray-400 hover:text-red-400 transition-colors" title="Eliminar">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                        </path>
                    </svg>
                </button>
            </div>
        @endif
    </div>
</div>