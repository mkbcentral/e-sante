<?php

namespace App\Imports;

use App\Models\ConsultationSheet;
use Maatwebsite\Excel\Concerns\ToModel;

class ConsultationSheetAgentImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new ConsultationSheet([
            //
        ]);
    }
}
