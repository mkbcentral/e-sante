<?php

namespace App\View\Components\Widget\Outpatientbill;

use App\Models\Product;
use App\Models\ProductInvoice;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ProductInvoiceInfo extends Component
{
    public ProductInvoice $productInvoice;
    /**
     * Create a new component instance.
     */
    public function __construct(ProductInvoice $productInvoice)
    {
        $this->productInvoice = $productInvoice;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.widget.outpatientbill.product-invoice-info');
    }
}
