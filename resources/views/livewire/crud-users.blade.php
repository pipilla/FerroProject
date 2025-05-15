<div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
    <x-nav-link wire:click="set('openModal', true)">
        <button>Users Admin</button>
    </x-nav-link>
    <x-dialog-modal maxWidth="4xl" wire:model="openModal">
        <x-slot name="title">
            Administrar usuarios
        </x-slot>
        <x-slot name="content">
            <div class="space-y-4">
                @foreach ($users as $item)
                    <div
                        class="flex flex-col md:flex-row items-start md:items-center justify-between shadow-md rounded-xl p-4 border border-gray-100 hover:shadow-lg transition
            @switch($item->role)
                @case(3) bg-red-100 @break
                @case(2) bg-orange-100 @break
                @case(1) bg-blue-100 @break
                @case(0) bg-green-100 @break
                @default bg-white
            @endswitch">

                        <div class="flex flex-col md:flex-row items-start md:items-center gap-4 w-full md:w-2/3">
                            <div class="flex items-center gap-3">
                                <div>
                                    <p class="font-semibold text-gray-800">{{ $item->name }}</p>
                                    <p class="text-sm text-gray-600">{{ $item->email }}</p>
                                </div>
                            </div>
                        </div>

                        <div
                            class="mt-3 md:mt-0 md:w-1/2 flex flex-col md:flex-row items-start md:items-center gap-2 md:justify-end">
                            @if ($userToEdit != $item->id)
                                <div class="text-gray-800 font-medium mb-2 md:mb-0">
                                    @switch($item->role)
                                        @case(3)
                                            Admin
                                        @break

                                        @case(2)
                                            Trabajador con permisos
                                        @break

                                        @case(1)
                                            Trabajador
                                        @break

                                        @case(0)
                                            Cliente
                                        @break

                                        @default
                                            Sin rol
                                    @endswitch
                                </div>
                                @if (Auth::id() != $item->id)
                                    <button wire:click="editUser({{ $item->id }})"
                                        class="flex items-center gap-2 text-sm bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-1.5 rounded-lg shadow-sm transition">
                                        <i class="fas fa-edit"></i> Editar
                                    </button>
                                    @if ($item->active)
                                        <button wire:click="blockUser({{ $item->id }})"
                                            class="flex items-center gap-2 text-sm bg-red-500 hover:bg-red-600 text-white px-4 py-1.5 rounded-lg shadow-sm transition">
                                            <i class="fas fa-ban"></i> Bloquear
                                        </button>
                                    @else
                                    <button wire:click="desbloquearUsuario({{ $item->id }})"
                                            class="flex items-center gap-2 text-sm bg-blue-500 hover:bg-blue-600 text-white px-4 py-1.5 rounded-lg shadow-sm transition">
                                            <i class="fas fa-ban"></i> Desbloquear
                                        </button>
                                    @endif
                                @endif
                            @else
                                <select name="role[{{ $item->id }}]" wire:model="role"
                                    class="w-full md:w-auto border border-gray-300 bg-white rounded-lg pl-4 pr-8 py-2 shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                                    @disabled(Auth::id() == $item->id)>
                                    <option value="3">Admin</option>
                                    <option value="2">Trabajador con permisos</option>
                                    <option value="1">Trabajador</option>
                                    <option value="0">Cliente</option>
                                </select>

                                <button wire:click="saveUser({{ $item->id }})"
                                    class="flex items-center gap-2 text-sm bg-green-600 hover:bg-green-700 text-white px-4 py-1.5 rounded-lg shadow-sm transition">
                                    <i class="fas fa-save"></i> Guardar
                                </button>
                                <button wire:click="cancelar"
                                    class="flex items-center gap-2 text-sm bg-gray-600 hover:bg-gray-700 text-white px-4 py-1.5 rounded-lg shadow-sm transition">
                                    <i class="fas fa-xmark"></i> Cancelar
                                </button>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>

        </x-slot>
        <x-slot name="footer">
            <div class="flex flex-row-reverse gap-2">
                <button type="button" wire:click="cerrar"
                    class="bg-red-500 text-white font-bold p-3 rounded-lg hover:bg-red-600 transition duration-300">
                    <i class="fas fa-xmark mr-2"></i>Cerrar
                </button>
            </div>
        </x-slot>
    </x-dialog-modal>
</div>
