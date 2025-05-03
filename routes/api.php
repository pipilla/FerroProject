<?php

use App\Http\Controllers\ChatController;
use App\Http\Controllers\MessageController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Message;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
