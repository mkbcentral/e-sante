<?php

namespace App\Livewire\Application\Setting;

use App\Models\UserSetting;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;

class SwitchThemeWidget extends Component
{
    public bool $is_dark_mode = false;
    public function updatedIsDarkMode($val)
    {
        $setting = UserSetting::where('user_id', Auth::user()->id)->first();
        if ($setting != null) {
            $setting->is_dark_mode = $val;
            $setting->update();
            Cache::forget('theme_setting');
        } else {
            $setting = UserSetting::create([
                'user_id' => Auth::user()->id,
                'is_dark_mode' => $this->is_dark_mode,
                'is_sidebar_collapse' => false
            ]);
            $setting->is_dark_mode = $val;
            $setting->update();
            Cache::forget('theme_setting');
        }
    }
    public function render()
    {
        if (Auth::user()) {
            $setting = UserSetting::where('user_id', Auth::user()->id)->first();
            if ($setting != null) {
                $this->is_dark_mode = $setting->is_dark_mode;
            }
        }
        return view('livewire.application.setting.switch-theme-widget');
    }
}
