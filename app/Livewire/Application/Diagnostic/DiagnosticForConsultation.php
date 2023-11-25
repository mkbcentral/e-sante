<?php

namespace App\Livewire\Application\Diagnostic;

use App\Models\ConsultationRequest;
use App\Models\Diagnostic;
use App\Models\Hospital;
use Livewire\Component;

class DiagnosticForConsultation extends Component
{
    protected $listeners=['consultationRequest'=>'getConsultationRequest'];
    public ?ConsultationRequest $consultationRequest;
    public array $diagnosticsSelected=[];
    public function updatedDiagnosticsSelected(): void
    {
        try {
            $this->consultationRequest->diagnostics()->sync($this->diagnosticsSelected);
            $this->dispatch('added', ['message' => 'Action bien réalisée']);
            $this->dispatch('refreshConsulting');
        }catch (\Exception $exception){
            $this->dispatch('error', ['message' => $exception->getMessage()]);
        }
    }
    public function getConsultationRequest(ConsultationRequest $consultationRequest): void
    {
        $this->consultationRequest=$consultationRequest;
    }
    public function render()
    {
        return view('livewire.application.diagnostic.diagnostic-for-consultation',[
            'diagnostics'=>Diagnostic::where('hospital_id',Hospital::DEFAULT_HOSPITAL)->get()
        ]);
    }
}
