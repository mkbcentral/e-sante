<?php

namespace App\Livewire\Application\Setting;

use App\Models\UserSetting;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;

class ChangeCollapseState extends Component
{
    public function updateCollapsedState()
    {
        $setting = UserSetting::where('user_id', Auth::user()->id)->first();
        if ($setting->is_sidebar_collapse == true) {
            $setting->is_sidebar_collapse = false;
        } else {
            $setting->is_sidebar_collapse = true;
        }
        $setting->update();
        Cache::forget('theme_setting');
    }
    public function render()
    {
        return view('livewire.application.setting.change-collapse-state');
    }
}
