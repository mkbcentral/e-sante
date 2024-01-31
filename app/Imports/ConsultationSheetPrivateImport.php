<?php

namespace App\Imports;

use App\Models\ConsultationSheet;
use App\Models\Hospital;
use App\Models\Source;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class ConsultationSheetPrivateImport implements ToCollection
{
    /*
    protected $fillable = [
        'number_sheet', 'name', 'date_of_birth', 'phone', 'other_phone', 'email',
        'blood_group', 'gender', 'type_patient_id', 'municipality', 'rural_area',
        'street', 'street_number', 'subscription_id', 'hospital_id', 'agent_service_id',
        'registration_number', 'source_id'
    ];
    */
    public function collection(Collection $rows)
    {
        $data = [];
        foreach ($rows as $row) {
            $date = Carbon::parse($row[5]);
            $age = date('Y') - $date->format('Y');

            $v1 = substr($row[0], 0, -5);
            $v2 = ltrim($v1, '0');

            /*$data[] = $row[4].'==>' . $row[1] . ' ' . $row[2] . ' ' . $row[3];
            if($row[4] !='F' && $row[4] != 'M'){
                 $data[] = $row[4].'==>' . $row[1] . ' ' . $row[2] . ' ' . $row[3];
            }
            */
            if (strpos($v2, '/') == false) {
                ConsultationSheet::create([
                    'number_sheet' => $v2,
                    'name' => $row[1] . ' ' . $row[2] . ' ' . $row[3],
                    'gender' => $row[4],
                    'date_of_birth' => $row[5],
                    'municipality' => $row[6],
                    'rural_area' => $row[7],
                    'street' => $row[8],
                    'street_number' => $row[9],
                    'phone' => $row[10],
                    'source_id' => Source::DEFAULT_SOURCE(),
                    'hospital_id' => Hospital::DEFAULT_HOSPITAL(),
                    'subscription_id' => 1,
                    'type_patient_id' => $age >= 18 ? 1 : 2
                ]);
            }

        }

        //dd($data);
    }
}
