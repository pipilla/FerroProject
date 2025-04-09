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

    protected $fillable = ['title', 'src', 'category_id'];

    public function category(): BelongsTo{
        return $this->belongsTo(Categories::class);
    }

    public function posts(): BelongsToMany{
        return $this->belongsToMany(Posts::class);
    }
}
