<?php

namespace App\Models;

use App\Enums\RoleType;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\Auth;

class ConsultationRequest extends Model
{
    use HasFactory;
    protected $fillable = [
        'request_number',
        'consultation_sheet_id',
        'consultation_id',
        'rate_id',
        'consulted_by',
        'printed_by',
        'validated_by',
        'has_a_shipping_ticket',
        'is_hospitalized',
        'paid_at',
        'created_at'
    ];
    protected $casts = [
        'created_at' => 'datetime',
        'paid_at' => 'datetime'
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
        return $this->belongsToMany(Tarif::class)
            ->withPivot(['id', 'qty', 'result', 'normal_value', 'unit']);
    }

    public function diagnostics(): BelongsToMany
    {
        return $this->belongsToMany(Diagnostic::class)->withPivot(['id']);
    }
    public function symptoms(): BelongsToMany
    {
        return $this->belongsToMany(Symptom::class)->withPivot(['id']);
    }
    /**
     * Summary of products
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
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
            $price = $this->consultation->subscriber_price * $this->rate->rate;
        } else {
            $price = $this->consultation->price_private * $this->rate->rate;
        }
        return $price;
    }

    public function getConsultationPriceUSD(): int|float
    {
        $price = 0;
        if ($this->consultationSheet->subscription->is_subscriber) {
            $price = $this->consultation->subscriber_price;
        } else {
            $price = $this->consultation->price_private;
        }
        return $price;
    }

    public function getHospitalizationAmountCDF(): int|float
    {
        $amount = 0;
        foreach ($this->consultationRequestHospitalizations as $consultationRequestHospitalization) {
            if ($this->consultationSheet->subscription->is_subscriber) {
                $amount += $consultationRequestHospitalization
                    ->hospitalizationRoom
                    ->hospitalization
                    ->subscriber_price *
                    $consultationRequestHospitalization
                    ->number_of_day * $this->rate->rate;
            } else {
                $amount += $consultationRequestHospitalization
                    ->hospitalizationRoom
                    ->hospitalization
                    ->price_private
                    * $consultationRequestHospitalization
                    ->number_of_day * $this->rate->rate;
            }
        }
        return $amount;
    }

    public function getHospitalizationAmountUSD(): int|float
    {
        $amount = 0;
        foreach ($this->consultationRequestHospitalizations as $consultationRequestHospitalization) {
            if ($this->consultationSheet->subscription->is_subscriber) {
                $amount += $consultationRequestHospitalization
                    ->hospitalizationRoom
                    ->hospitalization
                    ->subscriber_price * $consultationRequestHospitalization
                    ->number_of_day;
            } else {
                $amount += $consultationRequestHospitalization
                    ->hospitalizationRoom
                    ->hospitalization
                    ->price_private *
                    $consultationRequestHospitalization->number_of_day;
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
        if (Auth::user()->roles->pluck('name')->contains(RoleType::PHARMA)) {
            $net_to_paid = $this->getTotalProductCDF();
        } else {
            $net_to_paid = $this->consultation->is_consultation_paid == false ?
                ($this->getConsultationPriceCDF() + $total) +
                $this->getTotalProductCDF() + $this->getHospitalizationAmountCDF() + $this->getNursingAmountCDF() :
                $total + $this->getTotalProductCDF() + $this->getHospitalizationAmountCDF() + $this->getNursingAmountCDF();
        }


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
        # code...
        if (Auth::user()->roles->pluck('name')->contains(RoleType::PHARMA)) {
            $net_to_paid
                = $this->getTotalProductUSD();
        } else {
            $net_to_paid
                = $this->consultation->is_consultation_paid == false ?
                ($this->getConsultationPriceUSD() + $total) +
                $this->getTotalProductUSD() + $this->getHospitalizationAmountUSD() + $this->getNursingAmountUSD() :
                $total + $this->getTotalProductUSD() + $this->getHospitalizationAmountUSD() + $this->getNursingAmountUSD();
        }
        return $net_to_paid;
    }

    public function getAmountCautionCDF()
    {
        return $this->caution == null ? 0 : $this->getTotalInvoiceCDF() - $this->getCautionCDF();
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
            $substringMonth = substr($formattedMonth, 0, 4); // Change the parameters as needed
            $number = $formattedRequestNumber . '/' . $substringMonth . '/' . $this->consultationSheet->subscription->name;
        } else {
            $number = $formattedRequestNumber . '/' . $mounth;
        }
        return $number;
    }

    public function getBgStatus(): string
    {
        $bg = '';
        if (auth()->user()->roles->pluck('name')->contains(RoleType::ADMIN)) {
            $bg = $this->getTotalInvoiceUSD() == $this->getConsultationPriceUSD()
                ? 'bg-danger'
                : '';
        }
        return $bg;
    }

    public function scopeFilter(Builder $query, string $currency): Builder
    {
        return $query
            ->join(
                'consultation_sheets',
                'consultation_sheets.id',
                'consultation_requests.consultation_sheet_id'
            )
            ->join(
                'consultation_request_product',
                'consultation_requests.id',
                'consultation_request_product.consultation_request_id'
            )
            ->join(
                'products',
                'products.id',
                'consultation_request_product.product_id'
            )
            ->join(
                'consultation_request_tarif',
                'consultation_requests.id',
                'consultation_request_tarif.consultation_request_id'
            )
            ->join(
                'tarifs',
                'tarifs.id',
                'consultation_request_tarif.tarif_id'
            )
            ->join(
                'consultation_request_nersings',
                'consultation_requests.id',
                'consultation_request_nersings.consultation_request_id'
            )
            ->join(
                'consultation_request_hospitalizations',
                'consultation_requests.id',
                'consultation_request_hospitalizations.consultation_request_id'
            )
            ->join(
                'hospitalization_rooms',
                'hospitalization_rooms.id',
                'consultation_request_hospitalizations.hospitalization_room_id'
            )
            ->join(
                'hospitalizations',
                'hospitalizations.id',
                'hospitalization_rooms.hospitalization_id'
            )
            ->join(
                'rates',
                'rates.id',
                'consultation_requests.rate_id'
            )
            ->where('consultation_requests.currency_id', $currency)
            ->where('consultation_sheets.hospital_id', Hospital::DEFAULT_HOSPITAL())
            ->where('consultation_sheets.source_id', Source::DEFAULT_SOURCE())
            ->where('consultation_requests.is_hospitalized', true)
            ->where('consultation_requests.is_finished', true)
            ->selectRaw(
                $currency == 1 ?
                    'SUM(
                    (tarifs.price_private * consultation_request_tarif.qty) +
                    (consultation_request_nersings.amount * consultation_request_nersings.number)+
                    (hospitalizations.price_private * consultation_request_hospitalizations.number_of_day)+
                    (products.price * consultation_request_product.qty/rates.rate)
                ) as total_amount' :
                    'SUM(
                    ((tarifs.price_private * consultation_request_tarif.qty) +
                    (consultation_request_nersings.amount * consultation_request_nersings.number)+
                    (hospitalizations.price_private * consultation_request_hospitalizations.number_of_day)
                    *rates.rate)+
                    (products.price * consultation_request_product.qty)
                ) as total_amount'

            );
    }

    public function scopeReusable(Builder $query, array $filters): mixed
    {
        return $query->join('consultation_sheets', 'consultation_sheets.id', 'consultation_requests.consultation_sheet_id')
            ->join('subscriptions', 'subscriptions.id', 'consultation_sheets.subscription_id')
            ->where('consultation_sheets.subscription_id', $filters['id_subscription'])
            ->when($filters['q'], function ($q, $val) {
                return $q->where('consultation_sheets.name', 'like', '%' . $val . '%')
                    ->orWhere('consultation_sheets.number_sheet', 'like', '%' . $val . '%');
            })
            ->selectRaw('consultation_requests.*,subscriptions.name as subscription_name')
            ->with(
                [
                    'consultation',
                    'rate',
                    'consultationSheet.subscription',
                    'consultationRequestNursings',
                    'consultationRequestHospitalizations',
                    'consultationRequestHospitalizations.hospitalizationRoom',
                    'tarifs',
                    'products'
                ]
            )

            ->where('consultation_sheets.hospital_id', Hospital::DEFAULT_HOSPITAL())
            ->when($filters['source_id'], function ($q, $val) {
                return $q->where('consultation_sheets.source_id', operator: $val);
            })
            ->when($filters['is_hospitalized'], function ($q, $val) {
                return $q->where('consultation_requests.is_hospitalized', $val);
            });
    }
}
