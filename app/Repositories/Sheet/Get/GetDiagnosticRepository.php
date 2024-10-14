<?php

namespace App\Repositories\Sheet\Get;

use App\Models\Symptom;
use App\Models\Hospital;
use App\Models\Diagnostic;
use Illuminate\Support\Collection;
class GetDiagnosticRepository
{
    /**
     * Get list diagnostic by hospital id List
     * @return Collection
     */
    public static function getDiagnosticList():Collection{
        return Diagnostic::where('hospital_id',Hospital::DEFAULT_HOSPITAL())->get();
    }

    /**
     * Get list diagnostic by hospital id List
     * @return Collection
     */
    public static function getDiagnosticListByCategory(int $id): Collection
    {
        return Diagnostic::where('hospital_id', Hospital::DEFAULT_HOSPITAL())
                ->where('category_diagnostic_id',$id)
                ->orderBy('name','ASC')
                ->get();
    }

    /**
     * Get list diagnostic by hospital id List
     * @return Collection
     */
    public static function getSymptomticListByCategory(int $id): Collection
    {
        return Symptom::where('category_diagnostic_id', $id)
            ->orderBy('name', 'ASC')
            ->get();
    }
}
