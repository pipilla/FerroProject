<?php

namespace App\Livewire\Forms;

use App\Models\Concept;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Validate;
use Livewire\Form;

class FormUpdateConcept extends Form
{
    public ?Concept $concept = null;

    #[Rule(['required', 'string', 'min:4', 'max:70'])]
    public string $description = "";

    #[Rule(['required', 'decimal:0,2', 'min:0', 'max:99999'])]
    public float $price = 0;

    #[Rule(['required', 'int', 'min:0', 'max:999'])]
    public int $quantity = 0;

    #[Rule(['required', 'integer', 'exists:taxes,id'])]
    public int $tax_id = 1;

    public function setConcept(int $id) {
        $this->concept = Concept::findOrFail($id);
        $this->description = $this->concept->description;
        $this->price = $this->concept->price;
        $this->quantity = $this->concept->quantity;
        $this->tax_id = $this->concept->tax_id;
    }

    public function updateConcept() {
        $this->validate();

        $this->concept->update([
            'description' => $this->description,
            'price' => $this->price,
            'quantity' => $this->quantity,
            'tax_id' => $this->tax_id,
        ]);

        $this->formReset();
    }

    public function formReset()
    {
        $this->resetValidation();
        $this->reset();
    }
}
