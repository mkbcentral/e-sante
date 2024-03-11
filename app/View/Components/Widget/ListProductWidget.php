<?php

namespace App\View\Components\Widget;

use App\Models\Hospital;
use App\Models\Product;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Illuminate\View\Component;
use Livewire\WithPagination;

class ListProductWidget extends Component
{
    use WithPagination;
    public ?Collection  $listProduct;
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        $this->listProduct=Product::orderBy('name','ASC')
            ->where('products.hospital_id', Hospital::DEFAULT_HOSPITAL())
            ->where('is_trashed', false)
            ->whereIn('source_id', [1, 2])
            ->get();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.widget.list-product-widget');
    }
}
