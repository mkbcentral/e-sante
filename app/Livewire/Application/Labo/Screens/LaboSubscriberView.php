<?php

namespace App\Livewire\Application\Labo\Screens;

use App\Livewire\Helpers\Query\MakeQueryBuilderHelper;
use App\Models\ConsultationRequest;
use App\Models\Tarif;
use App\Repositories\Tarif\GetListTarifRepository;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Url;
use Livewire\Component;

class LaboSubscriberView extends Component
{
    public int $tarifsSelected;
    #[Url(as: 'q')]
    public $q = '';
    #[Url(as: 'sortBy')]
    public $sortBy = 'name';
    #[Url(as: 'sortAsc')]
    public $sortAsc = true;
    public int $selectedIndex=1;
    public ?ConsultationRequest $consultationRequest;


    /**
     * Sorted data
     * @param $value
     * @return void
     */
    public function sortTarif($value): void
    {
        if ($value == $this->sortBy) {
            $this->sortAsc = !$this->sortAsc;
        }
        $this->sortBy = $value;
    }

    /**
     * Save tarif items after property tarifsSelected updated (Clicked)
     * @param $val
     * @return void
     */
    public function updatedTarifsSelected($val): void
    {
        try {
            $data = DB::table('consultation_request_tarif')
            ->where('consultation_request_id', $this->consultationRequest->id)
                ->where('tarif_id', $this->tarifsSelected)
                ->first();
            if ($data) {
                if ($data->tarif_id == $this->tarifsSelected and $data->consultation_request_id == $this->consultationRequest->id) {
                    $tarif = Tarif::find($this->tarifsSelected);
                    $this->dispatch('error', ['message' => $tarif->name . ' déjà administré']);
                } else {
                    $this->saveData();
                    $this->dispatch('listLaboRefreshed', $this->selectedIndex);
                    $this->dispatch('added', ['message' => 'Action bien réalisée']);
                }
            } else {
                $this->saveData();
                $this->dispatch('listLaboRefreshed', $this->selectedIndex);
                $this->dispatch('added', ['message' => 'Action bien réalisée']);
            }
        } catch (\Exception $exception) {
            $this->dispatch('error', ['message' => $exception->getMessage()]);
        }
    }

    public function saveData()
    {
        MakeQueryBuilderHelper::create('consultation_request_tarif', [
            'consultation_request_id' => $this->consultationRequest->id,
            'tarif_id' => $this->tarifsSelected,
        ]);
    }



    public function mount(?ConsultationRequest $consultationRequest)
    {
        $this->consultationRequest = $consultationRequest;
    }
    public function render()
    {
        return view('livewire.application.labo.screens.labo-subscriber-view', [
            'tarifs' => GetListTarifRepository::getListTarifByCategory(1, $this->q, $this->sortBy, $this->sortAsc)
        ]);
    }
}
