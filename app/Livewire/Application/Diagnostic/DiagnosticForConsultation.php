<?php

namespace App\Livewire\Application\Diagnostic;

use App\Models\ConsultationRequest;
use App\Models\Diagnostic;
use Livewire\Component;

class DiagnosticForConsultation extends Component
{
    public ?ConsultationRequest $consultationRequest;
    public array $diagnosticsSelected=[];
    public function mount(ConsultationRequest $consultationRequest): void
    {
        $this->consultationRequest=$consultationRequest;
    }

    public  function addToConsultation(): void
    {
        try {
            if ($this->diagnosticsSelected==[]){
                $this->dispatch('error', ['message' => 'Aucun élément selectionner SVP !']);
            }else{
                $this->consultationRequest->diagnostics()->sync($this->diagnosticsSelected);
                $this->dispatch('added', ['message' => 'Action bien réalisée']);
            }
        }catch (\Exception $exception){
            $this->dispatch('error', ['message' => $exception->getMessage()]);
        }
    }
    public function render()
    {
        return view('livewire.application.diagnostic.diagnostic-for-consultation',[
            'diagnostics'=>Diagnostic::where('hospital_id',1)->get()
        ]);
    }
}
