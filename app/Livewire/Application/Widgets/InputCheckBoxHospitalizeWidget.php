<?php

namespace App\Livewire\Application\Widgets;

use App\Models\ConsultationRequest;
use Livewire\Component;

class InputCheckBoxHospitalizeWidget extends Component
{
    public bool $is_hospitalized = false;
    public ?ConsultationRequest $consultationRequest;
    public function updatedIsHospitalized($val)
    {
        $this->consultationRequest->is_hospitalized = $val;
        $this->consultationRequest->update();
        $this->dispatch('updated', ['message' => 'Patient marqué hospitalisé']);
        $this->dispatch('refreshConultPatient');
        $this->dispatch('resfreshVitalsign');
    }


    public function mount(ConsultationRequest $consultationRequest){
        $this->consultationRequest=$consultationRequest;

    }
    public function render()
    {
        $this->is_hospitalized = $this->consultationRequest->is_hospitalized;
        return view('livewire.application.widgets.input-check-box-hospitalize-widget');
    }
}
