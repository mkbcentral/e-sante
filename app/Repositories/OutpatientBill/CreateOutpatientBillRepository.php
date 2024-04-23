<?php

namespace App\Repositories\OutpatientBill;

use App\Models\Hospital;
use App\Models\OutpatientBill;
use App\Repositories\Rate\RateRepository;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class CreateOutpatientBillRepository
{
    /**
     * create
     * Create new OutpatientBill
     * @param  mixed $inputs
     * @return OutpatientBill
     */
    public  static function create(array $inputs):OutpatientBill
    {
        return OutpatientBill::create([
            'bill_number' => rand(1000, 10000),
            'client_name' => $inputs['client_name'],
            'consultation_id' =>$inputs['consultation_id'],
            'user_id' => Auth::id(),
            'hospital_id' => Hospital::DEFAULT_HOSPITAL(),
            'rate_id' => RateRepository::getCurrentRate()->id,
            'currency_id' => $inputs['currency_id'] == null ? null : $inputs['currency_id'],
        ]);
    }
    /*
    * Check if OutpatientBill exist
    */
    public static function outpatienBillExist(string $client):bool
    {
        return OutpatientBill::where('client_name', $client)->whereDate('created_at',Carbon::now())->exists();
    }
}
