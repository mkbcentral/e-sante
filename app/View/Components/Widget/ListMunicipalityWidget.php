<?php

namespace App\View\Components\Widget;

use App\Models\Municipality;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Illuminate\View\Component;

class ListMunicipalityWidget extends Component
{
    public Collection $listMunicipalities;
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        $this->listMunicipalities=Municipality::where('hospital_id',1)
            ->get();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.widget.list-municipality-widget');
    }
}
