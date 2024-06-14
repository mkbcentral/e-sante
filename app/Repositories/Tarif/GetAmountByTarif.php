<?php

namespace App\Repositories\Tarif;

use App\Models\CategoryTarif;
use App\Models\ConsultationRequest;
use App\Models\Hospital;
use App\Models\OutpatientBill;
use Illuminate\Support\Collection;

class GetAmountByTarif
{
    /**
     * Get consultation amount
     */
    public static function getAmountConsultationByMonth($month, $idSubscription): int|float
    {
        $amount = 0;
        $consultationRequests = SELF::getCollectionData($month, $idSubscription);
        foreach ($consultationRequests as $consultationRequest) {
            $amount += $consultationRequest->getConsultationPriceUSD();
        }
        return $amount;
    }
    //Get Nursing amount
    public static function getAmountNursingByMonth($month, $idSubscription): int|float
    {
        $amount = 0;
        $consultationRequests = SELF::getCollectionData($month, $idSubscription);
        foreach ($consultationRequests as $consultationRequest) {
            $amount += $consultationRequest->getNursingAmountUSD();
        }
        return $amount;
    }
    //Get hospitalization amount
    public static function getAmountHospitalizationByMonth($month, $idSubscription): int|float
    {
        $amount = 0;
        $consultationRequests = SELF::getCollectionData($month, $idSubscription);
        foreach ($consultationRequests as $consultationRequest) {
            $amount += $consultationRequest->getHospitalizationAmountUSD();
        }
        return $amount;
    }

    //get By tarif amount
    public static function getAmountByTarifByMonth($month, $idSubscription, $categoryId): int|float
    {
        $amount = 0;
        $consultationRequests = SELF::getCollectionData($month, $idSubscription);
        $category = CategoryTarif::find($categoryId);
        foreach ($consultationRequests as $consultationRequest) {
            foreach ($category->getConsultationTarifItems($consultationRequest, $category) as $item) {
                $amount += $item->subscriber_price;
            }
        }
        return $amount;
    }
    //Get tarif private hospitalize
    public static function getAmountByTarifByMonthHospitalizePrivate($month, $idSubscription, $categoryId): int|float
    {
        $amount = 0;
        $consultationRequests = SELF::getCollectionData($month, $idSubscription);
        $category = CategoryTarif::find($categoryId);
        foreach ($consultationRequests as $consultationRequest) {
            foreach ($category->getConsultationTarifItems(
                $consultationRequest,
                $category
            ) as $item) {
                $amount += $item->price_private;
            }
        }
        return $amount;
    }
    //Get amount with outpatientBill
    public static function getAmountoutpatientByMonth($month, $categoryId): int|float
    {
        $amount = 0;
        $outpatientBills = OutpatientBill::orderBy('created_at', 'DESC')
            ->whereMonth('created_at', $month)
            ->where('is_validated', true)
            ->get();
        $category = CategoryTarif::find($categoryId);

        foreach ($outpatientBills as $outpatientBill) {
            foreach ($category->getOutpatientBillTarifItems(
                $outpatientBill,
                $category
            ) as $item) {
                $amount += $item->price_private;
            }
        }
        return $amount;
    }
    //Reusable ConsultationResquest Data
    private static function getCollectionData($month, $idSubscription): Collection
    {
        return ConsultationRequest::whereMonth('consultation_requests.created_at', $month)
            ->join(
                'consultation_sheets',
                'consultation_sheets.id',
                'consultation_requests.consultation_sheet_id'
            )
            ->where('consultation_sheets.hospital_id', Hospital::DEFAULT_HOSPITAL())
            ->where('consultation_sheets.subscription_id', $idSubscription)
            ->select('consultation_requests.*')
            ->with(
                [
                    'consultation',
                    'rate',
                    'consultationSheet',
                    'tarifs',
                    'consultationRequestHospitalizations'
                ]
            )
            ->get();
    }
}
