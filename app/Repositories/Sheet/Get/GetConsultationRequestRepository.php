<?php

namespace App\Repositories\Sheet\Get;

use App\Models\ConsultationRequest;
use App\Models\Hospital;
use App\Models\Source;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class GetConsultationRequestRepository
{
    private static string $keytoSearch;

    /**
     * Get all consultation request
     * @param int $idSubscription
     * @param string $q
     * @param string $sortBy
     * @param bool $sortAsc
     * @param int $per_page
     * @return mixed
     */
    public static function getConsultationRequest(
        int    $idSubscription,
        string $q,
        string $sortBy,
        bool   $sortAsc,
        int    $per_page = 10
    ): mixed {
        SELF::$keytoSearch = $q;
        return ConsultationRequest::join('consultation_sheets', 'consultation_sheets.id', 'consultation_requests.consultation_sheet_id')
            ->join('subscriptions', 'subscriptions.id', 'consultation_sheets.subscription_id')
            ->where('consultation_sheets.subscription_id', $idSubscription)
            ->when($q, function ($query) {
                return $query->where(function ($query) {
                    return $query->where('consultation_sheets.name', 'like', '%' . SELF::$keytoSearch . '%')
                        ->orWhere('consultation_sheets.number_sheet', 'like', '%' . SELF::$keytoSearch . '%');
                });
            })
            ->selectRaw('consultation_requests.*,subscriptions.name as subscription_name')
            ->orderBy($sortBy, $sortAsc ? 'ASC' : 'DESC')
            ->select('consultation_requests.*')
            ->with(['consultationSheet', 'rate', 'consultationSheet.source', 'consultation'])
            ->where('consultation_sheets.hospital_id', Hospital::DEFAULT_HOSPITAL())
            ->where('consultation_sheets.source_id', Source::DEFAULT_SOURCE())
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
    public static function getConsultationRequestByDate(
        int    $idSubscription,
        string $q,
        string $sortBy,
        bool   $sortAsc,
        int    $per_page = 10,
        string $date,
        string $year,

    ): mixed {
        SELF::$keytoSearch = $q;
        return ConsultationRequest::join('consultation_sheets', 'consultation_sheets.id', 'consultation_requests.consultation_sheet_id')
            ->join('subscriptions', 'subscriptions.id', 'consultation_sheets.subscription_id')
            ->where('consultation_sheets.subscription_id', $idSubscription)
            ->when($q, function ($query) {
                return $query->where(function ($query) {
                    return $query->where('consultation_sheets.name', 'like', '%' . SELF::$keytoSearch . '%')
                        ->orWhere('consultation_sheets.number_sheet', 'like', '%' . SELF::$keytoSearch . '%');
                });
            })
            ->selectRaw('consultation_requests.*,subscriptions.name as subscription_name')
            ->orderBy($sortBy, $sortAsc ? 'ASC' : 'DESC')
            ->select('consultation_requests.*')
            ->with(['consultationSheet', 'rate', 'consultationSheet.source', 'consultation'])
            ->where('consultation_sheets.hospital_id', Hospital::DEFAULT_HOSPITAL())
            ->where('consultation_sheets.source_id', Source::DEFAULT_SOURCE())
            ->whereDate('consultation_requests.created_at', $date)
            ->whereYear('consultation_requests.created_at', $year) //is_hospitalized
            ->paginate($per_page);
    }
    /**
     * Get all consultation request by month
     * @param int $idSubscription
     * @param string $q
     * @param string $sortBy
     * @param bool $sortAsc
     * @param int $per_page
     * @return mixed
     */
    public static function getConsultationRequestByMonth(
        int    $idSubscription,
        string $q,
        string $sortBy,
        bool   $sortAsc,
        int    $per_page = 10,
        string $month,
        string $year,
    ): mixed {
        SELF::$keytoSearch = $q;
        return ConsultationRequest::join('consultation_sheets', 'consultation_sheets.id', 'consultation_requests.consultation_sheet_id')
            ->join('subscriptions', 'subscriptions.id', 'consultation_sheets.subscription_id')
            ->where('consultation_sheets.subscription_id', $idSubscription)
            ->when($q, function ($query) {
                return $query->where(function ($query) {
                    return $query->where('consultation_sheets.name', 'like', '%' . SELF::$keytoSearch . '%')
                        ->orWhere('consultation_sheets.number_sheet', 'like', '%' . SELF::$keytoSearch . '%');
                });
            })
            ->selectRaw('consultation_requests.*,subscriptions.name as subscription_name')
            ->orderBy($sortBy, $sortAsc ? 'ASC' : 'DESC')
            ->with(
                [
                    'consultationSheet.subscription',
                    'consultationSheet.source',
                    'rate',
                    'consultation',
                    'tarifs',
                    'consultationRequestHospitalizations',
                    'consultationRequestNursings',
                    'products'
                ]
            )
            ->where('consultation_sheets.hospital_id', Hospital::DEFAULT_HOSPITAL())
            ->where('consultation_sheets.source_id', Source::DEFAULT_SOURCE())
            ->whereMonth('consultation_requests.created_at', $month)
            ->whereYear('consultation_requests.created_at', $year)
            ->paginate($per_page);
    }

    public static function getConsultationRequestByMonthAllSource(
        int    $idSubscription,
        string $q,
        string $sortBy,
        bool   $sortAsc,
        int    $per_page = 10,
        string $month,
        string $year,
    ): mixed {
        SELF::$keytoSearch = $q;
        return ConsultationRequest::query()
            ->join('consultation_sheets', 'consultation_sheets.id', 'consultation_requests.consultation_sheet_id')
            ->join('subscriptions', 'subscriptions.id', 'consultation_sheets.subscription_id')
            ->where('consultation_sheets.subscription_id', $idSubscription)
            ->when($q, function ($query) {
                return $query->where(function ($query) {
                    return $query->where('consultation_sheets.name', 'like', '%' . SELF::$keytoSearch . '%')
                        ->orWhere('consultation_sheets.number_sheet', 'like', '%' . SELF::$keytoSearch . '%');
                });
            })
            ->selectRaw('consultation_requests.*,subscriptions.name as subscription_name')
            ->with(
                [
                    'consultationSheet.subscription',
                    'consultationSheet.source',
                    'rate',
                    'consultation',
                    'tarifs',
                    'consultationRequestHospitalizations',
                    'consultationRequestNursings',
                    'products'
                ]
            )
            ->orderBy($sortBy, $sortAsc ? 'ASC' : 'DESC')
            ->where('consultation_sheets.hospital_id', Hospital::DEFAULT_HOSPITAL())
            ->whereMonth('consultation_requests.created_at', $month)
            ->whereYear('consultation_requests.created_at', $year)
            ->paginate($per_page);
    }

    /**
     * Get all consultation request by month
     * @param int $idSubscription
     * @param string $q
     * @param string $sortBy
     * @param bool $sortAsc
     * @param int $per_page
     * @return mixed
     */
    public static function getConsultationRequestHospitalized(
        int    $idSubscription,
        string $q,
        string $sortBy,
        bool   $sortAsc,
        int    $per_page = 10,
        string $month,
        string $year,
    ): mixed {
        SELF::$keytoSearch = $q;
        return ConsultationRequest::query()
            ->join('consultation_sheets', 'consultation_sheets.id', 'consultation_requests.consultation_sheet_id')
            ->join('subscriptions', 'subscriptions.id', 'consultation_sheets.subscription_id')
            ->where('consultation_sheets.subscription_id', $idSubscription)
            ->when($q, function ($query) {
                return $query->where(function ($query) {
                    return $query->where('consultation_sheets.name', 'like', '%' . SELF::$keytoSearch . '%')
                        ->orWhere('consultation_sheets.number_sheet', 'like', '%' . SELF::$keytoSearch . '%');
                });
            })
            ->selectRaw('consultation_requests.*,subscriptions.name as subscription_name')
            ->orderBy($sortBy, $sortAsc ? 'ASC' : 'DESC')
            ->select('consultation_requests.*')
            ->with([
                'consultationSheet', 'rate'
            ])
            ->where('consultation_sheets.hospital_id', Hospital::DEFAULT_HOSPITAL())
            ->where('consultation_sheets.source_id', Source::DEFAULT_SOURCE())
            ->whereMonth('consultation_requests.created_at', $month)
            ->whereYear('consultation_requests.created_at', $year)
            ->where('consultation_requests.is_hospitalized', true)
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
        int    $idSubscription,
        string $q,
        string $sortBy,
        bool   $sortAsc,
        int    $per_page = 10,
        string $startDate,
        string $endDate,
    ): mixed {
        SELF::$keytoSearch = $q;
        return ConsultationRequest::query()
            ->join('consultation_sheets', 'consultation_sheets.id', 'consultation_requests.consultation_sheet_id')
            ->join('subscriptions', 'subscriptions.id', 'consultation_sheets.subscription_id')
            ->where('consultation_sheets.subscription_id', $idSubscription)
            ->when($q, function ($query) {
                return $query->where(function ($query) {
                    return $query->where('consultation_sheets.name', 'like', '%' . SELF::$keytoSearch . '%')
                        ->orWhere('consultation_sheets.number_sheet', 'like', '%' . SELF::$keytoSearch . '%');
                });
            })
            ->selectRaw('consultation_requests.*,subscriptions.name as subscription_name')
            ->orderBy($sortBy, $sortAsc ? 'ASC' : 'DESC')
            ->select('consultation_requests.*')
            ->with([
                'consultationSheet', 'rate'
            ])
            ->where('consultation_sheets.hospital_id', Hospital::DEFAULT_HOSPITAL())
            ->where('consultation_sheets.source_id', Source::DEFAULT_SOURCE())
            ->whereBetween('consultation_requests.created_at', [$startDate, $endDate])
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
        string $date,
        string $year,
    ): int|float {
        return ConsultationRequest::join('consultation_sheets', 'consultation_sheets.id', 'consultation_requests.consultation_sheet_id')
            ->where('consultation_sheets.subscription_id', $idSubscription)
            ->where('consultation_sheets.hospital_id', Hospital::DEFAULT_HOSPITAL())
            ->where('consultation_sheets.source_id', Source::DEFAULT_SOURCE())
            ->whereDate('consultation_requests.created_at', $date)
            ->whereYear('consultation_requests.created_at', $year)
            ->count();
    }

    public static function getCountConsultationRequestByMonth(
        int    $idSubscription,
        string $month,
        string $year,
    ): int|float {
        return ConsultationRequest::join('consultation_sheets', 'consultation_sheets.id', 'consultation_requests.consultation_sheet_id')
            ->where('consultation_sheets.subscription_id', $idSubscription)
            ->where('consultation_sheets.hospital_id', Hospital::DEFAULT_HOSPITAL())
            ->where('consultation_sheets.source_id', Source::DEFAULT_SOURCE())
            ->whereMonth('consultation_requests.created_at', $month)
            ->whereYear('consultation_requests.created_at', $year)
            ->count();
    }

    public static function getCountConsultationRequestByMonthAllSource(
        int    $idSubscription,
        string $month,
        string $year,
    ): int|float {
        return ConsultationRequest::join('consultation_sheets', 'consultation_sheets.id', 'consultation_requests.consultation_sheet_id')
            ->where('consultation_sheets.subscription_id', $idSubscription)
            ->where('consultation_sheets.hospital_id', Hospital::DEFAULT_HOSPITAL())
            ->whereMonth('consultation_requests.created_at', $month)
            ->whereYear('consultation_requests.created_at', $year)
            ->count();
    }

    public static function getCountConsultationRequestBetweenDate(
        int    $idSubscription,
        string $startDate,
        string $endDate,
    ): int|float {
        return ConsultationRequest::join('consultation_sheets', 'consultation_sheets.id', 'consultation_requests.consultation_sheet_id')
            ->where('consultation_sheets.subscription_id', $idSubscription)
            ->where('consultation_sheets.hospital_id', Hospital::DEFAULT_HOSPITAL())
            ->where('consultation_sheets.source_id', Source::DEFAULT_SOURCE())
            ->whereBetween('consultation_requests.created_at', [$startDate, $endDate])
            ->count();
    }


    /**
     * Get all consultation request by month
     * @param int $idSubscription
     * @param string $q
     * @param string $sortBy
     * @param bool $sortAsc
     * @param int $per_page
     * @return mixed
     */
    public static function getConsultationRequestHospitalizedToBordereau(): mixed
    {
        return ConsultationRequest::query()
            ->join('consultation_sheets', 'consultation_sheets.id', 'consultation_requests.consultation_sheet_id')
            ->with(['consultationSheet.subscription'])
            ->select('consultation_requests.*')
            ->where('consultation_sheets.hospital_id', Hospital::DEFAULT_HOSPITAL())
            ->where('consultation_sheets.source_id', Source::DEFAULT_SOURCE())
            ->whereDate('consultation_requests.paid_at', Carbon::now())
            ->where('perceived_by', auth()->id())
            ->where('consultation_requests.is_finished', true)
            ->where('consultation_requests.is_hospitalized', true)
            ->get();
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
}
