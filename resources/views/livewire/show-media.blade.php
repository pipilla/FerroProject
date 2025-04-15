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
        @foreach ($media as $image)
            <div>
                <img class="h-auto max-w-full rounded-lg" src="{{ Storage::url($image->src) }}"
                    alt="{{ $image->title }}">
            </div>
        @endforeach
    </div>

    <div class="mt-2">
        {{ $media->links() }}
    </div>

</x-self.base>
