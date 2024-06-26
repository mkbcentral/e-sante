<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Source extends Model
{
    use HasFactory;
    protected $fillable=['name','hospital_id'];

    const GOLF = 'GOLF';
    const VILLE = 'VILLE';
    const GOLF_ID = 1;
    const VILLE_ID = 2;

    /**
     * Get the hospital that owns the Source
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function hospital(): BelongsTo
    {
        return $this->belongsTo(Hospital::class, 'hospital_id');
    }

    /**
     * Get all of the users for the Source
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }


    public static function DEFAULT_SOURCE(): int
    {
        return auth()?->user()->source->id;
    }

}
