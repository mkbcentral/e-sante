<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class ConsultationRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'request_number', 'consultation_sheet_id',
        'consultation_id', 'rate_id', 'consulted_by',
        'printed_by', 'validated_by'
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
        return $this->belongsToMany(Tarif::class,)->withPivot(['id', 'qty']);
    }

    public function diagnostics(): BelongsToMany
    {
        return $this->belongsToMany(Diagnostic::class,)->withPivot(['id']);
    }

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class)->withPivot('id', 'qty', 'dosage');
    }

    public function consultationComment(): HasOne
    {
        return $this->hasOne(ConsultationComment::class);
    }

    public function getTotalProduct(): float|int
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
            $total += $product->price * $product->pivot->qty/$this->rate->rate;
        }
        return $total;
    }

    public function getConsultationPrice(): int|float
    {
        $price = 0;
        if ($this->consultationSheet->subscription->is_subscriber) {
            $price = Currency::DEFAULT_CURRENCY == 'CDF' ?
                $this->consultation->subscriber_price*$this->rate->rate
                :$this->consultation->subscriber_price;
        } else {
            $price = Currency::DEFAULT_CURRENCY == 'CDF' ?
                $this->consultation->price_private * $this->rate->rate
                : $this->consultation->price_private;
        }
        return $price;
    }

    public function getTotalInvoice()
    {
        $total = 0;
        foreach ($this->tarifs as $tarif) {
            if ($this->consultationSheet->subscription->is_subscriber) {
                $total += $tarif->subscriber_price * $tarif->pivot->qty;
            } else {
                $total += $total += Currency::DEFAULT_CURRENCY =='CDF' ?
                    $tarif->price_private * $tarif->pivot->qty * $this->rate->rate :
                    $tarif->price_private * $tarif->pivot->qty;
            }
        }
        return Currency::DEFAULT_CURRENCY =='CDF'?
            ($this->getConsultationPrice() + $total* $this->rate->rate)+$this->getTotalProduct():
            ($this->getConsultationPrice() + $total)+$this->getTotalProductUSD();
    }
}
