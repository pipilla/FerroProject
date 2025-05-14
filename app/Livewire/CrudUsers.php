<?php

namespace App\Livewire;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Attributes\Rule;
use Livewire\Component;

class CrudUsers extends Component
{
    public bool $openModal = false;
    public int $userToEdit = 0;

    #[Rule(['required', 'integer', 'min:0', 'max:3'])]
    public int $role = 0;

    #[On('usuarioEditado')]
    public function render()
    {
        $users = User::orderBy('role', 'desc')->orderBy('updatedAt', 'desc')->get();
        return view('livewire.crud-users', compact('users'));
    }

    public function editUser(int $id)
    {
        User::findOrFail($id);
        if (Auth::id() != $id) {
            if ($id != $this->userToEdit) {
                $this->userToEdit = $id;
            } else {
                $this->userToEdit = 0;
            }
        } else {
            abort(403, "No puedes editar el rol de tu usuario");
        }
    }

    public function saveUser(int $id)
    {
        $user = User::findOrFail($id);
        if (Auth::id() != $id) {
            if ($id == $this->userToEdit) {
                $this->validate();
                if ($user->role != $this->role) {
                    $user->update(['role' => $this->role]);
                    $this->resetValidation();
                    $this->dispatch('usuarioEditado');
                    $this->dispatch('mensaje', "Usuario editado");
                }
                $this->userToEdit = 0;
            } else {
                $this->userToEdit = 0;
            }
        } else {
            abort(403, "No puedes editar el rol de tu usuario");
        }
    }

    public function cancelar()
    {
        $this->reset();
    }

    public function cerrar()
    {
        $this->reset();
    }
}
