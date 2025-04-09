<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Comments extends Model
{
    /** @use HasFactory<\Database\Factories\CommentsFactory> */
    use HasFactory;

    protected $fillable = ['message', 'comment_id',  'post_id', 'user_id'];

    public function comment(): BelongsTo
    {
        return $this->belongsTo(Comments::class);
    }

    public function post(): BelongsTo
    {
        return $this->belongsTo(Posts::class);
    }
    
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
