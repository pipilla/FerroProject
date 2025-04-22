<?php

namespace App\Livewire\Forms;

use App\Models\Task;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Validate;
use Livewire\Attributes\Rule;
use Livewire\Form;

class FormCrearTask extends Form
{
    #[Rule(['required', 'string', 'min:4', 'max:50'])]
    public string $title = "";

    #[Rule(['required', 'string', 'min:4', 'max:250'])]
    public string $description = "";

    #[Rule(['required', 'integer', 'min:0', 'max:5'])]
    public int $priority = 0;

    public function storeTask(){
        $this->validate();

        Task::create([
            'title' => $this->title,
            'description' => $this->description,
            'priority' => $this->priority,
            'user_id' => Auth::id(),
        ]);
    }

    public function formReset(){
        $this->reset();
        $this->resetValidation();
    }
}
