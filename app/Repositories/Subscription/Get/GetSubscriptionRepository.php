<?php

namespace App\Repositories\Subscription\Get;

use App\Models\Hospital;
use App\Models\Subscription;
use Illuminate\Support\Collection;

class GetSubscriptionRepository
{
    public static function getAllSubscriptionList():Collection{
        return Subscription::where('hospital_id',Hospital::DEFAULT_HOSPITAL())
                ->where('is_activated',true)
                ->get();
    }

    public static function getAllSubscriptionListPrivateOnly(): Collection
    {
        return Subscription::where('hospital_id', Hospital::DEFAULT_HOSPITAL())
            ->where('is_activated', true)
            ->where('is_private',true)
            ->get();
    }

    public static function getAllSubscriptionListExecptPrivate(): Collection
    {
        return Subscription::where('hospital_id', Hospital::DEFAULT_HOSPITAL())
            ->where('is_activated', true)
            ->where('is_private', false)
            ->get();
    }
}
