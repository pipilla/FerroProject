<x-self.base>
    <div class="flex h-[80vh] bg-gray-100 rounded-lg ">
        <!-- Sidebar: Lista de Chats -->
        <div class="relative w-1/4 bg-white border-r p-4 rounded-l-lg">
            @livewire('crear-chat')
            <h2 class="text-lg font-semibold mb-4">Tus chats</h2>
            <div class="overflow-y-auto h-[70vh]">
                @foreach ($chats as $chat)
                    <button wire:click="seleccionarChat({{ $chat->id }})"
                        class="block w-full text-left px-4 py-2 mb-2 rounded-xl {{ $selectedChat != null && $selectedChat->id === $chat->id ? 'bg-blue-100 hover:bg-blue-300' : 'hover:bg-gray-100' }}">
                        <p class="hover:scale-105 transition-transform duration-200">
                            @if ($chat->is_group)
                                {{ $chat->name }}
                            @else
                                {{ $chat->users->firstWhere('id', '!=', Auth::id())->name }}
                            @endif
                        </p>
                    </button>
                @endforeach
            </div>
            <!-- Botón flotante dentro del contenedor de la lista de chats -->
        </div>

        <!-- Chat Window -->
        <div class="flex-1 flex flex-col rounded-r-lg">
            @if ($selectedChat != null)
                <div wire:poll.5000ms="updateMessages">
                    {{-- Lista de mensajes actualizados cada 5 segundos --}}
                </div>
                <!-- Encabezado del Chat -->
                <div class="bg-white px-6 py-4 border-b flex items-center justify-between rounded-tr-lg">
                    <h3 class="text-lg font-semibold">
                        @if ($selectedChat?->is_group)
                            {{ $selectedChat->name }}
                        @else
                            {{ $selectedChat?->users->firstWhere('id', '!=', Auth::id())?->name }}
                        @endif
                    </h3>
                    @if ($selectedChat?->is_group)
                        @if (Auth::id() == $selectedChat->admin)
                            <button class="text-lg font-semibold hover:scale-110 transition-transform duration-200"
                                wire:click="editChat({{ $selectedChat->id }})">
                                <i class="fas fa-gear"></i>
                            </button>
                        @else
                            <button class="text-lg font-semibold hover:scale-110 transition-transform duration-200"
                                wire:click="infoChat({{ $selectedChat->id }})">
                                <i class="fas fa-info"></i>
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
                    class="flex-1 overflow-y-auto p-6 space-y-4">
                    @foreach ($messages as $message)
                        <div @if ($loop->last) x-ref="ultimoMensaje" @endif
                            class="flex flex-col {{ $message->sender_id == Auth::id() ? 'items-end' : 'items-start' }}">
                            @if ($message->sender_id != Auth::id())
                                <p class="text-xs text-gray-600 mb-1">
                                    {{ $message->sender->name ?? 'Usuario' }}
                                </p>
                            @endif

                            <div
                                class="bg-{{ $message->sender_id == Auth::id() ? 'blue' : 'gray' }}-200 px-4 py-2 rounded-lg max-w-xs">
                                <p class="text-sm text-gray-800">{{ $message->content }}</p>
                                <p class="text-xs text-gray-500 text-right mt-1">
                                    {{ $message->created_at->format('H:i') }}
                                </p>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Formulario -->
                <form wire:submit.prevent="sendMessage"
                    class="p-4 bg-white border-t flex items-center gap-2 rounded-br-lg">
                    <input type="text" wire:model.defer="content"
                        class="flex-1 border rounded-full px-4 py-2 focus:outline-none focus:ring"
                        placeholder="Escribe un mensaje..." />
                    <button type="submit"
                        class="bg-blue-500 text-white px-4 py-2 rounded-full hover:bg-blue-600">Enviar</button>
                </form>
            @else
                <div class="flex-1 flex items-center justify-center text-gray-500">
                    Selecciona un chat para comenzar
                </div>
            @endif
        </div>
    </div>
    @if (Auth::user()->role > 1 && $openEdit)
        <x-dialog-modal maxWidth="sm" wire:model="openEdit">
            <x-slot name="title">
                Editar grupo
            </x-slot>
            <x-slot name="content">

                <div class="mt-4">
                    <input type="text" wire:model="uform.groupName" placeholder="Nombre del grupo"
                        class="border rounded p-2 w-full">
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
                        <i class="fas fa-save mr-2"></i>Actualizar Grupo
                    </button>
                    <button type="button" wire:click="cancelar"
                        class="bg-red-500 text-white font-bold p-3 rounded-lg hover:bg-red-600 transition duration-300">
                        <i class="fas fa-xmark mr-2"></i>Cerrar
                    </button>
                </div>
            </x-slot>
        </x-dialog-modal>
    @endif
    @if (Auth::user()->role > 1 && $openShow)
        <x-dialog-modal maxWidth="sm" wire:model="openShow">
            <x-slot name="title">
                Usuarios del grupo
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
                        <i class="fas fa-xmark mr-2"></i>Cerrar
                    </button>
                </div>
            </x-slot>
        </x-dialog-modal>
    @endif
</x-self.base>
