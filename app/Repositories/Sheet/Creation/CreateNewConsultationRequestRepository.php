<?php

namespace App\Repositories\Sheet\Creation;

use App\Models\ConsultationRequest;
use App\Repositories\Rate\RateRepository;

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
}
