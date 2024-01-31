<?php

namespace App\Livewire\Application\Sheet\Widget;

use App\Livewire\Helpers\Query\MakeQueryBuilderHelper;
use App\Models\CategoryTarif;
use App\Models\ConsultationRequest;
use App\Models\Currency;
use App\Models\Tarif;
use App\Repositories\Tarif\GetListTarifRepository;
use Illuminate\Support\Collection;
use Livewire\Component;

class ItemTarifByCategoryWidget extends Component
{
    protected $listeners = ['currencyName' => 'getCurrencyName'];
    public ?CategoryTarif $categoryTarif;
    public ConsultationRequest $consultationRequest;
    public int $idSelected = 0, $qty = 1, $idTarif = 0;
    public bool $isEditing = false;
    public ?Collection $tarifs;
    public ?Tarif $tarif;

    public string $currencyName = Currency::DEFAULT_CURRENCY;

    /**
     * getCurrencyName
     * Get currency name
     * @param  mixed $currency
     * @return void
     */
    public function getCurrencyName(string $currency)
    {
        $this->currencyName = $currency;
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
                    'consultation_request_tarif',
                    'id',
                    $this->idSelected,
                    ['qty' => $this->qty]
                );
            } else {
                MakeQueryBuilderHelper::update(
                    'consultation_request_tarif',
                    'id',
                    $this->idSelected,
                    ['qty' => $this->qty, 'tarif_id' => $this->idTarif],
                );
            }
            $this->dispatch('updated', ['message' => 'Action bien réalisée']);
            $this->isEditing = false;
            $this->idSelected = 0;
            $this->dispatch('listSheetRefreshed');
            $this->dispatch('refreshDetail');
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
            MakeQueryBuilderHelper::delete('consultation_request_tarif', 'id', $id,);
            $this->dispatch('updated', ['message' => 'Action bien réalisée']);
            $this->dispatch('refreshTarifItems');
            $this->dispatch('listSheetRefreshed');
            $this->dispatch('refreshDetail');
        } catch (\Exception $exception) {
            $this->dispatch('error', ['message' => $exception->getMessage()]);
        }
    }

    public function mount(?CategoryTarif $categoryTarif, ConsultationRequest $consultationRequest): void
    {

        $this->categoryTarif = $categoryTarif;
        $this->consultationRequest = $consultationRequest;
    }
    public function render()
    {
        return view('livewire.application.sheet.widget.item-tarif-by-category-widget');
    }
}
