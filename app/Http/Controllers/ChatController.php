<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function chatList()
    {
        return response()->json(Auth::user()->chats);
    }

    public function user()
    {
        return response()->json(Auth::user());
    }

    public function getUsers()
    {
        return response()->json(User::where('id', '!=', Auth::id())->orderBy('name')->get());
    }

    public function storeChat(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);

        $userId = $request->input('user_id');
        $currentUser = Auth::user();

        $existingChat = $currentUser->chats
            ->whereHas('users', fn($q) => $q->where('user_id', $userId))
            ->first();

        if ($existingChat) {
            return response()->json($existingChat);
        }

        $chat = Chat::create([
            'is_group' => false,
        ]);

        $chat->users()->attach([$currentUser->id, $userId]);

        return response()->json($chat);
    }
}
