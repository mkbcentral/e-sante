<?php

namespace App\Livewire\Application\Product\Supply;

use App\Models\ProductSupply;
use Exception;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ListSuppliesView extends Component
{
    protected $listeners = [
        'newSupplyListener' => 'store'
    ];

    public function addNew()
    {
        $this->dispatch('new-product-supply-dialog');
    }

    public function store()
    {
        try {
            ProductSupply::create([
                'code' => rand(1000, 10000) . '-PS',
                'user_id' => Auth::id()
            ]);
            $this->dispatch('product-supply-created-deleted', ['message' => 'Action bien réalisée']);
        } catch (Exception $ex) {
            $this->dispatch('error', ['message' => $ex->getMessage()]);
        }
    }

    public function edit(?ProductSupply $productSupply)
    {
        $this->dispatch('open-edit-product-supply-model');
        $this->dispatch('productSupply', $productSupply);
    }

    public function delete(?ProductSupply $productSupply)
    {
        try {
            $productSupply->delete();
            $this->dispatch('error', ['message' => 'Action bien réalisée']);
        } catch (Exception $ex) {

            $this->dispatch('error', ['message' => $ex->getMessage()]);
        }
    }

    public function addProductOnSupply(?ProductSupply $productSupply)
    {
        $this->dispatch('productSupplyToAdd',$productSupply);
        $this->dispatch('open-add-products-on-supply-modal');
    }

    public function render()
    {
        return view('livewire.application.product.supply.list-supplies-view', [
            'productSupplies' => ProductSupply::all()
        ]);
    }
}
