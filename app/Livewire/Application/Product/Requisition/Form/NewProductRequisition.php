<?php

namespace App\Livewire\Application\Product\Requisition\Form;

use App\Models\Hospital;
use App\Models\ProductRequisition;
use App\Models\Source;
use Exception;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Rule;
use Livewire\Component;

class NewProductRequisition extends Component
{

    protected $listeners = [
        'productRequisition' => 'getProductRequisition'
    ];

    #[Rule('required', message: 'Champs service obligtoire')]
    public $agent_service_id;
    #[Rule('nullable')]
    #[Rule('date', message: 'Date creation format invalide')]
    public $created_at;

    public $formLabel= "NOUVELLE REQUISITION";


    public ?ProductRequisition $productRequisition=null;

    public function getProductRequisition(?ProductRequisition $productRequisition){
        $this->productRequisition=$productRequisition;
        $this->agent_service_id=$productRequisition->agentService->id;
        $this->created_at=$productRequisition->created_at->format('Y-m-d');
        $this->formLabel= "EDITION REQUISITION";

    }

    public function store()
    {
        $fields =  $this->validate();
        try {
            $fields['hospital_id'] = Hospital::DEFAULT_HOSPITAL();
            $fields['source_id'] = Source::DEFAULT_SOURCE();
            $fields['number']=rand(1000,10000);
            ProductRequisition::create($fields);
            $this->dispatch('added', ['message' => 'Action bien réalisée']);
            $this->dispatch('listProductRequisition');
            $this->dispatch('close-new-requisition-modal');
        } catch (Exception $ex) {
            $this->dispatch('error', ['message' => $ex->getMessage()]);
        }
    }

    public function update(){
        $fields =  $this->validate();
        try {
            $this->productRequisition->update($fields);
            $this->dispatch('updated', ['message' => 'Action bien réalisée']);
            $this->dispatch('listProductRequisition');
            $this->dispatch('close-new-requisition-modal');
            $this->productRequisition=null;
            $this->formLabel = "NOUVELLE REQUISITION";
        } catch (Exception $ex) {
            $this->dispatch('error', ['message' => $ex->getMessage()]);
        }
    }

    public function handlerSubmit(){
        if ($this->productRequisition==null) {
            $this->store();
        } else {
           $this->update();
        }

    }

    public function mount(){
        $this->agent_service_id=Auth::user()->agentService->id;
    }

    public function render()
    {
        return view('livewire.application.product.requisition.form.new-product-requisition');
    }
}
