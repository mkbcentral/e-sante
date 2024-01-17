<?php

namespace App\View\Components\Widget;

use App\Models\BloodGoup;
use App\Models\Hospital;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Illuminate\View\Component;

class ListBloodGroupWidget extends Component
{
    public ?Collection $bloodGroups;
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        $this->bloodGroups=BloodGoup::where('hospital_id',Hospital::DEFAULT_HOSPITAL())
            ->get();;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.widget.list-blood-group-widget');
    }
}
