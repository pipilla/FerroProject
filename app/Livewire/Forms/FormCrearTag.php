<?php

namespace App\Livewire\Forms;

use App\Models\Tag;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Validate;
use Livewire\Form;

class FormCrearTag extends Form
{
    #[Rule('required', 'string', 'min:3', 'max:20')]
    public string $name = "";

    public function store(){
        $this->validate();
        Tag::create([
            'name' => $this->name,
        ]);
        $this->formReset();
    }

    public function formReset(){
        $this->reset();
        $this->resetValidation();
    }
}
