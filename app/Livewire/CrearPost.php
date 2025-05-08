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
        Media::findOrFail($id);
        if (!in_array($id, $this->cform->selectedMedia)) {
            $this->cform->selectedMedia[] = $id;
        }
    }

    public function removeMedia(int $id)
    {
        $this->cform->selectedMedia = array_values(
            array_filter($this->cform->selectedMedia, fn($item) => $item !== $id)
        );
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
