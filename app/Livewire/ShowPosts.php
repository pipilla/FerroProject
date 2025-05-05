<?php

namespace App\Livewire;

use App\Livewire\Forms\FormCrearComentario;
use App\Models\Comment;
use App\Models\Post;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class ShowPosts extends Component
{
    use WithPagination;

    public int $showPostComments = 0;
    public $comentariosPadre = [];
    public $comentariosHijo = [];

    public FormCrearComentario $ccform;
    public ?Comment $responderComentario = null;

    #[On('contenidoSubido')]
    public function render()
    {
        $posts = Post::orderBy('updated_at', 'desc')->with('media', 'user', 'tags', 'comments')->paginate(15);
        return view('livewire.show-posts', compact('posts'));
    }

    #[On('comentarioSubido')]
    public function showComments(int $id)
    {
        $this->reset();
        $post = Post::findOrFail($id);
        if($id != $this->showPostComments){
            foreach ($post->comments as $comment) {
                if ($comment->comment_id == null) {
                    $this->comentariosPadre[] = $comment;
                } else {
                    $this->comentariosHijo[$comment->comment_id][] = $comment;
                }
            }
            $this->showPostComments = $id;
        }
    }

    public function crearComentario(int $post_id, ?int $comment_id = null){
        $this->ccform->store($post_id, $comment_id);
        $this->reset('responderComentario');
        $this->dispatch('comentarioSubido', $post_id);
    }

    public function responder(int $id){
        $this->reset('responderComentario');
        $this->responderComentario = Comment::findOrFail($id);
    }

    public function cancelarResponder(){
        $this->reset('responderComentario');
    }
}
