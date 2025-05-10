<div>
    <button
        class="absolute top-3 right-3 bg-blue-600 text-white px-2 py-1 rounded-full shadow-lg hover:bg-blue-700 focus:outline-none hover:scale-110 transition-transform duration-200"
        wire:click="set('openCrear', true)">
        <i class="fas fa-plus"></i>
    </button>
    <x-dialog-modal maxWidth="sm" wire:model="openCrear">
        <x-slot name="title">
            Nuevo Chat
        </x-slot>
        <x-slot name="content">
            @if ($isGroup)
                <div class="mt-4">
                    <input type="text" wire:model="cform.groupName" placeholder="Nombre del grupo" value="r"
                        class="border rounded p-2 w-full">
                    <x-input-error for="cform.groupName" />
                </div>
            @endif
            <!-- Mostrar los usuarios disponibles -->
            <div class="mt-4">
                @if ($isGroup)
                    <h3>Seleccionar Usuarios</h3>
                @endif
                <ul>
                    @if ($isGroup)
                        @foreach ($allUsers as $user)
                            <li>
                                <input type="checkbox" wire:model="cform.selectedUsers" value="{{ $user['id'] }}"
                                    class="mr-2">
                                {{ $user['name'] }}
                            </li>
                        @endforeach
                    @else
                        @foreach ($users as $user)
                            <li>
                                <!-- Botón cuando no estamos creando un grupo -->
                                <button wire:click="createChat({{ $user['id'] }})"
                                    class="bg-blue-200 text-blue-700 px-4 py-2 rounded mb-2 hover:bg-blue-300">
                                    {{ $user['name'] }}
                                </button>
                            </li>
                        @endforeach
                    @endif
                </ul>
                <x-input-error for="cform.selectedUsers" />
            </div>

            <!-- Botón para crear un grupo -->
            @if (!$isGroup)
                <button wire:click="createGroup" class="bg-blue-500 text-white p-2 rounded">Crear grupo</button>
            @else
                <button wire:click="createChatGroup" class="bg-blue-500 text-white p-2 rounded mt-4">Crear</button>
            @endif

        </x-slot>
        <x-slot name="footer">
            <div class="flex flex-row-reverse gap-2">
                <button type="button" wire:click="cancelar"
                    class="bg-red-500 text-white font-bold p-3 rounded-lg hover:bg-red-600 transition duration-300">
                    <i class="fas fa-xmark mr-2"></i>Cerrar
                </button>
            </div>
        </x-slot>
    </x-dialog-modal>
</div>
