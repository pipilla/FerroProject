<?php

namespace App\Livewire\Forms;

use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Validate;
use Livewire\Form;

class FormUpdatePost extends Form
{
    public ?Post $post = null;
    #[Rule(['required', 'string', 'min:4', 'max:50'])]
    public string $title = "";

    #[Rule(['required', 'string', 'min:4', 'max:300'])]
    public string $description = "";

    #[Rule(['required'])]
    public $selectedMedia = [];

    #[Rule(['required'])]
    public $tags = [];

    public function setPost(int $id) {
        $post = Post::findOrFail($id);
        $this->post = $post;
        $this->title = $post->title;
        $this->description = $post->description;
        $this->selectedMedia = $post->media->toArray();
        $this->tags = $post->tags->toArray();
    }

    public function update()
    {
        $this->validate();
        $this->post->update([
            'title' => $this->title,
            'description' => $this->description,
            'user_id' => Auth::id(),
        ]);
        $this->post->tags()->sync($this->tags);
        $this->post->media()->sync($this->selectedMedia);
        $this->formReset();
    }

    public function formReset()
    {
        $this->reset();
        $this->resetValidation();
    }
}
