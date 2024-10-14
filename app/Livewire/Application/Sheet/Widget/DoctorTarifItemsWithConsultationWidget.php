<?php

namespace App\Livewire\Application\Sheet\Widget;

use Livewire\Component;
use App\Models\ConsultationRequest;
use App\Livewire\Helpers\Query\MakeQueryBuilderHelper;
use App\Repositories\Tarif\GetCategoryTarifRepository;

class DoctorTarifItemsWithConsultationWidget extends Component
{
    protected $listeners = [
        'refreshItemsTarifWidget' => 'getSelectedCategoryTarif',
        'refreshTarifItems' => '$refresh',
        'deleteItemListener' => 'delete'
    ];
    public int  $idItem;
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
            'categories' => GetCategoryTarifRepository::getListCategories(),
        ]);
    }
}
