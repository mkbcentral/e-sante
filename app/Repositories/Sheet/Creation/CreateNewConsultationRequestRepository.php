<?php

namespace App\Repositories\Sheet\Creation;

use App\Models\ConsultationRequest;
use App\Repositories\Rate\RateRepository;
use Carbon\Carbon;

class CreateNewConsultationRequestRepository
{
    public static function create(array $inputs):ConsultationRequest{
        return ConsultationRequest::create([
            'request_number'=>rand(10,100),
            'consultation_sheet_id'=>$inputs['consultation_sheet_id'],
            'consultation_id'=>$inputs['consultation_id'],
            'rate_id'=>RateRepository::getCurrentRate()->id,
            'has_a_shipping_ticket'=>$inputs['has_a_shipping_ticket']
        ]);
    }

    public static function checkExistingConsultationRequestInMonth(int $sheetId):ConsultationRequest|null{
        return ConsultationRequest::query()
            ->where('consultation_sheet_id',$sheetId)
            ->whereMonth('created_at',Carbon::now())
            ->first();
    }
}
