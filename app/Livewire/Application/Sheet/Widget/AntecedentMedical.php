<?php

namespace App\Livewire\Application\Sheet\Widget;

use App\Models\ConsultationRequest;
use App\Models\ConsultationSheet;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class AntecedentMedical extends Component
{
    protected $listeners = ['consultationRequest' => 'getConsultation'];
    public ?ConsultationRequest $consultationRequest;
    public ?ConsultationSheet $consultationSheet;

    /**
     * Get Consultation Request if listener emitted in parent view
     * @param ConsultationRequest $consultationRequest
     * @return void
     */
    public function getConsultation(ConsultationRequest $consultationRequest): void
    {
        $this->consultationRequest = $consultationRequest;
        $this->consultationSheet = ConsultationSheet::find($consultationRequest->consultationSheet->id);
    }

    /**
     * Render component
     * @return Application|Factory|View|\Illuminate\Foundation\Application
     */
    public function render()
    {
        return view('livewire.application.sheet.widget.antecedent-medical');
    }
}
