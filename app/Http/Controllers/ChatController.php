<?php

namespace App\Http\Controllers;

use App\Models\Chat;
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
}
