<?php

namespace App\Livewire\Application\Sheet;

use App\Models\CategoryTarif;
use App\Models\ConsultationRequest;
use App\Models\ConsultationSheet;
use App\Models\Hospital;
use App\Repositories\Tarif\GetCategoryTarifRepository;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use JetBrains\PhpStorm\NoReturn;
use Livewire\Component;

class MainConsultPatient extends Component
{
    public int $consultationRequestId;
    public ?ConsultationRequest $consultationRequest;
    public ?ConsultationSheet $consultationSheet;
    public int $selectedIndex=1;

    /**
     * Open detail consultation model view
     * emit consultationRequest listner to load data after modal detail opened
     * @return void
     */
    #[NoReturn] public function openDetailConsultationModal(): void
    {
        $this->dispatch('open-details-consultation');
        $this->dispatch('consultationRequest',$this->consultationRequest);
    }
    /**
     * Open antecedent modal view
     * emit consultationRequest listner to load data after modal antecedent opened
     * @return void
     */
    #[NoReturn] public function openAntecedentMedicalModal(): void
    {
        $this->dispatch('open-antecedent-medical');
        $this->dispatch('consultationRequest',$this->consultationRequest);
    }
    /**
     * Change index item selection on category tarif
     * @param CategoryTarif $category
     * @return void
     */
    #[NoReturn] public  function changeIndex(CategoryTarif $category): void
    {
        $this->selectedIndex=$category->id;
        $this->dispatch('selectedIndex',$this->selectedIndex);
    }

    /**
     * Mounted component
     * @return void
     */
    #[NoReturn] public function mount(): void
    {
        $this->consultationRequest=ConsultationRequest::find($this->consultationRequestId);
        $this->consultationSheet=$this->consultationRequest->consultationSheet;
    }

    /**
     * Render component
     * @return Application|Factory|View|\Illuminate\Foundation\Application
     */
    public function render()
    {
        return view('livewire.application.sheet.main-consult-patient',[
            'categories'=>GetCategoryTarifRepository::getListCategories()
        ]);
    }
}
