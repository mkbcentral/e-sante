<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Notifications\Notifiable;

class OutpatientBill extends Model
{
    use HasFactory,Notifiable;

    protected $fillable = [
        'bill_number', 'client_name', 'is_validated', 'is_printed',
        'consultation_id', 'user_id', 'hospital_id', 'rate_id', 'currency_id'
    ];

    public function receivesBroadcastNotificationsOn(): string
    {
        return 'outpatient_bills.' . $this->id;
    }

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
     * Get the currency that owns the OutpatientBill
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function currency(): BelongsTo
    {
        return $this->belongsTo(Currency::class, 'currency_id');
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

    /**
     * Get the detailOutpatientBill associated with the OutpatientBill
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function detailOutpatientBill(): HasOne
    {
        return $this->hasOne(DetailOutpatientBill::class);
    }

    /**
     * Get the otherOutpatientBill associated with the OtherDetailOutpatientBill
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function otherOutpatientBill(): HasOne
    {
        return $this->hasOne(OtherDetailOutpatientBill::class);
    }
    /* Get the consultation price in USD */
    public function getConsultationPriceUSD(): int|float
    {
        return $this->consultation->price_private;
    }
    /* Get the consultation price in CDF */
    public function getConsultationPriceCDF(): int|float
    {
        return $this->consultation->price_private * $this->rate->rate;
    }
    /* Get the other outpatient bill in USD */
    public function getOtherOutpatientBillPriceUSD(): int|float
    {
        return $this->otherOutpatientBill !=null? $this->otherOutpatientBill->amount:0;
    }
    /* Get the other outpatient bill in CDF */
    public function getOtherOutpatientBillPriceCDF(): int|float
    {
        return $this->otherOutpatientBill != null ? $this->otherOutpatientBill->amount * $this->rate->rate:0;
    }
    /* Get the total bill in USD */
    public function getTotalOutpatientBillUSD(): int|float
    {
        $total = 0;
        foreach ($this->tarifs as $tarif) {
            $total += $tarif->price_private * $tarif->pivot->qty;
        }
        return $this->getConsultationPriceUSD() + $total+$this->getOtherOutpatientBillPriceUSD();
    }
    /**
     * Get the total bill in CDF
     *
     * @return int|float
     */
    public function getTotalOutpatientBillCDF(): int|float
    {
        $total = 0;
        foreach ($this->tarifs as $tarif) {
            $total += ($tarif->price_private * $tarif->pivot->qty) * $this->rate->rate;
        }
        return $this->getConsultationPriceCDF() + $total +$this->getOtherOutpatientBillPriceCDF();
    }

    public function getBillNumberAttribute($value): string
    {
        return 'A-' . $value.'-PS';
    }
}
