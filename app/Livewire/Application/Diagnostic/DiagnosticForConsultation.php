<?php

namespace App\Livewire\Application\Diagnostic;

use App\Models\Symptom;
use Livewire\Component;
use App\Models\Diagnostic;
use App\Models\CategoryDiagnostic;
use Illuminate\Support\Facades\DB;
use App\Models\ConsultationRequest;
use Illuminate\Contracts\View\View;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\Foundation\Application;
use App\Livewire\Helpers\Query\MakeQueryBuilderHelper;
use App\Repositories\Sheet\Get\GetDiagnosticRepository;

class DiagnosticForConsultation extends Component
{
    public ?ConsultationRequest $consultationRequest;
    public int $diagnosticSelected, $symptomSelected;
    public int $selectedIndex=0;

    public function changeSelectedIndex(int $index){
        $this->selectedIndex=$index;
    }

    /**
     * Save data in if diagnosticsSelected property updated (Clicked)
     * @return void
     */
    public function updatedDiagnosticSelected(): void
    {
        try {
            $data = DB::table('consultation_request_diagnostic')
                ->where('consultation_request_id', $this->consultationRequest->id)
                ->where('diagnostic_id', $this->diagnosticSelected)
                ->first();
            if ($data) {
                if ($data->diagnostic_id == $this->diagnosticSelected and $data->consultation_request_id == $this->consultationRequest->id) {
                    $diagnostic = Diagnostic::find($this->diagnosticSelected);
                    $this->dispatch('error', ['message' => $diagnostic->name . ' déjà administré']);
                } else {
                    $this->saveDignostics();
                }
            } else {
                $this->saveDignostics();
            }
        } catch (\Exception $exception) {
            $this->dispatch('error', ['message' => $exception->getMessage()]);
        }
    }

    /**
     * Save data in if diagnosticsSelected property updated (Clicked)
     * @return void
     */
    public function updatedSymptomSelected(): void
    {
        try {
            $data = DB::table('consultation_request_symptom')
            ->where('consultation_request_id', $this->consultationRequest->id)
                ->where('symptom_id', $this->symptomSelected)
                ->first();
            if ($data) {
                if ($data->symptom_id == $this->symptomSelected and $data->consultation_request_id == $this->consultationRequest->id) {
                    $diagnostic = Symptom::find($this->symptomSelected);
                    $this->dispatch('error', ['message' => $diagnostic->name . ' déjà ajouté']);
                } else {
                    $this->saveSymptoms();
                }
            } else {
                $this->saveSymptoms();
            }
        } catch (\Exception $exception) {
            $this->dispatch('error', ['message' => $exception->getMessage()]);
        }
    }

    /**
     * Save data in DB
     * @return void
     */
    public function saveDignostics()
    {
        MakeQueryBuilderHelper::create('consultation_request_diagnostic', [
            'consultation_request_id' => $this->consultationRequest->id,
            'diagnostic_id' => $this->diagnosticSelected,
        ]);
        $this->dispatch('refreshConsulting');
        $this->dispatch('refreshDiagnosticItems');
        $this->dispatch('refreshDiagnosticData');
        $this->dispatch('added', ['message' => 'Action bien réalisée']);
    }

    public function saveSymptoms()
    {
        MakeQueryBuilderHelper::create('consultation_request_symptom', [
            'consultation_request_id' => $this->consultationRequest->id,
            'symptom_id' => $this->symptomSelected,
        ]);
        $this->dispatch('refreshConsulting');
        $this->dispatch('refreshDiagnosticItems');
        $this->dispatch('refreshDiagnosticData');
        $this->dispatch('added', ['message' => 'Action bien réalisée']);
    }

    public function mount(ConsultationRequest $consultationRequest)
    {
        $this->consultationRequest = $consultationRequest;
        $this->selectedIndex=CategoryDiagnostic::first()->id;
    }


    /**
     * Render Diagnostic For consultation view
     * @return Application|Factory|View|\Illuminate\Foundation\Application
     */
    public function render()
    {
        return view('livewire.application.diagnostic.diagnostic-for-consultation', [
            'diagnostics' => GetDiagnosticRepository::getDiagnosticListByCategory($this->selectedIndex),
            'symptoms' => GetDiagnosticRepository::getSymptomticListByCategory($this->selectedIndex),
            "categoryDiagnostics" => CategoryDiagnostic::all(),
        ]);
    }
}
