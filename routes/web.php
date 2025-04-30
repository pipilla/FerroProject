<?php

use App\Livewire\ShowInvoices;
use App\Livewire\ShowMedia;
use App\Livewire\ShowTasks;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
    Route::get('/tareas', ShowTasks::class)->name('tareas');
    Route::get('/facturas', ShowInvoices::class)->name('facturas');

    Route::get('/chat', function () {
        return view('chat');
    })->name('chat');
});
Route::get('/galeria', ShowMedia::class)->name('galeria');
