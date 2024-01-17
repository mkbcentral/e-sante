<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RuralArea extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'municipality_id'];

    /**
     * Get the municipality that owns the RuralArea
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function municipality(): BelongsTo
    {
        return $this->belongsTo(Municipality::class, 'municipality_id');
    }

}
