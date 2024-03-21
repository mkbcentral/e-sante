<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Caution extends Model
{
    use HasFactory;

    protected $fillable=['amount','consultation_request_id'];


    /**
     * Get the consultationRequest that owns the Caution
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function consultationRequest(): BelongsTo
    {
        return $this->belongsTo(ConsultationRequest::class, 'consultation_request_id');
    }
}
