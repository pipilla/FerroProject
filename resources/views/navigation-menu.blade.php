<nav x-data="{ open: false }"
    class="bg-white dark:bg-gray-900 border-b border-gray-100 dark:border-gray-700 fixed top-0 left-0 z-50 w-full">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">

            <!-- Logo -->
            <div class="shrink-0 flex items-center">
                <a href="{{ route('welcome') }}">
                    <x-application-mark class="block h-9 w-auto" />
                </a>
            </div>

            <!-- Links -->
            <div class="flex overflow-x-auto whitespace-nowrap scroll-smooth" style="scrollbar-width: none;">
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link class="dark:text-gray-200 dark:hover:text-white" href="{{ route('galeria') }}"
                        :active="request()->routeIs('galeria')">
                        {{ __('Galería') }}
                    </x-nav-link>
                </div>
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link class="dark:text-gray-200 dark:hover:text-white" href="{{ route('posts') }}"
                        :active="request()->routeIs('posts')">
                        {{ __('Posts') }}
                    </x-nav-link>
                </div>
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link class="dark:text-gray-200 dark:hover:text-white"
                        href="{{ route('formulario-contacto') }}" :active="request()->routeIs('formulario-contacto')">
                        {{ __('Contáctanos') }}
                    </x-nav-link>
                </div>

                @auth
                    @if (Auth::user()->role > 0)
                        <!-- Más links según el rol -->
                        <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                            <x-nav-link class="dark:text-gray-200 dark:hover:text-white" href="{{ route('tareas') }}"
                                :active="request()->routeIs('tareas')">
                                {{ __('Tareas') }}
                            </x-nav-link>
                        </div>
                        @if (Auth::user()->role > 1)
                            <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                                <x-nav-link class="dark:text-gray-200 dark:hover:text-white" href="{{ route('facturas') }}"
                                    :active="request()->routeIs('facturas')">
                                    {{ __('Facturas') }}
                                </x-nav-link>
                            </div>
                        @endif
                        <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                            <x-nav-link class="dark:text-gray-200 dark:hover:text-white" href="{{ route('chat') }}"
                                :active="request()->routeIs('chat')">
                                {{ __('Chat') }}
                            </x-nav-link>
                        </div>
                        <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                            <x-nav-link class="dark:text-gray-200 dark:hover:text-white" href="{{ route('designer') }}"
                                :active="request()->routeIs('designer')">
                                {{ __('Bocetos') }}
                            </x-nav-link>
                        </div>
                        @if (Auth::user()->role > 2)
                            @livewire('crud-users')
                        @endif
                    @endif
                @endauth
            </div>

            <!-- Botones login / usuario -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                @if (Route::has('login'))
                    <nav class="flex items-center justify-end gap-4">
                        @auth
                            <div class="ms-3 relative">
                                <x-dropdown align="right" width="48">
                                    <x-slot name="trigger">
                                        @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                                            <button
                                                class="flex text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300 dark:focus:border-gray-600 transition">
                                                <img class="size-8 rounded-full object-cover"
                                                    src="{{ Auth::user()->profile_photo_url }}"
                                                    alt="{{ Auth::user()->name }}" />
                                            </button>
                                        @else
                                            <button type="button"
                                                class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-200 dark:hover:text-white bg-white dark:bg-gray-800 hover:text-gray-700 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-700 transition ease-in-out duration-150">
                                                {{ Auth::user()->name }}
                                                <svg class="ms-2 -me-0.5 size-4" xmlns="http://www.w3.org/2000/svg"
                                                    fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                                    stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                                                </svg>
                                            </button>
                                        @endif
                                    </x-slot>

                                    <x-slot name="content" class="dark:bg-black">
                                        <div class="block px-4 py-2 text-xs text-gray-400 dark:text-gray-200">
                                            {{ __('Gestionar cuenta') }}
                                        </div>

                                        <x-dropdown-link class="dark:text-gray-300" href="{{ route('profile.show') }}">
                                            {{ __('Perfil') }}
                                        </x-dropdown-link>

                                        @if (Laravel\Jetstream\Jetstream::hasApiFeatures())
                                            <x-dropdown-link class="dark:text-gray-300"
                                                href="{{ route('api-tokens.index') }}">
                                                {{ __('API Tokens') }}
                                            </x-dropdown-link>
                                        @endif

                                        <div class="border-t border-gray-200 dark:border-gray-700"></div>

                                        <form method="POST" action="{{ route('logout') }}" x-data>
                                            @csrf
                                            <x-dropdown-link href="{{ route('logout') }}" @click.prevent="$root.submit();"
                                                class="dark:text-gray-300">
                                                {{ __('Cerrar Sesión') }}
                                            </x-dropdown-link>
                                        </form>
                                    </x-slot>
                                </x-dropdown>
                            </div>
                        @else
                            <a href="{{ route('login') }}"
                                class="inline-block px-5 py-1.5 text-[#1b1b18] dark:text-gray-200 border border-transparent hover:border-gray-300 dark:hover:border-gray-600 rounded-full text-sm leading-normal">
                                Iniciar Sesión
                            </a>

                            @if (Route::has('register'))
                                <a href="{{ route('register') }}"
                                    class="inline-block px-5 py-1.5 border-gray-300 dark:border-gray-600 hover:border-gray-400 dark:hover:border-gray-500 border text-[#1b1b18] dark:text-gray-200 rounded-full text-sm leading-normal">
                                    Registrarse
                                </a>
                            @endif
                        @endauth
                    </nav>
                @endif
            </div>

            <!-- Botón hamburguesa -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open"
                    class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 dark:text-gray-200 hover:text-gray-500 hover:bg-gray-100 dark:hover:bg-gray-800 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-700 transition duration-150 ease-in-out">
                    <svg class="size-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{ 'block': open, 'hidden': !open }" class="hidden sm:hidden dark:bg-gray-900 dark:text-white">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link href="{{ route('galeria') }}" :active="request()->routeIs('galeria')">
                {{ __('Galería') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link href="{{ route('posts') }}" :active="request()->routeIs('posts')">
                {{ __('Posts') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link href="{{ route('formulario-contacto') }}" :active="request()->routeIs('formulario-contacto')">
                {{ __('Contáctanos') }}
            </x-responsive-nav-link>
            @auth
                @if (Auth::user()->role > 0)
                    <x-responsive-nav-link href="{{ route('tareas') }}" :active="request()->routeIs('tareas')">
                        {{ __('Tareas') }}
                    </x-responsive-nav-link>
                    @if (Auth::user()->role > 1)
                        <x-responsive-nav-link href="{{ route('facturas') }}" :active="request()->routeIs('facturas')">
                            {{ __('Facturas') }}
                        </x-responsive-nav-link>
                    @endif
                    <x-responsive-nav-link href="{{ route('chat') }}" :active="request()->routeIs('chat')">
                        {{ __('Chat') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link href="{{ route('designer') }}" :active="request()->routeIs('designer')">
                        {{ __('Bocetos') }}
                    </x-responsive-nav-link>
                @endif
            @endauth
        </div>

        @if (Route::has('login'))
            <nav class="flex items-center justify-end gap-4">
                @auth
                    <!-- Responsive Settings Options -->
                    <div class="pt-4 pb-1 border-t border-gray-200">
                        <div class="flex items-center px-4">
                            @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                                <div class="shrink-0 me-3">
                                    <img class="size-10 rounded-full object-cover"
                                        src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" />
                                </div>
                            @endif

                            <div>
                                <div class="font-medium text-base text-gray-800 dark:text-gray-200">{{ Auth::user()->name }}</div>
                                <div class="font-medium text-sm text-gray-500 dark:text-gray-400">{{ Auth::user()->email }}</div>
                            </div>
                        </div>

                        <div class="mt-3 space-y-1">
                            <!-- Account Management -->
                            <x-responsive-nav-link href="{{ route('profile.show') }}" :active="request()->routeIs('profile.show')">
                                {{ __('Perfil') }}
                            </x-responsive-nav-link>

                            @if (Laravel\Jetstream\Jetstream::hasApiFeatures())
                                <x-responsive-nav-link href="{{ route('api-tokens.index') }}" :active="request()->routeIs('api-tokens.index')">
                                    {{ __('API Tokens') }}
                                </x-responsive-nav-link>
                            @endif

                            <!-- Authentication -->
                            <form method="POST" action="{{ route('logout') }}" x-data>
                                @csrf

                                <x-responsive-nav-link href="{{ route('logout') }}" @click.prevent="$root.submit();">
                                    {{ __('Cerrar Sesión') }}
                                </x-responsive-nav-link>
                            </form>

                        </div>
                    </div>
                @else
                    <div class="mb-3">
                        <a href="{{ route('login') }}"
                            class="inline-block px-5 py-1.5 text-[#1b1b18] dark:text-gray-200 border border-transparent hover:border-[#19140035] dark:hover:border-gray-200 rounded-sm text-sm leading-normal">
                            Iniciar Sesión
                        </a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}"
                                class="inline-block px-5 py-1.5 border-[#19140035] dark:border-gray-200 hover:border-[#1915014a] dark:hover:border-white border text-[#1b1b18] dark:text-gray-200 rounded-sm text-sm leading-normal">
                                Registrarse
                            </a>
                        @endif
                    </div>
                @endauth
            </nav>
        @endif
    </div>
</nav>
