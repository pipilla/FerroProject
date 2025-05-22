<x-self.base>

    <h1 class="mb-6 text-3xl text-center font-extrabold text-gray-900 dark:text-white md:text-5xl lg:text-6xl"><span
            class="text-transparent bg-clip-text bg-gradient-to-r to-blue-600 from-sky-400">Facturas</span></h1>

    @livewire('crear-invoice')

    <div class="grid w-full gap-6 md:grid-cols-3">
        @foreach ($invoices as $item)
            <div wire:click="show({{ $item->id }})"
                class="items-center w-full text-black dark:text-white dark:bg-gray-800 hover:bg-gray-700 p-5 border-2 border-gray-200 rounded-lg cursor-pointer dark:border-gray-500 peer-checked:border-blue-600 dark:peer-checked:border-blue-600 hover:scale-105 transition-transform duration-200">
                <div class="inline-flex justify-between w-full mb-2">
                    <h1 class="text-xl font-bold">{{ $item->to }}</h1>
                    <h3>{{ $item->date }}</h3>
                </div>
            </div>
        @endforeach
    </div>

    <div class="mt-2">
        {{ $invoices->links() }}
    </div>

    @if ($openShow && $sform->invoice != null)
        <div>
            <x-dialog-modal maxWidth="5xl" wire:model="openShow">
                <x-slot name="title">
                    Factura Nº: {{ $sform->invoice->id }}
                </x-slot>
                <x-slot name="content">
                    <div>
                        <div class="inline-flex justify-between w-full mb-2">
                            <h1 class="inline-flex">De: <p class="text-xl font-bold ml-2">{{ $sform->invoice->from }}
                                </p>
                            </h1>
                            <h1 class="inline-flex">Fecha: <p class="text-xl font-bold ml-2">{{ $sform->invoice->date }}
                                </p>
                            </h1>
                        </div>
                        <h1 class="inline-flex">Para: <p class="text-xl font-bold ml-2">{{ $sform->invoice->to }}</p>
                        </h1>
                    </div>
                    <div class="relative overflow-x-auto my-8">
                        <table class="w-full text-sm text-left text-gray-700 border border-gray-300">
                            <thead class="text-xs uppercase bg-gray-100 text-gray-700">
                                <tr>
                                    <th scope="col" class="px-6 py-4 rounded-tl-lg border-b border-gray-300">
                                        Descripción
                                    </th>
                                    <th scope="col" class="px-6 py-4 border-b border-gray-300">
                                        Cantidad
                                    </th>
                                    <th scope="col" class="px-6 py-4 border-b border-gray-300">
                                        Impuesto %
                                    </th>
                                    <th scope="col" class="px-6 py-4 border-b border-gray-300">
                                        Precio unidad
                                    </th>
                                    <th scope="col" class="px-6 py-4 rounded-tr-lg border-b border-gray-300">
                                        Precio
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white">
                                @foreach ($sform->concepts as $concept)
                                    <tr class="border-b border-gray-200">
                                        <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                            {{ $concept->description }}
                                        </td>
                                        <td class="px-6 py-4">
                                            {{ $concept->quantity }}
                                        </td>
                                        <td class="px-6 py-4">
                                            {{ $concept->tax->value }}%
                                        </td>
                                        <td class="px-6 py-4">
                                            {{ number_format($concept->price, 2) }} €
                                        </td>
                                        <td class="px-6 py-4">
                                            {{ number_format($concept->price * $concept->quantity + $concept->price * $concept->quantity * ($concept->tax->value / 100), 2) }}
                                            €
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot class="bg-gray-50">
                                <tr class="font-semibold text-gray-900">
                                    <th scope="row" class="px-6 py-4 text-base text-right" colspan="4">Subtotal
                                    </th>
                                    <td class="px-6 py-4">{{ number_format($sform->subtotal, 2) }} €</td>
                                </tr>
                                @foreach ($sform->taxes as $tax)
                                    <tr class="font-semibold text-gray-900">
                                        <th scope="row" class="px-6 py-4 text-base text-right" colspan="4">
                                            {{ $tax['name'] }}</th>
                                        <td class="px-6 py-4">+ {{ number_format($tax['price'], 2) }} €</td>
                                    </tr>
                                @endforeach
                                <tr class="font-bold text-gray-900">
                                    <th scope="row" class="px-6 py-4 text-xl text-right" colspan="4">Total</th>
                                    <td class="px-6 py-4 text-xl">{{ number_format($sform->total, 2) }} €</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    @if ($sform->invoice->details != '')
                        <div>
                            <p class="text-left font-bold text-lg">Detalles:</p>
                            <p>{{ $sform->invoice->details }}</p>
                        </div>
                    @endif
                </x-slot>
                <x-slot name="footer">
                    <div class="flex justify-between w-full">
                        <div class="text-left">
                            <button type="button" wire:click="update"
                                class="bg-blue-500 text-white font-bold p-3 rounded-lg hover:bg-blue-600 transition duration-300">
                                <i class="fas fa-edit mr-2"></i>Editar
                            </button>
                            <button type="button" wire:click="confirmarBorrar({{ $sform->invoice->id }})"
                                class="bg-red-500 text-white font-bold p-3 rounded-lg hover:bg-red-600 transition duration-300">
                                <i class="fas fa-trash mr-2"></i>Borrar
                            </button>
                        </div>
                        <div class="flex flex-row-reverse">
                            <button type="button" wire:click="cerrarShow"
                                class="bg-gray-500 text-white font-bold p-3 rounded-lg hover:bg-gray-600 transition duration-300">
                                <i class="fas fa-xmark mr-2"></i>Cerrar
                            </button>
                            <a href="{{ route('factura.pdf', $sform->invoice->id) }}" target="_blank"
                                class="bg-green-500 text-white font-bold p-3 rounded-lg hover:bg-green-600 transition duration-300 mr-2">
                                <i class="fas fa-download mr-2"></i>Descargar PDF
                             </a>
                        </div>
                    </div>
                </x-slot>
            </x-dialog-modal>
        </div>
    @endif
    @if ($openEdit && $uform->invoice != null)
        <div>
            <x-dialog-modal maxWidth="5xl" wire:model="openEdit">
                <x-slot name="title">
                    Editar Factura Nº: {{ $uform->invoice->id }}
                </x-slot>
                <x-slot name="content">
                    <div>
                        <div class="inline-flex justify-between w-full mb-2">
                            <h1 class="inline-flex">De: <input type="text" class="text-xl font-bold ml-2 rounded-xl"
                                    placeholder="Nombre, dirección..." id="from" name="from"
                                    wire:model.live="uform.from" />
                                <x-input-error for="uform.from" />
                            </h1>
                            <h1 class="inline-flex">Fecha: <input type="date"
                                    class="text-xl font-bold ml-2 rounded-xl" id="date" name="date"
                                    wire:model.live="uform.date" />
                                <x-input-error for="uform.date" />
                            </h1>
                        </div>
                        <h1 class="inline-flex">Para: <input type="text" class="text-xl font-bold ml-2 rounded-xl"
                                placeholder="Nombre, dirección..." id="to" name="to"
                                wire:model.live="uform.to" />
                            <x-input-error for="uform.to" />
                        </h1>
                    </div>
                    <div class="relative overflow-x-auto my-8">
                        <table class="w-full text-sm text-left text-gray-700 border border-gray-300">
                            <thead class="text-xs uppercase bg-gray-100 text-gray-700">
                                <tr>
                                    <th scope="col" class="px-6 py-4 rounded-tl-lg border-b border-gray-300">
                                        Descripción
                                    </th>
                                    <th scope="col" class="px-6 py-4 border-b border-gray-300">
                                        Cantidad
                                    </th>
                                    <th scope="col" class="px-6 py-4 border-b border-gray-300">
                                        Impuesto %
                                    </th>
                                    <th scope="col" class="px-6 py-4 border-b border-gray-300">
                                        Precio unidad
                                    </th>
                                    <th scope="col" class="px-6 py-4 rounded-tr-lg border-b border-gray-300">
                                        Precio
                                    </th>
                                    <th scope="col" class="px-6 py-4 rounded-tr-lg border-b border-gray-300">
                                        Acciones
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white">
                                @if ($uform->invoice != null)
                                    @foreach ($uform->invoice->concepts as $concept)
                                        @if ($editarConcepto && $conceptUpdateForm->concept->id == $concept->id)
                                            <tr class="border-b border-gray-200">
                                                <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                                    <input type="text" placeholder="Concepto..." id="description"
                                                        name="description" class="rounded-xl w-full"
                                                        wire:model.live="conceptUpdateForm.description">
                                                    <x-input-error for="conceptUpdateForm.description" />
                                                </td>

                                                <td class="px-6 py-4">
                                                    <input type="number" placeholder="1" id="quantity"
                                                        name="quantity" class="rounded-xl w-16 text-center"
                                                        wire:model="conceptUpdateForm.quantity">
                                                    <x-input-error for="conceptUpdateForm.quantity" />
                                                </td>

                                                <td class="px-6 py-4">
                                                    <select name="tax_id" id="tax_id"
                                                        wire:model="conceptUpdateForm.tax_id"
                                                        class="rounded-xl w-full">
                                                        @foreach ($taxes as $item)
                                                            <option value="{{ $item->id }}">{{ $item->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    <x-input-error for="conceptUpdateForm.tax_id" />
                                                </td>

                                                <td class="px-6 py-4">
                                                    <input type="number" placeholder="1" id="price"
                                                        name="price" class="rounded-xl w-24 text-center"
                                                        wire:model="conceptUpdateForm.price"
                                                        wire:change="conceptUpdateForm.calcularTotal">
                                                    <x-input-error for="conceptUpdateForm.price" />
                                                </td>

                                                <td class="px-6 py-4">
                                                    <button
                                                        class="p-2 border-gray-500 border-2 bg-slate-200 rounded-lg hover:bg-slate-300 transition"
                                                        wire:click="cancelarUpdateConcepto">
                                                        Cancelar
                                                    </button>
                                                </td>

                                                <td class="px-6 py-4">
                                                    <button
                                                        class="p-2 ml-4 border-gray-500 border-2 bg-slate-200 rounded-lg hover:bg-slate-300 transition"
                                                        wire:click="editConcepto">
                                                        Guardar
                                                    </button>
                                                </td>

                                            </tr>
                                        @else
                                            <tr class="border-b border-gray-200">
                                                <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                                    {{ $concept->description }}
                                                </td>
                                                <td class="px-6 py-4">
                                                    {{ $concept->quantity }}
                                                </td>
                                                <td class="px-6 py-4">
                                                    {{ $concept->tax->value }}%
                                                </td>
                                                <td class="px-6 py-4">
                                                    {{ number_format($concept->price, 2) }} €
                                                </td>
                                                <td class="px-6 py-4">
                                                    {{ number_format($concept->price * $concept->quantity + $concept->price * $concept->quantity * ($concept->tax->value / 100), 2) }}
                                                    €
                                                </td>
                                                <td class="px-6 py-4">
                                                    <button wire:click="updateConcepto({{ $concept->id }})"><i
                                                            class="fas fa-edit"></i></button>
                                                    <button wire:click="borrarConcepto({{ $concept->id }})"><i
                                                            class="fas fa-trash mx-4"></i></button>
                                                </td>
                                            </tr>
                                        @endif
                                    @endforeach
                                @endif
                                @if ($crearConcepto)
                                    <tr class="border-b border-gray-200">
                                        <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                            <input type="text" placeholder="Concepto..." id="description"
                                                name="description" class="rounded-xl w-full"
                                                wire:model.live="conceptForm.description">
                                            <x-input-error for="conceptForm.description" />
                                        </td>

                                        <td class="px-6 py-4">
                                            <input type="number" placeholder="1" id="quantity" name="quantity"
                                                class="rounded-xl w-16 text-center" wire:model="conceptForm.quantity">
                                            <x-input-error for="conceptForm.quantity" />
                                        </td>

                                        <td class="px-6 py-4">
                                            <select name="tax_id" id="tax_id" wire:model="conceptForm.tax_id"
                                                class="rounded-xl w-full">
                                                @foreach ($taxes as $item)
                                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                                @endforeach
                                            </select>
                                            <x-input-error for="conceptForm.tax_id" />
                                        </td>

                                        <td class="px-6 py-4" colspan="3">
                                            <input type="number" placeholder="1" id="price" name="price"
                                                class="rounded-xl w-24 text-center" wire:model="conceptForm.price"
                                                wire:change="conceptForm.calcularTotal">
                                            <x-input-error for="conceptForm.price" />
                                        </td>
                                    </tr>

                                    <tr class="border-b border-gray-200">
                                        <td class="px-6 py-4 text-center" colspan="6">
                                            <button
                                                class="p-2 border-gray-500 border-2 bg-slate-200 rounded-lg hover:bg-slate-300 transition"
                                                wire:click="cancelarConcepto">
                                                Cancelar
                                            </button>

                                            <button
                                                class="p-2 ml-4 border-gray-500 border-2 bg-slate-200 rounded-lg hover:bg-slate-300 transition"
                                                wire:click="guardarConcepto({{ $uform->invoice->id }})">
                                                Guardar
                                            </button>
                                        </td>
                                    </tr>
                                @else
                                    <tr class="border-b border-gray-200">
                                        <td class="px-6 py-4 text-center" colspan=6>
                                            <button class="p-2 border-gray-500 border-2 bg-slate-200 rounded-lg"
                                                wire:click="set('crearConcepto', true)">Añadir
                                                Concepto</button>
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                            <tfoot class="bg-gray-50">
                                @if ($sform->invoice != null)
                                    <tr class="font-semibold text-gray-900">
                                        <th scope="row" class="px-6 py-4 text-base text-right" colspan="5">
                                            Subtotal
                                        </th>
                                        <td class="px-6 py-4">{{ number_format($sform->subtotal, 2) }} €</td>
                                    </tr>
                                    @foreach ($sform->taxes as $tax)
                                        <tr class="font-semibold text-gray-900">
                                            <th scope="row" class="px-6 py-4 text-base text-right" colspan="5">
                                                {{ $tax['name'] }}</th>
                                            <td class="px-6 py-4">+ {{ number_format($tax['price'], 2) }} €</td>
                                        </tr>
                                    @endforeach
                                    <tr class="font-bold text-gray-900">
                                        <th scope="row" class="px-6 py-4 text-xl text-right" colspan="5">Total
                                        </th>
                                        <td class="px-6 py-4 text-xl">{{ number_format($sform->total, 2) }} €</td>
                                    </tr>
                                @endif
                            </tfoot>
                        </table>
                    </div>

                    <div>
                        <p class="text-left font-bold text-lg">Detalles:</p>
                        <textarea placeholder="Detalles de la factura..." class="w-full rounded-xl" id="details" name="details"
                            wire:model="uform.details"></textarea>
                        <x-input-error for="uform.details" />
                    </div>

                </x-slot>
                <x-slot name="footer">
                    <div class="flex flex-row-reverse gap-2">
                        <button type="button" wire:click="edit"
                            class="bg-green-500 text-white font-bold p-3 rounded-lg hover:bg-green-600 transition duration-300">
                            <i class="fas fa-save mr-2"></i>Guardar
                        </button>
                        <button type="button" wire:click="cerrarEdit"
                            class="bg-red-500 text-white font-bold p-3 rounded-lg hover:bg-red-600 transition duration-300">
                            <i class="fas fa-xmark mr-2"></i>Cerrar
                        </button>
                    </div>
                </x-slot>
            </x-dialog-modal>
        </div>
    @endif
</x-self.base>
