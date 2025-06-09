<x-self.base>

    <h1 class="mb-4 text-3xl text-center font-extrabold text-gray-900 dark:text-white md:text-5xl lg:text-6xl">
        <span class="text-transparent bg-clip-text bg-gradient-to-r to-blue-600 from-sky-400">Posts</span>
    </h1>

    <div class="pb-4 px-4 md:px-10 flex flex-wrap gap-y-4 justify-center md:justify-between items-center text-center">
        <div class="flex flex-wrap gap-y-4 justify-center items-center">
            <i class="fas fa-magnifying-glass mr-2 text-gray-900 dark:text-gray-300"></i>
            <input type="search" placeholder="Buscar post..."
                class="rounded-full dark:bg-gray-800 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                wire:model.live="buscar" />

            <button type="button" wire:click="changeOrder"
                class='text-gray-900 dark:text-white border ml-4 border-gray-200 dark:border-gray-600 hover:border-gray-300 dark:hover:border-gray-500 bg-white dark:bg-gray-800 focus:ring-4 focus:outline-none focus:ring-gray-200 dark:focus:ring-gray-600 rounded-full text-base px-5 py-2.5 text-center me-3 mb-3 font-bold items-center'>
                @if ($orden != 'desc')
                    <i class="fas fa-arrow-down-wide-short mr-2"></i>
                    <span class="hidden md:inline">Más Antiguos</span>
                @else
                    <i class="fas fa-arrow-up-wide-short mr-2"></i>
                    <span class="hidden md:inline">Últimos</span>
                @endif
            </button>
        </div>

        <div>
            @foreach ($selectedTags as $tag)
                <button type="button" wire:click="quitarTag({{ $tag->id }})"
                    class='text-gray-900 dark:text-white border border-gray-200 dark:border-gray-600 hover:border-gray-300 dark:hover:border-gray-500 bg-white dark:bg-gray-700 focus:ring-4 focus:outline-none focus:ring-gray-200 dark:focus:ring-gray-600 rounded-full text-base px-5 py-2.5 text-center me-3 mb-3 font-bold'>
                    {{ $tag->name }}
                    <i class="fas fa-xmark ml-1"></i>
                </button>
            @endforeach
        </div>

        @auth
            @if (Auth::user()->role > 1)
                @livewire('crear-post')
            @endif
        @endauth
    </div>


    <div class="space-y-10 px-4 md:px-10">
        @foreach ($posts as $post)
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-md dark:shadow-gray-700 p-6 space-y-4">

                <div class="flex justify-between">
                    <!-- Título -->
                    <p class="text-black dark:text-white text-xl">
                        {{ $post->title }}
                    </p>

                    <!-- Usuario -->
                    <p class="text-black dark:text-gray-300 italic text-sm">
                        {{ $post->user->name }} - {{ $post->updated_at->format('d M Y') }}
                    </p>
                </div>

                <!-- Carrusel -->
                <div id="post-{{ $loop->index }}" class="relative w-full" data-carousel="static">
                    <div class="relative h-56 overflow-hidden rounded-lg md:h-96">
                        @foreach ($post->media as $item)
                            <div class="@if(!$loop->first) hidden @endif absolute inset-0 transition-transform transform translate-x-0"
                                @if($loop->first) data-carousel-item="active" @else data-carousel-item @endif>
                                @if (str_starts_with($item->file_type, 'image/'))
                                    <img class="absolute block w-full -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2 h-full object-cover"
                                        src="{{ Storage::url($item->src) }}" alt="{{ $item->title }}">
                                @elseif(str_starts_with($item->file_type, 'video/'))
                                    <video
                                        class="absolute block w-full -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2 h-full object-cover"
                                        autoplay muted loop>
                                        <source src="{{ Storage::url($item->src) }}" type="{{ $item->file_type }}">
                                    </video>
                                @endif
                            </div>
                        @endforeach
                    </div>

                    <!-- Controles -->
                    @if ($post->media && $post->media->count() > 1)
                        <button type="button"
                            class="absolute top-0 start-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none"
                            data-carousel-prev>
                            <span
                                class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white/30 dark:bg-gray-700/30 group-hover:bg-white/50 dark:group-hover:bg-gray-700/50 group-focus:ring-4 group-focus:ring-white dark:group-focus:ring-gray-700">
                                <i class="fas fa-chevron-left text-white dark:text-gray-300"></i>
                            </span>
                        </button>
                        <button type="button"
                            class="absolute top-0 end-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none"
                            data-carousel-next>
                            <span
                                class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white/30 dark:bg-gray-700/30 group-hover:bg-white/50 dark:group-hover:bg-gray-700/50 group-focus:ring-4 group-focus:ring-white dark:group-focus:ring-gray-700">
                                <i class="fas fa-chevron-right text-white dark:text-gray-300"></i>
                            </span>
                        </button>
                    @endif
                </div>

                <!-- Descripción -->
                <p class="text-gray-700 dark:text-gray-300 text-base">
                    {{ $post->description }}
                </p>

                <div class="flex justify-between">
                    <!-- Tags -->
                    <div class="flex flex-wrap gap-2">
                        @foreach ($post->tags as $tag)
                            <button wire:click="anadirTag({{ $tag->id }})"
                                class="bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-100 text-xs font-medium px-2.5 py-0.5 rounded hover:scale-105 transition-transform duration-200">
                                #{{ $tag->name }}
                            </button>
                        @endforeach
                    </div>

                    <!-- Interacciones -->
                    <div class="flex space-4 text-gray-500 dark:text-gray-400">
                        @if (!$showPostComments || $showPostComments != $post->id)
                            @if ($post->comments->count() > 0 || Auth::check())
                                <button
                                    class="hover:text-blue-600 dark:hover:text-blue-400 hover:scale-110 transition-transform duration-200"
                                    wire:click="showComments({{ $post->id }})"><i
                                        class="fas fa-comment"></i></button>
                            @endif
                        @elseif($showPostComments == $post->id)
                            <button
                                class="hover:text-blue-600 dark:hover:text-blue-400 hover:scale-110 transition-transform duration-200"
                                wire:click="cerrarComentarios"><i class="fas fa-comment"></i></button>
                        @endif
                        @auth
                            @if (Auth::user()->role > 2 || Auth::id() == $post->user->id)
                                <button
                                    class="hover:text-blue-600 dark:hover:text-blue-400 ml-2 hover:scale-110 transition-transform duration-200"
                                    wire:click="managePost({{ $post->id }})"><i class="fas fa-gear"></i></button>
                            @endif
                        @endauth
                    </div>
                </div>

                <!-- Comentarios -->
                @if ($showPostComments == $post->id)
                    <div class="mt-6 space-y-6">
                        @foreach ($comentariosPadre as $commentPadre)
                            <div class="bg-gray-100 dark:bg-gray-700 p-4 rounded-xl shadow-sm">
                                <!-- Comentario padre -->
                                <div class="mb-2">
                                    <p class="text-sm text-gray-600 dark:text-gray-300">
                                        <span class="font-semibold text-gray-900 dark:text-white">
                                            {{ $commentPadre->user->name }}
                                        </span>
                                        <span class="text-xs text-gray-400 dark:text-gray-500">
                                            ({{ $commentPadre->user->email }})
                                        </span>
                                    </p>
                                    <p class="text-gray-800 dark:text-gray-200 mt-1">
                                        {{ $commentPadre->message }}
                                    </p>
                                    @auth
                                        <button wire:click="responder({{ $commentPadre->id }})"
                                            class="mt-2 text-blue-600 dark:text-blue-400 hover:underline text-sm">
                                            Responder
                                        </button>
                                    @endauth
                                </div>

                                <!-- Comentarios hijo (respuestas) -->
                                @foreach ($comentariosHijo[$commentPadre->id] ?? [] as $commentHijo)
                                    <div class="ml-6 mt-4 border-l-2 border-gray-300 dark:border-gray-600 pl-4">
                                        <p class="text-sm text-gray-600 dark:text-gray-300">
                                            <span class="font-semibold text-gray-900 dark:text-white">
                                                {{ $commentHijo->user->name }}
                                            </span>
                                            <span class="text-xs text-gray-400 dark:text-gray-500">
                                                ({{ $commentHijo->user->email }})
                                            </span>
                                        </p>
                                        <p class="text-gray-700 dark:text-gray-300 mt-1">
                                            {{ $commentHijo->message }}
                                        </p>
                                    </div>
                                @endforeach
                            </div>
                        @endforeach

                        <!-- Formulario de respuesta -->
                        @auth
                            <div class="mt-4">
                                @if ($responderComentario)
                                    <button class="flex group relative" wire:click="cancelarResponder">
                                        <p class="text-sm text-gray-700 dark:text-gray-300 mb-1">
                                            Responder a <strong>{{ $responderComentario->user->name }}</strong>
                                        </p>
                                        <i class="fas fa-xmark hidden group-hover:inline text-sm ml-2"></i>
                                    </button>
                                @endif
                                <div class="flex items-start gap-2">
                                    <input type="text" wire:model.live="ccform.message" id="message" name="message"
                                        class="w-full border border-gray-300 dark:border-gray-600 rounded-lg px-3 py-2 text-sm focus:ring focus:ring-blue-200 dark:focus:ring-blue-800 dark:bg-gray-700 dark:text-white"
                                        placeholder="Escribe tu comentario...">
                                    <x-input-error for="ccform.messages.{{ $post->id }}" />
                                    <button
                                        wire:click="crearComentario({{ $responderComentario ? $responderComentario->id : '' }})"
                                        class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm">
                                        Enviar
                                    </button>
                                </div>
                            </div>
                        @endauth
                    </div>
                @endif
            </div>
        @endforeach

        <div>
            {{ $posts->links() }}
        </div>
    </div>

    @if ($openUpdate)
        <x-dialog-modal wire:model="openUpdate">
            <x-slot name="title">
                Editar Post
            </x-slot>
            <x-slot name="content">
                <!-- Título -->
                <div class="relative mb-4">
                    <label for="title" class="sr-only">Título</label>
                    <input type="text" id="titulo" name="title" placeholder="Título del contenido"
                        wire:model.live="uform.title"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <i class="fas fa-heading absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                    <x-input-error for="uform.title" />
                </div>

                <!-- Descripcción -->
                <div class="relative mb-4">
                    <label for="description" class="sr-only">Descripción</label>
                    <textarea id="description" name="description" placeholder="Descripción del post..."
                        wire:model.live="uform.description"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </textarea>
                    <i class="fas fa-heading absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                    <x-input-error for="uform.description" />
                </div>

                <!-- Media -->
                <div class="mt-4 w-full text-center">
                    @livewire('show-media-modal')
                    <div>
                        @if (!empty($uform->selectedMedia))
                            <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                                @foreach ($uform->selectedMedia as $item)
                                    @php
                                        $item = App\Models\Media::findOrFail($item);
                                    @endphp
                                    <button wire:click="removeMedia({{ $item->id }})">
                                        @if (str_starts_with($item->file_type, 'image/'))
                                            <img class="h-full w-full object-cover rounded-lg"
                                                src="{{ Storage::url($item->src) }}" alt="{{ $item->title }}">
                                        @elseif(str_starts_with($item->file_type, 'video/'))
                                            <video class="h-full w-full object-cover rounded-lg">
                                                <source src="{{ Storage::url($item->src) }}"
                                                    type="{{ $item->file_type }}">
                                            </video>
                                        @endif
                                    </button>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
                <x-input-error for="uform.selectedMedia" />

                <!-- Tags -->
                <div class="relative mb-4">
                    <label for="tags" class="block text-sm font-medium text-gray-700 mb-2">Etiquetas</label>
                    <div class="flex flex-wrap gap-2">
                        @foreach ($tags as $tag)
                            <label
                                class="flex items-center space-x-2 text-sm bg-gray-100 px-3 py-1 rounded-full cursor-pointer">
                                <input type="checkbox" wire:model="uform.tags" value="{{ $tag->id }}"
                                    class="form-checkbox text-indigo-600">
                                <span>{{ $tag->name }}</span>
                            </label>
                        @endforeach
                        @if (!$addTag)
                            <label
                                class="flex items-center space-x-2 text-sm bg-gray-100 px-3 py-1 rounded-full cursor-pointer">
                                <button wire:click="nuevaEtiqueta" class="text-gray-700 hover:text-gray-900">
                                    <i class="fas fa-add mr-2"></i>Nueva etiqueta
                                </button>
                            </label>
                        @else
                            <div class="flex items-center space-x-2 bg-gray-100 px-3 py-1 rounded-full">
                                <input type="text" wire:model="ftag.name" placeholder="Nueva etiqueta..."
                                    class="px-2 py-1 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <x-input-error for="ftag.name" class="text-red-500 text-xs mt-1" />
                                <button wire:click="guardarTag"
                                    class="bg-blue-500 text-white px-4 py-2 rounded-full text-sm hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    Guardar tag
                                </button>
                            </div>
                        @endif
                    </div>
                    <x-input-error for="uform.tags" />
                </div>
            </x-slot>
            <x-slot name="footer">
                <div class="flex flex-row-reverse">
                    <button type="button" wire:click="update" wire:loading.attr="disabled"
                        class="bg-blue-500 text-white font-bold p-3 rounded-lg hover:bg-blue-600 transition duration-300">
                        <i class="fas fa-paper-plane mr-2"></i>Editar
                    </button>
                    <button type="button" wire:click="cancelarUpdate"
                        class="mr-4 bg-red-500 text-white font-bold p-3 rounded-lg hover:bg-red-600 transition duration-300">
                        <i class="fas fa-xmark mr-2"></i>Cerrar
                    </button>
                </div>
            </x-slot>
        </x-dialog-modal>
    @endif

</x-self.base>
