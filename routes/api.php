<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Message;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/messages', function () {
    return Message::latest()->take(50)->get()->reverse()->values();
});

Route::post('/messages', function (Request $request) {
    return Message::create([
        'content' => $request->input('content'),
    ]);
});