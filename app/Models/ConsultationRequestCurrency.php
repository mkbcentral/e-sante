<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ConsultationRequestCurrency extends Model
{
    use HasFactory;

    protected $fillable=['consultation_request_id','amount_cdf','amount_usd'];

    /**
     * Get the consultationRequest that owns the ConsultationRequestCurrency
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function consultationRequest(): BelongsTo
    {
        return $this->belongsTo(ConsultationRequest::class, 'consultation_request_id');
    }
}
