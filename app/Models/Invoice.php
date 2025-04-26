<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Invoice extends Model
{
    /** @use HasFactory<\Database\Factories\InvoiceFactory> */
    use HasFactory;

    protected $fillable=['from', 'to', 'date', 'subtotal', 'total', 'details'];

    public function concepts(): HasMany{
        return $this->hasMany(Concept::class);
    }
}
