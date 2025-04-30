<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Message extends Model
{
<<<<<<< HEAD
    protected $fillable = ['sender_id', 'chat_id', 'content'];

    public function sender(): BelongsTo
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function chat(): BelongsTo
    {
        return $this->belongsTo(Chat::class);
    }
=======
    protected $fillable=['content'];
>>>>>>> f2aff96 (Cambios para que funcione react)
}
