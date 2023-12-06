<?php

namespace App\Repositories\Sheet\Get;

use App\Models\ConsultationRequest;
use App\Models\Hospital;
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
    ): mixed
    {
        SELF::$keytoSearch = $q;
        return ConsultationRequest::
        join('consultation_sheets', 'consultation_sheets.id', 'consultation_requests.consultation_sheet_id')
            ->where('consultation_sheets.subscription_id', $idSubscription)
            ->when($q, function ($query) {
                return $query->where(function ($query) {
                    return $query->where('consultation_sheets.name', 'like', '%' . SELF::$keytoSearch . '%')
                        ->orWhere('consultation_sheets.number_sheet', 'like', '%' . SELF::$keytoSearch . '%');
                });
            })->orderBy($sortBy, $sortAsc ? 'ASC' : 'DESC')
            ->select('consultation_requests.*')
            ->with(['consultationSheet.subscription'])
            ->where('consultation_sheets.hospital_id', Hospital::DEFAULT_HOSPITAL)
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
}
