<?php

namespace App\Livewire\Application\Product\Requisition;

use App\Models\ProductRequisition;
use Exception;
use Livewire\Component;
use Livewire\WithPagination;

class MainProductRequisitionView extends Component
{
    use WithPagination;
    protected $listeners = [
        'listProductRequisition' => '$refresh'
    ];
    public $agent_service_id;

    public function updatedAgentServiceId($val){
        $this->agent_service_id=$val;
    }

    public function refreshList(){
        $this->agent_service_id=null;
    }

    public function openAddModal()
    {
        $this->dispatch('open-new-requisition-modal');
    }

    public function openAddProductItemsModal(ProductRequisition $productRequisition)
    {
        $this->dispatch('open-product-requisition-items-modal');
        $this->dispatch('productRequisition', $productRequisition);
    }

    public function edit(?ProductRequisition $productRequisition)
    {
        $this->dispatch('productRequisition', $productRequisition);
        $this->dispatch('open-new-requisition-modal');
    }

    public function delete(ProductRequisition $productRequisition)
    {
        try {
            $productRequisition->delete();
            $this->dispatch('error', ['message' => 'Action bien réalisée']);
        } catch (Exception $ex) {

            $this->dispatch('error', ['message' => $ex->getMessage()]);
        }
    }

    public function render()
    {
        return view('livewire.application.product.requisition.main-product-requisition-view', [
            'productRequisitions' => $this->agent_service_id == null ?
                 ProductRequisition::orderBy('created_at', 'desc')->paginate(10) :
                ProductRequisition::orderBy('created_at', 'desc')->where('agent_service_id', $this->agent_service_id)->paginate(10)
        ]);
    }
}
