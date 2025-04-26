<?php

namespace App\Livewire\Forms;

use App\Models\Media;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Validate;
use Livewire\Form;
use Livewire\WithFileUploads;

class FormUpdateMedia extends Form
{
    use WithFileUploads;

    public ?Media $media = null;
    
    #[Rule(['required', 'string', 'min:4', 'max:50'])]
    public string $title = "";

    public $src;

    public string $file_type = "";

    #[Rule(['required', 'integer', 'exists:categories,id'])]
    public int $category_id = 0;

    public function rules(): array {
        return [
            'src' => ($this->src) ? ['required', 'file', 'mimes:jpg,jpeg,png,gif,mp4,mov,avi,webm', 'max:20480'] : [],
        ];
    }

    public function setMedia(Media $media) {
        $this->media = $media;
        $this->title = $media->title;
        $this->file_type = $media->file_type;
        $this->category_id = $media->category_id;
    }

    public function updateMedia() {
        $this->validate();

        $srcVieja = $this->media->src;

        $this->media->update([
            'title' => $this->title,
            'src' => $this->src?->store('media') ?? $srcVieja,
            'file_type' => $this->src?->getMimeType() ?? $this->file_type,
            'category_id' => $this->category_id,
        ]);

        if($this->src){
            Storage::delete($srcVieja);
        }
    }

    public function formReset(){
        $this->resetValidation();
        $this->reset();
    }
}
