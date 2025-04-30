<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    public function index(int $id)
    {
        $chat = Chat::findOrFail($id);
        $this->authorizeChat($chat);

        return response()->json(Chat::with('messages.user')
            ->whereHas('users', fn($q) => $q->where('user_id', Auth::id())) // seguridad
            ->findOrFail($id)->messages);
    }

    public function store(Request $request)
    {
        $request->validate([
            'chat_id' => 'required|exists:chats,id',
            'content' => 'required|string',
        ]);

        $chat = Chat::findOrFail($request->chat_id);
        $this->authorizeChat($chat);

        $message = Message::create([
            'sender_id' => Auth::id(),
            'chat_id' => $chat->id,
            'content' => $request->content,
        ]);

        return response()->json($message->content);
    }

    protected function authorizeChat(Chat $chat)
    {
        if (!$chat->users->contains(Auth::id())) {
            abort(403, 'No perteneces a este chat');
        }
    }
}
