<?php

namespace App\Livewire\Application\Sheet\Widget;

use App\Livewire\Helpers\Query\MakeQueryBuilderHelper;
use App\Repositories\Sheet\Get\GetConsultationRequestRepository;
use Livewire\Component;

class DoctorTarifItemsWithConsultationWidget extends Component
{
    protected $listeners = [
        'refreshItemsTarifWidget' => 'getSelectedCategoryTarif',
        'refreshTarifItems' => '$refresh',
        'deleteItemListener' => 'delete'
    ];
    public int $tarifId, $consultationRequestId, $idItem;

    /**
     * Get category tarif id if refreshItemsTarifWidget emitted
     * @param int $tarifId
     * @return void
     */
    public function getSelectedCategoryTarif(int $tarifId): void
    {
        $this->tarifId = $tarifId;
    }

    /**
     * Mounted component
     * @param int $tarifId
     * @param int $consultationRequestId
     * @return void
     */
    public function mount(int $tarifId, int $consultationRequestId): void
    {
        $this->tarifId = $tarifId;
        $this->consultationRequestId = $consultationRequestId;
    }
    /**
     * Show delete dialog to confirm delete tarif item
     * @param $id
     * @return void
     */
    public function showDeleteDialog($id): void
    {
        $this->idItem = $id;
        $this->dispatch('delete-item-dialog');
    }
    /**
     * Delete tarif item in this widget
     * @return void
     */
    public function delete(): void
    {
        try {
            MakeQueryBuilderHelper::delete('consultation_request_tarif', 'id', $this->idItem,);
            $this->dispatch('item-deleted', ['message' => 'Action bien réalisée']);
        } catch (\Exception $exception) {
            $this->dispatch('error', ['message' => $exception->getMessage()]);
        }
    }
    public function render()
    {
        return view('livewire.application.sheet.widget.doctor-tarif-items-with-consultation-widget',[
            'tarifs' => GetConsultationRequestRepository::getConsultationTarifItemByCategoryTarif($this->consultationRequestId, $this->tarifId)
        ]);
    }
}
