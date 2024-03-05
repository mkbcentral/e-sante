<?php

namespace App\Livewire\Application\Labo\Screens;

use App\Livewire\Helpers\Query\MakeQueryBuilderHelper;
use App\Models\ConsultationRequest;
use App\Models\OutpatientBill;
use App\Models\Tarif;
use App\Repositories\Tarif\GetListTarifRepository;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Url;
use Livewire\Component;

class MakeLaboOutpatientBillView extends Component
{
    public ?OutpatientBill $outpatientBill;

    public int $tarifsSelected;
    #[Url(as: 'q')]
    public $q = '';
    #[Url(as: 'sortBy')]
    public $sortBy = 'name';
    #[Url(as: 'sortAsc')]
    public $sortAsc = true;
    public int $selectedIndex = 1;
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
            $data = DB::table('outpatient_bill_tarif')
            ->where('outpatient_bill_id', $this->outpatientBill->id)
                ->where('tarif_id', $this->tarifsSelected)
                ->first();
            if ($data) {
                if (
                    $data->tarif_id == $this->tarifsSelected and $data->outpatient_bill_id
                    == $this->outpatientBill->id
                ) {
                    $tarif = Tarif::find($this->tarifsSelected);
                    $this->dispatch('error', ['message' => $tarif->name . ' déjà administré']);
                } else {
                    $this->saveData();
                    $this->dispatch('added', ['message' => 'Action bien réalisée']);
                }
            } else {
                $this->saveData();
                $this->dispatch('refreshItemsTarifWidget', $this->selectedIndex);
                $this->dispatch('added', ['message' => 'Action bien réalisée']);
                $this->dispatch('listLaboOutpatientBillRefreshed');
            }
        } catch (\Exception $exception) {
            $this->dispatch('error', ['message' => $exception->getMessage()]);
        }
    }

    public function saveData()
    {
        MakeQueryBuilderHelper::create('outpatient_bill_tarif', [
            'outpatient_bill_id' => $this->outpatientBill->id,
            'tarif_id' => $this->tarifsSelected,
        ]);
    }


    public function mount(OutpatientBill $outpatientBill){
        $this->outpatientBill=$outpatientBill;
    }
    public function render()
    {
        return view('livewire.application.labo.screens.make-labo-outpatient-bill-view', [
            'tarifs' => GetListTarifRepository::getListTarifByCategory(1, $this->q, $this->sortBy, $this->sortAsc)
        ]);
    }
}
