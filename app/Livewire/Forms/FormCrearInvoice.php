<?php

namespace App\Livewire\Forms;

use App\Models\Invoice;
use Carbon\Carbon;
use Illuminate\Validation\Rules\Date;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Validate;
use Livewire\Form;

class FormCrearInvoice extends Form
{
    #[Rule(['required', 'string', 'min:4', 'max:70'])]
    public string $from = "";

    #[Rule(['required', 'string', 'min:4', 'max:70'])]
    public string $to = "";

    #[Rule(['required', 'date'])]
    public string $date = "";

    #[Rule(['string', 'min:0', 'max:255'])]
    public string $details = "";

    public float $subtotal = 0;
    public float $total = 0;

    public ?Invoice $invoice = null;

    public function createInvoice(){
        $this->invoice = Invoice::Create([
            'from' => "borrador",
            'to' => "borrador",
            'date' => Carbon::now()->format('Y-m-d'),
            'details' => "",
        ]);
    }

    public function updateInvoice() {
        $this->validate();

        $this->invoice->update([
            'from' => $this->from,
            'to' => $this->to,
            'date' =>$this->date,
            'details' => $this->details,
        ]);
    }

    public function formReset(){
        $this->resetValidation();
        $this->reset();
    }
}
