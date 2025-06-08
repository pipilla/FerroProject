<x-app-layout>
    <x-self.base>
        <!-- Banner Inicial -->
        <section class="relative bg-gray-800 py-20 text-center overflow-hidden">
            <!-- Fondo con opacidad -->
            <div class="absolute inset-0 bg-cover bg-center"
                style="background-image: url('{{ Storage::url('assets/1.jpg') }}'); opacity: 0.3;">
            </div>

            <!-- Contenido por encima -->
            <div class="relative z-10 max-w-4xl mx-auto px-4">
                <h1 class="text-4xl font-bold mb-4 text-white">FerroProject</h1>
                <p class="text-lg text-gray-300 mb-6">
                    Explora nuestra galería, descubre nuestros posts y contáctanos fácilmente.
                </p>
                <div class="flex justify-center space-x-4">
                    <a class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-3 rounded-lg inline-flex items-center"
                        href="{{ route('galeria') }}">
                        <i class="fas fa-images mr-2"></i> Galería
                    </a>
                    <a class="bg-green-600 hover:bg-green-700 text-white font-semibold px-6 py-3 rounded-lg inline-flex items-center"
                        href="{{ route('posts') }}">
                        <i class="fas fa-newspaper mr-2"></i> Posts
                    </a>
                </div>
            </div>
        </section>

        @guest
            <!-- Sobre la empresa -->
            <section class="bg-white dark:bg-gray-900 py-16">
                <div class="max-w-5xl mx-auto px-4 text-center">
                    <h2 class="text-3xl font-bold mb-4 text-gray-900 dark:text-white">¿Quiénes somos?</h2>
                    <p class="text-gray-700 dark:text-gray-300 text-md">
                        Somos una empresa de <b>carpintería metálica</b> en <b>Almería</b>.
                    </p>
                    <p class="text-gray-700 dark:text-gray-300 text-md">
                        Hacemos todo tipo de <b>trabajos metálicos</b>, y nos comprometemos a ofrecer los <b>mejores
                            resultados</b> para nuestros clientes.
                    </p>
                    <hr class="my-6 border-gray-300 dark:border-gray-700" />
                    <a class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-3 rounded-lg inline-flex items-center"
                        href="{{ route('posts') }}">
                        Conoce nuestros últimos trabajos
                    </a>
                </div>
            </section>
        @endguest

        <!-- Servicios / Enlaces Rápidos -->
        <section class="py-16 bg-gray-200 dark:bg-gray-900">
            <div class="max-w-6xl mx-auto px-4 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 text-center">
                <a class="p-6 rounded-lg shadow hover:shadow-md transition bg-white dark:bg-gray-800 dark:hover:bg-gray-700"
                    href="{{ route('galeria') }}">
                    <i class="fas fa-images text-3xl text-blue-500 mb-4"></i>
                    <h3 class="text-lg font-semibold mb-2 text-gray-900 dark:text-white">Galería</h3>
                    <p class="text-gray-600 dark:text-gray-300 text-sm">Descubre las imágenes y vídeos de nuestros
                        últimos trabajos.</p>
                </a>
                <a class="p-6 rounded-lg shadow hover:shadow-md transition bg-white dark:bg-gray-800 dark:hover:bg-gray-700"
                    href="{{ route('posts') }}">
                    <i class="fas fa-newspaper text-3xl text-green-500 mb-4"></i>
                    <h3 class="text-lg font-semibold mb-2 text-gray-900 dark:text-white">Posts</h3>
                    <p class="text-gray-600 dark:text-gray-300 text-sm">Consulta nuestra red social interna con los
                        últimos posts, noticias y trabajos.</p>
                </a>
                <a class="p-6 rounded-lg shadow hover:shadow-md transition bg-white dark:bg-gray-800 dark:hover:bg-gray-700 md:col-span-2 lg:col-span-1"
                    href="{{ route('formulario-contacto') }}">
                    <i class="fas fa-envelope text-3xl text-red-500 mb-4"></i>
                    <h3 class="text-lg font-semibold mb-2 text-gray-900 dark:text-white">Contáctanos</h3>
                    <p class="text-gray-600 dark:text-gray-300 text-sm">Envíanos tus consultas y trabajos a través de un
                        formulario.</p>
                </a>
                @auth
                    @if (Auth::user()->role > 0)
                        <a class="p-6 rounded-lg shadow hover:shadow-md transition bg-white dark:bg-gray-800 dark:hover:bg-gray-700"
                            href="{{ route('tareas') }}">
                            <i class="fas fa-list-check text-3xl text-blue-500 mb-4"></i>
                            <h3 class="text-lg font-semibold mb-2 text-gray-900 dark:text-white">Lista de Tareas</h3>
                            <p class="text-gray-600 dark:text-gray-300 text-sm">Consulta tu lista de tareas personal.
                            </p>
                        </a>
                        <a class="p-6 rounded-lg shadow hover:shadow-md transition bg-white dark:bg-gray-800 dark:hover:bg-gray-700"
                            href="{{ route('chat') }}">
                            <i class="fas fa-comment text-3xl text-green-500 mb-4"></i>
                            <h3 class="text-lg font-semibold mb-2 text-gray-900 dark:text-white">Chat</h3>
                            <p class="text-gray-600 dark:text-gray-300 text-sm">Acceso al chat de la empresa.</p>
                        </a>
                        @if (Auth::user()->role > 1)
                            <a class="p-6 rounded-lg shadow hover:shadow-md transition bg-white dark:bg-gray-800 dark:hover:bg-gray-700 md:col-span-2 lg:col-span-1"
                                href="{{ route('facturas') }}">
                                <i class="fas fa-file-invoice-dollar text-3xl text-red-500 mb-4"></i>
                                <h3 class="text-lg font-semibold mb-2 text-gray-900 dark:text-white">Facturas</h3>
                                <p class="text-gray-600 dark:text-gray-300 text-sm">Accede a las facturas de los
                                    clientes.
                                </p>
                            </a>
                        @else
                            <a class="p-6 rounded-lg shadow hover:shadow-md transition bg-white dark:bg-gray-800 dark:hover:bg-gray-700 md:col-span-2 lg:col-span-1"
                                href="{{ route('designer') }}">
                                <i class="fas fa-pencil text-3xl text-red-500 mb-4"></i>
                                <h3 class="text-lg font-semibold mb-2 text-gray-900 dark:text-white">Cuaderno</h3>
                                <p class="text-gray-600 dark:text-gray-300 text-sm">Accede a tu cuaderno de diseño
                                    personal.
                                </p>
                            </a>
                        @endif
                    @endif
                @endauth
            </div>
        </section>

        <!-- Contact Section -->
        <section class="bg-gray-50 dark:bg-gray-800 py-16">
            <div class="max-w-3xl mx-auto px-4 text-center">
                <h2 class="text-3xl font-bold mb-6 text-gray-900 dark:text-white">¿Tienes alguna pregunta?</h2>
                <p class="text-gray-700 dark:text-gray-300 mb-6">Ponte en contacto con nosotros a través del formulario.
                </p>
                <a href="{{ route('formulario-contacto') }}"
                    class="bg-red-500 hover:bg-red-600 text-white font-semibold px-6 py-3 rounded-lg inline-flex items-center">
                    <i class="fas fa-paper-plane mr-2"></i> Ir al Formulario
                </a>
            </div>
        </section>
    </x-self.base>
</x-app-layout>
