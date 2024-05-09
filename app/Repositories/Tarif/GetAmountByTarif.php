<?php

namespace App\Repositories\Tarif;

use App\Models\CategoryTarif;
use App\Models\ConsultationRequest;
use App\Models\Hospital;
use App\Models\OutpatientBill;
use App\Repositories\OutpatientBill\GetOutpatientRepository;

class GetAmountByTarif
{

    public static function getAmountByTarifByMonth($month, $idSubscription):int|float
    {
        $amount = 0;
        $consultationRequests = ConsultationRequest::
            whereMonth('consultation_requests.created_at',$month)
            ->join('consultation_sheets', 'consultation_sheets.id',
             'consultation_requests.consultation_sheet_id')
            ->where('consultation_sheets.hospital_id', Hospital::DEFAULT_HOSPITAL())
            ->where('consultation_sheets.subscription_id', $idSubscription)
            ->select('consultation_requests.*')
            ->with(['consultation', 'rate'])
            ->get();
        $category = CategoryTarif::find(1);
        foreach ($consultationRequests as $consultationRequest) {
            foreach ($category->getConsultationTarifItems(
                $consultationRequest, $category) as $item) {
               $amount+=$item->subscriber_price;
            }
        }
        return $amount;
    }
    public static function getAmountByTarifByMonthHospitalize($month, $idSubscription): int|float
    {
        $amount = 0;
        $consultationRequests = ConsultationRequest::whereMonth('consultation_requests.created_at', $month)
            ->join(
                'consultation_sheets',
                'consultation_sheets.id',
                'consultation_requests.consultation_sheet_id'
            )
            ->where('consultation_sheets.hospital_id', Hospital::DEFAULT_HOSPITAL())
            ->where('consultation_sheets.subscription_id', $idSubscription)
            ->where('consultation_requests.is_hospitalized', true)
            ->select('consultation_requests.*')
            ->with(['consultation', 'rate'])
            ->get();
        $category = CategoryTarif::find(1);
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

    public static function getAmountoutpatientByMonth($month): int|float
    {
        $amount = 0;
         $outpatientBills= OutpatientBill::orderBy('created_at', 'DESC')
            ->whereMonth('created_at', $month)
            ->where('is_validated', true)
            ->get();
        $category = CategoryTarif::find(1);

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
}
