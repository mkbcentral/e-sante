<?php

namespace App\Livewire\Application\Product\Supply\Form;

use App\Models\ProductSupply;
use Livewire\Component;

class AddProductsInSupply extends Component
{
    public ?ProductSupply $productSupply;
    public function mount(?ProductSupply $productSupply)
    {
        $this->productSupply = $productSupply;
    }
    public function render()
    {
        return view('livewire.application.product.supply.form.add-products-in-supply');
    }
}
