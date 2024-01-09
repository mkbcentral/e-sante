<?php

namespace App\Livewire\Application\Sheet\List;

use App\Models\ConsultationRequest;
use App\Repositories\Sheet\Get\GetConsultationRequestRepository;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class ListConsultationRequestByMonth extends Component
{
    use WithPagination;
    protected $listeners = [
        'selectedIndex' => 'getSelectedIndex',
        'listSheetRefreshed' => '$refresh'
    ];
    public int $selectedIndex;
    public string $month_name = '';
    public string $year = '';

    #[Url(as: 'q')]
    public string $q = '';
    #[Url(as: 'sortBy')]
    public $sortBy = 'name';
    #[Url(as: 'sortAsc')]
    public $sortAsc = true;

    /**
     * Get Consultation Sheet if listener emitted in parent veiew
     * @param int $selectedIndex
     * @return void
     */
    public function getSelectedIndex(int $selectedIndex): void
    {
        $this->selectedIndex = $selectedIndex;
        $this->resetPage();
    }

    /**
     * Open vital sign modal
     * @param ConsultationRequest $consultationRequest
     * @return void
     */
    public  function openVitalSignForm(ConsultationRequest $consultationRequest): void
    {
        $this->dispatch('open-vital-sign-form');
        $this->dispatch('consultationRequest', $consultationRequest);
    }

    /**
     * Sort data (ASC or DESC)
     * @param $value
     * @return void
     */
    public function sortSheet($value): void
    {
        if ($value == $this->sortBy) {
            $this->sortAsc = !$this->sortAsc;
        }
        $this->sortBy = $value;
    }
    public  function mount(int $selectedIndex): void
    {
        $this->selectedIndex = $selectedIndex;
        $this->month_name = date('m');
        $this->year = date('Y');
    }

    public function render()
    {
        return view('livewire.application.sheet.list.list-consultation-request-by-month',[
            'listConsultationRequest' => GetConsultationRequestRepository::getConsultationRequestByDateMonth(
                $this->selectedIndex,
                $this->q,
                $this->sortBy,
                $this->sortAsc,
                10,
                $this->month_name,
                $this->year
            )
        ]);
    }
}
