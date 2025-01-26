<?php

namespace App\Repositories\Sheet\Get;

use App\Models\ConsultationRequest;
use App\Models\Hospital;
use App\Models\Source;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class GetConsultationRequestRepository
{
    /**
     * Get all consultation request by date
     */
    public static function getConsultationRequestByDate(
        int|null    $idSubscription,
        string|null $q,
        string|null $sortBy,
        bool|null   $sortAsc,
        int|null    $per_page = 10,
        int|null    $source_id,
        bool|null    $is_hospitalized,
        string|null $date,

    ): mixed {
        $filters = self::filters(
            $idSubscription,
            $q,
            $source_id,
            $is_hospitalized
        );
        return ConsultationRequest::query()
            ->whereDate('consultation_requests.created_at', $date) //is_hospitalized
            ->where('consultation_sheets.source_id', Source::DEFAULT_SOURCE())
            ->reusable($filters)
            ->orderBy($sortBy, $sortAsc ? 'ASC' : 'DESC')
            ->paginate($per_page);
    }
    /**
     * Get all consultation request by month
     */
    public static function getConsultationRequestByMonth(
        int|null    $idSubscription,
        string|null $q,
        string|null $sortBy,
        bool|null   $sortAsc,
        int|null    $per_page,
        string|null $month,
        string|null $year,
        int|null    $source_id,
        bool|null    $is_hospitalized,
    ): mixed {
        $filters = self::filters(
            $idSubscription,
            $q,
            $source_id,
            $is_hospitalized
        );

        return ConsultationRequest::query()
            ->whereMonth('consultation_requests.created_at', $month)
            ->whereYear('consultation_requests.created_at', $year)
            ->reusable($filters)
            ->orderBy($sortBy, $sortAsc ? 'ASC' : 'DESC')
            ->paginate($per_page);
    }

    /**
     * Get all consultation request by date
     * @param int $idSubscription
     * @param string $q
     * @param string $sortBy
     * @param bool $sortAsc
     * @param int $per_page
     * @return mixed
     */
    public static function getConsultationRequestByPeriod(
        int|null    $idSubscription,
        string|null $q,
        string|null $sortBy,
        bool|null   $sortAsc,
        int|null    $per_page = 10,
        string|null $startDate,
        string|null $endDate,
        int|null    $source_id,
        bool|null    $is_hospitalized,
    ): mixed {
        $filters = self::filters(
            $idSubscription,
            $q,
            $source_id,
            $is_hospitalized
        );
        return ConsultationRequest::query()
            ->reusable($filters)
            ->whereBetween('consultation_requests.created_at', [$startDate, $endDate])
            ->orderBy($sortBy, $sortAsc ? 'ASC' : 'DESC')
            ->paginate($per_page);
    }

    /**
     * Get consultationRequest tarif items by category tarif id
     * @param int $consultationRequestId
     * @param int $categoryTarifId
     * @return Collection
     */
    public static function getConsultationTarifItemByCategoryTarif(int $consultationRequestId, int $categoryTarifId): \Illuminate\Support\Collection
    {
        return DB::table('consultation_request_tarif')
            ->join('tarifs', 'tarifs.id', 'consultation_request_tarif.tarif_id')
            ->join('category_tarifs', 'category_tarifs.id', 'tarifs.category_tarif_id')
            ->where('consultation_request_tarif.consultation_request_id', $consultationRequestId)
            ->where('category_tarifs.id', $categoryTarifId)
            ->select('consultation_request_tarif.*', 'tarifs.name', 'tarifs.abbreviation')
            ->get();
    }

    public static function getCountConsultationRequestByDate(
        int    $idSubscription,
        int|null    $source_id,
        string $date,
        bool|null    $is_hospitalized,
    ): int|float {
        $filters = self::filters(
            $idSubscription,
            null,
            $source_id,
            $is_hospitalized
        );
        return ConsultationRequest::query()
            ->reusable($filters)
            ->whereDate('consultation_requests.created_at', $date)
            ->count();
    }

    public static function getCountConsultationRequestByMonth(
        int    $idSubscription,
        string $month,
        int|null   $source_id,
        string $year,
        bool|null    $is_hospitalized,
    ): int|float {
        $filters = self::filters(
            $idSubscription,
            null,
            $source_id,
            $is_hospitalized
        );
        return ConsultationRequest::query()
            ->reusable($filters)
            ->whereMonth('consultation_requests.created_at', $month)
            ->whereYear('consultation_requests.created_at', $year)
            ->count();
    }



    public static function getCountConsultationRequestBetweenDate(
        int    $idSubscription,
        int|null   $source_id,
        string $startDate,
        string $endDate,
        bool|null    $is_hospitalized,
    ): int|float {
        $filters = self::filters(
            $idSubscription,
            null,
            $source_id,
            $is_hospitalized
        );
        return ConsultationRequest::query()
            ->reusable($filters)
            ->whereBetween('consultation_requests.created_at', [$startDate, $endDate])
            ->count();
    }


    /**
     * Get all consultation request hospitalize  by date*
     */
    public static function getConsultationRequestHospitalizedToBordereau(
        $idSubscription,
        $source_id,
        $date,
        int|null $user_id,
    ): mixed {
        $filters = self::filters(
            $idSubscription,
            null,
            $source_id,
            true
        );
        return ConsultationRequest::query()
            ->reusable($filters)
            ->when($user_id, function ($q, $val) {
                return $q->where('perceived_by', $val);
            })
            ->where('consultation_requests.is_finished', true)
            ->whereDate('consultation_requests.paid_at', $date)
            ->get();
    }
    /**
     * Get all consultation request hospitalize amount by date*
     */
    public static function getRequestHospitalizedToBordereauDateAmount(
        $idSubscription,
        $date,
        $year,
        $currency,
        int|null $user_id,
        int|null $source_id
    ): mixed {
        $total = 0;
        $filters = self::filters(
            $idSubscription,
            null,
            $source_id,
            true
        );
        $consultationRequests = ConsultationRequest::query()
            ->reusable($filters)
            ->where('perceived_by', Auth::id())
            ->where('consultation_requests.is_paid', true)
            ->whereDate('consultation_requests.paid_at', $date)
            ->get();
        return self::loop($consultationRequests, $currency);
    }
    /**
     * Get all consultation request hospitalize  by month*
     */
    public static function getConsultationRequestHospitalizedToBordereauMonth(
        $idSubscription,
        $month,
        $year,
        int|null $user_id,
        int|null $source_id
    ): mixed {
        $filters = self::filters(
            $idSubscription,
            null,
            $source_id,
            true
        );
        return ConsultationRequest::query()
            ->reusable($filters)
            ->whereMonth('consultation_requests.paid_at', $month)
            ->whereYear('consultation_requests.paid_at', $year)
            ->when($user_id, function ($q, $val) {
                return $q->where('perceived_by', $val);
            })
            ->where('consultation_requests.is_finished', true)
            ->where('consultation_requests.is_hospitalized', true)
            ->get();
    }
    /**
     * Get all consultation request hospitalize amount by date*
     */
    public static function getRequestHospitalizedToBordereauMonthAmount(
        $idSubscription,
        $month,
        $year,
        $currency,
        int|null $user_id,
        int|null $source_id
    ): mixed {
        $total = 0;
        $filters = self::filters(
            $idSubscription,
            null,
            null,
            null,
            $source_id,
            true
        );
        $consultationRequests = ConsultationRequest::query()
            ->reusable($filters)
            ->whereMonth('consultation_requests.paid_at', $month)
            ->whereYear('consultation_requests.paid_at', $year)
            ->when($user_id, function ($q, $val) {
                return $q->where('perceived_by', $val);
            })
            ->where('consultation_requests.is_finished', true)
            ->where('consultation_requests.is_hospitalized', true)
            ->get();

        return self::loop($consultationRequests, $currency);
    }

    //Get consultation request check is closing
    public static function getConsultationRequestChechkIfIsClosing(
        int $selectedIndex,
        string $month_name,
        string $year

    ): ?ConsultationRequest {
        return ConsultationRequest::join(
            'consultation_sheets',
            'consultation_sheets.id',
            'consultation_requests.consultation_sheet_id'
        )
            ->where('consultation_sheets.subscription_id', $selectedIndex)
            ->select('consultation_requests.*')
            ->with(['consultationSheet.subscription'])
            ->where('consultation_sheets.hospital_id', Hospital::DEFAULT_HOSPITAL())
            ->whereMonth('consultation_requests.created_at', $month_name)
            ->whereYear('consultation_requests.created_at', $year)
            ->orderBy('consultation_requests.id', 'ASC')
            ->where('consultation_requests.is_printed', true)
            ->orderBy('consultation_requests.created_at', 'DESC')
            ->first();
    }

    private static function filters(
        int    $idSubscription,
        string|null $q,
        int |null   $source_id,
        bool|null    $is_hospitalized,
    ): array {
        return [
            'id_subscription' => $idSubscription,
            'q' => $q,
            'source_id' => $source_id,
            'is_hospitalized' => $is_hospitalized,
        ];
    }

    private static function loop(Collection $consultationRequests, string $currency): int|float
    {
        $total = 0;
        foreach ($consultationRequests as $consultationRequest) {
            if ($consultationRequest->currency != null) {
                if ($currency == 'USD') {
                    $total += $consultationRequest->getTotalInvoiceUSD();
                } else {
                    $total = 0;
                }
                if ($currency == 'CDF') {
                    $total += $consultationRequest->getTotalInvoiceCDF();
                } else {
                    $total = 0;
                }
            } else {
                if ($currency == 'USD') {
                    $total += $consultationRequest->consultationRequestCurrency->amount_usd;
                } else {
                    $total += $consultationRequest->consultationRequestCurrency->amount_cdf;
                }
            }
        }
        return $total;
    }
}
