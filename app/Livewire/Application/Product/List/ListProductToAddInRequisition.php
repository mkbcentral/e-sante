<?php

namespace App\Livewire\Application\Product\List;

use App\Models\Product;
use App\Models\ProductRequisition;
use App\Repositories\Product\Get\GetProductRepository;
use Livewire\Attributes\Url;
use Livewire\Component;

class ListProductToAddInRequisition extends Component
{

    public ?ProductRequisition $productRequisition;

    #[Url(as: 'q')]
    public $q = '';
    #[Url(as: 'sortBy')]
    public $sortBy = 'name';
    #[Url(as: 'sortAsc')]
    public $sortAsc = true;

    /**
     * sort product ASC or DESC
     * @param $value
     * @return void
     */
    public function sortProduct($value): void
    {
        if ($value == $this->sortBy) {
            $this->sortAsc = !$this->sortAsc;
        }
        $this->sortBy = $value;
    }

    public function addNewProduct(Product $product)
    {
        $this->dispatch('productToRequition', $product, $this->productRequisition, false);
        $this->dispatch('open-add-to-product-requisition-modal');
    }

    public function mount(ProductRequisition $productRequisition){
        $this->productRequisition=$productRequisition;
    }
    public function render()
    {
        return view('livewire.application.product.list.list-product-to-add-in-requisition', [
            'products' => GetProductRepository::getList(
                $this->q,
                $this->sortBy,
                $this->sortAsc,
                null,
                null,
                50,
                false
            )
        ]);
    }
}
