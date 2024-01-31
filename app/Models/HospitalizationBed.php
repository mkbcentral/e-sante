<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HospitalizationBed extends Model
{
    use HasFactory;
    protected $fillable = ['code', 'hospitalization_room_id'];
    /**
     * Get the hospitalization_room that owns the HospitalizationBed
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function hospitalizationRoom(): BelongsTo
    {
        return $this->belongsTo(HospitalizationRoom::class, 'hospitalization_room_id');
    }
}
