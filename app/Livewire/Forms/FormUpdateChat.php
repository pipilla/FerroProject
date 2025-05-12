<?php

namespace App\Livewire\Forms;

use App\Models\Chat;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Validate;
use Livewire\Form;

class FormUpdateChat extends Form
{
    public ?Chat $chat = null;

    public $users = [];

    #[Rule(['required'])]
    public $groupUsers = [];

    #[Rule(['required', 'string', 'min:3', 'max:50'])]
    public string $groupName = "";

    public function setChat(int $id)
    {
        $this->chat = Chat::findOrFail($id);
        $users = User::where('id', '!=', Auth::id())->where('role', '>', 0)->get();
        $this->users = $users;
        $this->groupUsers = $this->chat->users->pluck('id')->toArray();
        $this->groupName = $this->chat->name;
    }

    public function updateChat()
    {
        $this->validate();

        $this->chat->update([
            'name' => $this->groupName,
            'is_group' => true,
        ]);

        $this->chat->users()->sync(
            User::findMany($this->groupUsers)
        );

        $this->reset();
        $this->resetValidation();
    }
}
