<?php

namespace App\Livewire\Forms;

use App\Models\Task;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Validate;
use Livewire\Form;

class FormUpdateTask extends Form
{
    public ?Task $task = null;
    
    #[Rule(['required', 'string', 'min:4', 'max:50'])]
    public string $title = "";

    #[Rule(['required', 'string', 'min:4', 'max:250'])]
    public string $description = "";

    #[Rule(['required', 'integer', 'min:0', 'max:5'])]
    public int $priority = 0;

    public function setTask(Task $task){
        $this->task = $task;
        $this->title = $task->title;
        $this->description = $task->description;
        $this->priority = $task->priority;
    }

    public function updateTask()
    {
        $this->validate();

        $this->task->update([
            'title' => $this->title,
            'description' => $this->description,
            'priority' => $this->priority,
        ]);
    }

    public function formReset()
    {
        $this->reset();
        $this->resetValidation();
    }
}
