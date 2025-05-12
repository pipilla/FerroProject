<x-self.base>

    <h1 class="mb-4 text-3xl text-center font-extrabold text-gray-900 dark:text-white md:text-5xl lg:text-6xl"><span
            class="text-transparent bg-clip-text bg-gradient-to-r to-blue-600 from-sky-400">Galería</span></h1>

    {{-- Botones para ordenar por categoría --}}
    <div class="flex items-center justify-center py-4 md:py-8 flex-wrap">
        <button type="button" wire:click="buscar(0)"
            class="text-blue-700 hover:text-white border border-blue-600 bg-white hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-full text-base font-medium px-5 py-2.5 text-center me-3 mb-3 dark:border-blue-500 dark:text-blue-500 dark:hover:text-white dark:hover:bg-blue-500 dark:bg-gray-900 dark:focus:ring-blue-800">Todas
            las categorías</button>
        @foreach ($categories as $category)
            <button type="button" wire:click="buscar({{ $category->id }})"
                class='text-gray-900 border border-white hover:border-gray-200 dark:border-gray-900 dark:bg-gray-900 dark:hover:border-gray-700 bg-white focus:ring-4 focus:outline-none focus:ring-gray-300 rounded-full text-base px-5 py-2.5 text-center me-3 mb-3 dark:text-white dark:focus:ring-gray-800 font-bold'>{{ $category->name }}</button>
        @endforeach

        @if (Auth::user() && Auth::user()->role >= 2)
            {{-- Botón para añadir, editar y eliminar categorías --}}
            @livewire('crud-category')

            {{-- Botón crear media --}}
            @livewire('crear-media')

        @endif
    </div>

    {{-- Contenido multimedia --}}
    <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
        @foreach ($media as $item)
            <button wire:click="show({{ $item->id }})">
                @if (str_starts_with($item->file_type, 'image/'))
                    <img class="h-full w-full object-cover rounded-lg" src="{{ Storage::url($item->src) }}"
                        alt="{{ $item->title }}">
                @elseif(str_starts_with($item->file_type, 'video/'))
                    <video class="h-full w-full object-cover rounded-lg">
                        <source src="{{ Storage::url($item->src) }}" type="{{ $item->file_type }}">
                    </video>
                @endif
            </button>
        @endforeach
    </div>

    <div class="mt-2">
        {{ $media->links() }}
    </div>

    {{-- Modal para el show --}}
    @if ($openShow && $sform->media != null)
        <div>
            <x-dialog-modal wire:model="openShow">
                <x-slot name="title">
                    {{ $sform->title }}
                </x-slot>
                <x-slot name="content">

                    @if (str_starts_with($sform->file_type, 'image/'))
                        <img class="h-full w-full object-cover rounded-lg" src="{{ Storage::url($sform->src) }}"
                            alt="{{ $sform->title }}">
                    @elseif(str_starts_with($sform->file_type, 'video/'))
                        <video class="h-full w-full object-cover rounded-lg" controls>
                            <source src="{{ Storage::url($sform->src) }}" type="{{ $sform->file_type }}">
                            Tu navegador no soporta el video.
                        </video>
                    @endif

                    <div class="flex justify-between text-center mt-4">
                        <button type="button" wire:click="buscar({{ $sform->category_id }})"
                            class='text-gray-900 border border-white hover:border-gray-200 dark:border-gray-900 dark:bg-gray-900 dark:hover:border-gray-700 bg-white focus:ring-4 focus:outline-none focus:ring-gray-300 rounded-full text-base px-5 py-2.5 text-center me-3 dark:text-white dark:focus:ring-gray-800 font-bold'>{{ $sform->category_name }}</button>

                        @if (Auth::user() && Auth::user()->role >= 2)
                            <div class="flex gap-2">
                                <button class="hover:scale-125 transition-transform duration-200 text-green-900"
                                    wire:click="edit({{ $sform->media->id }})">
                                    <i class="fas fa-edit text-xl"></i>
                                </button>
                                <button class="hover:scale-125 transition-transform duration-200 text-red-900"
                                    wire:click="confirmarBorrar({{ $sform->media->id }})">
                                    <i class="fas fa-trash text-xl"></i>
                                </button>
                            </div>
                        @endif

                    </div>
                </x-slot>
                <x-slot name="footer">
                    <div class="flex flex-row-reverse">
                        <button type="button" wire:click="cerrarShow"
                            class="bg-red-500 text-white font-bold p-3 rounded-lg hover:bg-red-600 transition duration-300">
                            <i class="fas fa-xmark mr-2"></i>Cerrar
                        </button>
                    </div>
                </x-slot>
            </x-dialog-modal>
        </div>
    @endif

    {{-- Modal para el update --}}
    @if ($openUpdate && $uform->media != null)
        <div>
            <x-button wire:click="set('openUpdate', true)">
                <i class="fas fa-add mr-2"></i><span class="font-semibold">Subir contenido</span>
            </x-button>
            <x-dialog-modal wire:model="openUpdate">
                <x-slot name="title">
                    Subir contenido
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

                    <!-- Categoría -->
                    <div class="relative">
                        <label for="categoria" class="sr-only">Categoría</label>
                        <select id="categoria" name="categoria" wire:model="uform.category_id"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">Selecciona una categoría</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                        <i class="fas fa-tag absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                        <x-input-error for="uform.category_id" />
                    </div>

                    <!-- Media -->
                    <div class="mt-4 w-full relative bg-slate-200 h-80">
                        <input type="file" accept="image/*,video/*" id="usrc" class="hidden"
                            wire:loading.attr="disabled" wire:model="uform.src">
                        <label for="usrc"
                            class="absolute bottom-2 right-2 bg-green-500 text-white font-bold p-3 rounded-lg hover:bg-green-600 transition duration-300">
                            <i class="fas fa-upload mr-2"></i>Subir
                        </label>
                        @isset($uform->src)
                            @if (str_starts_with($uform->src->getMimeType(), 'image/'))
                                <img src="{{ $uform->src->temporaryUrl() }}"
                                    class="size-full object-cover object-no-repeat object-center">
                            @elseif(str_starts_with($uform->src->getMimeType(), 'video/'))
                                <video controls class="size-full object-cover object-no-repeat object-center">
                                    <source src="{{ $uform->src->temporaryUrl() }}">
                                    Tu navegador no soporta el video.
                                </video>
                            @endif
                        @else
                            @if (str_starts_with($uform->media->file_type, 'image/'))
                                <img src="{{ Storage::url($uform->media->src) }}"
                                    class="size-full object-cover object-no-repeat object-center">
                            @elseif(str_starts_with($uform->media->file_type, 'video/'))
                                <video controls class="size-full object-cover object-no-repeat object-center">
                                    <source src="{{ Storage::url($uform->media->src) }}">
                                    Tu navegador no soporta el video.
                                </video>
                            @endif
                        @endisset
                    </div>
                    <x-input-error for="uform.src" />

                </x-slot>
                <x-slot name="footer">
                    <div class="flex flex-row-reverse">
                        <button type="button" wire:click="update" wire:loading.attr="disabled"
                            class=" bg-blue-500 text-white font-bold p-3 rounded-lg hover:bg-blue-600 transition duration-300">
                            <i class="fas fa-paper-plane mr-2"></i>Actualizar
                        </button>
                        <button type="button" wire:click="cancelar"
                            class="mr-4 bg-red-500 text-white font-bold p-3 rounded-lg hover:bg-red-600 transition duration-300">
                            <i class="fas fa-xmark mr-2"></i>Cerrar
                        </button>
                    </div>
                </x-slot>
            </x-dialog-modal>
        </div>
    @endif

</x-self.base>
