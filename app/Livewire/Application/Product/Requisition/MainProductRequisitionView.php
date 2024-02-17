<?php

namespace App\Livewire\Application\Product\Requisition;

use App\Models\ProductRequisition;
use Exception;
use Livewire\Component;

class MainProductRequisitionView extends Component
{

    protected $listeners = [
        'listProductRequisition' => '$refresh'
    ];


    public function openAddModal(){
        $this->dispatch('open-new-requisition-modal');
    }

    public function openAddProductItemsModal(ProductRequisition $productRequisition)
    {
        $this->dispatch('open-product-requisition-items-modal');
        $this->dispatch('productRequisition',$productRequisition);

    }

    public function edit(?ProductRequisition $productRequisition){
        $this->dispatch('productRequisition',$productRequisition);
        $this->dispatch('open-new-requisition-modal');
    }

    public function delete(ProductRequisition $productRequisition){
        try {
            $productRequisition->delete();
            $this->dispatch('error', ['message' => 'Action bien réalisée']);
        } catch (Exception $ex) {

            $this->dispatch('error', ['message' => $ex->getMessage()]);
        }
    }

    public function render()
    {
        return view('livewire.application.product.requisition.main-product-requisition-view',[
            'productRequisitions'=>ProductRequisition::all()
        ]);
    }
}
