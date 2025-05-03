<?php

namespace App\Livewire;

use App\Events\MessageSent;
use App\Models\Chat;
use App\Models\Message;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;

class ShowChat extends Component
{
    public ?Chat $selectedChat = null;
    public $messages = [];
    public string $content = "";

    public function render()
    {
        $chats = Chat::with(['users', 'latestMessage'])
            ->whereHas('users', function ($query) {
                $query->where('users.id', Auth::id());
            })
            ->get()
            ->sortByDesc(fn($chat) => optional($chat->latestMessage)->created_at);
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
