<x-self.base>

    <h1 class="mb-4 text-3xl text-center font-extrabold text-gray-900 dark:text-white md:text-5xl lg:text-6xl"><span
            class="text-transparent bg-clip-text bg-gradient-to-r to-blue-600 from-sky-400">Posts</span></h1>

    <!-- Buscador -->
    <div class="pb-4 px-4 md:px-10 flex justify-between">
        <div>
            <i class="fas fa-magnifying-glass mr-2"></i>
            <input type="search" placeholder="Buscar post..." class="rounded-full" wire:model.live="buscar" />
        </div>

        <div>
            @foreach ($selectedTags as $tag)
                <button type="button" wire:click="quitarTag({{ $tag->id }})"
                    class='text-gray-900 border border-white hover:border-gray-200 dark:border-gray-900 dark:bg-gray-900 dark:hover:border-gray-700 bg-white focus:ring-4 focus:outline-none focus:ring-gray-300 rounded-full text-base px-5 py-2.5 text-center me-3 mb-3 dark:text-white dark:focus:ring-gray-800 font-bold'>{{ $tag->name }}
                    <i class="fas fa-xmark ml-1 "></i>
                </button>
            @endforeach
        </div>

        @auth
            @livewire('crear-post')
        @endauth
    </div>


    <div class="space-y-10 px-4 md:px-10">
        @foreach ($posts as $post)
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-md p-6 space-y-4">

                <div class="flex justify-between">
                    <!-- Título -->
                    <p class="text-black dark:text-white text-xl">
                        {{ $post->title }}
                    </p>

                    <!-- Usuario -->
                    <p class="text-black dark:text-white italic text-sm">
                        {{ $post->user->name }}
                    </p>

                </div>

                <!-- Carrusel -->
                <div id="post-{{ $loop->index }}" class="relative w-full" data-carousel="slide">
                    <div class="relative h-56 overflow-hidden rounded-lg md:h-96">
                        @foreach ($post->media as $media)
                            <div class="hidden duration-700 ease-in-out" data-carousel-item>
                                <img src="{{ $media->src }}"
                                    class="absolute block w-full -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2 object-cover"
                                    alt="Media image">
                            </div>
                        @endforeach
                    </div>

                    <!-- Indicadores -->
                    <div class="absolute z-30 flex -translate-x-1/2 bottom-5 left-1/2 space-x-3 rtl:space-x-reverse">
                        @foreach ($post->media as $media)
                            <button type="button" class="w-3 h-3 rounded-full bg-white/70" aria-current="true"
                                aria-label="Slide {{ $loop->iteration }}"
                                data-carousel-slide-to="{{ $loop->index }}"></button>
                        @endforeach
                    </div>

                    <!-- Controles -->
                    <button type="button"
                        class="absolute top-0 start-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none"
                        data-carousel-prev>
                        <span
                            class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white/30 dark:bg-gray-800/30 group-hover:bg-white/50 group-focus:ring-4 group-focus:ring-white">
                            <i class="fas fa-chevron-left text-white dark:text-gray-200"></i>
                        </span>
                    </button>
                    <button type="button"
                        class="absolute top-0 end-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none"
                        data-carousel-next>
                        <span
                            class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white/30 dark:bg-gray-800/30 group-hover:bg-white/50 group-focus:ring-4 group-focus:ring-white">
                            <i class="fas fa-chevron-right text-white dark:text-gray-200"></i>
                        </span>
                    </button>
                </div>

                <!-- Descripción -->
                <p class="text-gray-700 dark:text-gray-200 text-base">
                    {{ $post->description }}
                </p>

                <div class="flex justify-between">
                    <!-- Tags -->
                    <div class="flex flex-wrap gap-2">
                        @foreach ($post->tags as $tag)
                            <button wire:click="anadirTag({{ $tag->id }})"
                                class="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded dark:bg-blue-900 dark:text-blue-300 hover:scale-105 transition-transform duration-200">
                                #{{ $tag->name }}
                            </button>
                        @endforeach
                    </div>

                    <!-- Interacciones -->
                    <div class="flex space-4 text-gray-500 dark:text-gray-400">
                        @if (!$showPostComments || $showPostComments != $post->id)
                            <button class="hover:text-blue-600 hover:scale-110 transition-transform duration-200"
                                wire:click="showComments({{ $post->id }})"><i class="fas fa-comment"></i></button>
                        @elseif($showPostComments == $post->id)
                            <button class="hover:text-blue-600 hover:scale-110 transition-transform duration-200"
                                wire:click="cerrarComentarios"><i class="fas fa-comment"></i></button>
                        @endif
                        @auth
                            @if (Auth::user()->role >= 2 || Auth::id() == $post->user->id)
                                <button class="hover:text-blue-600 ml-2 hover:scale-110 transition-transform duration-200"
                                    wire:click="showComments({{ $post->id }})"><i class="fas fa-gear"></i></button>
                            @endif
                        @endauth
                    </div>
                </div>

                <!-- Comentarios -->
                @if ($showPostComments == $post->id)
                    <div class="mt-6 space-y-6">
                        @foreach ($comentariosPadre as $commentPadre)
                            <div class="bg-gray-100 dark:bg-gray-800 p-4 rounded-xl shadow-sm">
                                <!-- Comentario padre -->
                                <div class="mb-2">
                                    <p class="text-sm text-gray-600 dark:text-gray-400">
                                        <span class="font-semibold text-gray-900 dark:text-white">
                                            {{ $commentPadre->user->name }}
                                        </span>
                                        <span class="text-xs text-gray-400">
                                            ({{ $commentPadre->user->email }})
                                        </span>
                                    </p>
                                    <p class="text-gray-800 dark:text-gray-200 mt-1">
                                        {{ $commentPadre->message }}
                                    </p>
                                    @auth
                                        <button wire:click="responder({{ $commentPadre->id }})"
                                            class="mt-2 text-blue-600 hover:underline text-sm">
                                            Responder
                                        </button>
                                    @endauth
                                </div>

                                <!-- Comentarios hijo (respuestas) -->
                                @foreach ($comentariosHijo[$commentPadre->id] ?? [] as $commentHijo)
                                    <div class="ml-6 mt-4 border-l-2 border-gray-300 dark:border-gray-600 pl-4">
                                        <p class="text-sm text-gray-600 dark:text-gray-400">
                                            <span class="font-semibold text-gray-900 dark:text-white">
                                                {{ $commentHijo->user->name }}
                                            </span>
                                            <span class="text-xs text-gray-400">
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
                                    <button class="flex group relative inline-block" wire:click="cancelarResponder">
                                        <p class="text-sm text-gray-700 dark:text-gray-300 mb-1">
                                            Responder a <strong>{{ $responderComentario->user->name }}</strong>
                                        </p>
                                        <i class="fas fa-xmark hidden group-hover:inline text-sm ml-2"></i>
                                    </button>
                                @endif
                                <form
                                    wire:submit.lazy="crearComentario({{ $post->id }}{{ $responderComentario ? ',' . $responderComentario->id : '' }})">
                                    <div class="flex items-start gap-2">
                                        <input type="text" wire:model.lazy="ccform.message" id="message"
                                            class="w-full border border-gray-300 dark:border-gray-700 rounded-lg px-3 py-2 text-sm focus:ring focus:ring-blue-200 dark:bg-gray-900 dark:text-white"
                                            placeholder="Escribe tu comentario...">
                                        <x-input-error for="ccform.message" />
                                        <button type="submit"
                                            class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm">
                                            Enviar
                                        </button>
                                    </div>
                                </form>
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

</x-self.base>
