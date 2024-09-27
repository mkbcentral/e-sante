<?php

namespace App\Livewire\Application\Diagnostic;

use App\Livewire\Helpers\Query\MakeQueryBuilderHelper;
use App\Models\ConsultationRequest;
use App\Models\Diagnostic;
use App\Repositories\Sheet\Get\GetDiagnosticRepository;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class DiagnosticForConsultation extends Component
{
    protected $listeners = ['consultationRequest' => 'getConsultationRequest'];
    public ?ConsultationRequest $consultationRequest;
    public int $diagnosticsSelected;

    /**
     * Save data in if diagnosticsSelected property updated (Clicked)
     * @return void
     */
    public function updatedDiagnosticsSelected(): void
    {
        try {
            $data = DB::table('consultation_request_diagnostic')
                ->where('consultation_request_id', $this->consultationRequest->id)
                ->where('diagnostic_id', $this->diagnosticsSelected)
                ->first();
            if ($data) {
                if ($data->diagnostic_id == $this->diagnosticsSelected and $data->consultation_request_id == $this->consultationRequest->id) {
                    $diagnostic = Diagnostic::find($this->diagnosticsSelected);
                    $this->dispatch('error', ['message' => $diagnostic->name . ' déjà administré']);
                } else {
                    $this->saveData();
                }
            } else {
                $this->saveData();
            }
        } catch (\Exception $exception) {
            $this->dispatch('error', ['message' => $exception->getMessage()]);
        }
    }

    /**
     * Save data in DB
     * @return void
     */
    public function saveData()
    {
        MakeQueryBuilderHelper::create('consultation_request_diagnostic', [
            'consultation_request_id' => $this->consultationRequest->id,
            'diagnostic_id' => $this->diagnosticsSelected,
        ]);
        $this->dispatch('refreshConsulting');
        $this->dispatch('refreshDiagnosticItems');
        $this->dispatch('refreshDiagnosticData');
        $this->dispatch('added', ['message' => 'Action bien réalisée']);
    }

    /**
     * Execute this function if consultationRequest listener emitted
     * To load consultationRequest is selected in parent view
     * @param ConsultationRequest $consultationRequest
     * @return void
     */
    public function getConsultationRequest(ConsultationRequest $consultationRequest): void
    {
        $this->consultationRequest = $consultationRequest;
    }

    /**
     * Render Diagnostic For consultation view
     * @return Application|Factory|View|\Illuminate\Foundation\Application
     */
    public function render()
    {
        return view('livewire.application.diagnostic.diagnostic-for-consultation', [
            'diagnostics' => GetDiagnosticRepository::getDiagnosticList()
        ]);
    }
}
