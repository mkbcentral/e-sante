<?php

namespace App\Livewire\Application\Finance\Widget;

use App\Models\Rate;
use Livewire\Component;

class RateInfoWidget extends Component
{
    protected $listeners = [
        'refreshRateInfo' => '$refresh'
    ];
    public function render()
    {
        return view('livewire.application.finance.widget.rate-info-widget',[
            'rate'=>Rate::where('is_current',true)->first()?->rate
        ]);
    }
}
