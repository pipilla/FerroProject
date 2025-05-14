<?php

use App\Http\Controllers\FacturasPdfController;
use App\Livewire\FormularioContacto;
use App\Livewire\ShowChat;
use App\Livewire\ShowInvoices;
use App\Livewire\ShowMedia;
use App\Livewire\ShowPosts;
use App\Livewire\ShowTasks;
use App\Models\Invoice;
use Barryvdh\DomPDF\Facade\Pdf;
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
    Route::get('/factura/{invoice}/pdf', [FacturasPdfController::class, 'download'])->name('factura.pdf');

    Route::get('/chat', ShowChat::class)->name('chat');
});
Route::get('/galeria', ShowMedia::class)->name('galeria');
Route::get('/posts', ShowPosts::class)->name('posts');
Route::get('/formulario-contacto', FormularioContacto::class)->name('formulario-contacto');