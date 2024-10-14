<?php

namespace App\Livewire\Application\Sheet;

use Livewire\Component;
use App\Models\CategoryTarif;
use App\Models\ConsultationSheet;
use App\Models\ConsultationRequest;
use App\Repositories\Tarif\GetCategoryTarifRepository;

class DoctorConsultPatientPage extends Component
{
    protected $listeners = [
        'refreshConultPatient' => '$refresh',
    ];
    public int $consultationRequestId;
    public ?ConsultationRequest $consultationRequest;
    public ?ConsultationSheet $consultationSheet;

    /**
     * Open detail consultation model view
     * emit consultationRequest listner to load data after modal detail opened
     * @return void
     */
    public function openDetailConsultationModal(): void
    {
        $this->dispatch('open-details-consultation');
        $this->dispatch('consultationRequest', $this->consultationRequest);
        $this->dispatch('consultationRequestItemsTarif', $this->consultationRequest);
        $this->dispatch('consultationRequestProductItems', $this->consultationRequest);
        $this->dispatch('consultationRequestNursingItems', $this->consultationRequest);
        $this->dispatch('consultationRequestHospitalizationItems', $this->consultationRequest);
    }
    /**
     * Open antecedent modal view
     * emit consultationRequest listner to load data after modal antecedent opened
     * @return void
     */
    public function openAntecedentMedicalModal(): void
    {
        $this->dispatch('open-antecedent-medical');
        $this->dispatch('consultationRequest', $this->consultationRequest);
    }

    public function openPrescriptionMedicalModal(): void
    {
        $this->dispatch('open-medical-prescription');
        $this->dispatch('consultationRequest', $this->consultationRequest);
    }

    public function openNursingModal(): void
    {
        $this->dispatch('open-consultation-request-nursing');
        $this->dispatch('consultationRequestNursing', $this->consultationRequest);
    }
    /**
     * Mounted component
     * @return void
     */
    public function mount(): void
    {
        $this->consultationRequest = ConsultationRequest::find($this->consultationRequestId);
        $this->consultationSheet = $this->consultationRequest->consultationSheet;

    }
    /**
     * Render component
     * @return Application|Factory|View|\Illuminate\Foundation\Application
     */
    public function render()
    {
        return view('livewire.application.sheet.doctor-consult-patient-page',[]);
    }
}
