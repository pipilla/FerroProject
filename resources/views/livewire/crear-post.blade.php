<div>
    <x-button wire:click="set('openModal', true)">
        <i class="fas fa-add mr-2 whitespace-nowrap"></i><span class="font-semibold whitespace-nowrap">Crear Post</span>
    </x-button>
    <x-dialog-modal wire:model="openModal">
        <x-slot name="title">
            Crear Post
        </x-slot>
        <x-slot name="content">
            <!-- Título -->
            <div class="relative mb-4">
                <label for="title" class="sr-only">Título</label>
                <input type="text" id="titulo" name="title" placeholder="Título del contenido"
                    wire:model.live="cform.title"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                <i class="fas fa-heading absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                <x-input-error for="cform.title" />
            </div>

            <!-- Descripcción -->
            <div class="relative mb-4">
                <label for="description" class="sr-only">Descripción</label>
                <textarea id="description" name="description" placeholder="Descripción del post..." wire:model.live="cform.description"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </textarea>
                <i class="fas fa-heading absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                <x-input-error for="cform.description" />
            </div>

            <!-- Media -->
            <div class="mt-4 w-full text-center">
                @livewire('show-media-modal')
                <div>
                    @if (!empty($cform->selectedMedia))
                        <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                            @foreach ($cform->selectedMedia as $item)
                                @php
                                    $item = App\Models\Media::findOrFail($item);
                                @endphp
                                <button wire:click="removeMedia({{ $item->id }})">
                                    @if (str_starts_with($item->file_type, 'image/'))
                                        <img class="h-full w-full object-cover rounded-lg"
                                            src="{{ Storage::url($item->src) }}" alt="{{ $item->title }}">
                                    @elseif(str_starts_with($item->file_type, 'video/'))
                                        <video class="h-full w-full object-cover rounded-lg">
                                            <source src="{{ Storage::url($item->src) }}" type="{{ $item->file_type }}">
                                        </video>
                                    @endif
                                </button>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
            <x-input-error for="cform.selectedMedia" />

            <!-- Tags -->
            <div class="relative mb-4">
                <label for="tags" class="block text-sm font-medium text-gray-700 mb-2">Etiquetas</label>
                <div class="flex flex-wrap gap-2">
                    @foreach ($tags as $tag)
                        <label
                            class="flex items-center space-x-2 text-sm bg-gray-100 px-3 py-1 rounded-full cursor-pointer">
                            <input type="checkbox" wire:model="cform.tags" value="{{ $tag->id }}"
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
                <x-input-error for="cform.tags" />
            </div>

        </x-slot>
        <x-slot name="footer">
            <div class="flex flex-row-reverse">
                <button type="button" wire:click="publicar" wire:loading.attr="disabled"
                    class=" bg-blue-500 text-white font-bold p-3 rounded-lg hover:bg-blue-600 transition duration-300">
                    <i class="fas fa-paper-plane mr-2"></i>Publicar
                </button>
                <button type="button" wire:click="cancelar"
                    class="mr-4 bg-red-500 text-white font-bold p-3 rounded-lg hover:bg-red-600 transition duration-300">
                    <i class="fas fa-xmark mr-2"></i>Cerrar
                </button>
            </div>
        </x-slot>
    </x-dialog-modal>
</div>
