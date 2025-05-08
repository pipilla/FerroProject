<?php

namespace App\Livewire;

use App\Livewire\Forms\FormCrearComentario;
use App\Livewire\Forms\FormUpdatePost;
use App\Models\Comment;
use App\Models\Media;
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

    public bool $openUpdate = false;
    public FormUpdatePost $uform;

    #[On('contenidoSubido')]
    public function render()
    {
        $tags = Tag::orderBy('name')->get();
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

        return view('livewire.show-posts', compact('posts', 'tags'));
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

    public function managePost(int $id) {
        Post::findOrFail($id);
        $this->dispatch('onManagePost', $id);
    }

    #[On('editOk')]
    public function edit(int $id){
        $post = Post::findOrFail($id);
        $this->authorize('update', $post);
        $this->uform->setPost($id);
        $this->openUpdate = true;
    }

    public function update() {
        $this->uform->update();
        $this->openUpdate = false;
        $this->dispatch('mensaje', "Post actualizado");
    }

    #[On('addMedia')]
    public function addMedia(int $id)
    {
        Media::findOrFail($id);
        if (!in_array($id, $this->uform->selectedMedia)) {
            $this->uform->selectedMedia[] = $id;
        }
    }

    public function removeMedia(int $id)
    {
        $this->uform->selectedMedia = array_values(
            array_filter($this->uform->selectedMedia, fn($item) => $item !== $id)
        );
    }

    public function cancelarUpdate(){
        $this->uform->formReset();
        $this->openUpdate = false;
    }

    #[On('borrarOk')]
    public function delete(int $id){
        $post = Post::findOrFail($id);
        $this->authorize('delete', $post);
        $post->delete();
        $this->dispatch('mensaje', "Post eliminado");
    }
}
