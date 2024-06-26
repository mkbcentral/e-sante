<?php

namespace App\Repositories\Rate;

use App\Models\Rate;

class RateRepository
{
    public static function getCurrentRate():Rate{
        return Rate::where('is_current',true)->first();
    }

    public static function getCurrentRateById($id): Rate
    {
        return Rate::find($id);
    }
}
