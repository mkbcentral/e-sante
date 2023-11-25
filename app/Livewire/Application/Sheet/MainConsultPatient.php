<?php

namespace App\Livewire\Application\Sheet;

use App\Models\CategoryTarif;
use App\Models\ConsultationRequest;
use App\Models\ConsultationSheet;
use App\Models\Hospital;
use JetBrains\PhpStorm\NoReturn;
use Livewire\Component;

class MainConsultPatient extends Component
{
    public int $consultationRequestId;
    public ?ConsultationRequest $consultationRequest;
    public ?ConsultationSheet $consultationSheet;
    public int $selectedIndex=1;

    #[NoReturn] public function openDetailConsultationModal(): void
    {
        $this->dispatch('open-details-consultation');
        $this->dispatch('consultationRequest',$this->consultationRequest);
    }
    #[NoReturn] public function openAntecedentMedicalModal(): void
    {
        $this->dispatch('open-antecedent-medical');
        $this->dispatch('consultationRequest',$this->consultationRequest);
    }
    public  function changeIndex(CategoryTarif $category): void
    {
        $this->selectedIndex=$category->id;
        $this->dispatch('selectedIndex',$this->selectedIndex);
    }
    public function mount(): void
    {

        $this->consultationRequest=ConsultationRequest::find($this->consultationRequestId);
        $this->consultationSheet=$this->consultationRequest->consultationSheet;
    }
    public function render()
    {
        return view('livewire.application.sheet.main-consult-patient',[
            'categories'=>CategoryTarif::orderBy('name','ASC')
                ->where('hospital_id',Hospital::DEFAULT_HOSPITAL)
                ->get()
        ]);
    }
}
