<?php

namespace App\Livewire\Forms;

use App\Models\Concept;
use App\Models\Invoice;
use App\Models\Tax;
use Exception;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Validate;
use Livewire\Form;

class FormCrearConcept extends Form
{
    #[Rule(['required', 'string', 'min:4', 'max:70'])]
    public string $description = "";

    #[Rule(['required', 'decimal:0,2', 'min:0', 'max:99999'])]
    public float $price = 0;

    #[Rule(['required', 'int', 'min:0', 'max:999'])]
    public int $quantity = 0;

    #[Rule(['required', 'integer', 'exists:taxes,id'])]
    public int $tax_id = 1;

    public function storeConcept(int $id) {
        Invoice::findOrFail($id);

        $this->validate();

        Concept::create([
            'description' => $this->description,
            'price' => $this->price,
            'quantity' => $this->quantity,
            'tax_id' => $this->tax_id,
            'invoice_id' => $id,
        ]);

        $this->formReset();
    }

    public function formReset()
    {
        $this->resetValidation();
        $this->reset();
    }
}
