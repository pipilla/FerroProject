<?php

namespace App\Livewire\Forms;

use App\Models\Media;
use Livewire\Attributes\Validate;
use Livewire\Form;

class FormShowMedia extends Form
{
    public ?Media $media = null;
    public string $title = "";
    public string $src = "";
    public string $file_type = "";
    public int $category_id = 0;
    public string $category_name = "";

    public function setMedia(Media $media) {
        $this->media = $media;
        $this->title = $media->title;
        $this->src = $media->src;
        $this->file_type = $media->file_type;
        $this->category_id = $media->category_id;
        $this->category_name = $media->category->name;
    }

    public function resetShow(){
        $this->reset();
    }
}
