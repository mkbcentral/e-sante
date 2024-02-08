<?php

namespace App\Repositories\Sheet\Get;

use App\Models\ConsultationRequest;
use App\Models\Hospital;
use App\Models\Source;

class GetConsultationRequestionAmountRepository
{
    /**
     * Get amount for consultation request by date CDF
     * @param $date
     * @return int|float
     */
    public static function getTotalByDateCDF($date, $idSubscription): int|float
    {
        $total = 0;
        $consultationRequests = ConsultationRequest::whereDate('consultation_requests.created_at', $date)

            ->join('consultation_sheets', 'consultation_sheets.id', 'consultation_requests.consultation_sheet_id')->where('consultation_sheets.hospital_id', Hospital::DEFAULT_HOSPITAL())
            ->where('consultation_sheets.source_id', Source::DEFAULT_SOURCE())
            ->where('consultation_sheets.subscription_id', $idSubscription)
            ->select('consultation_requests.*')
            ->with(['consultation', 'rate'])
            ->get();
        foreach ($consultationRequests as $consultationRequest) {
            $total += $consultationRequest->getTotalInvoiceCDF();
        }
        return $total;
    }

    /**
     * Get amount for consultation request by date CDF
     * @param $date
     * @return int|float
     */
    public static function getTotalByDateUSD($date, $idSubscription): int|float
    {
        $total = 0;
        $consultationRequests = ConsultationRequest::whereDate('consultation_requests.created_at', $date)

            ->join('consultation_sheets', 'consultation_sheets.id', 'consultation_requests.consultation_sheet_id')->where('consultation_sheets.hospital_id', Hospital::DEFAULT_HOSPITAL())
            ->where('consultation_sheets.source_id', Source::DEFAULT_SOURCE())
            ->where('consultation_sheets.subscription_id', $idSubscription)
            ->select('consultation_requests.*')
            ->with(['consultation', 'rate'])
            ->get();
        foreach ($consultationRequests as $consultationRequest) {
            $total += $consultationRequest->getTotalInvoiceUSD();
        }
        return $total;
    }

    /**
     * get consultation requests by month CDF
     * @param $month
     * @param $year
     * @return int|float
     */

    public static function getTotalByMonthCDF($month, $year, $idSubscription): int|float
    {
        $total = 0;
        $consultationRequests = ConsultationRequest::whereMonth('consultation_requests.created_at', $month)
            ->join('consultation_sheets', 'consultation_sheets.id', 'consultation_requests.consultation_sheet_id')
            ->where('consultation_sheets.hospital_id', Hospital::DEFAULT_HOSPITAL())
            ->where('consultation_sheets.source_id', Source::DEFAULT_SOURCE())
            ->where('consultation_sheets.subscription_id', $idSubscription)
            ->whereYear('consultation_requests.created_at', $year)
            ->select('consultation_requests.*')
            ->with(['consultation', 'rate'])
            ->get();
        foreach ($consultationRequests as $consultationRequest) {
            $total += $consultationRequest->getTotalInvoiceCDF();
        }
        return $total;
    }

    /**
     * Get consultation requests by month USD
     * @param $month
     * @param $year
     * @return int|float
     */
    public static function getTotalByMonthUSD($month, $year, $idSubscription): int|float
    {
        $total = 0;
        $consultationRequests = ConsultationRequest::whereMonth('consultation_requests.created_at', $month)
            ->join('consultation_sheets', 'consultation_sheets.id', 'consultation_requests.consultation_sheet_id')
            ->where('consultation_sheets.hospital_id', Hospital::DEFAULT_HOSPITAL())
            ->where('consultation_sheets.source_id', Source::DEFAULT_SOURCE())
            ->where('consultation_sheets.subscription_id', $idSubscription)
            ->whereYear('consultation_requests.created_at', $year)
            ->select('consultation_requests.*')
            ->with(['consultation', 'rate'])
            ->get();
        foreach ($consultationRequests as $consultationRequest) {
            $total += $consultationRequest->getTotalInvoiceUSD();
        }
        return $total;
    }

    /**
     * Get consultation request amount by period CDF
     * @param $startDate
     * @param $endDate
     * @return int|float
     */
    public static function getTotalPeriodCDF($startDate, $endDate, $idSubscription): int|float
    {
        $total = 0;
        $consultationRequests = ConsultationRequest::whereBetween('consultation_requests.created_at', [$startDate, $endDate])
            ->join('consultation_sheets', 'consultation_sheets.id', 'consultation_requests.consultation_sheet_id')
            ->where('consultation_sheets.hospital_id', Hospital::DEFAULT_HOSPITAL())
            ->where('consultation_sheets.source_id', Source::DEFAULT_SOURCE())
            ->where('consultation_sheets.subscription_id', $idSubscription)
            ->select('consultation_requests.*')
            ->with(['consultation', 'rate'])
            ->get();
        foreach ($consultationRequests as $consultationRequest) {
            $total += $consultationRequest->getTotalInvoiceCDF();
        }
        return $total;
    }

    /**
     * Get consultation request amount by period USD
     * @param $startDate
     * @param $endDate
     * @return int|float
     */
    public static function getTotalPeriodUSD($startDate, $endDate, $idSubscription): int|float
    {
        $total = 0;
        $consultationRequests = ConsultationRequest::whereBetween('consultation_requests.created_at', [$startDate, $endDate])
            ->join('consultation_sheets', 'consultation_sheets.id', 'consultation_requests.consultation_sheet_id')
            ->where('consultation_sheets.hospital_id', Hospital::DEFAULT_HOSPITAL())
            ->where('consultation_sheets.source_id', Source::DEFAULT_SOURCE())
            ->where('consultation_sheets.subscription_id', $idSubscription)
            ->select('consultation_requests.*')
            ->with(['consultation', 'rate'])
            ->get();
        foreach ($consultationRequests as $consultationRequest) {
            $total += $consultationRequest->getTotalInvoiceUSD();
        }
        return $total;
    }

    public static function getTotalHospitalize($month, $year, $idSubscription,$currency): int|float
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
                $amount += $consultationRequest->getTotalInvoiceCDF();
            } else {
                $amount += $consultationRequest->getTotalInvoiceUSD();
            }
        }
        return $amount;
    }



}
