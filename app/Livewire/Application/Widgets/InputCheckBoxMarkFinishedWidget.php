<?php

namespace App\Livewire\Application\Widgets;

use App\Models\ConsultationRequest;
use Livewire\Component;

class InputCheckBoxMarkFinishedWidget extends Component
{
    public bool $is_finished = false;
    public ?ConsultationRequest $consultationRequest;
    public function updatedIsFinished($val)
    {
        $this->consultationRequest->is_finished = $val;
        $this->consultationRequest->update();
        $this->dispatch('added', ['message' => 'Patient marqué terminé']);
        $this->dispatch('refreshConultPatient');
        $this->dispatch('resfreshVitalsign');
    }


    public function mount(ConsultationRequest $consultationRequest)
    {
        $this->consultationRequest = $consultationRequest;
    }
    public function render()
    {
        $this->is_finished = $this->consultationRequest->is_finished;
        return view('livewire.application.widgets.input-check-box-mark-finished-widget');
    }
}
