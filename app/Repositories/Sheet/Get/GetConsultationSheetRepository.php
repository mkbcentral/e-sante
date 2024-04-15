<?php

namespace App\Repositories\Sheet\Get;

use App\Models\ConsultationSheet;
use App\Models\Hospital;
use App\Models\Source;

class GetConsultationSheetRepository
{
    private static string $keyToSearch;

    /**
     * Get la consulation sheet number + 1 to next sheet number
     * @return int
     */
    public static function getLastConsultationSheetNumber(): int
    {
        return ConsultationSheet::orderBy('created_at', 'DESC')
            ->where('hospital_id', Hospital::DEFAULT_HOSPITAL())
            ->where('consultation_sheets.source_id', auth()->user()->source->id)
            ->first()?->number_sheet + 1;
    }

    /**
     * Get all Consultation sheet list with pagination default 10 values get
     * Powerfull search by (name,phone,number_sheet,...)
     * Sort ASC and DESC table header cliecked
     * @param int $idSubscription
     * @param string $q
     * @param string $sortBy
     * @param bool $sortAsc
     * @param int $per_page
     * @return mixed
     */
    public static function getConsultationSheetList(
        int    $idSubscription,
        string $q,
        string $sortBy,
        bool   $sortAsc,
        int    $per_page = 50
    ): mixed {
        SELF::$keyToSearch = $q;
        return ConsultationSheet::join('subscriptions', 'subscriptions.id', 'consultation_sheets.subscription_id')
            ->where('consultation_sheets.subscription_id', $idSubscription)
            ->when($q, function ($query) {
                return $query->where(function ($query) {
                    return $query->where('consultation_sheets.name', 'like', '%' . SELF::$keyToSearch . '%')
                        ->orWhere('consultation_sheets.email', 'like', '%' . SELF::$keyToSearch . '%')
                        ->orWhere('consultation_sheets.number_sheet', 'like', '%' . SELF::$keyToSearch . '%')
                        ->orWhere('consultation_sheets.phone', 'like', '%' . SELF::$keyToSearch . '%')
                        ->orWhere('consultation_sheets.registration_number', 'like', '%' . SELF::$keyToSearch . '%');
                });
            })->orderBy($sortBy, $sortAsc ? 'ASC' : 'DESC')
            ->select('consultation_sheets.*', 'subscriptions.name as subscription')
            ->where('consultation_sheets.hospital_id', Hospital::DEFAULT_HOSPITAL())
            ->where('consultation_sheets.source_id', auth()->user()->source->id)
            ->paginate($per_page);
    }

    public static function getExistingConsultationSheet(
        string $name,
        string $gender
    ): ?ConsultationSheet {
        return ConsultationSheet::where('name', $name)
        ->where('source_id',Source::DEFAULT_SOURCE())
        ->where('gender', $gender)->first();
    }
}
