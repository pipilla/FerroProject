<x-self.base>
    <div class="flex h-[80vh] bg-gray-100">
        <!-- Sidebar: Lista de Chats -->
        <div class="w-1/4 bg-white border-r overflow-y-auto p-4">
            <h2 class="text-lg font-semibold mb-4">Tus chats</h2>

            @foreach ($chats as $chat)
                <button wire:click="seleccionarChat({{ $chat->id }})"
                    class="block w-full text-left px-4 py-2 mb-2 rounded hover:bg-gray-100 {{ $selectedChat === $chat->id ? 'bg-blue-100' : '' }}">
                    @if ($chat->is_group)
                        {{ $chat->name }}
                    @else
                        {{ $chat->users->firstWhere('id', '!=', Auth::id())->name }}
                    @endif
                </button>
            @endforeach
            <button
                class="fixed bottom-6 left-6 bg-blue-600 text-white p-4 rounded-full shadow-lg hover:bg-blue-700 focus:outline-none"
                wire:click="crearNuevoChat">
                <i class="fas fa-plus"></i>
            </button>
        </div>

        <!-- Chat Window -->
        <div class="flex-1 flex flex-col">
            @if ($selectedChat != null)
                <div wire:poll.5000ms="updateMessages">
                    {{-- Lista de mensajes actualizados cada 5 segundos --}}
                </div>
                <!-- Encabezado del Chat -->
                <div class="bg-white px-6 py-4 border-b flex items-center justify-between">
                    <h3 class="text-lg font-semibold">
                        @if ($selectedChat?->is_group)
                            {{ $selectedChat->name }}
                        @else
                            {{ $selectedChat?->users->firstWhere('id', '!=', Auth::id())?->name }}
                        @endif
                    </h3>
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
                            class="flex flex-col {{ $message->sender_id === Auth::id() ? 'items-end' : 'items-start' }}">
                            @if ($message->sender_id !== Auth::id())
                                <p class="text-xs text-gray-600 mb-1">
                                    {{ $message->sender->name ?? 'Usuario' }}
                                </p>
                            @endif

                            <div
                                class="bg-{{ $message->sender_id === Auth::id() ? 'blue' : 'gray' }}-200 px-4 py-2 rounded-lg max-w-xs">
                                <p class="text-sm text-gray-800">{{ $message->content }}</p>
                                <p class="text-xs text-gray-500 text-right mt-1">
                                    {{ $message->created_at->format('H:i') }}
                                </p>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Formulario -->
                <form wire:submit.prevent="sendMessage" class="p-4 bg-white border-t flex items-center gap-2">
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
</x-self.base>
