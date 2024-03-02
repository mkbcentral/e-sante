<?php

namespace App\Repositories\Product\Get;

use App\Models\ConsultationRequest;
use Illuminate\Support\Collection;
class GetConsultationRequestGroupingCounterRepository
{
    /**
     * Get consultation request grouping by subscription by date
     * @param $date
     * @return Collection
     */
    public  static  function getConsultationRequestGroupingBySubscriptionByDate($date): Collection
    {
        return  ConsultationRequest::join('consultation_sheets', 'consultation_sheets.id', 'consultation_requests.consultation_sheet_id')
            ->join('subscriptions', 'subscriptions.id', 'consultation_sheets.subscription_id')
            ->whereDate('consultation_requests.created_at', $date)
            ->selectRaw('COUNT(consultation_requests.id) as number, subscriptions.name as subscription_name')
            ->groupBy('subscriptions.name')
            ->where('consultation_sheets.source_id', auth()->user()->source->id)
            ->get();
    }

    /**
     * Get consultation request grouping by subscription by month and year
     * @param $month
     * @param $year
     * @return Collection
     */
    public  static  function getConsultationRequestGroupingBySubscriptionByMonth($month, $year): Collection
    {
        return  ConsultationRequest::join('consultation_sheets', 'consultation_sheets.id', 'consultation_requests.consultation_sheet_id')
            ->join('subscriptions', 'subscriptions.id', 'consultation_sheets.subscription_id')
            ->whereMonth('consultation_requests.created_at', $month)
            ->whereYear('consultation_requests.created_at', $year)
            ->selectRaw('COUNT(consultation_requests.id) as number, subscriptions.name as subscription_name')
            ->groupBy('subscriptions.name')
            ->where('consultation_sheets.source_id', auth()->user()->source->id)
            ->get();
    }

    public  static  function getConsultationRequestGroupingBySubscriptionHospitalize($month, $year): Collection
    {
        return  ConsultationRequest::join('consultation_sheets', 'consultation_sheets.id', 'consultation_requests.consultation_sheet_id')
            ->join('subscriptions', 'subscriptions.id', 'consultation_sheets.subscription_id')
            ->whereMonth('consultation_requests.created_at', $month)
            ->whereYear('consultation_requests.created_at', $year)
            ->where('consultation_requests.is_hospitalized', true)
            ->selectRaw('COUNT(consultation_requests.id) as number, subscriptions.name as subscription_name')
            ->groupBy('subscriptions.name')
            ->where('consultation_sheets.source_id', auth()->user()->source->id)
            ->get();
    }
}
