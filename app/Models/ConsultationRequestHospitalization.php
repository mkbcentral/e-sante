<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ConsultationRequestHospitalization extends Model
{
    use HasFactory;

    protected $fillable=['consultation_request_id', 'hospitalization_room_id', 'number_of_day'];

    /**
     * Get the consultationRequest that owns the ConsultationRequestHospitalization
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function consultationRequest(): BelongsTo
    {
        return $this->belongsTo(ConsultationRequest::class, 'consultation_request_id');
    }

    /**
     * Get the hospitalizationRoom that owns the ConsultationRequestHospitalization
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function hospitalizationRoom(): BelongsTo
    {
        return $this->belongsTo(HospitalizationRoom::class, 'hospitalization_room_id');
    }
}
