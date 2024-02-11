<?php

namespace App\View\Components\Widget;

use App\Models\Product;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\View\Component;
use Livewire\WithPagination;

class ListProductWidget extends Component
{
    use WithPagination;
    public ?LengthAwarePaginator  $listProduct;
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        $this->listProduct=Product::orderBy('name','ASC')->get();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.widget.list-product-widget');
    }
}
