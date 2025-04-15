<div>
    <x-button wire:click="set('openModal', true)">
        <i class="fas fa-add mr-2"></i><span class="font-semibold">Subir contenido</span>
    </x-button>
    <x-dialog-modal wire:model="openModal">
        <x-slot name="title">
            Subir contenido
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

            <!-- Categoría -->
            <div class="relative">
                <label for="categoria" class="sr-only">Categoría</label>
                <select id="categoria" name="categoria" wire:model="cform.category_id"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">Selecciona una categoría</option>
                    @foreach ($categorias as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
                <i class="fas fa-tag absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                <x-input-error for="cform.category_id" />
            </div>

            <!-- Media -->
            <div class="mt-4 w-full relative bg-slate-200 h-80">
                <input type="file" accept="image/*,video/*" id="csrc" class="hidden" wire:loading.attr="disabled"
                    wire:model="cform.src">
                <label for="csrc"
                    class="absolute bottom-2 right-2 bg-green-500 text-white font-bold p-3 rounded-lg hover:bg-green-600 transition duration-300">
                    <i class="fas fa-upload mr-2"></i>Subir
                </label>
                @isset($cform->src)
                    <img src="{{ $cform->src->temporaryUrl() }}"
                        class="size-full object-cover object-no-repeat object-center">
                @endisset
            </div>

        </x-slot>
        <x-slot name="footer">
            <div class="flex flex-row-reverse">
                <button type="button" wire:click="store" wire:loading.attr="disabled"
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
