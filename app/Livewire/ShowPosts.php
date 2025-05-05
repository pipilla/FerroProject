<?php

namespace App\Livewire;

use App\Models\Comment;
use App\Models\Post;
use Livewire\Component;

class ShowPosts extends Component
{
    public int $showPostComments = 0;
    public $comentariosPadre = [];
    public $comentariosHijo = [];

    public int $responderComentario = 0;

    public function render()
    {
        $posts = Post::orderBy('updated_at', 'desc')->with('media', 'user', 'tags', 'comments')->paginate(15);
        return view('livewire.show-posts', compact('posts'));
    }

    public function showComments(int $id)
    {
        $this->reset();
        $post = Post::findOrFail($id);
        foreach ($post->comments as $comment) {
            if ($comment->comment_id == null) {
                $this->comentariosPadre[] = $comment;
            } else {
                $this->comentariosHijo[$comment->comment_id][] = $comment;
            }
        }
        $this->showPostComments = $id;
    }


    public function responder(int $id){
        $this->reset('responderComentario');
        Comment::findOrFail($id);
        $this->responderComentario = $id;
    }
}
