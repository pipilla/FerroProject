<div>
    <button type="button" wire:click="set('openModal', true)"
        class='text-gray-900 border border-white hover:border-gray-200 dark:border-gray-900 dark:bg-gray-900 dark:hover:border-gray-700 bg-white focus:ring-4 focus:outline-none focus:ring-gray-300 rounded-full text-base px-5 py-2.5 text-center me-3 mb-3 dark:text-white dark:focus:ring-gray-800 font-bold'>
        <i class="fas fa-plus mr-2"></i> Editar Categorías
    </button>
    <x-dialog-modal wire:model="openModal">
        <x-slot name="title">
            Editar Categorías
        </x-slot>
        <x-slot name="content">
            <div class="w-full grid grid-cols-2 md:grid-cols-3 gap-1 mb-2">
                @foreach ($categories as $item)
                    <div x-data="{ open: false }" class="relative">
                        {{-- Aquí uso Alpine.js para hacer los dropdown --}}
                        <button @click="open = !open" class="focus:outline-none text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                            {{ $item->name }} <i class="fa-solid fa-angle-down ml-2"></i>
                        </button>

                        <div x-show="open" @click.away="open = false"
                            class="absolute z-10 bg-white divide-y divide-gray-100 rounded-lg shadow-sm w-44 dark:bg-gray-700">
                            <ul class="py-2 text-sm text-gray-700 dark:text-gray-200">
                                <li>
                                    <a wire:click="edit({{ $item->id }})"
                                        class="block px-4 py-2 text-blue-400 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Editar</a>
                                </li>
                                <li>
                                    <a wire:click="confirmarBorrar({{ $item->id }})"
                                        class="block px-4 py-2 text-red-400 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Eliminar</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="items-center text-center mt-5">
                @if (!$openCreate)
                    <button wire:click="create"
                        class="focus:outline-none text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800">Añadir
                        Categoría</button>
                @else
                    <button wire:click="create"
                        class="focus:outline-none text-white bg-gray-700 hover:bg-gray-800 focus:ring-4 focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-gray-600 dark:hover:bg-gray-700 dark:focus:ring-gray-800">Cancelar</button>
                @endif
            </div>
            @if ($selectedCategory != null)
                <div class="text-center items-center">
                    <label for="name" class="block mb-2 text-lg font-bold text-gray-900 ">Cambiar Nombre de la
                        Categoría
                        "{{ $selectedCategory->name }}":</label>
                    <input type="text" id="name" name="name" wire:model.live="name"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-1/2 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 mx-auto mb-2"
                        placeholder="{{ $selectedCategory->name }}" />
                    <x-input-error for="name" class="mb-2" />
                    <button wire:click="update"
                        class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                        Cambiar nombre</button>
                </div>
            @endif
            @if ($openCreate)
                <div class="text-center items-center">
                    <label for="name" class="block mb-2 text-lg font-bold text-gray-900 ">Nombre de
                        Categoría:</label>
                    <input type="text" id="name" name="name" wire:model.live="name"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-1/2 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 mx-auto mb-2"
                        placeholder="Ejemplo..." />
                    <x-input-error for="name" class="mb-2" />
                    <button wire:click="store"
                        class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                        Crear Categoría</button>
                </div>
            @endif
        </x-slot>
        <x-slot name="footer">
            <div class="flex flex-row-reverse">
                <button type="button" wire:click="cancelar"
                    class="mr-4 bg-red-500 text-white font-bold p-3 rounded-lg hover:bg-red-600 transition duration-300">
                    <i class="fas fa-xmark mr-2"></i>Cerrar
                </button>
            </div>
        </x-slot>
    </x-dialog-modal>
</div>
