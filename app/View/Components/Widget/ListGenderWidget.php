<?php

namespace App\View\Components\Widget;

use App\Models\Gender;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Illuminate\View\Component;

class ListGenderWidget extends Component
{
    public Collection $listGenders;
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        $this->listGenders=Gender::where('hospital_id',1)
            ->get();;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.widget.list-gender-widget');
    }
}
