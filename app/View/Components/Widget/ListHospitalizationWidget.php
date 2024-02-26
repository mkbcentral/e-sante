<?php

namespace App\View\Components\Widget;

use App\Models\Hospital;
use App\Models\HospitalizationRoom;
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
        $this->listRooms = HospitalizationRoom::query()
            ->join('hospitalizations', 'hospitalizations.id', 'hospitalization_rooms.hospitalization_id')
            ->where('hospitalizations.hospital_id', Hospital::DEFAULT_HOSPITAL())
            ->select('hospitalization_rooms.*')
            ->get();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.widget.list-hospitalization-widget');
    }
}
