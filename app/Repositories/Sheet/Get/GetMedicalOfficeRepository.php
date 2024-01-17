<?php

namespace App\Repositories\Sheet\Get;

use App\Models\Hospital;
use App\Models\MedicalOffice;
use Illuminate\Support\Collection;

class GetMedicalOfficeRepository
{
    /**
     * Get Medical Office from DB
     * @return Collection
     */
    public static  function getMedicalOfficeList():Collection{
       return MedicalOffice::where('hospital_id',1)
            ->where('hospital_id',Hospital::DEFAULT_HOSPITAL())
            ->get();
    }
}
