<x-app-layout>
    <x-self.base>
        <!-- Banner Inicial -->
        <section class="bg-gray-100 py-20 text-center">
            <div class="max-w-4xl mx-auto px-4">
                <h1 class="text-4xl font-bold mb-4">FerroProject</h1>
                <p class="text-lg text-gray-700 mb-6">Explora nuestra galería, descubre nuestros posts y contáctanos
                    fácilmente.</p>
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

        @auth
            @if (Auth::user()->role > 0)
                <!-- Servicios para los trabajadores -->
                <section class="py-16 bg-white">
                    <div
                        class="max-w-6xl mx-auto px-4 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 text-center">
                        <a class="p-6 rounded-lg shadow hover:shadow-md transition" href="{{ route('tareas') }}">
                            <i class="fas fa-list-check text-3xl text-blue-500 mb-4"></i>
                            <h3 class="text-lg font-semibold mb-2">Lista de Tareas</h3>
                            <p class="text-gray-600 text-sm">Consulta tu lista de tareas personal.</p>
                        </a>
                        <a class="p-6 rounded-lg shadow hover:shadow-md transition" href="{{ route('chat') }}">
                            <i class="fas fa-comment text-3xl text-green-500 mb-4"></i>
                            <h3 class="text-lg font-semibold mb-2">Chat</h3>
                            <p class="text-gray-600 text-sm">Acceso al chat de la empresa.</p>
                        </a>
                        @if (Auth::user()->role > 1)
                            <a class="p-6 rounded-lg shadow hover:shadow-md transition" href="{{ route('facturas') }}">
                                <i class="fas fa-file-invoice-dollar text-3xl text-red-500 mb-4"></i>
                                <h3 class="text-lg font-semibold mb-2">Facturas</h3>
                                <p class="text-gray-600 text-sm">Accede a las facturas de los clientes.</p>
                            </a>
                        @else
                            <a class="p-6 rounded-lg shadow hover:shadow-md transition" href="{{ route('designer') }}">
                                <i class="fas fa-pencil text-3xl text-red-500 mb-4"></i>
                                <h3 class="text-lg font-semibold mb-2">Cuaderno</h3>
                                <p class="text-gray-600 text-sm">Accede a tu cuaderno de diseño personal.</p>
                            </a>
                        @endif
                    </div>
                </section>
            @endif
        @endauth

        <!-- Sobre la empresa -->
        <section class="bg-white py-16">
            <div class="max-w-5xl mx-auto px-4 text-center">
                <h2 class="text-3xl font-bold mb-4">¿Quiénes somos?</h2>
                <p class="text-gray-700 text-md">
                    Somos una empresa de <b>carpintería metálica</b> en <b>Almería</b>.
                </p>
                <p class="text-gray-700 text-md">
                    Hacemos todo tipo de <b>trabajos metálicos</b>, y nos comprometemos a ofecer los <b>mejores
                        resultados</b> para nuestros clientes.
                </p>
                <hr class="my-6" />
                <a class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-3 rounded-lg inline-flex items-center"
                    href="{{ route('posts') }}">
                    Conoce nuestros últimos trabajos
                </a>
            </div>
        </section>

        <!-- Banner imagen genérica -->
        <section>
            <img src="" alt="">
        </section>

        <!-- Servicios / Enlaces Rápidos -->
        <section class="py-16 bg-white">
            <div class="max-w-6xl mx-auto px-4 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 text-center">
                <a class="p-6 rounded-lg shadow hover:shadow-md transition" href="{{ route('galeria') }}">
                    <i class="fas fa-photo-film text-3xl text-blue-500 mb-4"></i>
                    <h3 class="text-lg font-semibold mb-2">Galería</h3>
                    <p class="text-gray-600 text-sm">Descubre las imágenes y vídeos de nuestros últimos trabajos.</p>
                </a>
                <a class="p-6 rounded-lg shadow hover:shadow-md transition" href="{{ route('posts') }}">
                    <i class="fas fa-users text-3xl text-green-500 mb-4"></i>
                    <h3 class="text-lg font-semibold mb-2">Posts</h3>
                    <p class="text-gray-600 text-sm">Consulta nuestra red social interna con los últimos posts, noticias
                        y trabajos.</p>
                </a>
                <a class="p-6 rounded-lg shadow hover:shadow-md transition" href="{{ route('formulario-contacto') }}">
                    <i class="fas fa-envelope text-3xl text-red-500 mb-4"></i>
                    <h3 class="text-lg font-semibold mb-2">Contáctanos</h3>
                    <p class="text-gray-600 text-sm">Envíanos tus consultas y trabajos a través de un formulario.</p>
                </a>
            </div>
        </section>

        <!-- Contact Section -->
        <section class="bg-gray-50 py-16">
            <div class="max-w-3xl mx-auto px-4 text-center">
                <h2 class="text-3xl font-bold mb-6">¿Tienes alguna pregunta?</h2>
                <p class="text-gray-700 mb-6">Ponte en contacto con nosotros a través del formulario o visítanos en
                    nuestras redes.</p>
                <a href="{{ route('formulario-contacto') }}"
                    class="bg-red-500 hover:bg-red-600 text-white font-semibold px-6 py-3 rounded-lg inline-flex items-center">
                    <i class="fas fa-paper-plane mr-2"></i> Ir al Formulario
                </a>
            </div>
        </section>
    </x-self.base>
</x-app-layout>
