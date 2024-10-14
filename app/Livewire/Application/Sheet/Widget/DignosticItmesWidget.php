<?php

namespace App\Livewire\Application\Sheet\Widget;

use Livewire\Component;
use App\Models\ConsultationRequest;
use App\Livewire\Helpers\Query\MakeQueryBuilderHelper;

class DignosticItmesWidget extends Component
{
    protected $listeners = [
        'refreshDiagnosticItems' => '$refresh',
    ];
    public ConsultationRequest $consultationRequest;
    /**
     * Mounted component
     * @param int $tarifId
     * @param int $consultationRequestId
     * @return void
     */
    public function mount(ConsultationRequest $consultationRequest): void
    {
        $this->consultationRequest = $consultationRequest;
    }
    /**
     * Delete diagnostic item in this widget
     * @return void
     */
    public function deleteDiagnostic($id): void
    {
        try {
            MakeQueryBuilderHelper::delete('consultation_request_diagnostic', 'id', $id,);
            $this->dispatch('item-deleted', ['message' => 'Action bien réalisée']);
        } catch (\Exception $exception) {
            $this->dispatch('error', ['message' => $exception->getMessage()]);
        }
    }

    /**
     * Delete tarif item in this widget
     * @return void
     */
    public function deleteSymptom($id): void
    {
        try {
            MakeQueryBuilderHelper::delete('consultation_request_symptom', 'id', $id,);
            $this->dispatch('item-deleted', ['message' => 'Action bien réalisée']);
        } catch (\Exception $exception) {
            $this->dispatch('error', ['message' => $exception->getMessage()]);
        }
    }

    public function render()
    {
        return view('livewire.application.sheet.widget.dignostic-itmes-widget');
    }
}
