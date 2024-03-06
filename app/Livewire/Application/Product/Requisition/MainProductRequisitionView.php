<?php

namespace App\Livewire\Application\Product\Requisition;

use App\Models\ProductRequisition;
use Exception;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class MainProductRequisitionView extends Component
{
    use WithPagination;
    protected $listeners = [
        'listProductRequisition' => '$refresh'
    ];
    public $agent_service_id;
    public $month;
    public function updatedAgentServiceId($val)
    {
        $this->agent_service_id = $val;
    }

    public function refreshList()
    {
        $this->agent_service_id = null;
    }

    public function openAddModal()
    {
        $this->dispatch('open-new-requisition-modal');
    }

    public function openListAmount()
    {
        $this->dispatch('open-list-amount-requisition-by-service');
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
            if ($productRequisition->productRequistionProducts->isEmpty()) {
                $productRequisition->delete();
                $this->dispatch('updated', ['message' => 'Action bien réalisée']);
            } else {
                $this->dispatch('error', ['message' => 'Action impossible, car la requistion contient des produits']);
            }
        } catch (Exception $ex) {

            $this->dispatch('error', ['message' => $ex->getMessage()]);
        }
    }

    public function changeStatus(?ProductRequisition $productRequisition)
    {
        try {
            if ($productRequisition->is_valided == true) {
                $productRequisition->is_valided = false;
            } else {
                $productRequisition->is_valided = true;
            }
            $productRequisition->update();
            $this->dispatch('added', ['message' => 'Action bien réalisée']);
        } catch (Exception $ex) {

            $this->dispatch('error', ['message' => $ex->getMessage()]);
        }
    }

    public function mount()
    {
        $this->month = date('m');
    }

    public function render()
    {
        if (Auth::user()->roles->pluck('name')->contains('Depot-Pharma')) {
            $productRequisitions = $this->agent_service_id == null ?
                ProductRequisition::orderBy('created_at', 'desc')
                ->whereMonth('created_at', $this->month)
                ->paginate(10) :
                ProductRequisition::orderBy('created_at', 'desc')
                ->whereMonth('created_at', $this->month)
                ->where('agent_service_id', $this->agent_service_id)
                ->paginate(10);
        } elseif (Auth::user()->roles->pluck('name')->contains('Nurse')) {
            $productRequisitions = ProductRequisition::orderBy('created_at', 'desc')
                ->whereIn('agent_service_id', [Auth::user()->agentService->id,5,6,7])
                ->whereMonth('created_at', $this->month)
                ->paginate(10);
        } else {
            $productRequisitions = ProductRequisition::orderBy('created_at', 'desc')
                ->where('agent_service_id', Auth::user()->agentService->id)
                ->whereMonth('created_at', $this->month)
                ->paginate(10);
        }
        return view('livewire.application.product.requisition.main-product-requisition-view', [
            'productRequisitions' => $productRequisitions
        ]);
    }
}
