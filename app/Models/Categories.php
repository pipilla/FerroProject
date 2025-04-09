<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Categories extends Model
{
    protected $fillable = ['name'];

    public $timestamps = false;

    public function media(): HasMany{
        return $this->hasMany(Media::class);
    }
}
