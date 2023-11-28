<?php

namespace App\View\Components\Widget;

use App\Models\ProductFamily;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Illuminate\View\Component;

class ListProductFamilyWidget extends Component
{
    public ?Collection $listFamily;
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        $this->listFamily=ProductFamily::orderBy('name','ASC')->get();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.widget.list-product-family-widget');
    }
}
