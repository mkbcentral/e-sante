<?php

namespace App\Livewire\Application\Diagnostic;

use App\Models\ConsultationRequest;
use App\Models\Diagnostic;
use Livewire\Component;

class DiagnosticForConsultation extends Component
{
    public ?ConsultationRequest $consultationRequest;
    public function mount(ConsultationRequest $consultationRequest): void
    {
        $this->consultationRequest=$consultationRequest;
    }
    public function render()
    {
        return view('livewire.application.diagnostic.diagnostic-for-consultation',[
            'diagnostics'=>Diagnostic::where('hospital_id',1)->get()
        ]);
    }
}
