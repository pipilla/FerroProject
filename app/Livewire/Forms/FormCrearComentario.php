<?php

namespace App\Livewire\Forms;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Validate;
use Livewire\Form;

class FormCrearComentario extends Form
{
    public ?Post $post = null;

    #[Rule(['required', 'string', 'min:1', 'max:255'])]
    public string $message = "";

    public function setPost(int $id)
    {
        $this->post = Post::findOrFail($id);
    }

    public function store(?int $comment_id = null)
    {
        if ($comment_id != null) {
            Comment::findOrFail($comment_id);
        }
        $this->validate();
        Comment::create([
            'message' => $this->message,
            'comment_id' => ($comment_id != null) ? ($comment_id) : null,
            'post_id' => $this->post->id,
            'user_id' => Auth::id(),
        ]);

    }

    public function formReset()
    {
        $this->reset();
        $this->resetValidation();
    }
}
