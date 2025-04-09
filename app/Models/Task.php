<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Tasks extends Model
{
    /** @use HasFactory<\Database\Factories\TasksFactory> */
    use HasFactory;

    protected $fillable = ['title', 'description', 'priority', 'user_id'];

    public function user(): BelongsTo{
        return $this->belongsTo(User::class);
    }
}
