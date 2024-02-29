<?php

namespace App\Livewire\Application\Product\Purcharse;

use App\Models\ProductPurchase;
use Livewire\Component;
use Livewire\WithPagination;

class ListProductPurchase extends Component
{
    use WithPagination;
    protected $listeners = [
        'productPurchase' => 'getProductPurchase',
    ];

    public ?ProductPurchase $productPurchase=null;

    public function getProductPurchase(ProductPurchase $productPurchase)
    {
        $this->productPurchase = $productPurchase;

    }

    public function render()
    {
        return view('livewire.application.product.purcharse.list-product-purchase',[
            'products'=>
            $this->productPurchase !=null? $this->productPurchase->products()->orderBy('name', 'ASC')

                ->paginate(20)
            :[]
        ]);
    }
}
