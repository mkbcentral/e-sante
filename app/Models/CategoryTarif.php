<?php

namespace App\Models;

use App\Repositories\OutpatientBill\GetOutpatientRepository;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class CategoryTarif extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'hospital_id', 'source_id'];

    public function tarifs(): HasMany
    {
        return $this->hasMany(Tarif::class,);
    }

    public function getConsultationTarifItems(ConsultationRequest $consultationRequest, CategoryTarif $categoryTarif): Collection
    {

        return DB::table('consultation_request_tarif')
            ->join('tarifs', 'tarifs.id', '=', 'consultation_request_tarif.tarif_id')
            ->join('category_tarifs', 'category_tarifs.id', '=', 'tarifs.category_tarif_id')
            ->select(
                'consultation_request_tarif.*',
                'tarifs.name',
                'tarifs.price_private',
                'tarifs.subscriber_price',
                'tarifs.id as id_tarif',
                'category_tarifs.id as category_id'
            )
            ->where('consultation_request_tarif.consultation_request_id', $consultationRequest->id)
            ->where('category_tarifs.id', $categoryTarif->id)
            ->where('category_tarifs.hospital_id', Hospital::DEFAULT_HOSPITAL())
            ->get();
    }

    public function getUnitPriceCDF(ConsultationRequest $consultationRequest, $idTarif): float|int
    {
        $tarif = Tarif::find($idTarif);
        $price = 0;
        if ($consultationRequest->consultationSheet->subscription->is_subscriber) {
            $price = $tarif->subscriber_price * $consultationRequest->rate->rate;
        } else {
            $price =  $tarif->price_private * $consultationRequest->rate->rate;
        }
        return $price;
    }

    public function getUnitPriceUSD(ConsultationRequest $consultationRequest, $idTarif): float|int
    {
        $tarif = Tarif::find($idTarif);
        $price = 0;
        if ($consultationRequest->consultationSheet->subscription->is_subscriber) {
            $price = $tarif->subscriber_price;
        } else {
            $price =  $tarif->price_private;
        }
        return $price;
    }

    public function getTotalPriceCDF(ConsultationRequest $consultationRequest, int $qty, int $idTarif): float|int
    {
        $tarif = Tarif::find($idTarif);
        $price = 0;
        if ($consultationRequest->consultationSheet->subscription->is_subscriber) {
            ($tarif->subscriber_price * $qty) * $consultationRequest->rate->rate;
        } else {
            $price = ($tarif->price_private * $qty) * $consultationRequest->rate->rate;
        }
        return $price;
    }

    public function getTotalPriceUSD(ConsultationRequest $consultationRequest, int $qty, int $idTarif): float|int
    {
        $tarif = Tarif::find($idTarif);
        $price = 0;
        if ($consultationRequest->consultationSheet->subscription->is_subscriber) {
            ($tarif->subscriber_price * $qty);
        } else {
            $price = ($tarif->price_private * $qty);
        }
        return $price;
    }

    public function getTotalTarifInvoiceByCategoryCDF(ConsultationRequest $consultationRequest, CategoryTarif $categoryTarif): float|int
    {
        $total = 0;
        foreach ($categoryTarif->getConsultationTarifItems($consultationRequest, $categoryTarif) as $item) {
            $total += $categoryTarif->getTotalPriceCDF($consultationRequest, $item->qty, $item->id_tarif);
        }
        return $total;
    }
    public function getTotalTarifInvoiceByCategoryUSD(ConsultationRequest $consultationRequest, CategoryTarif $categoryTarif): float|int
    {
        $total = 0;
        foreach ($categoryTarif->getConsultationTarifItems($consultationRequest, $categoryTarif) as $item) {
            $total += $categoryTarif->getTotalPriceUSD($consultationRequest, $item->qty, $item->id_tarif);
        }
        return $total;
    }

    public function getOutpatientBillTarifItems(OutpatientBill $outpatientBill, CategoryTarif $categoryTarif): Collection
    {

        return DB::table('outpatient_bill_tarif')
        ->join('tarifs', 'tarifs.id', '=', 'outpatient_bill_tarif.tarif_id')
        ->join('category_tarifs', 'category_tarifs.id', '=', 'tarifs.category_tarif_id')
        ->select(
            'outpatient_bill_tarif.*',
            'tarifs.name',
            'tarifs.abbreviation',
            'tarifs.price_private',
            'tarifs.id as id_tarif',
            'category_tarifs.id as category_id'
        )
            ->where('outpatient_bill_tarif.outpatient_bill_id', $outpatientBill->id)
            ->where('category_tarifs.id', $categoryTarif->id)
            ->where('category_tarifs.hospital_id', Hospital::DEFAULT_HOSPITAL())
            ->get();
    }

    public function getAmountOutpatientBillByCategory(int $outpatientBillId):int|float{
        $total=0;
        $tarifs=GetOutpatientRepository::
        getOutpatientBillTarifItemByCategoryTarif($outpatientBillId,$this->id);
        foreach ($tarifs as $tarif) {
           $total+=$tarif->price_private*$tarif->qty;
        }
        return $total;
    }
}
