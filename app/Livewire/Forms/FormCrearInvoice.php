<?php

namespace App\Livewire\Forms;

use App\Models\Invoice;
use Carbon\Carbon;
use Livewire\Attributes\Validate;
use Livewire\Form;

class FormCrearInvoice extends Form
{
    public string $from = "";
    public string $to = "";
    public string $date = "";
    public float $subtotal = 0;
    public float $total = 0;
    public string $details = "";
    public ?Invoice $invoice = null;

    public function createInvoice(){
        $this->invoice = Invoice::Create([
            'from' => "borrador",
            'to' => "borrador",
            'date' => Carbon::now(),
            'details' => "",
        ]);
    }

    public function storeInvoice() {

    }

    public function formReset(){
        $this->resetValidation();
        $this->reset();
    }
}
