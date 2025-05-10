<?php

namespace App\Livewire\Forms;

use App\Models\Chat;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Validate;
use Livewire\Form;

class FormCrearChat extends Form
{
    public array $users = [];

    #[Rule(['required'])]
    public $selectedUsers = [];

    #[Rule(['required', 'string', 'min:3', 'max:50'])]
    public string $groupName = "";

    public function setUsers($users) {
        $this->users = $users;
    }

    public function storeChatGroup() {
        $this->validate();

        $chat = Chat::create([
            'name' =>$this->groupName,
            'is_group' => true,
        ]);

        $chat->users()->attach(array_merge($this->selectedUsers, [Auth::id()]));

        $this->reset();
        $this->resetValidation();

        return $chat->id;
    }
    
    public function storeChat(int $id) {
        $user = User::findOrFail($id);

        $chat = Chat::create();

        $chat->users()->attach(Auth::id());
        $chat->users()->attach($user->id);

        $this->reset();
        $this->resetValidation();

        return $chat->id;
    }

}
