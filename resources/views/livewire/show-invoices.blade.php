<x-self.base>

    <h1 class="mb-6 text-3xl text-center font-extrabold text-gray-900 dark:text-white md:text-5xl lg:text-6xl"><span
            class="text-transparent bg-clip-text bg-gradient-to-r to-blue-600 from-sky-400">Facturas</span></h1>

    <div class="grid w-full gap-6 md:grid-cols-3">
        @foreach ($invoices as $item)
            <div wire:click="show({{ $item->id }})"
                class="items-center w-full text-black p-5 border-2 border-gray-200 rounded-lg cursor-pointer dark:border-gray-700 peer-checked:border-blue-600 dark:peer-checked:border-blue-600 hover:scale-105 transition-transform duration-200">
                <div class="inline-flex justify-between w-full mb-2">
                    <h1 class="text-xl font-bold">{{ $item->to }}</h1>
                    <h3>{{ $item->date }}</h3>
                </div>
                <h3 class="text-center inline-flex">Precio:<p class="font-bold ml-2">{{ $item->total }} €</p>
                </h3>
            </div>
        @endforeach
    </div>

    <div class="mt-2">
        {{ $invoices->links() }}
    </div>

    @if ($invoice != null)
        <div>
            <x-dialog-modal maxWidth="5xl" wire:model="openShow">
                <x-slot name="title">
                    Factura Nº: {{ $invoice->id }}
                </x-slot>
                <x-slot name="content">
                    <div>
                        <div class="inline-flex justify-between w-full mb-2">
                            <h1 class="inline-flex">De: <p class="text-xl font-bold ml-2">{{ $invoice->from }}</p>
                            </h1>
                            <h1 class="inline-flex">Fecha: <p class="text-xl font-bold ml-2">{{ $invoice->date }}</p>
                            </h1>
                        </div>
                        <h1 class="inline-flex">Para: <p class="text-xl font-bold ml-2">{{ $invoice->to }}</p>
                        </h1>
                    </div>
                    <div class="relative overflow-x-auto my-4">
                        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                            <thead
                                class="text-xs text-gray-700 uppercase bg-gray-100 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th scope="col" class="px-6 py-3 rounded-s-lg">
                                        Descripción
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Cantidad
                                    </th>
                                    <th scope="col" class="px-6 py-3 rounded-e-lg">
                                        Impuesto %
                                    </th>
                                    <th scope="col" class="px-6 py-3 rounded-e-lg">
                                        Precio sin impuestos
                                    </th>
                                    <th scope="col" class="px-6 py-3 rounded-e-lg">
                                        Precio
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($invoice->concepts as $concept)
                                    <tr class="bg-white dark:bg-gray-800">
                                        <th scope="row"
                                            class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                            {{ $concept->description }}
                                        </th>
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
                                            {{ number_format($concept->price + $concept->price * ($concept->tax->value / 100), 2) }}
                                            €
                                        </td>
                                    </tr>
                                @endforeach

                            </tbody>
                            <tfoot>
                                <tr class="font-semibold text-gray-900 dark:text-white">
                                    <th scope="row" class="px-6 py-3 text-base">Total</th>
                                    <td class="px-6 py-3">3</td>
                                    <td class="px-6 py-3">21,000</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </x-slot>
                <x-slot name="footer">
                    <div class="flex flex-row-reverse">
                        <button type="button" wire:click="cerrarShow"
                            class="bg-red-500 text-white font-bold p-3 rounded-lg hover:bg-red-600 transition duration-300">
                            <i class="fas fa-xmark mr-2"></i>Cerrar
                        </button>
                    </div>
                </x-slot>
            </x-dialog-modal>
        </div>
    @endif
</x-self.base>
