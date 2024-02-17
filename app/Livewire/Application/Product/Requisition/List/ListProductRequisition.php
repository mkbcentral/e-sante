<?php

namespace App\Livewire\Application\Product\Requisition\List;

use App\Models\Product;
use App\Models\ProductRequisition;
use App\Models\ProductRequisitionProduct;
use Exception;
use Livewire\Attributes\Url;
use Livewire\Component;

class ListProductRequisition extends Component
{
    protected $listeners = [
        'listProductRequisition' => '$refresh'
    ];
    public ?ProductRequisition $productRequisition;
    #[Url(as: 'q')]
    public $q = '';
    public function mount(ProductRequisition $productRequisition){
        $this->productRequisition=$productRequisition;
    }

    public function edit(?Product $product)
    {
        $this->dispatch('productToRequition', $product, $this->productRequisition, true);
        $this->dispatch('open-add-to-product-requisition-modal');
    }

    public function delete(ProductRequisitionProduct $productRequisitionProduct)
    {
        try {
            $productRequisitionProduct->delete();
            $this->dispatch('error', ['message' => 'Action bien réalisée']);
        } catch (Exception $ex) {
            $this->dispatch('error', ['message' => $ex->getMessage()]);
        }
    }

    public function render()
    {
        return view('livewire.application.product.requisition.list.list-product-requisition',
            [
                'productProductRequisitions' => ProductRequisitionProduct::query()
                    ->join('products', 'products.id', 'product_requisition_products.product_id')
                    ->join('product_requisitions', 'product_requisitions.id', 'product_requisition_products.product_requisition_id')
                    ->select('product_requisition_products.*')
                    ->where('product_requisition_products.product_requisition_id', $this->productRequisition->id)
                    ->where('products.name', 'like', '%' . $this->q . '%')
                    ->with(['product'])
                    ->paginate(20)
            ]
        );
    }
}
