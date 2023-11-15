<?php

namespace App\View\Components\Widget;

use App\Models\TypePatient;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Illuminate\View\Component;

class ListTypePatientWidget extends Component
{
    public Collection $listType;
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        $this->listType=TypePatient::orderBy('name','ASC')
            ->where('hospital_id',1)
            ->get();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.widget.list-type-patient-widget');
    }
}
