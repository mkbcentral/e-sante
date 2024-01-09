<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class OutpatientBill extends Model
{
    use HasFactory;

    protected $fillable = [
        'bill_number', 'client_name', 'is_validated', 'is_printed',
        'consultation_id', 'user_id', 'hospital_id', 'rate_id', 'currency_id'
    ];

    /**
     * The tarifs that belong to the OutpatientBill
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function tarifs(): BelongsToMany
    {
        return $this->belongsToMany(Tarif::class)->withPivot(['id', 'qty']);;
    }

    /**
     * Get the rate that owns the OutpatientBill
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function rate(): BelongsTo
    {
        return $this->belongsTo(Rate::class, 'rate_id');
    }

    /**
     * Get the consultation that owns the OutpatientBill
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function consultation(): BelongsTo
    {
        return $this->belongsTo(Consultation::class, 'consultation_id');
    }

    /**
     * Get the user that owns the OutpatientBill
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }


    public function getConsultationPriceUSD(): int|float
    {
        return $this->consultation->price_private;
    }

    public function getConsultationPriceCDF(): int|float
    {
        return $this->consultation->price_private * $this->rate->rate;
    }

    public function getTotalOutpatientBillUSD(): int|float
    {
        $total = 0;
        foreach ($this->tarifs as $tarif) {
            $total += $tarif->price_private * $tarif->pivot->qty;
        }
        return $this->getConsultationPriceUSD() + $total;
    }

    public function getTotalOutpatientBillCDF(): int|float
    {
        $total = 0;
        foreach ($this->tarifs as $tarif) {
            $total += ($tarif->price_private * $tarif->pivot->qty) * $this->rate->rate;
        }
        return $this->getConsultationPriceCDF() + $total;
    }
}
