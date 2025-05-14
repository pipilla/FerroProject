<?php

namespace App\Livewire;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class CrudUsers extends Component
{
    public bool $openModal = false;
    public int $userToEdit = 0;

    public function render()
    {
        $users = User::orderBy('role', 'desc')->orderBy('updatedAt', 'desc')->get();
        return view('livewire.crud-users', compact('users'));
    }

    public function editUser(int $id)
    {
        $user = User::findOrFail($id);
        /* $this->authorize('update', [Auth::id(), $user]); */
        if ($id != $this->userToEdit) {
            $this->userToEdit = $id;
        } else {
            $this->userToEdit = 0;
        }
    }

    public function cancelar()
    {
        $this->reset();
    }
}
