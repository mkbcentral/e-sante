<?php

namespace App\Livewire\Application\Sheet\Widget;

use App\Livewire\Helpers\Query\MakeQueryBuilderHelper;
use App\Models\ConsultationRequest;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class TarifItemsWithConsultationWidget extends Component
{
    protected $listeners=[
        'refreshItemsTarifWidget'=>'getSeletedCategoryTarif',
        'deleteItemListener'=>'delete'
    ];
    public int $tarifId,$consultationRequestId,$idItem;

    public function getSeletedCategoryTarif(int $tarifId)
    {
        $this->tarifId = $tarifId;
    }
    public function mount(int $tarifId, int $consultationRequestId){
       $this->tarifId=$tarifId;
       $this->consultationRequestId=$consultationRequestId;
    }

    public function showDeleteDialog($id): void
    {
        $this->idItem=$id;
        $this->dispatch('delete-item-dialog');
    }
    public function delete(): void
    {
        try {
            MakeQueryBuilderHelper::delete($this->idItem, 'consultation_request_tarif');
            $this->dispatch('item-deleted', ['message' => 'Action bien réalisée']);
        } catch (\Exception $exception) {
            $this->dispatch('error', ['message' => $exception->getMessage()]);
        }
    }
    public function render()
    {
        return view('livewire.application.sheet.widget.tarif-items-with-consultation-widget',[
            'tarifs'=>DB::table('consultation_request_tarif')
                ->join('tarifs','tarifs.id','consultation_request_tarif.tarif_id')
                ->join('category_tarifs','category_tarifs.id','tarifs.category_tarif_id')
                ->where('consultation_request_tarif.consultation_request_id',$this->consultationRequestId)
                ->where('category_tarifs.id',$this->tarifId)
                ->select('consultation_request_tarif.*','tarifs.name','tarifs.abbreviation')
                ->get()
        ]);
    }
}
