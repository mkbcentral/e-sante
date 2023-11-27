<?php

namespace App\Repositories\Sheet\Get;

use App\Models\Diagnostic;
use App\Models\Hospital;
use Illuminate\Support\Collection;
class GetDiagnosticRepository
{
    /**
     * Get list diagnostic by hospital id List
     * @return Collection
     */
    public static function getDiagnosticList():Collection{
        return Diagnostic::where('hospital_id',Hospital::DEFAULT_HOSPITAL)->get();
    }
}
