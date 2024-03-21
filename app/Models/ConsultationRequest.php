<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class ConsultationRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'request_number', 'consultation_sheet_id',
        'consultation_id', 'rate_id', 'consulted_by',
        'printed_by', 'validated_by', 'has_a_shipping_ticket', 'is_hospitalized', 'paid_at', 'created_at'
    ];



    public function rate(): BelongsTo
    {
        return $this->belongsTo(Rate::class, 'rate_id');
    }

    public function consultationSheet(): BelongsTo
    {
        return $this->belongsTo(ConsultationSheet::class, 'consultation_sheet_id');
    }

    public function consultation(): BelongsTo
    {
        return $this->belongsTo(Consultation::class, 'consultation_id');
    }

    public function vitalSigns(): BelongsToMany
    {
        return $this->belongsToMany(VitalSign::class)->withPivot(['id', 'value']);
    }

    public function medicalOffices(): BelongsToMany
    {
        return $this->belongsToMany(MedicalOffice::class);
    }

    public function tarifs(): BelongsToMany
    {
        return $this->belongsToMany(Tarif::class)->withPivot(['id', 'qty']);
    }

    public function diagnostics(): BelongsToMany
    {
        return $this->belongsToMany(Diagnostic::class)->withPivot(['id']);
    }

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class)->withPivot('id', 'qty', 'dosage');
    }

    public function consultationComment(): HasOne
    {
        return $this->hasOne(ConsultationComment::class);
    }
    /**
     * Get all of the ConsultationRequestHospitalization for the ConsultationRequest
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function consultationRequestHospitalizations(): HasMany
    {
        return $this->hasMany(ConsultationRequestHospitalization::class);
    }

    /**
     * Get all of the consultationRequestNursings for the ConsultationRequest
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function consultationRequestNursings(): HasMany
    {
        return $this->hasMany(ConsultationRequestNersing::class);
    }

    /**
     * Get the currency that owns the ConsultationRequest
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function currency(): BelongsTo
    {
        return $this->belongsTo(Currency::class, 'currency_id');
    }

    /**
     * Get the consultationRequestCurrency associated with the ConsultationRequest
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function consultationRequestCurrency(): HasOne
    {
        return $this->hasOne(ConsultationRequestCurrency::class);
    }
    /**
     * Get the caution associated with the ConsultationRequest
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function caution(): HasOne
    {
        return $this->hasOne(Caution::class);
    }

    public function getTotalProductCDF(): float|int
    {
        $total = 0;
        foreach ($this->products as $product) {
            $total += $product->price * $product->pivot->qty;
        }
        return $total;
    }

    public function getTotalProductUSD(): float|int
    {
        $total = 0;
        foreach ($this->products as $product) {
            $total += $product->price * $product->pivot->qty / $this->rate->rate;
        }
        return $total;
    }

    public function getConsultationPriceCDF(): int|float
    {
        $price = 0;
        if ($this->consultationSheet->subscription->is_subscriber) {
            $price =   $this->consultation->subscriber_price * $this->rate->rate;
        } else {
            $price = $this->consultation->price_private * $this->rate->rate;
        }
        return $price;
    }

    public function getConsultationPriceUSD(): int|float
    {
        $price = 0;
        if ($this->consultationSheet->subscription->is_subscriber) {
            $price =  $this->consultation->subscriber_price;
        } else {
            $price =  $this->consultation->price_private;
        }
        return $price;
    }

    public function getHospitalizationAmountCDF(): int|float
    {
        $amount = 0;
        foreach ($this->consultationRequestHospitalizations as $consultationRequestHospitalization) {
            if ($this->consultationSheet->subscription->is_subscriber) {
                $amount += $consultationRequestHospitalization->hospitalizationRoom
                    ->hospitalization->subscriber_price *
                    $consultationRequestHospitalization->number_of_day * $this->rate->rate;
            } else {
                $amount += $consultationRequestHospitalization->hospitalizationRoom->hospitalization->price_private
                    * $consultationRequestHospitalization->number_of_day * $this->rate->rate;
            }
        }
        return $amount;
    }
    public function getHospitalizationAmountUSD(): int|float
    {
        $amount = 0;
        foreach ($this->consultationRequestHospitalizations as $consultationRequestHospitalization) {
            if ($this->consultationSheet->subscription->is_subscriber) {
                $amount += $consultationRequestHospitalization->hospitalizationRoom->hospitalization->subscriber_price * $consultationRequestHospitalization->number_of_day;
            } else {
                $amount += $consultationRequestHospitalization->hospitalizationRoom->hospitalization->price_private  * $consultationRequestHospitalization->number_of_day;
            }
        }
        return $amount;
    }


    public function getNursingAmountCDF(): int|float
    {
        $total = 0;
        foreach ($this->consultationRequestNursings as $nursing) {
            $total += $nursing->amount * $nursing->number * $this->rate->rate;
        }
        return $total;
    }

    public function getNursingAmountUSD(): int|float
    {
        $total = 0;
        foreach ($this->consultationRequestNursings as $nursing) {
            $total += $nursing->amount * $nursing->number;
        }
        return $total;
    }

    public function getCautionCDF(): int|float
    {
        return $this->caution->amount * $this->rate->rate;
    }

    public function getCautionUSD(): int|float
    {
        return $this->caution->amount;
    }


    /**
     * Get the total invoice in CDF
     * @return float|int
     */
    public function getTotalInvoiceCDF()
    {
        $total = 0;
        $net_to_paid = 0;
        foreach ($this->tarifs as $tarif) {
            if ($this->consultationSheet->subscription->is_subscriber) {
                $total += $tarif->subscriber_price * $tarif->pivot->qty * $this->rate->rate;
            } else {
                $total += $tarif->price_private * $tarif->pivot->qty * $this->rate->rate;
            }
        }
        $net_to_paid = $this->consultation->is_consultation_paid == false ?
            ($this->getConsultationPriceCDF() + $total) +
            $this->getTotalProductCDF() + $this->getHospitalizationAmountCDF() + $this->getNursingAmountCDF() :
            $total + $this->getTotalProductCDF() + $this->getHospitalizationAmountCDF() + $this->getNursingAmountCDF();

        return $net_to_paid;
    }
    /**
     * Get the total invoice in USD
     * @return float|int
     */
    public function getTotalInvoiceUSD()
    {
        $total = 0;
        $net_to_paid = 0;
        foreach ($this->tarifs as $tarif) {
            if ($this->consultationSheet->subscription->is_subscriber) {
                $total += $tarif->subscriber_price * $tarif->pivot->qty;
            } else {
                $total += $tarif->price_private * $tarif->pivot->qty;
            }
        }
        $net_to_paid
            = $this->consultation->is_consultation_paid == false ?
            ($this->getConsultationPriceUSD() + $total) +
            $this->getTotalProductUSD() + $this->getHospitalizationAmountUSD() + $this->getNursingAmountUSD() :
            $total + $this->getTotalProductUSD() + $this->getHospitalizationAmountUSD() + $this->getNursingAmountUSD();
        return  $net_to_paid;
    }

    public function getAmountCautionCDF(){
        return $this->caution ==null?0:$this->getTotalInvoiceCDF()-$this->getCautionCDF();
    }

    public function getAmountCautionUSD()
    {
        return $this->caution == null ? 0 : $this->getTotalInvoiceUSD() - $this->getCautionUSD();
    }

    /**
     * Get the request number formatted
     *
     * @return string
     */
    public function getRequestNumberFormatted(): string
    {
        $number = '';
        $mounth = $this->created_at->format('m');
        $formattedRequestNumber = str_pad($this->request_number, 3, '0', STR_PAD_LEFT);
        if ($this->consultationSheet->subscription->is_subscriber == true) {
            $formattedMonth = format_fr_month_name($mounth);
            $substringMonth = substr($formattedMonth, 0, 3); // Change the parameters as needed
            $number = $formattedRequestNumber . '/' . $substringMonth . '/' . $this->consultationSheet->subscription->name;
        } else {
            $number = $formattedRequestNumber . '/' . $mounth;
        }
        return $number;
    }
}
