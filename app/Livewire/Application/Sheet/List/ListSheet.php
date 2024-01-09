<?php

namespace App\Livewire\Application\Sheet\List;

use App\Models\ConsultationSheet;
use App\Repositories\Sheet\Get\GetConsultationSheetRepository;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class ListSheet extends Component
{
    use WithPagination;
    protected $listeners = [
        'selectedIndex' => 'getSelectedIndex',
        'deleteSheetListener' => 'delete',
        'listSheetRefreshed' => '$refresh'
    ];
    public int $selectedIndex;
    public ?ConsultationSheet $sheet = null;
    #[Url(as: 'q')]
    public $q = '';
    #[Url(as: 'sortBy')]
    public $sortBy = 'name';
    #[Url(as: 'sortAsc')]
    public $sortAsc = true;

    /**
     * Get selected Subscription when selectedIndex listener emitted in parent view
     * @param int $selectedIndex
     * @return void
     */
    public function getSelectedIndex(int $selectedIndex): void
    {
        $this->selectedIndex = $selectedIndex;
        $this->resetPage();
    }
    public  function newSheet(): void
    {
        $this->dispatch('selectedIndex', $this->selectedIndex);
        $this->dispatch('emptySheet');
        $this->dispatch('open-form-new');
    }
    /**
     * Open form sheet modal in creation mode
     * @param ConsultationSheet $consultationSheet
     * @return void
     */
    public  function  newRequestForm(ConsultationSheet $consultationSheet): void
    {
        $this->dispatch('open-new-request-form');
        $this->dispatch('consultationSheet', $consultationSheet);
    }
    /**
     * Open form Sheet modal in editable mode
     * @param ConsultationSheet $sheet
     * @return void
     */
    public  function  edit(ConsultationSheet $sheet): void
    {
        $this->dispatch('open-form-new');
        $this->dispatch('sheetInfo', $sheet);
        $this->dispatch('selectedIndex', $this->selectedIndex);
    }
    /**
     * Show delete sheet dialog
     * @param ConsultationSheet $sheet
     * @return void
     */
    public function showDeleteDialog(ConsultationSheet $sheet): void
    {
        $this->sheet = $sheet;
        $this->dispatch('delete-sheet-dialog');
    }
    /**
     * Destroy Consultation sheet
     * @return void
     */
    public function delete(): void
    {
        try {
            if ($this->sheet->consultationRequests->isEmpty()) {
                $this->sheet->delete();
                $this->dispatch('sheet-deleted', ['message' => "Fiche de consultation bien rétiré !"]);
            } else {
                $this->dispatch('error', ['message' => 'Action impossible, SVP, Cette fiche contient pluesieus données']);
            }
        } catch (\Exception $ex) {
            $this->dispatch('error', ['message' => $ex->getMessage()]);
        }
    }
    /**
     * Sort consultation Sheet (ASC or DESC)
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
    /**
     * Mounted component
     * @param int $selectedIndex
     * @return void
     */
    public  function mount(int $selectedIndex): void
    {
        $this->selectedIndex = $selectedIndex;
    }
    /**
     * Render component
     * @return Application|Factory|View|\Illuminate\Foundation\Application
     */
    public function render()
    {
        return view('livewire.application.sheet.list.list-sheet', [
            'sheets' => GetConsultationSheetRepository::getConsultationSheetList(
                $this->selectedIndex,
                $this->q,
                $this->sortBy,
                $this->sortAsc
            )
        ]);
    }
}
