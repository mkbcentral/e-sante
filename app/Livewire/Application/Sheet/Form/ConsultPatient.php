<?php

namespace App\Livewire\Application\Sheet\Form;

use App\Livewire\Helpers\Query\MakeQueryBuilderHelper;
use App\Models\ConsultationRequest;
use App\Models\Tarif;
use App\Repositories\Tarif\GetListTarifRepository;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Url;
use Livewire\Component;

class ConsultPatient extends Component
{
    protected $listeners = [
        'selectedIndex' => 'getSelectedIndex',
        'refreshConsulting' => '$refresh'
    ];
    public int $tarifsSelected;
    #[Url(as: 'q')]
    public $q = '';
    #[Url(as: 'sortBy')]
    public $sortBy = 'name';
    #[Url(as: 'sortAsc')]
    public $sortAsc = true;
    public int $selectedIndex;
    public ?ConsultationRequest $consultationRequest;


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
                    $this->dispatch('refreshItemsTarifWidget', $this->selectedIndex);
                    $this->dispatch('added', ['message' => 'Action bien réalisée']);
                }
            } else {
                $this->saveData();
                $this->dispatch('refreshItemsTarifWidget', $this->selectedIndex);
                $this->dispatch('added', ['message' => 'Action bien réalisée']);
            }
            $this->dispatch('refreshConultPatient');
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
    public function mount(ConsultationRequest $consultationRequest, int $selectedIndex): void
    {
        $this->selectedIndex = $selectedIndex;
        $this->consultationRequest = $consultationRequest;
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
     * Render view
     * @return Application|Factory|View|\Illuminate\Foundation\Application
     */
    public function render()
    {
        return view('livewire.application.sheet.form.consult-patient', [
            'tarifs' => GetListTarifRepository::getListTarifByCategory($this->selectedIndex, $this->q, $this->sortBy, $this->sortAsc)
        ]);
    }
}
