<x-self.base>

    <h1 class="mb-6 text-3xl text-center font-extrabold text-gray-900 dark:text-white md:text-5xl lg:text-6xl"><span
            class="text-transparent bg-clip-text bg-gradient-to-r to-blue-600 from-sky-400">Lista de Tareas</span></h1>

    <div>
        <ul class="grid w-full gap-6 md:grid-cols-3">
            @foreach ($tasks as $item)
                @if ($uform->task != null && $uform->task->id == $item->id)
                    <li class="">
                        <div
                            class="items-center w-full text-black p-5 border-2 border-gray-200 rounded-lg cursor-pointer dark:border-gray-700 peer-checked:border-blue-600 dark:peer-checked:border-blue-600 hover:scale-105 transition-transform duration-200">
                            <label>Título:</label>
                            <input type="text" class="w-full rounded-lg" wire:model="uform.title" value="{{$item->title}}">
                            <x-input-error for="uform.title" />
                            <hr class='my-2'>
                            <label>Descripción:</label>
                            <div class="w-full text-sm">
                                <textarea class="w-full rounded-lg" wire:model="uform.description">{{$item->description}}</textarea>
                                <x-input-error for="uform.description" />
                            </div>
                            <hr class='my-2'>
                            <div>
                                <label>Prioridad: {{ $uform->priority }}</label>
                                <input id="minmax-range" type="range" min="0" max="5"
                                    wire:model.live="uform.priority"
                                    class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer dark:bg-gray-700">
                                <x-input-error for="uform.priority" />
                            </div>
                            <div class="text-center itemd-center mt-4">
                                <button type="button" wire:click="descartarUpdate"
                                    class="text-white bg-gradient-to-r from-red-400 via-red-500 to-red-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">Descartar</button>
                                <button type="button" wire:click="update({{$item->id}})"
                                    class="text-white bg-gradient-to-r from-green-400 via-green-500 to-green-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-green-300 dark:focus:ring-green-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">Guardar</button>
                            </div>
                        </div>
                    </li>
                @else
                    <li>

                        <div @class([
                            'inline-flex items-center justify-between w-full text-black p-5 border-2 border-gray-200 rounded-lg cursor-pointer dark:border-gray-700 peer-checked:border-blue-600 dark:peer-checked:border-blue-600 hover:scale-105 transition-transform duration-200' => true,
                            'bg-green-300' => $item->priority == 0 && !$item->done,
                            'bg-blue-300' => $item->priority == 1 && !$item->done,
                            'bg-blue-500' => $item->priority == 2 && !$item->done,
                            'bg-yellow-500' => $item->priority == 3 && !$item->done,
                            'bg-orange-500' => $item->priority == 4 && !$item->done,
                            'bg-red-500' => $item->priority == 5 && !$item->done,
                            'bg-gray-400' => $item->done,
                        ])>
                            <div class="w-full">
                                <div class="flex flex-row-reverse">
                                    @if (!$item->done)
                                        <i @class([
                                            'fas text-xl ml-4 hover:scale-150 transition-transform duration-200',
                                            'fa-circle text-green-500' => $item->priority == 0,
                                            'fa-circle text-blue-500' => $item->priority == 1,
                                            'fa-circle text-blue-700' => $item->priority == 2,
                                            'fa-circle text-yellow-700' => $item->priority == 3,
                                            'fa-circle-exclamation' => $item->priority >= 4,
                                        ]) wire:click="ocultar({{ $item->id }})"></i>
                                    @else
                                        <i class="fas fa-check text-xl ml-4 text-gray-600 hover:scale-150 transition-transform duration-200"
                                            wire:click="ocultar({{ $item->id }})"></i>
                                    @endif
                                    <div class="w-full text-lg font-semibold">{{ $item->title }}
                                    </div>
                                </div>
                                <hr @class([
                                    'my-4',
                                    'border-gray-600' => $item->done,
                                    'border-green-500' => $item->priority == 0 && !$item->done,
                                    'border-blue-500' => $item->priority == 1 && !$item->done,
                                    'border-blue-700' => $item->priority == 2 && !$item->done,
                                    'border-yellow-700' => $item->priority == 3 && !$item->done,
                                    'border-orange-700' => $item->priority == 4 && !$item->done,
                                    'border-red-700' => $item->priority == 5 && !$item->done,
                                ])>
                                <div class="w-full text-sm">{{ $item->description }}</div>
                                <div class="text-center items-center">
                                    <div class="flex justify-end gap-3">
                                        <button wire:click="edit({{$item->id}})"
                                            class="hover:scale-125 transition-transform duration-200 text-gray-600 hover:text-black">
                                            <i class="fas fa-edit text-xl"></i>
                                        </button>
                                        <button wire:click="confirmarBorrar({{$item->id}})"
                                            class="hover:scale-125 transition-transform duration-200 text-gray-600 hover:text-black">
                                            <i class="fas fa-trash text-xl"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                @endif
            @endforeach
            @if ($nuevaTarea)
                <li class="">
                    <div
                        class="items-center w-full text-black p-5 border-2 border-gray-200 rounded-lg cursor-pointer dark:border-gray-700 peer-checked:border-blue-600 dark:peer-checked:border-blue-600 hover:scale-105 transition-transform duration-200">
                        <label>Título:</label>
                        <input type="text" class="w-full rounded-lg" wire:model="cform.title">
                        <x-input-error for="cform.title" />
                        <hr class='my-2'>
                        <label>Descripción:</label>
                        <div class="w-full text-sm">
                            <textarea class="w-full rounded-lg" wire:model="cform.description"></textarea>
                            <x-input-error for="cform.description" />
                        </div>
                        <hr class='my-2'>
                        <div>
                            <label>Prioridad: {{ $cform->priority }}</label>
                            <input id="minmax-range" type="range" min="0" max="5" value="0"
                                wire:model.live="cform.priority"
                                class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer dark:bg-gray-700">
                            <x-input-error for="cform.priority" />
                        </div>
                        <div class="text-center itemd-center mt-4">
                            <button type="button" wire:click="descartar"
                                class="text-white bg-gradient-to-r from-red-400 via-red-500 to-red-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">Descartar</button>
                            <button type="button" wire:click="create"
                                class="text-white bg-gradient-to-r from-green-400 via-green-500 to-green-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-green-300 dark:focus:ring-green-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">Guardar</button>
                        </div>
                    </div>
                </li>
            @endif
        </ul>
        @if (!$nuevaTarea)
            <div class="text-center items-center my-4"><button wire:click="set('nuevaTarea', true)"
                    class="relative inline-flex items-center justify-center p-1 mb-2 me-2 overflow-hidden text-sm font-medium text-gray-900 rounded-2xl group bg-gradient-to-br to-blue-600 from-sky-400 group-hover:from-green-400 group-hover:to-blue-600 hover:text-white dark:text-white focus:ring-4 focus:outline-none focus:ring-blue-200 dark:focus:ring-blue-800 hover:scale-105 transition-transform duration-200">
                    <span
                        class="relative px-5 py-2.5 transition-all ease-in duration-75 bg-white dark:bg-gray-900 rounded-xl group-hover:bg-transparent group-hover:dark:bg-transparent">
                        <i class="fas fa-plus"></i> Nueva Tarea
                    </span>
                </button></div>
        @endif
    </div>
</x-self.base>
