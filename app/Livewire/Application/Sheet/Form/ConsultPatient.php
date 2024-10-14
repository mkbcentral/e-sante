<?php

namespace App\Livewire\Application\Sheet\Form;

use App\Models\Tarif;
use Livewire\Component;
use Livewire\Attributes\Url;
use Livewire\WithPagination;
use App\Models\CategoryTarif;
use Illuminate\Support\Facades\DB;
use App\Models\ConsultationRequest;
use Illuminate\Contracts\View\View;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\Foundation\Application;
use App\Repositories\Tarif\GetListTarifRepository;
use App\Livewire\Helpers\Query\MakeQueryBuilderHelper;
use App\Repositories\Tarif\GetCategoryTarifRepository;

class ConsultPatient extends Component
{
    use WithPagination;
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
     * Change index item selection on category tarif
     * @param CategoryTarif $category
     * @return void
     */
    public  function changeIndex(CategoryTarif $category): void
    {
        $this->selectedIndex = $category->id;
    }

    /**
     * Mounted compoenent
     * @param ConsultationRequest $consultationRequest
     * @param int $selectedIndex
     * @return void
     */
    public function mount(ConsultationRequest $consultationRequest): void
    {
        $this->consultationRequest = $consultationRequest;
        $category = CategoryTarif::where('name', 'like', '%LABO%')->first();
        if ($category) {
            $this->selectedIndex = $category->id;
        }
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
            'categories' => GetCategoryTarifRepository::getListCategories(),
            'tarifs' => GetListTarifRepository::getListTarifByCategory($this->selectedIndex, $this->q, $this->sortBy, $this->sortAsc)
        ]);
    }
}
