<?php

namespace App\View\Components\Widget;

use App\Models\Hospital;
use App\Models\VitalSign;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Illuminate\View\Component;

class ListVitalSignWidget extends Component
{
    public ?Collection $listVitalSign;
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        $this->listVitalSign=VitalSign::where('hospital_id',Hospital::DEFAULT_HOSPITAL())->get();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.widget.list-vital-sign-widget');
    }
}
