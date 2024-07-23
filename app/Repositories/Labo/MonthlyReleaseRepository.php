<?php

namespace App\Repositories\Labo;

use Illuminate\Support\Facades\DB;

class MonthlyReleaseRepository
{
    /**
     * Retourner les consommations par jour
     * @param string $subscription_id
     * @param string $day
     * @param int $tarif_id
     * @return float|int
     */
    public static function getConsultationRequestReleaseByDay(
        string $subscription_id,
        string $day,
        int $tarif_id,
    ):float|int {
        return
            DB::table('consultation_request_tarif')
            ->join(
                'consultation_requests',
                'consultation_requests.id',
                'consultation_request_tarif.consultation_request_id',
            )
            ->join(
                'consultation_sheets',
                'consultation_sheets.id',
                'consultation_requests.consultation_sheet_id',
            )
            ->when(
                $subscription_id,
                function ($query, $f) {
                    return $query->where('consultation_sheets.subscription_id', $f);
                }
            )
            ->whereDate('consultation_requests.created_at', $day)
            ->where('consultation_request_tarif.tarif_id', $tarif_id)
            ->count();
    }

    /**
     * Retourner les consommations par mois
     * @param string $subscription_id
     * @param string $month
     * @param int $tarif_id
     * @return float|int
     */
    public static function getConsultationRequestReleaseByMonth(
        string $subscription_id,
        string $month,
        int $tarif_id,
    ): float|int {
        return
            DB::table('consultation_request_tarif')
            ->join(
                'consultation_requests',
                'consultation_requests.id',
                'consultation_request_tarif.consultation_request_id',
            )
            ->join(
                'consultation_sheets',
                'consultation_sheets.id',
                'consultation_requests.consultation_sheet_id',
            )
            ->when(
                $subscription_id,
                function ($query, $f) {
                    return $query->where('consultation_sheets.subscription_id', $f);
                }
            )
            ->whereMonth('consultation_requests.created_at', $month)
            ->where('consultation_request_tarif.tarif_id', $tarif_id)
            ->count();
    }


    /**
     * Summary of getOutpatientReleaseByDay
     * @param string $day
     * @param int $tarif_id
     * @return float|int
     */
    public static function getOutpatientReleaseByDay(
        string $day,
        int $tarif_id
    ):float|int{
        return DB::table('outpatient_bill_tarif')
            ->join(
                'outpatient_bills',
                'outpatient_bills.id',
                'outpatient_bill_tarif.outpatient_bill_id',
            )
            ->whereDate('outpatient_bills.created_at', $day)
            ->where('outpatient_bill_tarif.tarif_id', $tarif_id)
            ->count();
    }

    public static function getOutpatientReleaseByMonth(
        string $month,
        int $tarif_id
    ): float|int {
        return DB::table('outpatient_bill_tarif')
            ->join(
                'outpatient_bills',
                'outpatient_bills.id',
                'outpatient_bill_tarif.outpatient_bill_id',
            )
            ->whereMonth('outpatient_bills.created_at', $month)
            ->where('outpatient_bill_tarif.tarif_id', $tarif_id)
            ->count();
    }
}
