<?php

namespace App\Livewire;

use App\Livewire\Forms\FormCrearTask;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ShowTasks extends Component
{
    public bool $nuevaTarea = false;
    public FormCrearTask $cform;

    public bool $showEdit = false;

    public function render()
    {
        $tasks = Task::where('user_id', Auth::id())
            ->orderBy('priority', 'desc')
            ->get();
        return view('livewire.show-tasks', compact('tasks'));
    }

    public function create()
    {
        $this->cform->storeTask();
        $this->descartar();
    }

    public function descartar()
    {
        $this->nuevaTarea = false;
        $this->cform->formReset();
    }

    public function ocultar(int $id) {
        
    }
}
