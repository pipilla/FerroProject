<?php

namespace App\Livewire\Forms;

use App\Models\Invoice;
use Livewire\Attributes\Validate;
use Livewire\Form;

class FormShowInvoices extends Form
{
    public ?Invoice $invoice = null;
    public array 

    public function setInvoice(Invoice $invoice) {
        $this->invoice = $invoice;

    }
}
