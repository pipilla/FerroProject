<?php

namespace App\Livewire\Forms;

use App\Models\Media;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Validate;
use Livewire\Form;
use Livewire\WithFileUploads;

class FormCrearMedia extends Form
{
    use WithFileUploads;

    #[Rule(['required', 'string', 'min:4', 'max:50'])]
    public string $title = "";

    #[Rule(['required', 'file', 'mimes:png,jpg,jpeg,mp4'])]
    public $src;

    #[Rule(['required', 'integer', 'exists:categories,id'])]
    public int $category_id = 0;

    public function storeMedia() {
        $this->validate();

        Media::create([
            'title' => $this->title,
            'src' => $this->src->store('media'),
            'category_id' => $this->category_id,
        ]);
    }

    public function formReset(){
        $this->resetValidation();
        $this->reset();
    }
}
