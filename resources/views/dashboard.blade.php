<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    {{-- Estilos para mejorar la visualización del Chatbot --}}
    <style>
        #ai-chat-widget * {
            white-space: pre-wrap;
            /* Respeta saltos de línea y espacios */
        }

        #ai-chat-widget ul {
            list-style-type: disc;
            padding-left: 20px;
            margin: 10px 0;
        }

        #ai-chat-widget ol {
            list-style-type: decimal;
            padding-left: 20px;
            margin: 10px 0;
        }

        #ai-chat-widget strong {
            font-weight: bold;
            color: #60a5fa;
        }
    </style>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                <p class="text-gray-700 mb-4">
                    Bienvenidoooo a <strong>PromptVault</strong>.
                </p>

                {{-- Acción principal --}}
                <div class="mb-6">
                    <a href="{{ route('prompts.create') }}"
                        class="inline-flex items-center gap-2 rounded bg-blue-600 px-5 py-2 text-white hover:bg-blue-700">
                        ➕ Crear Prompt
                    </a>
                </div>

                {{-- Accesos rápidos --}}
                <div class="flex gap-2 flex-wrap">
                    <a href="{{ route('prompts.index') }}"
                        class="inline-flex items-center rounded border px-4 py-2 hover:bg-gray-50">
                        Prompts
                    </a>

                    <a href="{{ route('categorias.index') }}"
                        class="inline-flex items-center rounded border px-4 py-2 hover:bg-gray-50">
                        Categorías
                    </a>

                    <a href="{{ route('etiquetas.index') }}"
                        class="inline-flex items-center rounded border px-4 py-2 hover:bg-gray-50">
                        Etiquetas
                    </a>

                    <a href="{{ route('actividades.index') }}"
                        class="inline-flex items-center rounded border px-4 py-2 hover:bg-gray-50">
                        Actividades
                    </a>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>