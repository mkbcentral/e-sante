<?php

namespace App\Livewire\Application\Sheet\Widget;

use App\Livewire\Helpers\Query\MakeQueryBuilderHelper;
use App\Models\CategoryTarif;
use App\Models\ConsultationRequest;
use App\Models\Hospital;
use App\Models\Tarif;
use App\Repositories\Tarif\GetListTarifRepository;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Livewire\Component;

class ConsultationRequestDetail extends Component
{
    protected $listeners = ['consultationRequest' => 'getConsultation'];
    public ?ConsultationRequest $consultationRequest;
    public int $idSelected = 0, $qty = 1, $idTarif = 0;
    public bool $isEditing = false;
    public ?Collection $tarifs;
    public ?Tarif $tarif;

    /**
     * Get Consultation Sheet if listener emitted in parent view
     * @param ConsultationRequest $consultationRequest
     * @return void
     */
    public function getConsultation(ConsultationRequest $consultationRequest): void
    {
        $this->consultationRequest = $consultationRequest;
    }

    /**
     * Call update function if IdTarif updated (Clicked)
     * @return void
     */
    public function updatedIdTarif(): void
    {
        $this->update();
    }

    /**
     * Edit item tarif on detail Consultation Request
     * @param int $id
     * @param int $qty
     * @param $categoryId
     * @param $idTarif
     * @return void
     */
    public function edit(int $id, int $qty, $categoryId, $idTarif): void
    {
        $this->idSelected = $id;
        $this->isEditing = true;
        $this->qty = $qty;
        $this->idTarif = $idTarif;
        $this->tarifs = GetListTarifRepository::getSimpleTarifByCategory($categoryId);
    }

    /**
     * Update item tarif selected on consultation Request
     * @return void
     */
    public function update(): void
    {
        try {
            if ($this->idTarif == 0) {
                MakeQueryBuilderHelper::update(
                    $this->idSelected,
                    ['qty' => $this->qty], 'consultation_request_tarif');
            } else {
                MakeQueryBuilderHelper::update(
                    $this->idSelected,
                    ['qty' => $this->qty, 'tarif_id' => $this->idTarif],
                    'consultation_request_tarif'
                );
            }
            $this->dispatch('updated', ['message' => 'Action bien réalisée']);
            $this->isEditing = false;
            $this->idSelected = 0;
        } catch (\Exception $exception) {
            $this->dispatch('error', ['message' => $exception->getMessage()]);
        }
    }

    /**
     * Delete item tarif on consultation request
     * @param int $id
     * @return void
     */
    public function delete(int $id): void
    {
        try {
            MakeQueryBuilderHelper::delete($id, 'consultation_request_tarif');
            $this->dispatch('updated', ['message' => 'Action bien réalisée']);
        } catch (\Exception $exception) {
            $this->dispatch('error', ['message' => $exception->getMessage()]);
        }
    }

    /**
     * Render component
     * @return Application|Factory|View|\Illuminate\Foundation\Application
     */
    public function render()
    {
        return view('livewire.application.sheet.widget.consultation-request-detail', [
                'categoriesTarif' => CategoryTarif::where('hospital_id', Hospital::DEFAULT_HOSPITAL)->get()
            ]
        );
    }
}
