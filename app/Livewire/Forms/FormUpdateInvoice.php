<?php

namespace App\Livewire\Forms;

use App\Models\Invoice;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Validate;
use Livewire\Form;

class FormUpdateInvoice extends Form
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

    public function setInvoice(Invoice $invoice){
        $this->invoice = $invoice;
        $this->from = $invoice->from;
        $this->to = $invoice->to;
        $this->date = $invoice->date;
        $this->details = $invoice->details;
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
