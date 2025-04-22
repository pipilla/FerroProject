<?php

namespace App\Livewire;

use App\Models\Task;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ShowTasks extends Component
{
    public bool $nuevaTarea = false;

    public function render()
    {
        $tasks = Task::where('user_id', Auth::id())
        ->orderBy('priority', 'desc')
        ->get();
        return view('livewire.show-tasks', compact('tasks'));
    }

    public function create(){
        $this->nuevaTarea = true;
    }
}
