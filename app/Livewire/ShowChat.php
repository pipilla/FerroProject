<?php

namespace App\Livewire;

use App\Events\MessageSent;
use App\Models\Chat;
use App\Models\Message;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Attributes\Rule;
use Livewire\Component;

class ShowChat extends Component
{
    public ?Chat $selectedChat = null;
    public $messages = [];

    /* #[Rule('required', 'string', 'min:1', 'max:2000')] */
    public string $content = "";

    #[On('chatCreado')]
    public function render(?int $id = null)
    {
        $chats = Chat::with(['users', 'latestMessage'])
            ->whereHas('users', function ($query) {
                $query->where('users.id', Auth::id());
            })
            ->get()
            ->sortByDesc(fn($chat) => optional($chat->latestMessage)->created_at);

        if ($id != null) {
            $this->seleccionarChat($id);
        }

        return view('livewire.show-chat', compact('chats'));
    }

    public function seleccionarChat(int $id)
    {
        $chat = Chat::findOrFail($id);
        $this->selectedChat = $chat;

        $this->messages = $chat->messages()->get() ?? [];
        $this->dispatch('scrollToBottom');
    }

    public function updateMessages()
    {
        $this->messages = $this->selectedChat->messages()->get() ?? [];
    }

    public function sendMessage()
    {
        if (trim($this->content) === '') {
            return; // No hacer nada si está vacío o solo contiene espacios
        }

        Message::create([
            'sender_id' => Auth::id(),
            'chat_id' => $this->selectedChat->id,
            'content' => $this->content,
        ]);

        $this->reset('content');
        $this->updateMessages();
        $this->dispatch('scrollToBottom');
    }
}
