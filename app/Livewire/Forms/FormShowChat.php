<?php

namespace App\Livewire\Forms;

use App\Models\Chat;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Validate;
use Livewire\Form;

class FormShowChat extends Form
{
    public ?Chat $chat = null;

    public $users = [];

    public function setChat(int $id)
    {
        $this->chat = Chat::findOrFail($id);
        $this->users = $this->chat->users->pluck('id')->toArray();
    }
}
