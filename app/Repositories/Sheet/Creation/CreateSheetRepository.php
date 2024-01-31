<?php

namespace App\Repositories\Sheet\Creation;

use App\Models\ConsultationSheet;

class CreateSheetRepository
{
    public static function create(array $inputs): ConsultationSheet
    {
        return  ConsultationSheet::create([
            'number_sheet' => $inputs['number_sheet'],
            'name' => $inputs['name'],
            'date_of_birth' => $inputs['date_of_birth'],
            'phone' => $inputs['phone'],
            'other_phone' => $inputs['other_phone'],
            'email' => $inputs['email'],
            'blood_group' => $inputs['blood_group'],
            'gender' => $inputs['gender'],
            'type_patient_id' => $inputs['type_patient_id'],
            'rural_area' => $inputs['rural_area'],
            'municipality' => $inputs['municipality'],
            'street' => $inputs['street'],
            'street_number' => $inputs['street_number'],
            'subscription_id' => $inputs['subscription_id'],
            'hospital_id' => $inputs['hospital_id'],
            'agent_service_id' => $inputs['agent_service_id'],
            'registration_number' => $inputs['registration_number'],
            'source_id' => $inputs['source_id'],
        ]);
    }
}
