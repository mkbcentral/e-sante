<?php

namespace App\Repositories\Sheet\Countig;

use App\Models\ConsultationSheet;
use App\Models\Hospital;

class CountConsultationSheetRepository
{
    public static function countAllConsultationBySubscription(string $subscriptionId):float{
        return ConsultationSheet::whereSubscriptionId($subscriptionId)
            ->where('hospital_id',Hospital::DEFAULT_HOSPITAL())
            ->where('source_id', auth()->user()->source->id)
            ->count();
    }
}
