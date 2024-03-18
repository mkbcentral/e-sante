<?php

namespace App\Repositories\Product\Get;

use App\Models\ConsultationRequest;
use App\Models\Hospital;
use App\Models\Source;

class GetConsultationRequestProductAmountRepository
{
    /**
     * Get consultation request product amount
     * @return int|float
     */
    public static  function getProductAmountByDay($date, $idSubscription, $currency): int|float
    {

        $amount = 0;
        $consultationRequests = ConsultationRequest::whereDate('consultation_requests.created_at', $date)

            ->join('consultation_sheets', 'consultation_sheets.id', 'consultation_requests.consultation_sheet_id')
            ->where('consultation_sheets.hospital_id', Hospital::DEFAULT_HOSPITAL())
            ->where('consultation_sheets.source_id', Source::DEFAULT_SOURCE())
            ->where('consultation_sheets.subscription_id', $idSubscription)
            ->select('consultation_requests.*')
            ->with(['consultation', 'rate'])
            ->get();
        foreach ($consultationRequests as $consultationRequest) {
            if ($currency == 'CDF') {
                $amount += $consultationRequest->getTotalProductCDF();
            } else {
                $amount += $consultationRequest->getTotalProductUSD();
            }
        }
        return $amount;
    }

    /**
     * Get consultation request product amount
     * @return int|float
     */
    public static function getProductAmountByMonth($month, $year, $idSubscription,$currency): int|float
    {
        $amount = 0;
        $consultationRequests = ConsultationRequest::whereMonth('consultation_requests.created_at', $month)
            ->join('consultation_sheets', 'consultation_sheets.id', 'consultation_requests.consultation_sheet_id')
            ->where('consultation_sheets.hospital_id', Hospital::DEFAULT_HOSPITAL())
            ->where('consultation_sheets.source_id', Source::DEFAULT_SOURCE())
            ->where('consultation_sheets.subscription_id', $idSubscription)
            ->whereYear('consultation_requests.created_at', $year)
            ->select('consultation_requests.*')
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
                ])
            ->get();
        foreach ($consultationRequests as $consultationRequest) {
            if ($currency == 'CDF') {
                $amount += $consultationRequest->getTotalProductCDF();
            } else {
                $amount += $consultationRequest->getTotalProductUSD();
            }
        }
        return $amount;
    }
    //
    public static function getProductAmountByPeriod($startDate, $endDate, $idSubscription,$currency): int|float
    {
        $amount = 0;
        $consultationRequests = ConsultationRequest::whereBetween('consultation_requests.created_at', [$startDate, $endDate])
            ->join('consultation_sheets', 'consultation_sheets.id', 'consultation_requests.consultation_sheet_id')
            ->where('consultation_sheets.hospital_id', Hospital::DEFAULT_HOSPITAL())
            ->where('consultation_sheets.source_id', Source::DEFAULT_SOURCE())
            ->where('consultation_sheets.subscription_id', $idSubscription)
            ->select('consultation_requests.*')
            ->with(['consultation', 'rate'])
            ->get();
        foreach ($consultationRequests as $consultationRequest) {
            if ($currency == 'CDF') {
                $amount += $consultationRequest->getTotalProductCDF();
            } else {
                $amount += $consultationRequest->getTotalProductUSD();
            }
        }
        return $amount;;
    }

    /**
     * Get consultation request product amount
     * @return int|float
     */
    public static function getProductAmountHospitalize($month, $year, $idSubscription, $currency): int|float
    {
        $amount = 0;
        $consultationRequests = ConsultationRequest::whereMonth('consultation_requests.created_at', $month)
            ->join('consultation_sheets', 'consultation_sheets.id', 'consultation_requests.consultation_sheet_id')
            ->where('consultation_sheets.hospital_id', Hospital::DEFAULT_HOSPITAL())
            ->where('consultation_sheets.source_id', Source::DEFAULT_SOURCE())
            ->where('consultation_sheets.subscription_id', $idSubscription)
            ->whereYear('consultation_requests.created_at', $year)
            ->where('consultation_requests.is_hospitalized', true)
            ->select('consultation_requests.*')
            ->with(['consultation', 'rate'])
            ->get();
        foreach ($consultationRequests as $consultationRequest) {
            if ($currency == 'CDF') {
                $amount += $consultationRequest->getTotalProductCDF();
            } else {
                $amount += $consultationRequest->getTotalProductUSD();
            }
        }
        return $amount;
    }

}
