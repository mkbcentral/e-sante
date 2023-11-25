<?php

namespace App\Livewire\Application\Sheet\Widget;

use App\Models\ConsultationRequest;
use Livewire\Component;

class AntecedentMedical extends Component
{
    protected $listeners = ['consultationRequest' => 'getConsultation'];
    public ?ConsultationRequest $consultationRequest;

    public function getConsultation(ConsultationRequest $consultationRequest): void
    {
        $this->consultationRequest = $consultationRequest;
    }
    public function render()
    {
        return view('livewire.application.sheet.widget.antecedent-medical');
    }
}
