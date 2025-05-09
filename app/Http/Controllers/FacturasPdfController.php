<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class FacturasPdfController extends Controller
{
    public function download(Invoice $invoice)
    {
        $concepts = [];
        $taxes = [];
        $subtotal = 0;
        $total = 0;

        foreach ($invoice->concepts as $concept) {
            $concepts[] = $concept;

            $taxFound = false;

            // Al poner &, me quedo con la referencia real del array, no con la copia de los valores
            foreach ($taxes as &$tax) { 
                if ($tax['id'] == $concept->tax_id) {
                    $tax['price'] += ($concept->price * $concept->quantity) * ($concept->tax->value / 100);
                    $taxFound = true;
                    break;
                }
            }

            if (!$taxFound) {
                $taxes[] = [
                    'id' => $concept->tax_id,
                    'name' => $concept->tax->name,
                    'value' => $concept->tax->value,
                    'price' => ($concept->price * $concept->quantity) * ($concept->tax->value / 100),
                ];
            }

            $subtotal += ($concept->price * $concept->quantity);
            $total += ($concept->price * $concept->quantity) * ($concept->tax->value / 100);
        }
        $total += $subtotal;


        $pdf = Pdf::loadView('pdf.facturas', compact('invoice', 'concepts', 'taxes', 'subtotal', 'total'));
        return $pdf->stream('factura_' . $invoice->id . '.pdf');
    }
}
