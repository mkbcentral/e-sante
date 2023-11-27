<?php

namespace App\Livewire\Application\Sheet\List;

use App\Models\ConsultationRequest;
use App\Models\Hospital;
use App\Repositories\Sheet\Get\GetConsultationRequestRepository;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class ListConsultationRequest extends Component
{
    use WithPagination;
    protected $listeners=[
        'selectedIndex'=>'getSelectedIndex',
        'listSheetRefreshed'=>'$refresh'
    ];
    public int $selectedIndex;

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
        $this->selectedIndex=$selectedIndex;
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
        $this->dispatch('consultationRequest',$consultationRequest);
    }

    /**
     * Sort data (ASC or DESC)
     * @param $value
     * @return void
     */
    public function sortSheet($value): void
    {
        if($value==$this->sortBy){
            $this->sortAsc=!$this->sortAsc;
        }
        $this->sortBy = $value;
    }
    public  function mount(int $selectedIndex): void
    {
        $this->selectedIndex=$selectedIndex;
    }

    /**
     * Render component
     * @return Application|Factory|View|\Illuminate\Foundation\Application
     */
    public function render()
    {
        return view('livewire.application.sheet.list.list-consultation-request',[
            'listConsultationRequest'=>GetConsultationRequestRepository::getConsultationRequest(
                $this->selectedIndex,
                $this->q,
                $this->sortBy,
                $this->sortAsc
            )
        ]);
    }
}
