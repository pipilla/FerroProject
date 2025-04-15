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
        $mediaQuery = Media::with('category')->orderBy('updated_at', 'desc');
        if(!$this->showAll) {
            $mediaQuery->where('category_id', $this->category_id);
        }
        $media = $mediaQuery->paginate(12);
        return view('livewire.show-media', compact('media', 'categories'));
    }

    public function buscar(int $id) {
        $this->category_id = $id;
        $this->showAll = ($id <= 0);
    }
}
