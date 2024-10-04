<?php

namespace App\Livewire\Application\Labo\Screens;

use Exception;
use Livewire\Component;
use App\Models\CategoryTarif;
use App\Models\ConsultationRequest;
use App\Livewire\Helpers\Query\MakeQueryBuilderHelper;

class ListItemsLabo extends Component
{
    protected $listeners = [
        'listLaboRefreshed' => '$refresh'
    ];

    public ?ConsultationRequest $consultationRequest;
    public ?CategoryTarif $categroryTarif;
    public bool $isEditing=false;
    public $idTarif;
    public $result,$qty, $unit, $normal_value;
    public $tarifData;


    public function edit($id){
        $this->idTarif=$id;
        $this->isEditing=true;
        $this->tarifData=MakeQueryBuilderHelper::getSingleData('consultation_request_tarif','id',$id);
        $this->qty=$this->tarifData->qty;
        $this->result = $this->tarifData->result;
        $this->normal_value = $this->tarifData->normal_value;
        $this->unit = $this->tarifData->unit;
    }

    public function update(){
        try {
            MakeQueryBuilderHelper::update('consultation_request_tarif','id',$this->idTarif,[
                'qty'=>$this->qty,
                'result' => $this->result,
                'unit' => $this->unit,
                'normal_value' => $this->normal_value,
            ]);
            $this->dispatch('updated', ['message' => 'Action bien réalisée']);
            $this->isEditing=false;
            $this->tarifData=0;
        } catch (Exception $ex) {
            $this->dispatch('error', ['message' => $ex->getMessage()]);
        }
    }

    public function delete($id)
    {
        try {
            MakeQueryBuilderHelper::delete('consultation_request_tarif', 'id', $id);
            $this->dispatch('error', ['message' => 'Action bien réalisée']);
        } catch (Exception $ex) {
            $this->dispatch('error', ['message' => $ex->getMessage()]);
        }
    }


    public function mount(?ConsultationRequest $consultationRequest)
    {
        $this->consultationRequest = $consultationRequest;
        $this->categroryTarif = CategoryTarif::find(1);
    }


    public function render()
    {
        return view('livewire.application.labo.screens.list-items-labo');
    }
}
