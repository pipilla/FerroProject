<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Media extends Model
{
    /** @use HasFactory<\Database\Factories\MediaFactory> */
    use HasFactory;

    protected $fillable = ['title', 'src', 'file_type', 'category_id'];

    public function category(): BelongsTo{
        return $this->belongsTo(Category::class);
    }

    public function posts(): BelongsToMany{
        return $this->belongsToMany(Post::class);
    }
}
