<?php

namespace App\View\Components\Widget;

use App\Models\HospitalizationRoom;
use App\Models\Source;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Illuminate\View\Component;

class ListHospitalizationWidget extends Component
{
    public ?Collection $listRooms;
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        $this->listRooms = HospitalizationRoom::where('source_id',Source::DEFAULT_SOURCE())->get();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.widget.list-hospitalization-widget');
    }
}
