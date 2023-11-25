<?php

namespace App\Livewire\Application\Sheet\List;

use App\Models\ConsultationSheet;
use App\Models\Hospital;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class ListSheet extends Component
{
    use WithPagination;
    protected $listeners=[
        'selectedIndex'=>'getSelectedIndex',
        'deleteSheetListener'=>'delete',
        'listSheetRefreshed'=>'$refresh'
    ];
    public int $selectedIndex;
    public ?ConsultationSheet $sheet=null;
    #[Url(as: 'q')]
    public $q = '';
    #[Url(as: 'sortBy')]
    public $sortBy = 'name';
    #[Url(as: 'sortAsc')]
    public $sortAsc = true;


    public function getSelectedIndex(int $selectedIndex): void
    {
        $this->selectedIndex=$selectedIndex;
        $this->resetPage();
    }
    public  function newSheet(): void
    {
        $this->dispatch('selectedIndex',$this->selectedIndex);
        $this->dispatch('sheetInfo');
        $this->dispatch('open-form-new');
    }
    public  function  newRequestForm(ConsultationSheet $consultationSheet): void
    {
        $this->dispatch('open-new-request-form');
        $this->dispatch('consultationSheet',$consultationSheet);
    }
    public  function  edit(ConsultationSheet $sheet): void
    {
        $this->dispatch('open-form-new');
        $this->dispatch('sheetInfo',$sheet);
        $this->dispatch('selectedIndex',$this->selectedIndex);
    }
    public function showDeleteDialog(ConsultationSheet $sheet): void
    {
        $this->sheet=$sheet;
        $this->dispatch('delete-sheet-dialog');
    }
    public function delete(): void
    {
        try {
            $this->sheet->delete();
            $this->dispatch('sheet-deleted', ['message' => "Fiche de consultation bien rétiré !"]);
        }catch (\Exception $ex){
            $this->dispatch('error', ['message' => $ex->getMessage()]);
        }
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
        return view('livewire.application.sheet.list.list-sheet',[
            'sheets'=>ConsultationSheet::join('subscriptions','subscriptions.id','consultation_sheets.subscription_id')
                ->where('consultation_sheets.subscription_id',$this->selectedIndex)
                ->when($this->q, function ($query) {
                    return $query->where(function ($query) {
                        return $query->where('consultation_sheets.name', 'like', '%' . $this->q . '%')
                            ->orWhere('consultation_sheets.email', 'like', '%' . $this->q . '%')
                            ->orWhere('consultation_sheets.number_sheet', 'like', '%' . $this->q . '%')
                            ->orWhere('consultation_sheets.phone', 'like', '%' . $this->q . '%')
                            ->orWhere('consultation_sheets.registration_number', 'like', '%' . $this->q . '%');
                    });
                })->orderBy($this->sortBy, $this->sortAsc ? 'ASC' : 'DESC')
                ->select('consultation_sheets.*','subscriptions.name as subscription')
                ->where('consultation_sheets.hospital_id',Hospital::DEFAULT_HOSPITAL)
                ->paginate(10)
        ]);
    }
}
