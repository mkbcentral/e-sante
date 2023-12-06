<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class CategoryTarif extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'hospital_id'];

    public function tarifs(): HasMany
    {
        return $this->hasMany(Tarif::class,);
    }

    public function getConsultationTarifItemls(ConsultationRequest $consultationRequest, CategoryTarif $categoryTarif): Collection
    {

        return DB::table('consultation_request_tarif')
            ->join('tarifs', 'tarifs.id', '=', 'consultation_request_tarif.tarif_id')
            ->join('category_tarifs', 'category_tarifs.id', '=', 'tarifs.category_tarif_id')
            ->select(
                'consultation_request_tarif.*',
                'tarifs.name', 'tarifs.price_private',
                'tarifs.subscriber_price',
                'tarifs.id as id_tarif',
                'category_tarifs.id as category_id')
            ->where('consultation_request_tarif.consultation_request_id', $consultationRequest->id)
            ->where('category_tarifs.id', $categoryTarif->id)
            ->where('category_tarifs.hospital_id', Hospital::DEFAULT_HOSPITAL)
            ->get();
    }

    public function getUnitPrice(ConsultationRequest $consultationRequest, $idTarif): float|int
    {
        $tarif = Tarif::find($idTarif);
        $price = 0;
        if ($consultationRequest->consultationSheet->subscription->is_subscriber) {
            $price = Currency::DEFAULT_CURRENCY == 'CDF' ?
                $tarif->subscriber_price * $consultationRequest->rate->rate :
                $tarif->price_private;
        } else {
            $price = Currency::DEFAULT_CURRENCY == 'CDF' ?
                $tarif->price_private * $consultationRequest->rate->rate :
                $tarif->price_private;
        }
        return $price;
    }

    public function getTotalPrice(
        ConsultationRequest $consultationRequest,
        int $qty,
        int $idTarif
    ): float|int
    {
        $tarif = Tarif::find($idTarif);
        $price = 0;
        if ($consultationRequest->consultationSheet->subscription->is_subscriber) {
            $price = $price = Currency::DEFAULT_CURRENCY == 'CDF' ?
                ($tarif->subscriber_price * $qty) * $consultationRequest->rate->rate
                : $tarif->subscriber_price * $qty;
        } else {
            $price = Currency::DEFAULT_CURRENCY == 'CDF' ?
                ($tarif->price_private * $qty) * $consultationRequest->rate->rate :
                $tarif->price_private * $qty;
        }
        return $price;
    }

    public function getTotalTarifInvoiceByCategory(ConsultationRequest $consultationRequest, CategoryTarif $categoryTarif): float|int
    {
        $total = 0;
        foreach ($categoryTarif->getConsultationTarifItemls($consultationRequest, $categoryTarif) as $item) {
            $total += $categoryTarif->getTotalPrice($consultationRequest, $item->qty, $item->id_tarif);
        }
        return $total;
    }
}
