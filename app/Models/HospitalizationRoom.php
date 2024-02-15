<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class HospitalizationRoom extends Model
{
    use HasFactory;

    protected $fillable = ['code', 'name', 'source_id', 'hospitalization_id'];

    /**
     * Get all of the HospitalizationBeds for the HospitalizationRoom
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function hospitalizationBeds(): HasMany
    {
        return $this->hasMany(HospitalizationBed::class);
    }

    /**
     * Get the hospitalization that owns the HospitalizationRoom
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function hospitalization(): BelongsTo
    {
        return $this->belongsTo(Hospitalization::class, 'hospitalization_id');
    }

    /**
     * Get the ConsultationRequestHospitalization associated with the HospitalizationRoom
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function consultationRequestHospitalization(): HasOne
    {
        return $this->hasOne(ConsultationRequestHospitalization::class);
    }
}
