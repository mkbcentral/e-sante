<?php

namespace App\Livewire\Application\Sheet\Widget;

use Livewire\Component;
use App\Models\ConsultationRequest;
use App\Livewire\Helpers\Query\MakeQueryBuilderHelper;

class VitalSignItemsWidget extends Component
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
     * Delete tarif item in this widget
     * @return void
     */
    public function delete($id): void
    {
        try {
            MakeQueryBuilderHelper::delete('consultation_request_vital_sign', 'id', $id,);
            $this->dispatch('item-deleted', ['message' => 'Action bien réalisée']);
        } catch (\Exception $exception) {
            $this->dispatch('error', ['message' => $exception->getMessage()]);
        }
    }

    public function render()
    {
        return view('livewire.application.sheet.widget.vital-sign-items-widget');
    }
}
