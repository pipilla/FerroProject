<?php

namespace App\Livewire;

use App\Livewire\Forms\FormCrearTask;
use App\Livewire\Forms\FormUpdateTask;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;

class ShowTasks extends Component
{
    public bool $nuevaTarea = false;
    public FormCrearTask $cform;
    public FormUpdateTask $uform;

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
        $task = Task::findOrFail($id);
        $this->authorize('update', $task);
        $task->update(['done' => (!$task->done)]);
    }

    public function edit(int $id)
    {
        $task = Task::findOrFail($id);
        $this->authorize('update', $task);
        $this->uform->setTask($task);
    }
    
    public function update(int $id)
    {
        $task = Task::findOrFail($id);
        $this->authorize('update', $task);
        $this->uform->updateTask();
        $this->uform->formReset();
    }


    public function descartarUpdate()
    {
        $this->uform->formReset();
    }

    public function confirmarBorrar(int $id)
    {
        $task = Task::findOrFail($id);
        $this->authorize('delete', $task);
        $this->dispatch('confirmarBorrarTask', $id);
    }

    #[On('borrarOk')]
    public function borrar(int $id)
    {
        $task = Task::findOrFail($id);
        $this->authorize('delete', $task);
        $task->delete();
        $this->dispatch('mensaje', 'Tarea eliminada');
    }

}
