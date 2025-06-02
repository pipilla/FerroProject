<x-self.base>
    <div x-data="{ openSidebar: true }" class="flex h-[80vh] bg-gray-100 rounded-lg dark:bg-gray-900 relative">
        <!-- Overlay oscuro -->
        <div x-show="openSidebar" @click="openSidebar = false" class="fixed inset-0 bg-black bg-opacity-50 z-30 md:hidden">
        </div>

        <!-- Sidebar: Lista de Chats -->
        <div :class="openSidebar ? 'translate-x-0 mt-16' : '-translate-x-full'"
            class="fixed md:relative md:translate-x-0 top-0 left-0 z-40 w-3/4 md:w-1/4 h-full md:h-auto bg-white border-r p-4 rounded-none md:rounded-l-lg dark:bg-gray-800 dark:border-gray-700 transform transition-transform duration-300 ease-in-out">
            @livewire('crear-chat')
            <div class="flex">
                <!-- Botón hamburguesa para móviles -->
                <button @click="openSidebar = !openSidebar" class="md:hidden mb-4 mr-2">
                    <svg class="w-6 h-6 text-gray-800 dark:text-gray-200" fill="none" stroke="currentColor"
                        stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
                <h2 class="text-lg font-semibold mb-4 dark:text-gray-200">Tus chats</h2>
            </div>
            <div class="overflow-y-auto h-[70vh]">
                @foreach ($chats as $chat)
                    @php
                        $unreadCount = $chat->unreadMessagesForUser(Auth::id())->count();
                    @endphp
                    <button wire:click="seleccionarChat({{ $chat->id }})" :class="openSidebar ? 'mt-2' : ''"
                        class="relative block w-full text-left px-4 py-2 mb-2 rounded-xl transition-colors duration-200
                        {{ $selectedChat != null && $selectedChat->id === $chat->id ? 'bg-blue-100 hover:bg-blue-300 dark:bg-blue-700 dark:hover:bg-blue-600' : 'hover:bg-gray-100 dark:hover:bg-gray-700' }}
                        text-black dark:text-gray-200">
                        <p class="hover:scale-105 transition-transform duration-200">
                            @if ($chat->is_group)
                                {{ $chat->name }}
                            @else
                                {{ $chat->users->firstWhere('id', '!=', Auth::id())->name }}
                            @endif
                        </p>

                        @if ($unreadCount > 0)
                            <div
                                class="absolute top-2 right-2 bg-blue-500 text-white text-xs font-bold rounded-full h-5 w-5 flex items-center justify-center shadow">
                                {{ $unreadCount }}
                            </div>
                        @endif
                    </button>
                @endforeach
            </div>
            <!-- Botón flotante dentro del contenedor de la lista de chats -->
        </div>

        <!-- Chat Window -->
        <div class="flex-1 flex flex-col rounded-r-lg overflow-hidden z-10 md:z-auto">
            @if ($selectedChat != null)
                <div wire:poll.5000ms="updateMessages">
                    {{-- Lista de mensajes actualizados cada 5 segundos --}}
                </div>
                <!-- Encabezado del Chat -->
                <div
                    class="bg-white px-6 py-4 border-b flex items-center justify-between rounded-tr-lg dark:bg-gray-800 dark:border-gray-700">
                    <!-- Botón hamburguesa para móviles -->
                    <button @click="openSidebar = !openSidebar" class="md:hidden mr-2">
                        <svg class="w-6 h-6 text-gray-800 dark:text-gray-200" fill="none" stroke="currentColor"
                            stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                    <h3 class="text-lg font-semibold dark:text-gray-200">
                        @if ($selectedChat?->is_group)
                            {{ $selectedChat->name }}
                        @else
                            {{ $selectedChat?->users->firstWhere('id', '!=', Auth::id())?->name }}
                        @endif
                    </h3>
                    @if ($selectedChat?->is_group)
                        @if (Auth::id() == $selectedChat->admin)
                            <button
                                class="text-lg font-semibold hover:scale-110 transition-transform duration-200 dark:text-gray-200"
                                wire:click="editChat({{ $selectedChat->id }})">
                                <i class="fas fa-gear"></i>
                            </button>
                        @else
                            <button
                                class="text-lg font-semibold hover:scale-110 transition-transform duration-200 dark:text-gray-200"
                                wire:click="infoChat({{ $selectedChat->id }})">
                                <i class="fas fa-info"></i>
                            </button>
                        @endif
                    @endif
                </div>
                <div x-data="{
                    init() {
                            this.scrollToBottom();
                            Livewire.on('scrollToBottom', () => this.scrollToBottom());
                        },
                        scrollToBottom() {
                            this.$nextTick(() => {
                                if (this.$refs.ultimoMensaje) {
                                    this.$refs.ultimoMensaje.scrollIntoView({ behavior: 'smooth', block: 'end' });
                                }
                            });
                        }
                }" x-init="init" x-ref="scrollBox"
                    class="flex-1 overflow-y-auto p-6 space-y-4 bg-white dark:bg-gray-900">
                    @foreach ($messages as $message)
                        <div @if ($loop->last) x-ref="ultimoMensaje" @endif
                            class="flex flex-col {{ $message->sender_id == Auth::id() ? 'items-end' : 'items-start' }}">
                            @if ($message->sender_id != Auth::id())
                                <p class="text-xs text-gray-600 mb-1 dark:text-gray-400">
                                    {{ $message->sender->name ?? 'Usuario' }}
                                </p>
                            @endif

                            <div
                                class="px-4 py-2 rounded-lg max-w-xs {{ $message->sender_id == Auth::id() ? 'bg-blue-200 dark:bg-blue-700' : 'bg-gray-200 dark:bg-gray-700' }}">
                                <p class="text-sm text-gray-800 dark:text-gray-100">{{ $message->content }}</p>
                                <p class="text-xs text-gray-500 text-right mt-1 dark:text-gray-400">
                                    {{ $message->created_at->format('H:i') }}
                                </p>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Formulario -->
                <form wire:submit.prevent="sendMessage"
                    class="p-4 bg-white border-t flex items-center gap-2 rounded-br-lg dark:bg-gray-800 dark:border-gray-700">
                    <input type="text" wire:model.defer="content"
                        class="flex-1 border rounded-full px-4 py-2 focus:outline-none focus:ring bg-gray-100 dark:bg-gray-700 dark:text-white border-gray-300 dark:border-gray-600"
                        placeholder="Escribe un mensaje..." />
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-full hover:bg-blue-600">
                        Enviar
                    </button>
                </form>
            @else
                <div class="flex-1 flex items-center justify-center">
                    <button @click="openSidebar = !openSidebar" class="md:hidden mr-2">
                        <svg class="w-6 h-6 text-gray-800 dark:text-gray-200" fill="none" stroke="currentColor"
                            stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                    <div class="text-gray-500 dark:text-gray-400">
                        Selecciona un chat para comenzar
                    </div>
                </div>
            @endif
        </div>
    </div>
    @if ($openEdit)
        <x-dialog-modal maxWidth="sm" wire:model="openEdit">
            <x-slot name="title">
                Editar grupo
            </x-slot>
            <x-slot name="content">

                <div class="mt-4">
                    <input type="text" wire:model="uform.groupName" placeholder="Nombre del grupo"
                        class="border rounded p-2 w-full bg-white  border-gray-300 ">
                    <x-input-error for="uform.groupName" />
                </div>

                <!-- Mostrar los usuarios disponibles -->
                <div class="mt-4">
                    <h3>Usuarios del grupo</h3>
                    <ul>
                        @foreach ($uform->users as $user)
                            <li>
                                <input type="checkbox" wire:model="uform.groupUsers" value="{{ $user->id }}"
                                    class="mr-2">
                                {{ $user->name }}
                            </li>
                        @endforeach
                    </ul>
                    <x-input-error for="uform.selectedUsers" />
                </div>

            </x-slot>
            <x-slot name="footer">
                <div class="flex justify-between gap-2">
                    <button type="button" wire:click="updateGroup"
                        class="bg-green-500 text-white font-bold p-3 rounded-lg hover:bg-green-600 transition duration-300">
                        <i class="fas fa-save mr-2"></i><span>Actualizar Grupo</span>
                    </button>
                    <button type="button" wire:click="cancelar"
                        class="bg-red-500 text-white font-bold p-3 rounded-lg hover:bg-red-600 transition duration-300">
                        <i class="fas fa-xmark mr-2"></i><span>Cerrar</span>
                    </button>
                </div>
            </x-slot>
        </x-dialog-modal>
    @endif
    @if ($openShow)
        <x-dialog-modal maxWidth="sm" wire:model="openShow">
            <x-slot name="title">
                Usuarios del Grupo
            </x-slot>
            <x-slot name="content">

                <div class="mt-4">
                    <ul>
                        @foreach ($selectedChat->users as $user)
                            <li>
                                {{ $user->name }}
                            </li>
                        @endforeach
                    </ul>
                </div>

            </x-slot>
            <x-slot name="footer">
                <div class="flex justify-between gap-2">
                    <button type="button" wire:click="cancelar"
                        class="bg-red-500 text-white font-bold p-3 rounded-lg hover:bg-red-600 transition duration-300">
                        <i class="fas fa-xmark mr-2"></i><span>Cerrar</span>
                    </button>
                </div>
            </x-slot>
        </x-dialog-modal>
    @endif
</x-self.base>
