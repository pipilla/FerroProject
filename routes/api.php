<?php

use App\Http\Controllers\ChatController;
use App\Http\Controllers\MessageController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Message;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/chatList', [ChatController::class, 'chatList']);
Route::get('/user', [ChatController::class, 'user']);
Route::get('/users', [ChatController::class, 'getUsers']);

Route::post('/chats', [MessageController::class, 'storeChat']);
Route::get('/messages/{chat}', [MessageController::class, 'index']);
Route::post('/messages', [MessageController::class, 'store']);