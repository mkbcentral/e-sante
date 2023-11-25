<?php

namespace App\View\Components\Widget;

use App\Models\CategoryTarif;
use App\Models\Hospital;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Illuminate\View\Component;

class ListCategoryTarifWidget extends Component
{
    public  ?Collection $listCategories;
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        $this->listCategories=CategoryTarif::orderBy('name','ASC')
            ->where('hospital_id',Hospital::DEFAULT_HOSPITAL)
            ->get();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.widget.list-category-tarif-widget');
    }
}
