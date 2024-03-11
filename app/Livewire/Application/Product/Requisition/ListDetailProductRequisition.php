<?php

namespace App\Livewire\Application\Product\Requisition;

use App\Models\Product;
use App\Models\ProductRequisition;
use App\Models\ProductRequisitionProduct;
use Livewire\Component;

class ListDetailProductRequisition extends Component
{
    protected $listeners = ['productRequisitionDetail' => 'getProductRequisitionDetail'];

    public bool $isEditing=false;
    public $productRequistionProductId;
    public ProductRequisitionProduct $productRequisitionProduct;
    public int $quantity;

    public ProductRequisition   $productRequisition;

    public function getProductRequisitionDetail(ProductRequisition $productRequisition)
    {
        $this->productRequisition = $productRequisition;
    }

    public function edit(ProductRequisitionProduct $productRequisitionProduct)
    {
        $this->isEditing = true;
        $this->productRequistionProductId = $productRequisitionProduct->id;
        $this->productRequisitionProduct = $productRequisitionProduct;
        $this->quantity=$productRequisitionProduct->quantity;
    }

    public function update()
    {
        try {
            $this->productRequisitionProduct->update([
                'quantity' => $this->quantity,
            ]);
            $this->dispatch('updated', ['message' => 'Action bien réalisée']);
            $this->isEditing = false;
        } catch (\Exception $ex) {
            $this->dispatch('error', ['message' => $ex->getMessage()]);
        }
    }

    public function delete(ProductRequisitionProduct $productRequisitionProduct)
    {

       try {
            $productRequisitionProduct->delete();
            $this->dispatch('updated', ['message' => 'Action bien réalisée']);
       } catch (\Exception $ex) {
            $this->dispatch('error', ['message' => $ex->getMessage()]);
        }
    }

    public function render()
    {
        return view('livewire.application.product.requisition.list-detail-product-requisition');
    }
}
