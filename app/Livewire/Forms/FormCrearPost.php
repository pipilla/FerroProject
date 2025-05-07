<?php

namespace App\Livewire\Forms;

use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Validate;
use Livewire\Form;

class FormCrearPost extends Form
{
    #[Rule(['required', 'string', 'min:4', 'max:50'])]
    public string $title = "";
    
    #[Rule(['required', 'string', 'min:4', 'max:300'])]
    public string $description = "";

    #[Rule(['required'])]
    public $selectedMedia = [];

    #[Rule(['required'])]
    public $tags = [];

    public function store(){
        $this->validate();
        $post = Post::create([
            'title' => $this->title,
            'description' => $this->description,
            'user_id' => Auth::id(),
        ]);
        $post->tags()->attach($this->tags);
        $post->media()->attach($this->selectedMedia);
        $this->formReset();
    }

    public function formReset() {
        $this->reset();
        $this->resetValidation();
    }

}
