<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
        integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.jsx'])
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js"></script>

    <!-- Styles -->
    @livewireStyles
</head>

<body class="min-h-screen flex flex-col font-sans antialiased">
    <x-banner />

    <div class="flex-grow bg-gray-100">
        @livewire('navigation-menu')

        <!-- Page Heading -->
        @if (isset($header))
            <header class="bg-white shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endif

        <!-- Page Content -->
        <main class="pt-16">
            {{ $slot }}
        </main>

    </div>

    @include('footer')

    @stack('modals')

    @livewireScripts

    {{-- Alertas --}}
    <script>
        Livewire.on('mensaje', txt => {
            Swal.fire({
                icon: "success",
                title: txt,
                showConfirmButton: false,
                timer: 1500
            });
        })
        Livewire.on('confirmarBloquearUser', (id) => {
            Swal.fire({
                title: "Bloquear usuario?",
                text: "Se bloqueará su acceso completo a la página",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Sí, bloquearlo"
            }).then((result) => {
                if (result.isConfirmed) {
                    Livewire.dispatchTo('crud-users', 'bloquearUserOk', id);
                }
            });
        });
        Livewire.on('confirmarBorrarMedia', (id) => {
            Swal.fire({
                title: "¿Borrar elemento?",
                text: "Una vez eliminado no podrás recuperarlo",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Sí, borrarlo"
            }).then((result) => {
                if (result.isConfirmed) {
                    Livewire.dispatchTo('show-media', 'borrarMediaOk', id);
                }
            });
        });
        Livewire.on('confirmarBorrarInvoice', (id) => {
            Swal.fire({
                title: "¿Borrar factura?",
                text: "Una vez eliminada no podrás recuperar los datos",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Sí, borrarla"
            }).then((result) => {
                if (result.isConfirmed) {
                    Livewire.dispatchTo('show-invoices', 'borrarInvoiceOk', id);
                }
            });
        });
        Livewire.on('confirmarBorrarCategoria', (id) => {
            Swal.fire({
                title: "¿Borrar categoría?",
                text: "¡Se eliminarán todos los vídeos e imágenes que pertenezcan a la misma!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Sí, borrarla"
            }).then((result) => {
                if (result.isConfirmed) {
                    Livewire.dispatchTo('crud-category', 'borrarCategoriaOk', id);
                }
            });
        });
        Livewire.on('confirmarBorrarTask', (id) => {
            Swal.fire({
                title: "¿Borrar tarea?",
                text: "Una vez eliminada no podrás recuperarla",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Sí, borrarla"
            }).then((result) => {
                if (result.isConfirmed) {
                    Livewire.dispatchTo('show-tasks', 'borrarOk', id);
                }
            });
        });
        Livewire.on('onManagePost', (id) => {
            Swal.fire({
                title: '¿Qué quieres hacer con este post?',
                icon: 'question',
                showDenyButton: true,
                showCancelButton: true,
                confirmButtonText: '✏️ Editarlo',
                denyButtonText: '🗑️ Borrarlo',
                cancelButtonText: 'Cancelar',
            }).then((result) => {
                if (result.isConfirmed) {
                    Livewire.dispatchTo('show-posts', 'editOk', id);
                } else if (result.isDenied) {
                    Swal.fire({
                        title: '¿Estás seguro?',
                        text: 'Esta acción no se puede deshacer.',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Sí, borrarlo',
                        cancelButtonText: 'Cancelar',
                    }).then((confirmResult) => {
                        if (confirmResult.isConfirmed) {
                            Livewire.dispatchTo('show-posts', 'borrarOk', id);
                        }
                    });
                }
            });
        });
    </script>
</body>

</html>
