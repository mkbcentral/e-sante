<?php

namespace App\Repositories\Subscription\Get;

use App\Models\Hospital;
use App\Models\Subscription;
use Illuminate\Support\Collection;

class GetSubscriptionRepository
{
    public static function getAllSubscriptionList():Collection{
        return Subscription::where('hospital_id',Hospital::DEFAULT_HOSPITAL)->get();
    }
}
