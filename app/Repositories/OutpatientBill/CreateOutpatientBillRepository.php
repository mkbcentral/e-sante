<?php

namespace App\Repositories\OutpatientBill;

use App\Models\Hospital;
use App\Models\OutpatientBill;
use App\Repositories\Rate\RateRepository;
use Illuminate\Support\Facades\Auth;

class CreateOutpatientBillRepository
{
    public  static function create(array $inputs):OutpatientBill
    {
        return OutpatientBill::create([
            'bill_number' => rand(100, 1000),
            'client_name' => $inputs['client_name'],
            'consultation_id' =>$inputs['consultation_id'],
            'user_id' => Auth::id(),
            'hospital_id' => Hospital::DEFAULT_HOSPITAL(),
            'rate_id' => RateRepository::getCurrentRate()->id,
            'currency_id' => $inputs['currency_id'] == null ? null : $inputs['currency_id'],
        ]);
    }
}
