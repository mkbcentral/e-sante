<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Tarif extends Model
{
    protected $fillable = ['name', 'abbreviation', 'price_private', 'subscriber_price', 'category_tarif_id'];
    use HasFactory;

    /**
     * Get the categoryTarif that owns the Tarif
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function categoryTarif(): BelongsTo
    {
        return $this->belongsTo(CategoryTarif::class, 'category_tarif_id');
    }

    /**
     * The roles that belong to the Tarif
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function consultationRequests(): BelongsToMany
    {
        return $this->belongsToMany(ConsultationRequest::class,)->withPivot(['id', 'qty']);
    }

    /**
     * The OutpatientBills that belong to the Tarif
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function outpatientBills(): BelongsToMany
    {
        return $this->belongsToMany(OutpatientBill::class)->withPivot(['id', 'qty']);
    }

    /**
     * getPricePrivateOutpatientBillUSD
     * Get USD price
     * @param  mixed $outpatientBill
     * @param  mixed $qty
     * @return void
     */
    public function getPricePrivateOutpatientBillUSD()
    {
        return $this->price_private;
    }
    /**
     * getPricePrivateOutpatientBillCaculateUSD
     * Get USD price calculate with qty to to get Total amount
     * @param  mixed $outpatientBill
     * @param  mixed $qty
     * @return void
     */
    public function getPricePrivateOutpatientBillCaculateUSD(
        OutpatientBill $outpatientBill,
        int $qty
    ): float|int {
        return $this->price_private * $qty;
    }

    /**
     * getPricePrivateOutpatientBillCDF
     * Get CDF price
     * @param  mixed $outpatientBill
     * @param  mixed $qty
     * @return void
     */
    public function getPricePrivateOutpatientBillCDF(OutpatientBill $outpatientBill): float|int
    {
        return $this->price_private * $outpatientBill->rate->rate;
    }

    /**
     * getPricePrivateOutpatientBillCalculateCDF
     * Get CDF price calculate with qty to to get Total amount
     * @param  mixed $outpatientBill
     * @param  mixed $qty
     * @return void
     */
    public function getPricePrivateOutpatientBillCalculateCDF(OutpatientBill $outpatientBill, int $qty): float|int
    {
        return ($this->price_private * $qty) * $outpatientBill->rate->rate;
    }

    public function getNameOrAbbreviation(): string
    {
        return $this->abbreviation == null ? $this->name : $this->abbreviation;
    }
}
