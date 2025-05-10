<?php

namespace App\Livewire;

use App\Livewire\Forms\FormCrearMedia;
use App\Models\Category;
use Livewire\Component;
use Livewire\WithFileUploads;

class CrearMedia extends Component
{
    use WithFileUploads;
    
    public bool $openModal = false;

    public FormCrearMedia $cform;

    public function render()
    {
        $categorias = Category::orderBy('nombre')->get();
        return view('livewire.crear-media', compact('categorias'));
    }

    public function store()
    {
        $this->cform->storeMedia();
        $this->dispatch('contenidoSubido')->to(ShowMedia::class);
        $this->dispatch('contenidoSubido')->to(ShowMediaModal::class);
        $this->cancelar();
        $this->dispatch('mensaje', 'Contenido Subido');
    }

    public function cancelar() {
        $this->openModal = false;
        $this->cform->formReset();
    }
}
