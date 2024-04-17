<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Rate extends Model
{
    use HasFactory;
    protected $fillable=['rate','hospital_id', 'is_current','source_id'];
    /**
     * Get all of the consultationRequest for the Rate
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function ocnsultationRequest(): HasMany
    {
        return $this->hasMany(ConsultationRequest::class);
    }
}
