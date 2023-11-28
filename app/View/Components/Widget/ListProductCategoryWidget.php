<?php

namespace App\View\Components\Widget;

use App\Models\ProductCategory;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Illuminate\View\Component;

class ListProductCategoryWidget extends Component
{
    public ?Collection $listCategory;
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        $this->listCategory=ProductCategory::orderBy('name','ASC')->get();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.widget.list-product-category-widget');
    }
}
