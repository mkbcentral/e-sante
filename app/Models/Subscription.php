<?php

namespace App\Models;

use App\Repositories\Sheet\Get\GetConsultationRequestionAmountRepository;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Subscription extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'is_private', 'is_subscriber', 'is_personnel', 'source_id', 'hospital_id'];
    /**
     * Get all of the consultationSheets for the Subscription
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function consultationSheets(): HasMany
    {
        return $this->hasMany(ConsultationSheet::class);
    }

    public function getAmountUSDBySubscription($month,$year):int|float{
        return GetConsultationRequestionAmountRepository::getTotalByMonthUSD($month,$year,$this->id);
    }
}
