<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    public function index(Chat $chat)
    {
        $this->authorizeChat($chat);

        return $chat->messages()->with('sender')->latest()->take(50)->get()->reverse()->values();
    }

    public function store(Request $request)
    {
        $request->validate([
            'chat_id' => 'required|exists:chats,id',
            'content' => 'required|string',
        ]);

        $chat = Chat::findOrFail($request->chat_id);
        $this->authorizeChat($chat);

        $message = $chat->messages()->create([
            'sender_id' => Auth::id(),
            'content' => $request->content,
        ]);

        return $message->load('sender');
    }

    protected function authorizeChat(Chat $chat)
    {
        if (!$chat->users->contains(Auth::id())) {
            abort(403, 'No perteneces a este chat');
        }
    }
}
