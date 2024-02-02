<?php

namespace App\Livewire\Application\Product;

use App\Models\Product;
use App\Models\ProductSupply;
use App\Models\ProductSupplyProduct;
use Exception;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class ListProductSupplyItem extends Component
{
    use WithPagination;
    protected $listeners = ['refreshProductSupplies' => '$refresh'];
    public ?ProductSupply $productSupply;
    #[Url(as: 'q')]
    public $q = '';
    public function mount(?ProductSupply $productSupply){
        $this->productSupply=$productSupply;
    }

    public function edit(?Product $product){
        $this->dispatch('productToSupply',$product,$this->productSupply,true);
        $this->dispatch('open-add-to-product-supply-modal');
    }

    public function delete(ProductSupplyProduct $productSupplyProduct){
        try {
            $productSupplyProduct->delete();
            $this->dispatch('error', ['message' => 'Action bien réalisée']);
        } catch (Exception $ex) {
            $this->dispatch('error', ['message' => $ex->getMessage()]);
        }
    }
    public function render()
    {
        return view('livewire.application.product.list-product-supply-item', [
            'productProductSupplies' => ProductSupplyProduct::join('products', 'products.id', 'product_supply_products.product_id')
                ->join('product_supplies', 'product_supplies.id', 'product_supply_products.product_supply_id')
                ->join('users', 'users.id', 'product_supplies.user_id')
                ->select('product_supply_products.*')
                ->where('product_supply_products.product_supply_id',$this->productSupply->id)
                ->where('products.name','like','%'.$this->q.'%')
                ->with(['product'])
                ->paginate(20)
        ]);
    }
}
