<?php

namespace App\Livewire\Application\Sheet\Widget;

use App\Models\Tarif;
use Livewire\Component;
use App\Models\Currency;
use App\Models\Hospital;
use App\Models\CategoryTarif;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use App\Models\ConsultationRequest;
use App\Repositories\Tarif\GetListTarifRepository;
use App\Livewire\Helpers\Query\MakeQueryBuilderHelper;

class ItemTarifByCategoryWidget extends Component
{
    protected $listeners = [
        'currencyName' => 'getCurrencyName',
        'consultationRequestItemsTarif' => 'getConsultationRequest'
    ];
    public ConsultationRequest $consultationRequest;
    public int $idSelected = 0, $qty = 1, $idTarif = 0,$idTarifToAdd;
    public bool $isEditing = false;
    public ?Collection $tarifs;
    public ?Tarif $tarif;
    public $categoryIdSelected=0;
    public $is_add = false;

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

    public function newTarifItem($categoryId){
        $this->categoryIdSelected=$categoryId;
        $this->is_add=true;
    }

    /**
     * Call update function if IdTarif updated (Clicked)
     * @return void
     */
    public function updatedIdTarif(): void
    {
        $this->update();
    }

    public function updatedIdTarifToAdd($val){
        try {
            $data = DB::table('consultation_request_tarif')
                ->where('consultation_request_id', $this->consultationRequest->id)
                ->where('tarif_id', $val)
                ->first();
            if ($data) {
                  $tarif = Tarif::find($val);
                    $this->dispatch('error', ['message' => $tarif->name . ' déjà administré']);
            } else {
              MakeQueryBuilderHelper::create('consultation_request_tarif', [
            'consultation_request_id' => $this->consultationRequest->id,
            'tarif_id' => $val,
        ]);
        $this->dispatch('added', ['message' => 'Action bien réalisée']);
            }
            $this->dispatch('refreshConultPatient');
        } catch (\Exception $exception) {
            $this->dispatch('error', ['message' => $exception->getMessage()]);
        }
    }

    public function getConsultationRequest(?ConsultationRequest $consultationRequest)
    {
        $this->consultationRequest = $consultationRequest;

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
        $this->is_add = false;
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
            $this->is_add = false;
            $this->idSelected = 0;
            $this->dispatch('listSheetRefreshed');
            $this->dispatch('refreshDetail');
            $this->dispatch('refreshAmount');
            $this->dispatch('consultationRequestItemsTarif', $this->consultationRequest);
            $this->dispatch('consultationRequestProductItems', $this->consultationRequest);
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
            $this->dispatch('refreshAmount');
        } catch (\Exception $exception) {
            $this->dispatch('error', ['message' => $exception->getMessage()]);
        }
    }

    public function mount( ConsultationRequest $consultationRequest): void
    {
        $this->consultationRequest = $consultationRequest;
    }
    public function render()
    {
        return view('livewire.application.sheet.widget.item-tarif-by-category-widget',[
                'categoriesTarif' => CategoryTarif::where('hospital_id', Hospital::DEFAULT_HOSPITAL())->get()
            ]);
    }
}
