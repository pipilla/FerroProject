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
                @class([
                    'text-gray-900 border border-white hover:border-gray-200 dark:border-gray-900 dark:bg-gray-900 dark:hover:border-gray-700 bg-white focus:ring-4 focus:outline-none focus:ring-gray-300 rounded-full text-base font-medium px-5 py-2.5 text-center me-3 mb-3 dark:text-white dark:focus:ring-gray-800',
                    'font-bold' => true,
                ])>{{ $category->name }}</button>
        @endforeach
        @if (Auth::user() && Auth::user()->role >= 2)
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
                        Tu navegador no soporta el video.
                    </video>
                @endif
            </button>
        @endforeach
    </div>

    <div class="mt-2">
        {{ $media->links() }}
    </div>

    @if ($sform->media != null)
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

                    <div class="text-center mt-4">
                        <button type="button" wire:click="buscar({{ $sform->category_id }})"
                            class='text-gray-900 border border-white hover:border-gray-200 dark:border-gray-900 dark:bg-gray-900 dark:hover:border-gray-700 bg-white focus:ring-4 focus:outline-none focus:ring-gray-300 rounded-full text-base px-5 py-2.5 text-center me-3 dark:text-white dark:focus:ring-gray-800 font-bold'>{{ $sform->category_name }}</button>
                    </div>

                    {{ $sform->file_type }}
                </x-slot>
                <x-slot name="footer">
                    <div class="flex flex-row-reverse">
                        <button type="button" wire:click="cerrarShow"
                            class="mr-4 bg-red-500 text-white font-bold p-3 rounded-lg hover:bg-red-600 transition duration-300">
                            <i class="fas fa-xmark mr-2"></i>Cerrar
                        </button>
                    </div>
                </x-slot>
            </x-dialog-modal>
        </div>
    @endif

</x-self.base>
