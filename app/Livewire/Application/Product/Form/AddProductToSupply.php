<?php

namespace App\Livewire\Application\Product\Form;

use App\Models\Product;
use App\Models\ProductSupply;
use App\Models\ProductSupplyProduct;
use Exception;
use Livewire\Attributes\Rule;
use Livewire\Component;

class AddProductToSupply extends Component
{
    protected $listeners = ['productToSupply' => 'getProduct'];
    public ?Product $product;
    public ProductSupply $productSupply;
    #[Rule('required', message: 'Quantité obligatoire obligatoire')]
    #[Rule('numeric', message: 'Quantité  format invalide')]
    public $quantity;

    public bool $isEditing = false;

    public function getProduct(Product $product, ProductSupply $productSupply, bool $isEditing)
    {
        $this->product = $product;
        $this->productSupply = $productSupply;
        $this->isEditing = $isEditing;
        if ($this->isEditing==true) {
            $productSupplyProduct = ProductSupplyProduct::where('product_id', $product->id)->first();
            $this->quantity=$productSupplyProduct->quantity;
        }
    }

    public function store()
    {
        $this->validate();
        try {
            ProductSupplyProduct::create([
                'quantity' => $this->quantity,
                'product_id' => $this->product->id,
                'product_supply_id' => $this->productSupply->id,
            ]);
            $this->dispatch('updated', ['message' => 'Action bien réalisée']);
        } catch (Exception $ex) {
            $this->dispatch('error', ['message' => $ex->getMessage()]);
        }
    }

    public function update()
    {
        $this->validate();
        try {
            $productSupplyProduct = ProductSupplyProduct::where('product_id', $this->product->id)->first();
            $productSupplyProduct->quantity = $this->quantity;
            $productSupplyProduct->update();
        } catch (Exception $ex) {
            $this->dispatch('error', ['message' => $ex->getMessage()]);
        }
    }

    public function handlerSubmit()
    {
        if ($this->isEditing == false) {
            $this->store();
        } else {
            $this->update();
        }
        $this->dispatch('close-add-to-product-supply-modal');
        $this->dispatch('refreshProductSupplies');
    }
    public function render()
    {
        return view('livewire.application.product.form.add-product-to-supply');
    }
}
