<?php

namespace App\Repositories\Sheet\Get;

use App\Models\ConsultationRequest;
use App\Models\Hospital;
use App\Models\Source;
use Carbon\Carbon;

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
            $total += $consultationRequest->getTotalInvoiceCDF();
        }
        return $total;
    }
    public static function getTotalByMonthAllSourceCDF($month, $year, $idSubscription): int|float
    {
        $total = 0;
        $consultationRequests = ConsultationRequest::whereMonth('consultation_requests.created_at', $month)
            ->join('consultation_sheets', 'consultation_sheets.id', 'consultation_requests.consultation_sheet_id')
            ->where('consultation_sheets.hospital_id', Hospital::DEFAULT_HOSPITAL())
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
            $total += $consultationRequest->getTotalInvoiceUSD();
        }
        return $total;
    }

    public static function getTotalByMonthAllSourceUSD($month, $year, $idSubscription): int|float
    {
        $total = 0;
        $consultationRequests = ConsultationRequest::whereMonth('consultation_requests.created_at', $month)
            ->join('consultation_sheets', 'consultation_sheets.id', 'consultation_requests.consultation_sheet_id')
            ->where('consultation_sheets.hospital_id', Hospital::DEFAULT_HOSPITAL())
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
            $total += $consultationRequest->getTotalInvoiceUSD();
        }
        return $total;
    }

    public static function getTotalHospitalize($month, $year, $idSubscription, $currency): int|float
    {
        $amount = 0;
        $consultationRequests = ConsultationRequest::whereMonth('consultation_requests.created_at', $month)
            ->join('consultation_sheets', 'consultation_sheets.id', 'consultation_requests.consultation_sheet_id')
            ->where('consultation_sheets.hospital_id', Hospital::DEFAULT_HOSPITAL())
            ->where('consultation_sheets.source_id', Source::DEFAULT_SOURCE())
            ->where('consultation_sheets.subscription_id', $idSubscription)
            ->whereYear('consultation_requests.created_at', $year)
            ->where('consultation_requests.is_hospitalized', true)
            ->where('consultation_requests.is_finished', true)
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
                $amount += $consultationRequest->getTotalInvoiceCDF();
            } else {
                $amount += $consultationRequest->getTotalInvoiceUSD();
            }
        }
        return $amount;
    }


    public static function getTotalHospitalizeUSD(): int|float
    {
        $consultationRequests = ConsultationRequest::query()
            ->join('consultation_sheets', 'consultation_sheets.id', 'consultation_requests.consultation_sheet_id')
            ->select('consultation_requests.*')
            ->where('consultation_sheets.hospital_id', Hospital::DEFAULT_HOSPITAL())
            ->where('consultation_sheets.source_id', auth()->user()->source->id)
            ->whereDate('consultation_requests.paid_at', Carbon::now())
            ->where('consultation_requests.is_finished', true)
            ->where('consultation_requests.is_hospitalized', true)
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

        $amount = 0;
        foreach ($consultationRequests as  $consultationRequest) {
            if ($consultationRequest->currency_id != null && $consultationRequest->currency->name == "USD") {
                $amount += $consultationRequest->getTotalInvoiceUSD();
            } else {
                $amount += $consultationRequest?->consultationRequestCurrency?->amount_usd;
            }
        }
        return $amount;
    }

    public static function getTotalHospitalizeCDF(): int|float
    {
        $consultationRequests = ConsultationRequest::query()
            ->join('consultation_sheets', 'consultation_sheets.id', 'consultation_requests.consultation_sheet_id')
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
            ->select('consultation_requests.*')
            ->where('consultation_sheets.hospital_id', Hospital::DEFAULT_HOSPITAL())
            ->where('consultation_sheets.source_id', auth()->user()->source->id)
            ->whereDate('consultation_requests.paid_at', Carbon::now())
            ->where('consultation_requests.is_finished', true)
            ->where('consultation_requests.is_hospitalized', true)
            ->get();

        $amount = 0;
        foreach ($consultationRequests as  $consultationRequest) {
            if ($consultationRequest->currency_id != null
            && $consultationRequest->currency->name == "CDF") {
                $amount += $consultationRequest->getTotalInvoiceCDF();
            } else {
                $amount += $consultationRequest?->consultationRequestCurrency?->amount_cdf;
            }
        }
        return $amount;
    }
}
