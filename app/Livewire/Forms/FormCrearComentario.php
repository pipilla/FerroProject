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
    #[Rule(['required', 'string', 'min:1', 'max:255'])]
    public string $message = "";

    public function store(int $post_id, ?int $comment_id = null){
        $this->validate();
        $post = Post::findOrFail($post_id);
        if($comment_id != null) {
            $commentPadre = Comment::findOrFail($comment_id);
        }
        $comment = Comment::create([
            'message' => $this->message,
            'comment_id' => ($comment_id != null) ? ($comment_id) : null,
            'post_id' => $post_id,
            'user_id' => Auth::id(),
        ]);
        if($comment_id != null) {
            $commentPadre->commentChild->attach($comment);
        }

        $this->reset();
    }
}
