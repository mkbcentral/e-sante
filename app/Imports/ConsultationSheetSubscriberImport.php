<?php

namespace App\Imports;

use App\Models\ConsultationSheet;
use App\Models\Hospital;
use App\Models\Source;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class ConsultationSheetSubscriberImport implements ToCollection
{
    private $subscriptionid;

    public function __construct($value)
    {
        $this->subscriptionid = $value;
    }

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
                    'subscription_id' => $this->subscriptionid,
                    'type_patient_id' => $age >= 18 ? 1 : 2,
                    'registration_number'=>$row[13]
                ]);
            }
        }

        //dd($data);
    }
}
