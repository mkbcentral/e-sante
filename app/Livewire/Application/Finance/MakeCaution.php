<?php

namespace App\Livewire\Application\Finance;

use App\Models\Caution;
use App\Models\ConsultationRequest;
use Livewire\Attributes\Rule;
use Livewire\Component;

class MakeCaution extends Component
{
    protected $listeners = ['consultationRequestionCaution' => 'getConsultationRequest'];
    public ?ConsultationRequest $consultationRequest;
    #[Rule('required', message: 'Montant obligatoire')]
    #[Rule('numeric', message: 'Montant format invalide')]
    public  $amount;
    public $formLabel= "PASSER CAUTION";
    public function getConsultationRequest(ConsultationRequest $consultationRequest)
    {
        if ($consultationRequest->caution != null) {
            $this->amount=$consultationRequest->caution->amount;
            $this->formLabel= "MODIFIER CAUTION";
        }else{
            $this->amount='';
            $this->formLabel = "PASSER CAUTION";
        }
        $this->consultationRequest = $consultationRequest;
    }

    public function store()
    {
        $this->validate();
        try {
            Caution::create([
                'amount' => $this->amount,
                'consultation_request_id' => $this->consultationRequest->id
            ]);
            $this->dispatch('added', ['message' => 'Action bien réalisée']);
        } catch (\Exception $ex) {
            $this->dispatch('error', ['message' => $ex->getMessage()]);
        }
    }

    public function update()
    {
        $this->validate();
        try {
            $this->consultationRequest->caution->amount = $this->amount;
            $this->consultationRequest->caution->update();
            $this->dispatch('updated', ['message' => 'Action bien réalisée']);
        } catch (\Exception $ex) {
        } catch (\Exception $ex) {
            $this->dispatch('error', ['message' => $ex->getMessage()]);
        }
    }

    public function handlerSubmit(){
        if ($this->consultationRequest->caution==null) {
            $this->store();
        }else{
            $this->update();
        }
        $this->dispatch('close-form-caution');
        $this->dispatch('listHospitalizeRefreshed');
    }


    public function delete(){
        try {
            $this->consultationRequest->caution->delete();
            $this->dispatch('close-form-caution');
        } catch (\Exception $ex) {
            $this->dispatch('error', ['message' => $ex->getMessage()]);
        }
    }

    public function render()
    {
        return view('livewire.application.finance.make-caution');
    }
}
