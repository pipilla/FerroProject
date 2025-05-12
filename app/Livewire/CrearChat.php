<?php

namespace App\Livewire;

use App\Livewire\Forms\FormCrearChat;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class CrearChat extends Component
{
    public bool $openCrear = false;

    public $users = [];
    public $allUsers = [];

    public bool $isGroup = false;

    public FormCrearChat $cform;

    public function render()
    {
        $allUsers = User::where('id', '!=', Auth::id())->where('role', '>', 0)->get();
        $this->allUsers = $allUsers;
        $existingChats = Auth::user()->chats()->where('is_group', false)->get();
        // Filtrar usuarios que ya estén en un chat no grupal
        $blockedUserIds = $existingChats->flatMap(function ($chat) {
            return $chat->users->where('id', '!=', Auth::id())->pluck('id');
        })->toArray();

        // Filtrar los usuarios excluyendo a los bloqueados
        $this->users = $allUsers->whereNotIn('id', $blockedUserIds)->all();

        return view('livewire.crear-chat');
    }

    public function createGroup()
    {
        $this->isGroup = true;
    }

    public function createChat(int $id)
    {
        $this->cform->setUsers($this->users);
        $user = User::findOrFail($id);
        if (!$this->isGroup && in_array($user, $this->users)) {
            $chatId = $this->cform->storeChat($id);
            $this->dispatch('chatCreado', $chatId)->to(ShowChat::class);
            $this->dispatch('mensaje', 'Chat creado');
        }
        $this->reset();
    }

    public function createChatGroup()
    {
        $this->cform->setUsers($this->users);
        if ($this->isGroup) {
            $chatId = $this->cform->storeChatGroup();
            $this->dispatch('chatCreado', $chatId)->to(ShowChat::class);
            $this->dispatch('mensaje', 'Chat creado');
        }
        $this->reset();
    }

    public function cancelar()
    {
        $this->openCrear = false;
        $this->reset();
    }
}
