<?php

namespace App\Livewire\Application\Product\Requisition;

use App\Models\ProductRequisition;
use Livewire\Component;

class ProductRequisitionItemsView extends Component
{
    public ?ProductRequisition $productRequisition = null;
    public function mount(ProductRequisition $productRequisition)
    {
        $this->productRequisition = $productRequisition;
    }
    public function render()
    {
        return view('livewire.application.product.requisition.product-requisition-items-view');
    }
}
