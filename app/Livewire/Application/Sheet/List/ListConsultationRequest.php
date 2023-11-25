<?php

namespace App\Livewire\Application\Sheet\List;

use App\Models\ConsultationRequest;
use App\Models\Hospital;
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


    public function getSelectedIndex(int $selectedIndex): void
    {
        $this->selectedIndex=$selectedIndex;
        $this->resetPage();
    }

    public  function openVitalSignForm(ConsultationRequest $consultationRequest): void
    {
        $this->dispatch('open-vital-sign-form');
        $this->dispatch('consultationRequest',$consultationRequest);
    }

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

    public function render()
    {
        return view('livewire.application.sheet.list.list-consultation-request',[
            'listConsultationRequest'=>ConsultationRequest::
                join('consultation_sheets','consultation_sheets.id','consultation_requests.consultation_sheet_id')
                ->where('consultation_sheets.subscription_id',$this->selectedIndex)
                ->when($this->q, function ($query) {
                    return $query->where(function ($query) {
                        return $query->where('consultation_sheets.name', 'like', '%' . $this->q . '%')
                            ->orWhere('consultation_sheets.number_sheet', 'like', '%' . $this->q . '%');
                    });
                })->orderBy($this->sortBy, $this->sortAsc ? 'ASC' : 'DESC')
                ->select('consultation_requests.*')
                ->with(['consultationSheet.subscription'])
                ->where('consultation_sheets.hospital_id',Hospital::DEFAULT_HOSPITAL)
                ->paginate(15)
        ]);
    }
}
