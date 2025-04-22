<x-self.base>

    <h1 class="mb-6 text-3xl text-center font-extrabold text-gray-900 dark:text-white md:text-5xl lg:text-6xl"><span
            class="text-transparent bg-clip-text bg-gradient-to-r to-blue-600 from-sky-400">Lista de Tareas</span></h1>

    <div>
        <ul class="grid w-full gap-6 md:grid-cols-3">
            @foreach ($tasks as $item)
                <li>
                    <input type="checkbox" class="hidden peer">
                    <label @class([
                        'inline-flex items-center justify-between w-full text-black p-5 border-2 border-gray-200 rounded-lg cursor-pointer dark:border-gray-700 peer-checked:border-blue-600 dark:peer-checked:border-blue-600 hover:scale-105 transition-transform duration-200' => true,
                        'bg-green-300' => $item->priority == 0,
                        'bg-blue-300' => $item->priority == 1,
                        'bg-blue-500' => $item->priority == 2,
                        'bg-yellow-500' => $item->priority == 3,
                        'bg-orange-500' => $item->priority == 4,
                        'bg-red-500' => $item->priority == 5,
                    ])>
                        <div>
                            <div class="flex flex-row-reverse"><i @class([
                                'fas text-xl ml-4',
                                'fa-check text-green-500' => $item->done,
                                'fa-circle text-green-500' => $item->priority == 0,
                                'fa-circle text-blue-500' => $item->priority == 1,
                                'fa-circle text-blue-700' => $item->priority == 2,
                                'fa-circle text-yellow-700' => $item->priority == 3,
                                'fa-circle-exclamation' => $item->priority >= 4,
                            ])></i>
                                <div class="w-full text-lg font-semibold">{{ $item->title }}
                                </div>
                            </div>
                            <hr @class([
                                'my-4',
                                'border-green-500' => $item->priority == 0,
                                'border-blue-500' => $item->priority == 1,
                                'border-blue-700' => $item->priority == 2,
                                'border-yellow-700' => $item->priority == 3,
                                'border-orange-700' => $item->priority == 4,
                                'border-red-700' => $item->priority == 5,
                            ])>
                            <div class="w-full text-sm">{{ $item->description }}</div>
                        </div>
                    </label>
                </li>
            @endforeach
            @if ($nuevaTarea)
                <li class="">
                    <div class="items-center w-full text-black p-5 border-2 border-gray-200 rounded-lg cursor-pointer dark:border-gray-700 peer-checked:border-blue-600 dark:peer-checked:border-blue-600 hover:scale-105 transition-transform duration-200">
                        <label>Título:</label>
                        <input type="text" class="w-full rounded-lg">
                        <hr class='my-4'>
                        <label>Descripción:</label>
                        <div class="w-full text-sm">
                            <textarea class="w-full rounded-lg"></textarea>
                        </div>
                        <div><input id="minmax-range" type="range" min="0" max="5" value="0" class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer dark:bg-gray-700"></div>
                        <div class="text-center itemd-center mt-4"><button type="button" class="text-white bg-gradient-to-r from-green-400 via-green-500 to-green-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-green-300 dark:focus:ring-green-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">Guardar</button></div>
                    </div>
                </li>
            @endif
        </ul>
        <div class="text-center items-center my-4"><button wire:click="set('nuevaTarea', true)"
                class="relative inline-flex items-center justify-center p-1 mb-2 me-2 overflow-hidden text-sm font-medium text-gray-900 rounded-2xl group bg-gradient-to-br to-blue-600 from-sky-400 group-hover:from-green-400 group-hover:to-blue-600 hover:text-white dark:text-white focus:ring-4 focus:outline-none focus:ring-blue-200 dark:focus:ring-blue-800 hover:scale-105 transition-transform duration-200">
                <span
                    class="relative px-5 py-2.5 transition-all ease-in duration-75 bg-white dark:bg-gray-900 rounded-xl group-hover:bg-transparent group-hover:dark:bg-transparent">
                    <i class="fas fa-plus"></i> Nueva Tarea
                </span>
            </button></div>
    </div>
</x-self.base>
