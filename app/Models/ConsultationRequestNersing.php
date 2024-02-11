<?php

namespace App\Models;

use App\Repositories\Rate\RateRepository;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ConsultationRequestNersing extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'amount', 'number', 'consultation_request_id'];
    /**
     * Get the consultationRequest that owns the ConsultationRequestNersing
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function consultationRequest(): BelongsTo
    {
        return $this->belongsTo(ConsultationRequest::class, 'consultation_request_id');
    }

    public function getAmountCDF(): int|float
    {
        return $this->amount * RateRepository::getCurrentRate()->rate;
    }

    public function getAmountUSD(): int|float
    {
        return $this->amount;
    }


}
