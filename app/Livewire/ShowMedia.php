<?php

namespace App\Livewire;

use App\Livewire\Forms\FormShowMedia;
use App\Models\Category;
use App\Models\Media;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\On;
use Livewire\Component;

class ShowMedia extends Component
{
    public int $category_id = 0;
    public bool $showAll = true;

    public FormShowMedia $sform;
    public bool $openShow = false;

    #[On('contenidoSubido')]
    public function render()
    {
        $categories = Category::orderBy('name')->get();
        $mediaQuery = Media::with('category')->orderBy('updated_at', 'desc');
        if (!$this->showAll) {
            $mediaQuery->where('category_id', $this->category_id);
        }
        $media = $mediaQuery->paginate(12);
        return view('livewire.show-media', compact('media', 'categories'));
    }

    public function buscar(int $id)
    {
        $this->category_id = $id;
        $this->showAll = ($id <= 0);
    }

    public function show(int $id)
    {
        $media = Media::findOrFail($id);
        $this->sform->setMedia($media);
        $this->openShow = true;
    }

    public function cerrarShow()
    {
        $this->openShow = false;
    }

    public function confirmarBorrar(int $id)
    {
        $media = Media::findOrFail($id);
        $this->dispatch('confirmarBorrarMedia', $id);
    }

    #[On('borrarOk')]
    public function borrar(int $id)
    {
        $media = Media::findOrFail($id);
        $this->openShow = false;
        $this->sform->resetShow();
        Storage::delete($media->src);
        $media->delete();
        $this->dispatch('mensaje', 'Contenido eliminado');
    }
}
