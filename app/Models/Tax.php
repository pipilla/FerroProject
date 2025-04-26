<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Tax extends Model
{
    protected $fillable=['name', 'value'];

    public $timestamps = false;

    public function concepts(): HasMany{
        return $this->hasMany(Concept::class);
    }
}
