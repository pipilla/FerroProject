<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Tags extends Model
{
    protected $fillable = ['name'];

    public $timestamps = false;

    public function posts(): BelongsToMany{
        return $this->belongsToMany(Posts::class);
    }
}
