<?php

namespace App\Livewire;

use App\Livewire\Forms\FormCrearComentario;
use App\Models\Comment;
use App\Models\Post;
use App\Models\Tag;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class ShowPosts extends Component
{
    use WithPagination;

    public string $buscar = "";
    public $selectedTags = [];

    public int $showPostComments = 0;
    public $comentariosPadre = [];
    public $comentariosHijo = [];

    public FormCrearComentario $ccform;
    public ?Comment $responderComentario = null;

    #[On('contenidoSubido')]
    public function render()
    {
        $posts = Post::orderBy('updated_at', 'desc')
            ->with('media', 'user', 'tags', 'comments')
            ->where(function ($q) {
                $q->where('title', 'like', "%{$this->buscar}%")
                    ->orWhere('description', 'like', "%{$this->buscar}%")
                    ->orWhereHas('user', function ($c) {
                        $c->where('name', 'like', "%{$this->buscar}%")
                            ->orWhere('email', 'like', "%{$this->buscar}%");
                    });
            });

        if (!empty($this->selectedTags)) {
            $tagIds = collect($this->selectedTags)->pluck('id')->all();

            $posts->whereHas('tags', function ($q) use ($tagIds) {
                $q->whereIn('tags.id', $tagIds);
            });
        }

        $posts = $posts->paginate(15);

        return view('livewire.show-posts', compact('posts'));

        return view('livewire.show-posts', compact('posts'));
    }

    #[On('comentarioSubido')]
    public function showComments(int $id)
    {
        $this->cerrarComentarios();
        $post = Post::findOrFail($id);
        if ($id != $this->showPostComments) {
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

    public function cerrarComentarios()
    {
        $this->reset('showPostComments', 'comentariosPadre', 'comentariosHijo', 'ccform', 'responderComentario');
    }

    public function crearComentario(int $post_id, ?int $comment_id = null)
    {
        $this->ccform->store($post_id, $comment_id);
        $this->reset('responderComentario');
        $this->dispatch('comentarioSubido', $post_id);
    }

    public function responder(int $id)
    {
        $this->reset('responderComentario');
        $this->responderComentario = Comment::findOrFail($id);
    }

    public function anadirTag(int $id)
    {
        $tag = Tag::findOrFail($id);
        if (!in_array($tag, $this->selectedTags)) {
            $this->selectedTags[] = $tag;
        }
    }

    public function quitarTag(int $id)
    {
        $tag = Tag::findOrFail($id);
        $this->selectedTags = array_filter($this->selectedTags, function ($t) use ($tag) {
            return $t->id !== $tag->id;
        });
    }

    public function cancelarResponder()
    {
        $this->reset('responderComentario');
    }
}
