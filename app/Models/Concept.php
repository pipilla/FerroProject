<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Concept extends Model
{
    /** @use HasFactory<\Database\Factories\ConceptFactory> */
    use HasFactory;

    protected $fillable=['description', 'price', 'tax_id', 'invoice_id'];

    public function invoice(): BelongsTo{
        return $this->belongsTo(Invoice::class);
    }

    public function tax(): BelongsTo{
        return $this->belongsTo(Tax::class);
    }
}
