<?php

namespace App\Livewire\Application\Product\Supply\Form;

use App\Models\ProductSupply;
use Exception;
use Livewire\Attributes\Rule;
use Livewire\Component;

class EditProductSupllyView extends Component
{
    protected $listeners = ['productSupply' => 'getProductSupply'];
    public ?ProductSupply $productSupply;
    #[Rule('required', message: 'Date obligatoire obligatoire')]
    #[Rule('date', message: 'Date creation format invalide')]
    public $created_at;

    public function getProductSupply(?ProductSupply $productSupply)
    {
        $this->productSupply = $productSupply;
        $this->created_at = $productSupply->created_at->format('Y-m-d');
    }

    public function update()
    {
        try {
            $this->productSupply->created_at = $this->created_at;
            $this->productSupply->update();
            $this->dispatch('updated', ['message' => 'Action bien réalisée']);
            $this->dispatch('close-edit-product-supply-model');
        } catch (Exception $ex) {
            $this->dispatch('error', ['message' => $ex->getMessage()]);
        }
    }
    public function render()
    {
        return view('livewire.application.product.supply.form.edit-product-suplly-view');
    }
}
