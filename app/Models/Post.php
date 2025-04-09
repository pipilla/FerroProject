<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Post extends Model
{
    /** @use HasFactory<\Database\Factories\PostsFactory> */
    use HasFactory;

    protected $fillable = ['title', 'description', 'user_id'];

    public function user(): BelongsTo{
        return $this->belongsTo(User::class);
    }

    public function media(): BelongsToMany{
        return $this->belongsToMany(Media::class);
    }

    public function comments(): HasMany{
        return $this->hasMany(Comment::class);
    }

    public function tags(): BelongsToMany{
        return $this->belongsToMany(Tags::class);
    }
}
