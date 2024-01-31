<?php

namespace App\Livewire\Application\Product\List;

use App\Models\Product;
use App\Models\ProductSupply;
use App\Repositories\Product\Get\GetProductRepository;
use Livewire\Attributes\Url;
use Livewire\Component;

class ListProductWithItemAdding extends Component
{
    public ?ProductSupply $productSupply;
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

    public function addNewProduct(Product $product){
        $this->dispatch('productToSupply',$product,$this->productSupply,false);
        $this->dispatch('open-add-to-product-supply-modal');
    }

    public function mount(?ProductSupply $productSupply){
        $this->productSupply=$productSupply;
    }

    public function render()
    {
        return view(
            'livewire.application.product.list.list-product-with-item-adding',
            [
                'products' => GetProductRepository::getProductListExceptFamilyAndCategory(
                    $this->q,
                    $this->sortBy,
                    $this->sortAsc,
                )
            ]
        );
    }
}
