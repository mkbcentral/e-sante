<?php

namespace App\View\Components\Widget;

use App\Models\Hospital;
use App\Models\RuralArea;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Illuminate\View\Component;

class ListRuralAreaWidget extends Component
{
    public Collection $listRuralArea;
    /**
     * Create a new component instance.
     */
    public function __construct(public string $municipalityName='')
    {
        $this->listRuralArea=RuralArea::join('municipalities','municipalities.id','=','rural_areas.municipality_id')
            ->where('municipalities.name',$this->municipalityName)
            ->where('municipalities.hospital_id',Hospital::DEFAULT_HOSPITAL)
            ->select('rural_areas.*')->get();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.widget.list-rural-area-widget');
    }
}
