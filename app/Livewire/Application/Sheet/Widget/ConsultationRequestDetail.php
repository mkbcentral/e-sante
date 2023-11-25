<?php

namespace App\Livewire\Application\Sheet\Widget;

use App\Models\CategoryTarif;
use App\Models\ConsultationRequest;
use App\Models\Hospital;
use App\Models\Tarif;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class ConsultationRequestDetail extends Component
{
    protected $listeners = ['consultationRequest' => 'getConsultation'];
    public ?ConsultationRequest $consultationRequest;
    public int $idSelected = 0, $qty=1, $idTarif=0;
    public bool $isEditing = false;
    public ?Collection $tarifs;
    public ?Tarif $tarif;

    public function getConsultation(ConsultationRequest $consultationRequest): void
    {
        $this->consultationRequest = $consultationRequest;
    }

    public function updatedIdTarif(){
       $this->update();
    }

    public function edit(int $id, int $qty, $categoryId,$idTarif): void
    {
        $this->idSelected = $id;
        $this->isEditing = true;
        $this->qty = $qty;
        $this->idTarif=$idTarif;
        $this->tarifs= Tarif::join('category_tarifs','category_tarifs.id','=','tarifs.category_tarif_id')
            ->where('category_tarifs.hospital_id',Hospital::DEFAULT_HOSPITAL)
            ->where('tarifs.category_tarif_id',$categoryId)
            ->select('tarifs.*')
            ->get();
    }

    public function update(): void
    {
        try {
            if ($this->idTarif==0){
                DB::table('consultation_request_tarif')
                    ->where('id', $this->idSelected)
                    ->update(['qty' => $this->qty]);
            }else{
                DB::table('consultation_request_tarif')
                    ->where('id', $this->idSelected)
                    ->update(['qty' => $this->qty,'tarif_id' => $this->idTarif]);
            }
            $this->dispatch('updated', ['message' => 'Action bien réalisée']);
            $this->isEditing=false;
            $this->idSelected=0;
        }catch (\Exception $exception){
            $this->dispatch('error', ['message' => $exception->getMessage()]);
        }
    }

    public function delete(int $id): void
    {
        try {
            DB::table('consultation_request_tarif')->where('id',$id)->delete();
            $this->dispatch('updated', ['message' => 'Action bien réalisée']);
        }catch (\Exception $exception){
            $this->dispatch('error', ['message' => $exception->getMessage()]);
        }
    }
    public function render()
    {
        return view('livewire.application.sheet.widget.consultation-request-detail', [
                'categoriesTarif' => CategoryTarif::where('hospital_id', Hospital::DEFAULT_HOSPITAL)->get()
            ]
        );
    }
}
