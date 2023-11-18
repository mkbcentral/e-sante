<?php

namespace App\Livewire\Application\Sheet;

use App\Models\CategoryTarif;
use App\Models\ConsultationRequest;
use App\Models\ConsultationSheet;
use Livewire\Component;

class MainConsultPatient extends Component
{
    public int $consultationRequestId;
    public ?ConsultationRequest $consultationRequest;
    public ?ConsultationSheet $consultationSheet;
    public int $selectedIndex=1;

    public  function changeIndex(CategoryTarif $category): void
    {
        $this->selectedIndex=$category->id;
        $this->dispatch('selectedIndex',$this->selectedIndex);
    }
    public function mount(){

        $this->consultationRequest=ConsultationRequest::find($this->consultationRequestId);
        $this->consultationSheet=$this->consultationRequest->consultationSheet;
    }
    public function render()
    {
        return view('livewire.application.sheet.main-consult-patient',[
            'categories'=>CategoryTarif::orderBy('name','ASC')->get()
        ]);
    }
}
