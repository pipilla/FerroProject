<?php

namespace App\Livewire;

use App\Livewire\Forms\FormShowMedia;
use App\Livewire\Forms\FormUpdateMedia;
use App\Models\Category;
use App\Models\Media;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class ShowMedia extends Component
{
    use WithFileUploads;
    use WithPagination;

    public array $mediaIds = [];

    public int $category_id = 0;
    public bool $showAll = true;

    public FormShowMedia $sform;
    public bool $openShow = false;

    public FormUpdateMedia $uform;
    public bool $openUpdate = false;

    #[On('contenidoSubido')]
    public function render()
    {
        $categories = Category::orderBy('name')->get();
        $mediaQuery = Media::with('category')->orderBy('updated_at', 'desc');
        if (!$this->showAll) {
            $mediaQuery->where('category_id', $this->category_id);
        }
        $media = $mediaQuery->paginate(12);
        $this->mediaIds = $mediaQuery->pluck('id')->toArray();
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
        $this->reset('sform');
    }

    public function confirmarBorrar(int $id)
    {
        $media = Media::findOrFail($id);
        $this->authorize('delete', $media);
        $this->dispatch('confirmarBorrarMedia', $id);
    }

    #[On('borrarMediaOk')]
    public function borrar(int $id)
    {
        $media = Media::findOrFail($id);
        $this->authorize('delete', $media);
        $this->openShow = false;
        $this->sform->resetShow();
        Storage::delete($media->src);
        $media->delete();
        $this->dispatch('mensaje', 'Contenido eliminado');
    }

    public function edit(int $id)
    {
        $media = Media::findOrFail($id);
        $this->authorize('update', $media);
        $this->uform->setMedia($media);
        $this->openShow = false;
        $this->openUpdate = true;
    }

    public function update()
    {
        $this->uform->updateMedia();
        $this->cancelar();
        $this->openUpdate = false;;
        $this->dispatch('mensaje', 'Contenido editado');
    }

    public function cancelar()
    {
        $this->openUpdate = false;;
        $this->uform->formReset();
    }

    public function siguiente()
    {
        if (!$this->sform || !$this->sform->media) return;

        $currentId = $this->sform->media->id;
        $index = array_search($currentId, $this->mediaIds);
        $nextId = $this->mediaIds[$index + 1] ?? null;

        if ($nextId) {
            $this->show($nextId);
        }
    }

    public function anterior()
    {
        if (!$this->sform || !$this->sform->media) return;

        $currentId = $this->sform->media->id;
        $index = array_search($currentId, $this->mediaIds);
        $prevId = $this->mediaIds[$index - 1] ?? null;

        if ($prevId) {
            $this->show($prevId);
        }
    }
}
