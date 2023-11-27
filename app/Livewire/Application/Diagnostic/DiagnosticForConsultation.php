<?php

namespace App\Livewire\Application\Diagnostic;

use App\Models\ConsultationRequest;
use App\Models\Diagnostic;
use App\Models\Hospital;
use App\Repositories\Sheet\Get\GetDiagnosticRepository;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;
class DiagnosticForConsultation extends Component
{
    protected $listeners=['consultationRequest'=>'getConsultationRequest'];
    public ?ConsultationRequest $consultationRequest;
    public array $diagnosticsSelected=[];
    /**
     * Save data in if diagnosticsSelected property updated (Clicked)
     * @return void
     */
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
    /**
     * Execute this function if consultationRequest listener emitted
     * To load consultationRequest is selected in parent view
     * @param ConsultationRequest $consultationRequest
     * @return void
     */
    public function getConsultationRequest(ConsultationRequest $consultationRequest): void
    {
        $this->consultationRequest=$consultationRequest;
    }
    /**
     * Render Diagnostic For consultation view
     * @return Application|Factory|View|\Illuminate\Foundation\Application
     */
    public function render()
    {
        return view('livewire.application.diagnostic.diagnostic-for-consultation',[
            'diagnostics'=>GetDiagnosticRepository::getDiagnosticList()
        ]);
    }
}
