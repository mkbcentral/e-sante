<?php

namespace App\Repositories\Sheet\Creation;

use App\Models\ConsultationRequest;
use App\Repositories\Rate\RateRepository;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class CreateNewConsultationRequestRepository
{
    public static function create(array $inputs): ConsultationRequest
    {
        return ConsultationRequest::create([
            'request_number' => $inputs['request_number'],
            'consultation_sheet_id' => $inputs['consultation_sheet_id'],
            'consultation_id' => $inputs['consultation_id'],
            'rate_id' => RateRepository::getCurrentRate()->id,
            'has_a_shipping_ticket' => $inputs['has_a_shipping_ticket']
        ]);
    }

    public static function checkExistingConsultationRequestInMonth(int $sheetId): ConsultationRequest|null
    {
        return ConsultationRequest::query()
            ->join(
                'consultation_sheets',
                'consultation_sheets.id',
                'consultation_requests.consultation_sheet_id'
            )
            ->where('consultation_requests.consultation_sheet_id', $sheetId)
            ->whereMonth('consultation_requests.created_at', date('m'))
            ->whereYear('consultation_requests.created_at', date('Y'))
            ->where('consultation_sheets.source_id', Auth::user()->source->id)
            ->first();
    }

    public static function generateConsultationRequetNumber($subscriptionId, $month)
    {
        return  ConsultationRequest::query()
            ->join('consultation_sheets', 'consultation_sheets.id', 'consultation_requests.consultation_sheet_id')
            ->where('consultation_sheets.subscription_id', $subscriptionId)
            ->whereMonth('consultation_requests.created_at', $month)
            ->count();
    }
}
