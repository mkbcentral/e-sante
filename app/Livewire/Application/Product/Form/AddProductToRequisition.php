<?php

namespace App\Livewire\Application\Product\Form;

use App\Models\Product;
use App\Models\ProductRequisition;
use App\Models\ProductRequisitionProduct;
use Exception;
use Livewire\Attributes\Rule;
use Livewire\Component;

class AddProductToRequisition extends Component
{
    protected $listeners = ['productToRequition' => 'getProduct'];
    public ?Product $product;
    public ProductRequisition $productRequisition;
    #[Rule('required', message: 'Quantité obligatoire obligatoire')]
    #[Rule('numeric', message: 'Quantité  format invalide')]
    public $quantity;

    public bool $isEditing = false;

    public function getProduct(Product $product, ProductRequisition $productRequisition, bool $isEditing)
    {
        $this->product = $product;
        $this->productRequisition = $productRequisition;
        $this->isEditing = $isEditing;
        if ($this->isEditing == true) {
            $productRequisitionProduct = ProductRequisitionProduct::where('product_id', $product->id)->first();
            $this->quantity = $productRequisitionProduct->quantity;
        }
    }

    public function store()
    {
        $this->validate();
        try {
            ProductRequisitionProduct::create([
                'quantity' => $this->quantity,
                'product_id' => $this->product->id,
                'product_requisition_id' => $this->productRequisition->id,
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
            $productRequisitionProduct = ProductRequisitionProduct::where('product_id', $this->product->id)->first();
            $productRequisitionProduct->quantity = $this->quantity;
            $productRequisitionProduct->update();
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
        $this->dispatch('close-add-to-product-requisition-modal');
        $this->dispatch('listProductRequisition');
    }
    public function render()
    {
        return view('livewire.application.product.form.add-product-to-requisition');
    }
}
