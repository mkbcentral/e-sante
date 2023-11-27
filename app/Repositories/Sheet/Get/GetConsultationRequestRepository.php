<?php

namespace App\Repositories\Sheet\Get;

use App\Models\ConsultationRequest;
use App\Models\Hospital;

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
}
