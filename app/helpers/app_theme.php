<?php

use App\Models\UserSetting;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

function theme_setting($key)
{
    if (Auth::user()) {
        $setting = Cache::rememberForever('theme_setting', function () {
            return UserSetting::where('user_id', Auth::user()->id)->first();
        });
        return $setting->{$key};
    }
}
