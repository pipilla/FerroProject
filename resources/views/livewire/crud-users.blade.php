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
                        <div class="mt-3 md:mt-0 md:w-1/2 flex">
                            @if ($userToEdit != $item->id)
                                <div class="text-gray-800 font-medium">
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
                                <button wire:click="editUser({{ $item->id }})"
                                    class="text-sm bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded transition">
                                    <i class="fas fa-edit mr-2"></i>Editar
                                </button>
                                <button wire:click="deleteUser({{ $item->id }})"
                                    class="text-sm bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded transition">
                                    <i class="fas fa-x-mark mr-2"></i>Eliminar
                                </button>
                            @else
                                <select name="role[{{ $item->id }}]"
                                    class="w-full border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                    @disabled(Auth::id() == $item->id)>
                                    <option value="3" @selected($item->role == 3)>Admin</option>
                                    <option value="2" @selected($item->role == 2)>Trabajador con permisos</option>
                                    <option value="1" @selected($item->role == 1)>Trabajador</option>
                                    <option value="0" @selected($item->role == 0)>Cliente</option>
                                </select>
                                <button wire:click="saveUser({{ $item->id }})"
                                    class="text-sm bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded transition">
                                    <i class="fas fa-save mr-2"></i>Guardar
                                </button>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>

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
