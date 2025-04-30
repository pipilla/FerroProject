<?php

namespace App\Livewire;

use App\Models\Category;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\On;
use Livewire\Attributes\Rule;
use Livewire\Component;

class CrudCategory extends Component
{
    public bool $openModal = false;
    public bool $openCreate = false;

    public ?Category $selectedCategory = null;

    public string $name = "";

    #[On('contenidoSubido')]
    public function render()
    {
        $categories = Category::orderBy('nombre')->get();
        return view('livewire.crud-category', compact('categories'));
    }

    public function cancelar()
    {
        $this->openModal = false;
    }

    public function rules(?int $id = null): array
    {
        return [
            'name' => ['required', 'string', 'min:2', 'max:25', 'unique:categories,name,' . (($id != null) ? $id : "")],
        ];
    }

    public function edit(int $id)
    {
        $this->selectedCategory =  Category::findOrFail($id);
    }

    public function update()
    {
        $this->validate($this->rules($this->selectedCategory->id));

        $this->selectedCategory->update(['name' => $this->name]);

        $this->dispatch('mensaje', 'Categoría actualizada');
        $this->dispatch('contenidoSubido')->to(CrudCategory::class);
        $this->dispatch('contenidoSubido')->to(ShowMedia::class);
        $this->resetValidation();
        $this->selectedCategory = null;
        $this->name = "";
    }

    public function create()
    {
        $this->openCreate = true;
    }

    public function store()
    {
        $this->validate();

        Category::create(['name' => $this->name]);

        $this->dispatch('mensaje', 'Categoría creada');
        $this->dispatch('contenidoSubido')->to(ShowMedia::class);
        $this->resetValidation();
        $this->reset();
    }

    public function confirmarBorrar(int $id)
    {
        $category = Category::findOrFail($id);
        $this->dispatch('confirmarBorrarCategoria', $id);
    }

    #[On('borrarCategoriaOk')]
    public function borrar(int $id)
    {
        $category = Category::findOrFail($id);
        $media = $category->media;
        foreach ($media as $item) {
            Storage::delete($item->src);
            $item->delete();
        }
        $category->delete();
        $this->dispatch('mensaje', 'Categoría eliminada');
        $this->dispatch('contenidoSubido')->to(ShowMedia::class);
    }
}
