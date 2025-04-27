<div>
    <div class="text-center items-center my-4"><button wire:click="createInvoice"
            class="relative inline-flex items-center justify-center p-1 mb-2 me-2 overflow-hidden text-sm font-medium text-gray-900 rounded-2xl group bg-gradient-to-br to-blue-600 from-sky-400 group-hover:from-green-400 group-hover:to-blue-600 hover:text-white dark:text-white focus:ring-4 focus:outline-none focus:ring-blue-200 dark:focus:ring-blue-800 hover:scale-105 transition-transform duration-200">
            <span
                class="relative px-5 py-2.5 transition-all ease-in duration-75 bg-white dark:bg-gray-900 rounded-xl group-hover:bg-transparent group-hover:dark:bg-transparent">
                <i class="fas fa-plus"></i> Nueva Tarea
            </span>
        </button>
    </div>
    <x-dialog-modal maxWidth="5xl" closeOnClickOutside="false" wire:model="openCrear">
        <x-slot name="title">
            Nueva Factura
        </x-slot>
        <x-slot name="content">
            <div>
                <div class="inline-flex justify-between w-full mb-2">
                    <h1 class="inline-flex">De: <input type="text" class="text-xl font-bold ml-2" />
                    </h1>
                    <h1 class="inline-flex">Fecha: <input class="text-xl font-bold ml-2" />
                    </h1>
                </div>
                <h1 class="inline-flex">Para: <input type="text" class="text-xl font-bold ml-2" />
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
                        {{-- @foreach ($cform->concepts as $concept)
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
                        @endforeach --}}
                        @if ($crearConcepto)
                            <tr class="border-b border-gray-200">
                                <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                    <input type="text" placeholder="Concepto..." id="description" name="description"
                                        wire:model.live="conceptForm.description">
                                    <x-input-error for="conceptForm.description" />
                                </td>
                                <td class="px-6 py-4">
                                    <input type="number" placeholder="1" id="quantity" name="quantity"
                                        wire:model="conceptForm.quantity">
                                    <x-input-error for="conceptForm.quantity" />
                                </td>
                                <td class="px-6 py-4">
                                    <select name="tax_id" id="tax_id" wire:model="conceptForm.tax_id">
                                        @foreach ($taxes as $item)
                                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                    <x-input-error for="conceptForm.tax_id" />
                                </td>
                                <td class="px-6 py-4">
                                    <input type="number" placeholder="1" value="0" id="price" name="price"
                                        wire:model="conceptForm.price"> €
                                    <x-input-error for="conceptForm.price" />
                                </td>
                                <td class="px-6 py-4">
                                    {{ $conceptForm->total }} €
                                </td>
                            </tr>
                            <tr class="border-b border-gray-200">
                                <td class="px-6 py-4 text-center" colspan=5>
                                    <button class="p-2 border-gray-500 border-2 bg-slate-200 rounded-lg"
                                        wire:click="conceptForm.storeConcept('{{ $cform->invoice }}')">Guardar</button>
                                </td>
                            </tr>
                        @else
                            <tr class="border-b border-gray-200">
                                <td class="px-6 py-4 text-center" colspan=5>
                                    <button class="p-2 border-gray-500 border-2 bg-slate-200 rounded-lg"
                                        wire:click="set('crearConcepto', true)">Añadir
                                        Concepto</button>
                                </td>
                            </tr>
                        @endif
                    </tbody>
                    <tfoot class="bg-gray-50">
                        {{-- <tr class="font-semibold text-gray-900">
                            <th scope="row" class="px-6 py-4 text-base text-right" colspan="4">Subtotal</th>
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
                        </tr> --}}
                    </tfoot>
                </table>
            </div>
            {{-- @if ($sform->invoice->details != '')
                <div>
                    <p class="text-left font-bold text-lg">Detalles:</p>
                    <p>{{ $sform->invoice->details }}</p>
                </div>
            @endif --}}
        </x-slot>
        <x-slot name="footer">
            <div class="flex flex-row-reverse">
                <button type="button" wire:click="cancelar"
                    class="bg-red-500 text-white font-bold p-3 rounded-lg hover:bg-red-600 transition duration-300">
                    <i class="fas fa-xmark mr-2"></i>Cerrar
                </button>
            </div>
        </x-slot>
    </x-dialog-modal>
</div>
