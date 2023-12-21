<?php

namespace App\Livewire\Application\Finance\Billing\Form\Widget;

use App\Livewire\Helpers\Query\MakeQueryBuilderHelper;
use App\Models\OutpatientBill;
use App\Models\Tarif;
use App\Repositories\Tarif\GetListTarifRepository;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Url;
use Livewire\Component;

class TarifItemsWithOutpatientBill extends Component
{
    protected $listeners = [
        'selectedIndex' => 'getSelectedIndex',
        'refreshConsulting' => '$refresh',
        'outpatientSelected' => 'getSelectedOutpatient'
    ];
    public int $tarifsSelected;
    #[Url(as: 'q')]
    public $q = '';
    #[Url(as: 'sortBy')]
    public $sortBy = 'name';
    #[Url(as: 'sortAsc')]
    public $sortAsc = true;
    public int $selectedIndex;
    public ?OutpatientBill $outpatientBill;

    public function getSelectedOutpatient(?OutpatientBill $outpatientBill)
    {
        $this->outpatientBill = $outpatientBill;
    }

    /**
     * Execute this function if Category tarif Selected and listener emitted
     * @param int $selectedIndex
     * @return void
     */
    public function getSelectedIndex(int $selectedIndex): void
    {
        $this->selectedIndex = $selectedIndex;
    }

    /**
     * Mounted compoenent
     * @param ConsultationRequest $consultationRequest
     * @param int $selectedIndex
     * @return void
     */
    public function mount(?OutpatientBill $outpatientBill, int $selectedIndex): void
    {
        $this->selectedIndex = $selectedIndex;
        $this->outpatientBill=$outpatientBill;
    }

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
                if ($data->tarif_id == $this->tarifsSelected and $data->outpatient_bill_id
                         == $this->outpatientBill->id) {
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
                $this->dispatch('refreshUsdAmount');
                $this->dispatch('refreshCdfAmount');
                $this->dispatch('refreshListItemsOupatient');
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



    public function render()
    {
        return view('livewire.application.finance.billing.form.widget.tarif-items-with-outpatient-bill', [
            'tarifs' => GetListTarifRepository::getListTarifByCategory($this->selectedIndex, $this->q, $this->sortBy, $this->sortAsc)
        ]);
    }
}
