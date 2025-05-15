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

    public function blockUser(int $id)
    {
        User::findOrFail($id);
        if (Auth::id() != $id) {
            $this->dispatch('confirmarBloquearUser', $id);
        } else {
            abort(403, "No puedes bloquear tu propio usuario");
        }
    }

    #[On('bloquearUserOk')]
    public function bloquearOk(int $id)
    {
        $user = User::findOrFail($id);
        if (Auth::id() != $id) {
            if ($user->active) {
                $user->update(['active' => false]);
                $this->dispatch('mensaje', 'Usuario bloqueado correctamente');
            } else {
                abort(403, "El usuario ya está bloqueado");
            }
        } else {
            abort(403, "No puedes bloquear tu propio usuario");
        }
    }

    public function desbloquearUsuario(int $id)
    {
        $user = User::findOrFail($id);
        if (Auth::id() != $id && !$user->active) {
            if (!$user->active) {
                $user->update(['active' => true]);
                $this->dispatch('mensaje', 'Usuario desbloqueado correctamente');
            } else {
                abort(403, "El usuario no está bloqueado");
            }
        } else {
            abort(403, "No puedes desbloquear tu propio usuario");
        }
    }

    public function cancelar()
    {
        $this->reset('userToEdit');
    }

    public function cerrar()
    {
        $this->reset();
    }
}
