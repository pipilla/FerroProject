<?php

namespace App\Livewire;

use App\Livewire\Forms\FormCrearPost;
use App\Models\Media;
use App\Models\Tag;
use Livewire\Attributes\On;
use Livewire\Component;

class CrearPost extends Component
{
    public bool $openModal = false;

    public FormCrearPost $cform;


    public function render()
    {
        $tags = Tag::orderBy('name')->get();
        return view('livewire.crear-post', compact('tags'));
    }

    #[On('addMedia')]
    public function addMedia(int $id)
    {
        $media = Media::findOrFail($id);
        if (!in_array($media, $this->cform->selectedMedia)) {
            $this->cform->selectedMedia[] = $media;
        }
    }

    public function removeMedia(int $id)
    {
        $this->cform->selectedMedia = collect($this->cform->selectedMedia)
            ->reject(fn($item) => $item['id'] === $id)
            ->values();
    }

    public function publicar()
    {
        $this->cform->store();
        $this->reset();
        $this->dispatch('contenidoSubido')->to(ShowPosts::class);
        $this->dispatch('mensaje', "Post creado");
    }

    public function cancelar()
    {
        $this->cform->formReset();
        $this->reset();
    }
}
