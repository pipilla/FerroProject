<x-self.base>

    <h1 class="mb-4 text-3xl text-center font-extrabold text-gray-900 dark:text-white md:text-5xl lg:text-6xl"><span
            class="text-transparent bg-clip-text bg-gradient-to-r to-blue-600 from-sky-400">Formulario de Contacto</span>
    </h1>

    <div class="max-w-xl mx-auto p-6 bg-white shadow-md rounded-xl space-y-4">
        <!-- Tipo de Consulta -->
        <div>
            <label class="block font-semibold mb-1"><i class="fas fa-question-circle mr-1"></i>Tipo de consulta</label>
            <select wire:model.live="tipoConsulta" class="w-full border rounded px-3 py-2">
                <option value="">Selecciona una opción</option>
                <option>Encargo de trabajo</option>
                <option>Consulta</option>
            </select>
            <x-input-error for="tipoConsulta" />
        </div>

        @if ($tipoConsulta === 'Encargo de trabajo')
            <!-- Tipo de trabajo -->
            <div>
                <label class="block font-semibold mb-1"><i class="fas fa-tools mr-1"></i>Tipo de trabajo</label>
                <select wire:model.live="tipoTrabajo" class="w-full border rounded px-3 py-2">
                    <option value="">Selecciona tipo de trabajo</option>
                    <option value="Puertas">Puertas</option>
                    <option value="Rejas">Rejas</option>
                    <option value="Ventanas">Ventanas</option>
                    <option value="Tejados">Tejados</option>
                    <option value="Otros">Otros</option>
                </select>
                <x-input-error for="tipoTrabajo" />
            </div>

            @if ($tipoTrabajo == 'Otros')
                <!-- Otro trabajo -->
                <div>
                    <label class="block font-semibold mb-1"><i class="fas fa-edit mr-1"></i>Describe el trabajo</label>
                    <input type="text" wire:model="otroTrabajo" class="w-full border rounded px-3 py-2"
                        placeholder="Especifica el trabajo">
                    <x-input-error for="otroTrabajo" />
                </div>
            @endif

            <!-- Nombre y Apellidos -->
            <div>
                <label class="block font-semibold mb-1"><i class="fas fa-user mr-1"></i>Nombre y Apellidos</label>
                <input type="text" wire:model="nombre" class="w-full border rounded px-3 py-2"
                    placeholder="Tu nombre completo">
                <x-input-error for="nombre" />
            </div>

            <!-- Dirección -->
            <div>
                <label class="block font-semibold mb-1"><i class="fas fa-map-marker-alt mr-1"></i>Dirección</label>
                <input type="text" wire:model="direccion" class="w-full border rounded px-3 py-2"
                    placeholder="Dirección completa">
                <x-input-error for="direccion" />
            </div>

            <!-- Teléfono -->
            <div>
                <label class="block font-semibold mb-1"><i class="fas fa-phone mr-1"></i>Teléfono</label>
                <input type="text" wire:model="telefono" class="w-full border rounded px-3 py-2"
                    placeholder="Número de contacto">
                <x-input-error for="telefono" />
            </div>

            <!-- Email -->
            <div>
                <label class="block font-semibold mb-1"><i class="fas fa-envelope mr-1"></i>Email</label>
                <input type="email" wire:model="email" class="w-full border rounded px-3 py-2"
                    placeholder="correo@ejemplo.com">
                <x-input-error for="email" />
            </div>
        @elseif ($tipoConsulta == 'Consulta')
            <!-- Nombre -->
            <div>
                <label class="block font-semibold mb-1"><i class="fas fa-user mr-1"></i>Nombre y Apellidos</label>
                <input type="text" wire:model="nombre" class="w-full border rounded px-3 py-2"
                    placeholder="Tu nombre completo">
                <x-input-error for="nombre" />
            </div>

            <!-- Mensaje -->
            <div>
                <label class="block font-semibold mb-1"><i class="fas fa-comment mr-1"></i>Mensaje</label>
                <textarea wire:model="mensaje" rows="4" class="w-full border rounded px-3 py-2"
                    placeholder="Tu mensaje o consulta"></textarea>
                <x-input-error for="mensaje" />
            </div>

            <!-- Email -->
            <div>
                <label class="block font-semibold mb-1"><i class="fas fa-envelope mr-1"></i>Email</label>
                <input type="email" wire:model="email" class="w-full border rounded px-3 py-2"
                    placeholder="correo@ejemplo.com">
                <x-input-error for="email" />
            </div>
        @endif

        <!-- Submit -->
        <div>
            <button wire:click="send" class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700 transition">
                <i class="fas fa-paper-plane mr-1"></i>Enviar
            </button>
        </div>
    </div>
</x-self.base>
