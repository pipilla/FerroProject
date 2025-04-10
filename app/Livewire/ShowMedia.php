<?php

namespace App\Livewire;

use App\Models\Category;
use App\Models\Media;
use Livewire\Component;

class ShowMedia extends Component
{
    public int $category_id = 0;
    public bool $showAll = true;

    public function render()
    {
        $categories = Category::orderBy('name')->get();
        $media = Media::with('category')
        ->where('category_id', $this->category_id)
        ->orderBy('updated_at')
        ->paginate(12);
        return view('livewire.show-media', compact('media', 'categories'));
    }

    public function buscar(int $id) {
        $this->category_id = $id;
    }
}
