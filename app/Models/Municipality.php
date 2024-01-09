<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Municipality extends Model
{
    use HasFactory;
    protected $fillable=['name', 'hospital_id'];

    /**
     * Get all of the rurals for the Municipality
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function ruralAreas(): HasMany
    {
        return $this->hasMany(RuralArea::class);
    }
}
