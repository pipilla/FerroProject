<x-self.base>

    <h1 class="mb-6 text-3xl text-center font-extrabold text-gray-900 dark:text-white md:text-5xl lg:text-6xl"><span
            class="text-transparent bg-clip-text bg-gradient-to-r to-blue-600 from-sky-400">Facturas</span></h1>

            @livewire('crear-invoice')

    <div class="grid w-full gap-6 md:grid-cols-3">
        @foreach ($invoices as $item)
            <div wire:click="show({{ $item->id }})"
                class="items-center w-full text-black p-5 border-2 border-gray-200 rounded-lg cursor-pointer dark:border-gray-700 peer-checked:border-blue-600 dark:peer-checked:border-blue-600 hover:scale-105 transition-transform duration-200">
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
                                            {{ number_format(($concept->price * $concept->quantity) + ($concept->price * $concept->quantity) * ($concept->tax->value / 100), 2) }} €
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot class="bg-gray-50">
                                <tr class="font-semibold text-gray-900">
                                    <th scope="row" class="px-6 py-4 text-base text-right" colspan="4">Subtotal</th>
                                    <td class="px-6 py-4">{{ number_format($sform->subtotal, 2) }} €</td>
                                </tr>
                                @foreach ($sform->taxes as $tax)
                                    <tr class="font-semibold text-gray-900">
                                        <th scope="row" class="px-6 py-4 text-base text-right" colspan="4">{{ $tax['name'] }}</th>
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
                    @if ($sform->invoice->details != "")
                    <div>
                        <p class="text-left font-bold text-lg">Detalles:</p>
                        <p>{{$sform->invoice->details}}</p>
                    </div>
                    @endif
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
