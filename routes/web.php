<?php

use App\Http\Controllers\DesignerController;
use App\Http\Controllers\FacturasPdfController;
use App\Http\Middleware\IsUserActive;
use App\Http\Middleware\UserWorker;
use App\Http\Middleware\UserWorkerPlus;
use App\Livewire\FormularioContacto;
use App\Livewire\ShowChat;
use App\Livewire\ShowInvoices;
use App\Livewire\ShowMedia;
use App\Livewire\ShowPosts;
use App\Livewire\ShowTasks;
use App\Models\Invoice;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Route;

Route::middleware([IsUserActive::class])->group(function () {
    Route::get('/', function () {
        return view('welcome');
    })->name('welcome');

    Route::middleware([
        'auth:sanctum',
        config('jetstream.auth_session'),
        'verified',
    ])->group(function () {
        Route::middleware([UserWorker::class])->group(function () {
            Route::get('/tareas', ShowTasks::class)->name('tareas');
            Route::get('/chat', ShowChat::class)->name('chat');
        });
        Route::middleware([UserWorkerPlus::class])->group(function () {
            Route::get('/facturas', ShowInvoices::class)->name('facturas');
            Route::get('/factura/{invoice}/pdf', [FacturasPdfController::class, 'download'])->name('factura.pdf');
        });
    });
    Route::get('/galeria', ShowMedia::class)->name('galeria');
    Route::get('/posts', ShowPosts::class)->name('posts');
    Route::get('/formulario-contacto', FormularioContacto::class)->name('formulario-contacto');
    Route::get('/designer', [DesignerController::class, 'index'])->name('designer');
});
