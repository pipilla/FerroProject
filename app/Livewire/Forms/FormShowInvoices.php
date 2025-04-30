<?php

namespace App\Livewire\Forms;

use App\Models\Invoice;
use Livewire\Attributes\Validate;
use Livewire\Form;

class FormShowInvoices extends Form
{
    public ?Invoice $invoice = null;
    public array $concepts = [];
    public array $taxes = [];
    public float $subtotal = 0;
    public float $total = 0;

    public function setInvoice(Invoice $invoice)
    {
        $this->invoice = $invoice;
        foreach ($invoice->concepts as $concept) {
            $this->concepts[] = $concept;

            $taxFound = false;

            // Al poner &, me quedo con la referencia real del array, no con la copia de los valores
            foreach ($this->taxes as &$tax) { 
                if ($tax['id'] == $concept->tax_id) {
                    $tax['price'] += ($concept->price * $concept->quantity) * ($concept->tax->value / 100);
                    $taxFound = true;
                    break;
                }
            }

            if (!$taxFound) {
                $this->taxes[] = [
                    'id' => $concept->tax_id,
                    'name' => $concept->tax->name,
                    'value' => $concept->tax->value,
                    'price' => ($concept->price * $concept->quantity) * ($concept->tax->value / 100),
                ];
            }

            $this->subtotal += ($concept->price * $concept->quantity);
            $this->total += ($concept->price * $concept->quantity) * ($concept->tax->value / 100);
        }
        $this->total += $this->subtotal;
    }

    public function resetForm()
    {
        $this->reset();
    }
}
