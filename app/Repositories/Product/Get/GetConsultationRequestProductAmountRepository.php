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
    public static  function getProductAmountByDay(
        int|null    $idSubscription,
        string|null $q,
        string|null $sortBy,
        bool|null   $sortAsc,
        int|null    $per_page = 10,
        int|null    $source_id,
        bool|null    $is_hospitalized,
        string|null $date,
        string|null $currency
    ): int|float {
        $filters = self::filters(
            $idSubscription,
            $q,
            $sortBy,
            $sortAsc,
            $source_id,
            $is_hospitalized
        );
        $amount = 0;
        $consultationRequests = ConsultationRequest::query()
            ->reusable($filters)
            ->whereDate('consultation_requests.created_at', $date)
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
    public static function getProductAmountByMonth($month, $year, $idSubscription, $currency): int|float
    {
        $amount = 0;
        $consultationRequests = ConsultationRequest::whereMonth('consultation_requests.created_at', $month)
            ->join('consultation_sheets', 'consultation_sheets.id', 'consultation_requests.consultation_sheet_id')
            ->where('consultation_sheets.hospital_id', Hospital::DEFAULT_HOSPITAL())
            //->where('consultation_sheets.source_id', Source::DEFAULT_SOURCE())
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
                ]
            )
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
    public static function getProductCountByMonth($month, $year, $idSubscription): int|float
    {
        return ConsultationRequest::whereMonth('consultation_requests.created_at', $month)
            ->join('consultation_sheets', 'consultation_sheets.id', 'consultation_requests.consultation_sheet_id')
            ->where('consultation_sheets.hospital_id', Hospital::DEFAULT_HOSPITAL())
            //->where('consultation_sheets.source_id', Source::DEFAULT_SOURCE())
            ->where('consultation_sheets.subscription_id', $idSubscription)
            ->whereYear('consultation_requests.created_at', $year)
            ->count();
    }
    //getProductAmountByMonth
    public static function getProductAmountByPeriod(
        $startDate,
        $endDate,
        $idSubscription,
        $currency
    ): int|float {
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

    /**
     * Get consultation request product amount
     * @return int|float
     */
    public static function getProductCountHospitalize($month, $year, $idSubscription): int|float
    {
        return  ConsultationRequest::whereMonth('consultation_requests.created_at', $month)
            ->join('consultation_sheets', 'consultation_sheets.id', 'consultation_requests.consultation_sheet_id')
            ->where('consultation_sheets.hospital_id', Hospital::DEFAULT_HOSPITAL())
            ->where('consultation_sheets.source_id', Source::DEFAULT_SOURCE())
            ->where('consultation_sheets.subscription_id', $idSubscription)
            ->whereYear('consultation_requests.created_at', $year)
            ->where('consultation_requests.is_hospitalized', true)
            ->select('consultation_requests.*')
            ->with(['consultation', 'rate'])
            ->count();
    }

    private static function filters(
        int    $idSubscription,
        string|null $q,
        string|null $sortBy,
        bool |null  $sortAsc,
        int |null   $source_id,
        bool|null    $is_hospitalized,
    ): array {
        return [
            'id_subscription' => $idSubscription,
            'sort_by' => $sortBy,
            'sort_asc' => $sortAsc,
            'q' => $q,
            'source_id' => $source_id,
            'is_hospitalized' => $is_hospitalized,
        ];
    }
}
