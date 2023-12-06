<?php

namespace App\Livewire\Application\Sheet\Widget;

use App\Livewire\Helpers\Query\MakeQueryBuilderHelper;
use App\Models\ConsultationSheet;
use Livewire\Component;

class FreshDiagnosticInfoWidget extends Component
{
    protected $listeners=[
        'refreshDiagnosticData'=>'$refresh',
        'deleteIDiagnosticListener'=>'delete'
    ];
    public ?ConsultationSheet $consultationSheet;
    public int $idItem;
    public function showDeleteDialog($id): void
    {
        $this->idItem=$id;
        $this->dispatch('delete-diagnostic-dialog');
    }
    public function delete(): void
    {
        try {
            MakeQueryBuilderHelper::delete('consultation_request_diagnostic','id',$this->idItem, );
            $this->dispatch('item-deleted', ['message' => 'Action bien réalisée']);
        } catch (\Exception $exception) {
            $this->dispatch('error', ['message' => $exception->getMessage()]);
        }
    }
    public function mount(?ConsultationSheet $consultationSheet){
        $this->consultationSheet=$consultationSheet;
    }
    public function render()
    {
        return view('livewire.application.sheet.widget.fresh-diagnostic-info-widget');
    }
}
