<?php

namespace App\Repositories\Tarif;

use App\Models\CategoryTarif;
use App\Models\ConsultationRequest;
use App\Models\Hospital;

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
}
